<?php

function makeDirectory(String $path)
{
    $directory = dirname($path);
    if(!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
}
