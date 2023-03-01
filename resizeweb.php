#!/usr/bin/env php
<?php

// we need at least one args
if (!isset($argv[1]) || empty($argv[1]))
{
    echo "Usage : resizeweb <file1> <file2> ...\n";
    return 1;
}

for ($i = 0; $i < sizeof($argv); $i++)
{
    if (!file_exists($argv[$i]))
    {
        echo "Error : The file " . $argv[$i] . " does not exist\n";
        return 2;
    }
}

function getFileExtension(string $filename) {
    $ext = pathinfo($filename)['extension'];
    return $ext;
}

for ($i = 1; $i < sizeof($argv); $i++)
{
    $userImage = $argv[$i];
    $fileExtension = getFileExtension(($userImage));

    $image = new Imagick($userImage);

    $image->adaptiveResizeImage(1920, 0);
    $image->writeImage("output-1920." . $fileExtension);

    $image->adaptiveResizeImage(1536, 0);
    $image->writeImage("output-1536." . $fileExtension);

    $image->adaptiveResizeImage(1280, 0);
    $image->writeImage("output-1280." . $fileExtension);

    $image->adaptiveResizeImage(1024, 0);
    $image->writeImage("output-1024." . $fileExtension);

    $image->adaptiveResizeImage(768, 0);
    $image->writeImage("output-768." . $fileExtension);

    $image->adaptiveResizeImage(640, 0);
    $image->writeImage("output-640." . $fileExtension);

    $image->destroy();
}


