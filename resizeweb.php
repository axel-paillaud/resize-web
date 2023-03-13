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
    $fileName = $argv[2];
    $dirName = $argv[2];
    $argsIndex = 3; // if we have filename, start check if file exist only at index 3 of args
}
else
{
    $argsIndex = 1;
    $fileName = "output";
    $dirName = "output";
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

function resizeImg($image, int $size, string $fileName, string $fileExtension) {
    global $dirName;
    $cloneImage = $image->clone();
    $cloneImage->resizeImage($size, 0, imagick::FILTER_LANCZOS, 0.5);
    $cloneImage->writeImage("./$dirName/original/$fileName-$size.$fileExtension");
    echo "Write $fileName-$size.$fileExtension in ./$dirName/original/\n";
    return $cloneImage;
}

function convertImg($image, int $size, string $format, string $fileName) {
    global $dirName;
    $image->setOption('quality', '80');
    $image->setImageFormat($format);
    $image->writeImage("./$dirName/avif/$fileName-$size.avif");
    echo "Write $fileName-$size.avif in ./$dirName/avif/\n";
}

$userImage = $argv[$argsIndex];
$fileExtension = getFileExtension(($userImage));

$image = new Imagick($userImage);

// create directories to organise output. if cannot create dir, throw err and return
if (!mkdir("./$dirName/avif", 0775, true)) {
    echo "Failed to create directories ...\n";
    return;
}
if (!mkdir("./$dirName/original", 0775)) {
    echo "Failed to create directories ...\n";
    return;
}

$resizedImage = resizeImg($image, 1920, $fileName, $fileExtension);
convertImg($resizedImage, 1920, "AVIF", $fileName);

$resizedImage = resizeImg($image, 1536, $fileName, $fileExtension);
convertImg($resizedImage, 1536, "AVIF", $fileName);

$resizedImage = resizeImg($image, 1280, $fileName, $fileExtension);
convertImg($resizedImage, 1280, "AVIF", $fileName);

$resizedImage = resizeImg($image, 1024, $fileName, $fileExtension);
convertImg($resizedImage, 1024, "AVIF", $fileName);

$resizedImage = resizeImg($image, 768, $fileName, $fileExtension);
convertImg($resizedImage, 768, "AVIF", $fileName);

$resizedImage = resizeImg($image, 640, $fileName, $fileExtension);
convertImg($resizedImage, 640, "AVIF", $fileName);

$image->destroy();
