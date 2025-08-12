<?php

function selectOptionArrGenerator($data, string $key = 'id', string $value = 'name'): array
{
    $tmp = [];

    foreach ($data as $item) {
        $tmp[$item[$key]] = $item[$value];
    }

    return $tmp;
}

function selectOptionArrGeneratorByKey($data): array
{
    $tmp = [];

    foreach ($data as $key => $item) {
        $tmp[$key] = $item;
    }

    return $tmp;
}
function selectOptionHtmlArrGeneratorByKey($data, $selected = null): string
{
    $tmp = '<option value="">'.getTranslation('Select').'</option>';

    foreach ($data as $key => $item) {
        $tmp .= '<option '.($selected && $selected == $key ? 'selected' : '')." value='{$key}'>{$item}</option>";
    }

    return $tmp;
}

function generateSelectOptions($data, string $key = 'id', string $value = 'name', $selected = null): string
{
    $tmp = '<option value="">'.getTranslation('Select').'</option>';

    foreach ($data as $item) {
        $tmp .= '<option '.($selected && $selected == $item[$key] ? 'selected' : '')." value='{$item[$key]}'>{$item[$value]}</option>";
    }

    return $tmp;
}

function generateTranslatedSelectOptions(
    $data,
    string $key = 'id',
    string $value = 'name',
    string $firstLine = 'Select',
    $selected = null
): string {
    $tmp = '<option value="">'.getTranslation($firstLine).'</option>';

    foreach ($data as $item) {
        $tmp .= '<option '.($selected && $selected == $item[$key] ? 'selected' : '')." value='{$item[$key]}'>{$item->getTranslationOne($value)}</option>";
    }

    return $tmp;
}
