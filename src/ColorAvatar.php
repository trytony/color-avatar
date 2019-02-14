<?php

namespace Tony\ColorAvatar;

use Tony\ColorAvatar\Exceptions\InvalidArgumentException;

class ColorAvatar
{

    /**
     * @param string $text
     * @param string $saveDir
     * @param string $fileName
     * @return string
     * @throws InvalidArgumentException
     */
    public function create(string $text, string $saveDir, string $fileName)
    {
        if (!is_dir($saveDir)) {
            throw new InvalidArgumentException('Invalid directory.');
        }

        if (!$this->isImg($fileName)) {
            throw new InvalidArgumentException('Illegal file name.');
        }

        if (strlen($text) > 2) {
            throw new InvalidArgumentException('Invalid text.');
        }

        $text = strtoupper($text);

        // Set the width and height of the new image in pixels.
        $width = 240;
        $height = 240;

        // Create a pointer to a new true colour image.
        $im = imagecreatetruecolor($width, $height);
        imagealphablending($im, false);

        // Set pure white as transparent color.
        $colorTransparent = imagecolorallocatealpha($im, 255, 255, 255, 127);
        imagefill($im, 0, 0, $colorTransparent);
        imagesavealpha($im, true);

        // Randomize a somewhat light colored background color.
        $hue = mt_rand(0, 360) / 360;
        $rgb = $this->hslToRgb($hue);
        $r = $rgb['r'];
        $g = $rgb['g'];
        $b = $rgb['b'];

        // Draw a filled circle.
        $colorRandom = imagecolorallocate($im, $r, $g, $b);
        imagefilledellipse($im, $width / 2, $height / 2, $width, $height, $colorRandom);

        // Add text, a little less white, since we used pure white as transparent color.
        $colorWhite = imagecolorallocate($im, 254, 254, 254);
        $fontPath = '../src/fonts/Hack-Bold.ttf'; // MIT license.

        if (strlen($text) == 1) {
            $xOffset = 85;
        } else {
            $xOffset = 55;
        }

        imagettftext($im, 80, 0, $xOffset, 160, $colorWhite, $fontPath, $text);

        $dateFolder = date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . date('d');

        $fullFileName = $saveDir . DIRECTORY_SEPARATOR . $dateFolder . DIRECTORY_SEPARATOR . $fileName;
        $fullFolder = $saveDir . DIRECTORY_SEPARATOR . $dateFolder;
        $this->createDir($fullFolder);

        // Save image.
        imagepng($im, $fullFileName);

        // Destroy reference.
        imagedestroy($im);

        return $saveDir
            . DIRECTORY_SEPARATOR
            . $dateFolder
            . DIRECTORY_SEPARATOR
            . $fileName;
    }

    /**
     * @param $path
     * @return bool
     */
    public function createDir(string $path)
    {
        return is_dir($path) or self::createDir(dirname($path)) and mkdir($path, 0777);
    }

    /**
     * @param string $fileName
     * @return bool
     */
    public function isImg(string $fileName): bool
    {
        $arr = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'];

        $pathInfo = pathinfo($fileName);

        if (!in_array($pathInfo['extension'], $arr)) {
            return false;
        }

        return true;
    }

    /**
     * @param $h
     * @param float $s
     * @param float $l
     * @return array
     */
    public function hslToRgb($h, float $s = 0.8, float $l = 0.6): array
    {
        $r = $l;
        $g = $l;
        $b = $l;
        $v = ($l + $s - $l * $s);
        if ($v > 0) {
            $m = $l + $l - $v;
            $sv = ($v - $m) / $v;
            $h *= 6.0;
            $sextant = floor($h);
            $fract = $h - $sextant;
            $vsf = $v * $sv * $fract;
            $mid1 = $m + $vsf;
            $mid2 = $v - $vsf;

            switch ($sextant) {
                case 0:
                    $r = $v;
                    $g = $mid1;
                    $b = $m;
                    break;
                case 1:
                    $r = $mid2;
                    $g = $v;
                    $b = $m;
                    break;
                case 2:
                    $r = $m;
                    $g = $v;
                    $b = $mid1;
                    break;
                case 3:
                    $r = $m;
                    $g = $mid2;
                    $b = $v;
                    break;
                case 4:
                    $r = $mid1;
                    $g = $m;
                    $b = $v;
                    break;
                case 5:
                    $r = $v;
                    $g = $m;
                    $b = $mid2;
                    break;
            }
        }
        return array('r' => $r * 255.0, 'g' => $g * 255.0, 'b' => $b * 255.0);
    }

}