<?php

use App\Models\Setting;

function setting($name, $default = null)
{
    return Setting::where('name', $name)->value('value') ?? $default;
}
