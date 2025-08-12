<?php

namespace App\DTO;

class SimaDto extends BaseDto
{
    public string $operationType;

    public string $operationId;

    public int $nbfUtc;

    public int $expUtc;

    public array $assignee;

    public string $dataUri;

    public string $callbackUrl;

    public string $redirectUrl;

    public ?string $algoName;

    public ?string $fingerprint;

    public function __construct(
        $operationType,
        $operationId,
        $nbfUtc,
        $expUtc,
        $assignee,
        $dataUri,
        $callbackUrl,
        $redirectUrl,
        $algoName = null,
        $fingerprint = null
    ) {
        $this->operationType = $operationType;
        $this->operationId = $operationId;
        $this->nbfUtc = $nbfUtc;
        $this->expUtc = $expUtc;
        $this->assignee = $assignee;
        $this->dataUri = $dataUri;
        $this->callbackUrl = $callbackUrl;
        $this->redirectUrl = $redirectUrl;
        $this->algoName = $algoName;
        $this->fingerprint = $fingerprint;
    }
}
