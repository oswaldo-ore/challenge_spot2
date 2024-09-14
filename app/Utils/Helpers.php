<?php
use Illuminate\Support\Str;
function makeDirectory(String $path)
{
    $directory = dirname($path);
    if(!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
}

function generateRandomCode()
{
    return Str::random(8);
}
