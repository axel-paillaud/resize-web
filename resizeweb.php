#!/usr/bin/env php
<?php

// we need at least one args
if (!isset($argv[1]) || empty($argv[1]))
{
    echo "Usage : resizeweb <file1> <file2> ...\n";
    return 1;
}

if ($argv[1] === "-n")
{
    $checkUserNameFile = true;
    $nameFile = $argv[2];
    $argsIndex = 3; // if we have filename, start check if file exist only at index 3 of args
}
else
{
    $checkUserNameFile = false;
    $argsIndex = 1;
    $nameFile = "output";
}

for ($i = $argsIndex; $i < sizeof($argv); $i++)
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

function resizeImg($image, int $size, string $nameFile, string $fileExtension) {
    $image->adaptiveResizeImage($size, 0);
    $image->writeImage("./output/original/$nameFile-$size.$fileExtension");
    echo "Write $nameFile-$size.$fileExtension in ./output/original/\n";
}

function convertImg($image, int $size, string $format, string $nameFile) {
    $cloneImage = $image->clone();
    $cloneImage->setImageFormat($format);
    $cloneImage->writeImage("./output/avif/$nameFile-$size.avif");
    echo "Write $nameFile-$size.avif in ./output/avif/\n";
}

// create directories to organise output. if cannot create dir, throw err and return
if (!mkdir("./output/avif", 0775, true)) {
    echo "Failed to create directories ...\n";
    return;
}
if (!mkdir("./output/original", 0775)) {
    echo "Failed to create directories ...\n";
    return;
}

for ($i = $argsIndex; $i < sizeof($argv); $i++)
{
    $userImage = $argv[$i];
    $fileExtension = getFileExtension(($userImage));

    $image = new Imagick($userImage);
    $imageWidth = $image->getImageWidth();

    // resize image work best when we go smaller and smaller
    if ($imageWidth > 3000) {
        $reminder = ($imageWidth - 2000) / 5;
        for ($i = 0; $i < 6; $i++) {
            $image->adaptiveResizeImage($imageWidth, 0);
            $imageWidth = $imageWidth - $reminder;
        }
    }

    resizeImg($image, 1920, $nameFile, $fileExtension);
    convertImg($image, 1920, "AVIF", $nameFile);

    resizeImg($image, 1536, $nameFile, $fileExtension);
    convertImg($image, 1536, "AVIF", $nameFile);

    resizeImg($image, 1280, $nameFile, $fileExtension);
    convertImg($image, 1280, "AVIF", $nameFile);

    resizeImg($image, 1024, $nameFile, $fileExtension);
    convertImg($image, 1024, "AVIF", $nameFile);

    resizeImg($image, 768, $nameFile, $fileExtension);
    convertImg($image, 768, "AVIF", $nameFile);

    resizeImg($image, 640, $nameFile, $fileExtension);
    convertImg($image, 640, "AVIF", $nameFile);

    $image->destroy();
}


