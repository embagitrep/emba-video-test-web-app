<?php

function customUcFirst($str)
{
    $fc = mb_strtoupper(mb_substr($str, 0, 1));

    return $fc.mb_substr($str, 1);
}

function limitParagraphs($text, $limit = 2, $ending = '...')
{
    $paragraphs = preg_split('/\r\n|\r|\n{2}/', $text);

    $limitedParagraphs = array_slice($paragraphs, 0, $limit);

    $limitedText = implode("\n\n", $limitedParagraphs);

    if (count($paragraphs) > $limit) {
        $limitedText .= $ending;
    }

    return $limitedText;
}

function generateLorem($sentences = 3)
{
    $faker = \Faker\Factory::create();

    return implode(' ', $faker->sentences($sentences));
}

function maskPhoneNumber($phoneNumber)
{
    $lastThreeDigits = substr($phoneNumber, -3);

    $maskedPortion = substr($phoneNumber, 0, -3);

    return str_repeat('*', strlen($maskedPortion)).$lastThreeDigits;
}

function normalizePhoneNumber($phoneNumber)
{
    return str_replace(['(', ')', '-', ' '], '', $phoneNumber);
}

function formatNumber($number)
{
    $number = (float) $number;

    return number_format($number, 2, '.', ',');
}

function getRangeColumnStr($start, array $suffix, $end = null)
{
    if ($end) {
        return "{$start}-{$end} {$suffix[1]}";
    }

    return "{$start} {$suffix[0]}";

}

function getStrInitials($string): string
{
    $words = explode(' ', $string);
    $initials = '';

    foreach ($words as $word) {
        $initials .= strtoupper(mb_substr($word, 0, 1));
    }

    return $initials;
}
