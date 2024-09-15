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
    return strtolower(Str::random(8));
}

function validateUrl(String $url)
{
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        throw new InvalidArgumentException("The URL provided is not valid");
    }
}
