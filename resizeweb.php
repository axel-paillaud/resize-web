#!/usr/bin/env php
<?php

$image = new Imagick("big-picture.jpeg");

$image->blurImage(5,3);

$image->writeImage("output.jpeg");
