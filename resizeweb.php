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
    $nameFile = $argv[2];
    $argsIndex = 3; // if we have filename, start check if file exist only at index 3 of args
}
else
{
    $argsIndex = 1;
    $nameFile = "output";
}

if (!file_exists($argv[$argsIndex]))
{
    echo "Error : The file " . $argv[$argsIndex] . " does not exist\n";
    return 2;
}

function getFileExtension(string $filename) {
    $ext = pathinfo($filename)['extension'];
    return $ext;
}

function resizeImg($image, int $size, string $nameFile, string $fileExtension) {
    $cloneImage = $image->clone();
    $cloneImage->adaptiveResizeImage($size, 0);
    $cloneImage->writeImage("./output/original/$nameFile-$size.$fileExtension");
    echo "Write $nameFile-$size.$fileExtension in ./output/original/\n";
}

function convertImg($image, int $size, string $format, string $nameFile) {
    $cloneImage = $image->clone();
    $cloneImage->setImageFormat($format);
    $cloneImage->writeImage("./output/avif/$nameFile-$size.avif");
    echo "Write $nameFile-$size.avif in ./output/avif/\n";
}

$userImage = $argv[$argsIndex];
$fileExtension = getFileExtension(($userImage));

$image = new Imagick($userImage);

// create directories to organise output. if cannot create dir, throw err and return
if (!mkdir("./output/avif", 0775, true)) {
    echo "Failed to create directories ...\n";
    return;
}
if (!mkdir("./output/original", 0775)) {
    echo "Failed to create directories ...\n";
    return;
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
