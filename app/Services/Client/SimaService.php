<?php

namespace App\Services\Client;

use App\DTO\SimaDto;
use App\DTO\SimaUserDetailsDto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SimaService
{
    private static $masterKey = '7B812541-A033-4C6D-B388-CE738DB97F02';

    private static $algName = 'HMACSHA256';

    private static string $protocolName = 'web2app';

    private static string $protocolVersion = '2.0';

    private static int $clientId = 2214001;

    private static string $clientName = 'SAR Group';

    private static string $iconUri = 'https://example.com/client/assets/images/content/mark.png';

    private static string $hostName = 'example.com';

    public function generateTSQuery(SimaDto $dto): string
    {
        $container = self::getContainer($dto);

        $signature = self::generateSignature($container);

        $fullTSContainer = [
            'SignableContainer' => $container,
            'Header' => [
                'AlgName' => self::$algName,
                'Signature' => $signature,
            ],
        ];

        $serializedTSContainer = json_encode($fullTSContainer, JSON_UNESCAPED_SLASHES);

        return base64_encode($serializedTSContainer);
    }

    private static function getContainer(SimaDto $data): array
    {
        return [
            'ProtoInfo' => [
                'Name' => self::$protocolName,
                'Version' => self::$protocolVersion,
            ],
            'OperationInfo' => [
                'Type' => $data->operationType,
                'OperationId' => $data->operationId,
                'NbfUTC' => $data->nbfUtc,
                'ExpUTC' => $data->expUtc,
                'Assignee' => $data->assignee,
            ],
            'DataInfo' => [
                'DataURI' => $data->dataUri,
                'AlgName' => $data->algoName,
                'FingerPrint' => $data->fingerprint,
            ],
            'ClientInfo' => [
                'ClientId' => self::$clientId,
                'ClientName' => self::$clientName,
                'IconURI' => self::$iconUri,
                'Callback' => $data->callbackUrl,
                'RedirectURI' => $data->redirectUrl,
                'HostName' => [self::$hostName],
            ],

        ];
    }

    private static function generateSignature($container): string
    {

        $containerJson = json_encode($container, JSON_UNESCAPED_SLASHES);

        $containerBytes = iconv('ISO-8859-1', 'UTF-8', $containerJson);

        $containerSha256Bytes = hash('sha256', $containerBytes, true);

        $masterKeyBytes = iconv('ISO-8859-1', 'UTF-8', self::$masterKey);

        $hmacHashData = hash_hmac('sha256', $containerSha256Bytes, $masterKeyBytes, true);

        return base64_encode($hmacHashData);
    }

    public function getData(string $sessionId, string $name, string $data): array
    {
        return [
            'sessionid' => $sessionId,
            'type' => 'raw',
            'dataObjects' => [
                [
                    'name' => $name,
                    'data' => base64_encode($data),
                ],
            ],
            'signFormat' => 'pades-t',
            'claims' => [
                'deviceinfo',
                'location',
                'idinfo',
                'idphoto',
                'validate',
            ],
        ];
    }

    public function handleCallback(string $cert): ?SimaUserDetailsDto
    {
        $data = $this->parseCertificate($cert);

        if (! $data) {
            return null;
        }

        return $this->extractUserData($data['subject']);
    }

    private function extractUserData(array $data): SimaUserDetailsDto
    {
        return SimaUserDetailsDto::fromArray([
            'name' => $data['GN'],
            'surname' => $data['SN'],
            'serial' => $data['serialNumber'],
        ]);
    }

    private function parseCertificate(string $certificate): ?array
    {
        try {

            $formattedCertificate = $this->formatCertificate($certificate);

            $parsed = openssl_x509_parse($formattedCertificate);

            if ($parsed === false) {
                return null;
            }

            return [
                'subject' => $parsed['subject'] ?? null,
                'issuer' => $parsed['issuer'] ?? null,
                'valid_from' => isset($parsed['validFrom_time_t']) ? date('Y-m-d H:i:s', $parsed['validFrom_time_t']) : null,
                'valid_to' => isset($parsed['validTo_time_t']) ? date('Y-m-d H:i:s', $parsed['validTo_time_t']) : null,
                'serial_number' => $parsed['serialNumberHex'] ?? null,
                'version' => $parsed['version'] ?? null,
                'signature_algorithm' => $parsed['signatureTypeSN'] ?? null,
                'extensions' => $parsed['extensions'] ?? [],
            ];
        } catch (\Exception $e) {

            return null;
        }
    }

    private function formatCertificate(string $certificate): string
    {

        if (strpos($certificate, '-----BEGIN CERTIFICATE-----') === false) {
            $certificate = "-----BEGIN CERTIFICATE-----\n".
                chunk_split($certificate, 64, "\n").
                "-----END CERTIFICATE-----\n";
        }

        return $certificate;
    }

    private function getOperationName()
    {
        return 'simaOperation-';
    }

    public function getOperation($operationId)
    {
        return Cache::get($this->getOperationName().$operationId);
    }

    public function setOperationStatus(string $status, string $type = 'Auth', ?string $operationId = null, int $minutes = 5): bool
    {
        $ttlSeconds = $minutes * 60;
        $expiresAt = now()->addSeconds($ttlSeconds);

        Cache::put($this->getOperationName().$operationId, [
            'operationId' => $operationId,
            'status' => $status,
            'type' => $type,
            'expiresAt' => $expiresAt,
        ], $ttlSeconds);

        return true;
    }

    function updateOperation(string $operationId, callable $modifier): bool
    {
        $operation = $this->getOperation($operationId);

        Log::info('operation:   '.json_encode($operation));

        if (!$operation || !isset($operation['expiresAt'])) {
            return false;
        }

        $expiresAt = Carbon::parse($operation['expiresAt']);
        $ttl = now()->diffInSeconds($expiresAt);

        if ($ttl <= 0) {
            return false;
        }

        $modified = $modifier($operation);

        $modified['expiresAt'] = $expiresAt;

        Log::info('Putting data .....');

        return Cache::put($this->getOperationName().$operationId, $modified, $ttl);
    }

    private function getUserOperationName()
    {
        return 'userOperation-';
    }

    public function setUserOperationDetails(string $operationId, array $data)
    {
        Cache::put($this->getUserOperationName().$operationId, $data, 30*60);
    }

    public function getUserOperationDetails(string $operationId)
    {
        return Cache::get($this->getUserOperationName().$operationId);
    }
}
