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
    $imageWidth = $image->getImageWidth();

    // resize image work best when we go smaller and smaller
    if ($imageWidth > 3000) {
        $reminder = ($imageWidth - 2000) / 5;
        for ($i = 0; $i < 6; $i++) {
            $image->adaptiveResizeImage($imageWidth, 0);
            $imageWidth = $imageWidth - $reminder;
        }
    }

    $image->adaptiveResizeImage(1920, 0);
    $image->writeImage("output-1920." . $fileExtension);
    $cloneImage = $image->clone();
    $cloneImage->setImageFormat("AVIF");
    $cloneImage->writeImage("output-1920.avif");

    $image->adaptiveResizeImage(1536, 0);
    $image->writeImage("output-1536." . $fileExtension);
    $cloneImage = $image->clone();
    $cloneImage->setImageFormat("AVIF");
    $cloneImage->writeImage("output-1536.avif");

    $image->adaptiveResizeImage(1280, 0);
    $image->writeImage("output-1280." . $fileExtension);
    $cloneImage = $image->clone();
    $cloneImage->setImageFormat("AVIF");
    $cloneImage->writeImage("output-1280.avif");

    $image->adaptiveResizeImage(1024, 0);
    $image->writeImage("output-1024." . $fileExtension);
    $cloneImage = $image->clone();
    $cloneImage->setImageFormat("AVIF");
    $cloneImage->writeImage("output-1024.avif");

    $image->adaptiveResizeImage(768, 0);
    $image->writeImage("output-768." . $fileExtension);
    $cloneImage = $image->clone();
    $cloneImage->setImageFormat("AVIF");
    $cloneImage->writeImage("output-768.avif");

    $image->adaptiveResizeImage(640, 0);
    $image->writeImage("output-640." . $fileExtension);
    $cloneImage = $image->clone();
    $cloneImage->setImageFormat("AVIF");
    $cloneImage->writeImage("output-640.avif");

    $image->destroy();
}


