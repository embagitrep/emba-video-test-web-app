<?php

function locales()
{
    return config('app.locales') ?? [];
}

function locale()
{
    return app()->getLocale();
}
