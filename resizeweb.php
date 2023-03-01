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

mkdir("./output", 0775);
mkdir("./output/avif", 0775);
mkdir("./output/original", 0775);

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
    $image->writeImage("./output/original/output-1920." . $fileExtension);
    echo "Write output-1920." . $fileExtension . " in ./output/original/\n";
    $cloneImage = $image->clone();
    $cloneImage->setImageFormat("AVIF");
    $cloneImage->writeImage("./output/avif/output-1920.avif");
    echo "Write output-1920.avif in ./output/avif/\n";

    $image->adaptiveResizeImage(1536, 0);
    $image->writeImage("./output/original/output-1536." . $fileExtension);
    echo "Write output-1536." . $fileExtension . " in ./output/original/\n";
    $cloneImage = $image->clone();
    $cloneImage->setImageFormat("AVIF");
    $cloneImage->writeImage("./output/avif/output-1536.avif");
    echo "Write output-1536.avif in ./output/avif/\n";

    $image->adaptiveResizeImage(1280, 0);
    $image->writeImage("./output/original/output-1280." . $fileExtension);
    echo "Write output-1280." . $fileExtension . " in ./output/original/\n";
    $cloneImage = $image->clone();
    $cloneImage->setImageFormat("AVIF");
    $cloneImage->writeImage("./output/avif/output-1280.avif");
    echo "Write output-1280.avif in ./output/avif/\n";

    $image->adaptiveResizeImage(1024, 0);
    $image->writeImage("./output/original/output-1024." . $fileExtension);
    echo "Write output-1024." . $fileExtension . " in ./output/original/\n";
    $cloneImage = $image->clone();
    $cloneImage->setImageFormat("AVIF");
    $cloneImage->writeImage("./output/avif/output-1024.avif");
    echo "Write output-1024.avif in ./output/avif/\n";

    $image->adaptiveResizeImage(768, 0);
    $image->writeImage("./output/original/output-768." . $fileExtension);
    echo "Write output-768." . $fileExtension . " in ./output/original/\n";
    $cloneImage = $image->clone();
    $cloneImage->setImageFormat("AVIF");
    $cloneImage->writeImage("./output/avif/output-768.avif");
    echo "Write output-768.avif in ./output/avif/\n";

    $image->adaptiveResizeImage(640, 0);
    $image->writeImage("./output/original/output-640." . $fileExtension);
    echo "Write output-640." . $fileExtension . " in ./output/original/\n";
    $cloneImage = $image->clone();
    $cloneImage->setImageFormat("AVIF");
    $cloneImage->writeImage("./output/avif/output-640.avif");
    echo "Write output-640.avif in ./output/avif/\n";

    $image->destroy();
}


