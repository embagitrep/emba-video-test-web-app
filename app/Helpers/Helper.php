<?php

use App\Models\Setting;

if (! function_exists('getSetting')) {

    function getSetting($name)
    {
        $setting = Setting::getSetting($name);
        if (isset($setting)) {
            return $setting->value;
        } else {
            $setting = Setting::create([
                'name' => $name, 'value' => 0,
            ]);

            return $setting->value;
        }
    }
}

if (! function_exists('bannerTypes')) {

    function bannerTypes()
    {

        return [
            'main' => 'Main banner',
        ];
    }
}

if (! function_exists('addSpan')) {

    function addSpan($str)
    {
        if ($str !== '') {
            $arr = explode(' ', $str);
            if (count($arr) <= 1) {
                return $str;
            }
            $firstTwoWords = '<span class="text--orange">'.$arr[0].' '.$arr[1].'</span>';
            $remainingWords = array_slice($arr, 2);

            return $firstTwoWords.' '.implode(' ', $remainingWords);
        } else {
            return $str;
        }
    }

}

if (! function_exists('getMenus')) {

    function getMenus()
    {
        $menus = \App\Models\Menu::with(['translation', 'activePages.translation'])
            ->withCount(['activePages'])
            ->active()->where('in_menu', 1)->orderBy('sort')->get();

        return $menus;
    }
}

if (! function_exists('str_slug')) {

    function str_slug($str)
    {
        return \Illuminate\Support\Str::slug($str);
    }
}

if (! function_exists('addBreakBannerText')) {

    function addBreakBannerText($text, $minWords = 3)
    {
        $return = $text;
        $arr = explode(' ', $text);
        $newString = '';
        $count = 0;
        if (count($arr) > $minWords) {
            foreach ($arr as $word) {
                if ($count == $minWords) {
                    $newString .= '<br>';
                    $count = 0;
                }
                $newString .= $word.' ';
                $count++;
            }
            $return = $newString;
        }

        return $return;
    }
}

function allArrFieldsIsNull($array)
{
    $count = 0;
    foreach ($array as $value) {
        if ($value === null) {
            $count++;
        }
    }

    return $count == count($array);
}

function compareArrayItemByKey($key)
{
    return function ($a, $b) use ($key) {
        $valueA = $a[$key] ?? '';
        $valueB = $b[$key] ?? '';

        return strcmp($valueA, $valueB);
    };
}

function numberToRoman($num)
{
    $map = [
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1,
    ];

    $roman = '';
    while ($num > 0) {
        foreach ($map as $romanChar => $value) {
            if ($num >= $value) {
                $num -= $value;
                $roman .= $romanChar;
                break;
            }
        }
    }

    return $roman;
}
