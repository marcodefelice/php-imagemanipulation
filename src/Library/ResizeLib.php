<?php

namespace MLAB\FileManipulation\Library;

use InvalidArgumentException;
use MLAB\FileManipulation\Model\FileInterface;
use MLAB\FileManipulation\Model\MimeType\MimeTypeInterface;

/**
 * @ Author: Marco De Felice
 * @ Create Time: 2024-02-14 09:01:48
 * @ Description: resize class
 */

class ResizeLib
{
    private $classReference;
    private const RESIZE_TYPE = [
        'crop',
        'fit',
        'stretch'
    ];

    /**
     *  instantiate class with the right object file
     *  @param string $file
     */
    public function __construct(string $classReference)
    {
        $this->classReference = $classReference;
    }
    /**
     * Resize an image with various options.
     *
     * @param FileInterface $file The file to resize.
     * @param int|null $width The target width.
     * @param int|null $height The target height.
     * @param string $resizeType The type of resize operation: 'crop', 'fit', 'stretch'.
     * @return MimeTypeInterface
     */
    public function resize(FileInterface $file, $width = null, $height = null, $resizeType = 'fit'): MimeTypeInterface
    {
        if(!in_array($resizeType, self::RESIZE_TYPE)) {
            throw new InvalidArgumentException("Resize type value is not correct choose one of these ".implode(',', self::RESIZE_TYPE));
        }

        // Create source and destination images
        $src = imagecreatefromjpeg($file->path(true));

        $originalWidth = imagesx($src);
        $originalHeight = imagesy($src);

        // Calculate aspect ratio
        $aspectRatio = $originalWidth / $originalHeight;

        // Determine new dimensions based on resize type
        switch ($resizeType) {
            case 'crop':
                list($newWidth, $newHeight) = self::calculateCropDimensions($width, $height, $aspectRatio);
                break;
            case 'stretch':
                $newWidth = $width;
                $newHeight = $height;
                break;
            case 'fit':
            default:
                list($newWidth, $newHeight) = self::calculateFitDimensions($width, $height, $aspectRatio);
                break;
        }

        $newHeight = ceil($newHeight);
        $newWidth  = ceil($newWidth);

        $dst = imagecreatetruecolor((int) $newWidth, (int) $newHeight);

        // Resize and copy
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

        // Return the resized image
        return new $this->classReference($dst, $file);
    }

    /**
     * Calculate dimensions for cropping.
     *
     * @param int|null $width The target width.
     * @param int|null $height The target height.
     * @param float $aspectRatio The original image aspect ratio.
     * @return array The calculated dimensions [$newWidth, $newHeight].
     */
    private function calculateCropDimensions($width, $height, $aspectRatio): array
    {
        if (!$width && !$height) {
            throw new InvalidArgumentException('At least one of width or height must be provided for crop operation.');
        }

        if (!$width) {
            $width = $height * $aspectRatio;
        }

        if (!$height) {
            $height = $width / $aspectRatio;
        }

        return [$width, $height];
    }

    /**
     * Calculate dimensions for fitting without deformation.
     *
     * @param int|null $width The target width.
     * @param int|null $height The target height.
     * @param float $aspectRatio The original image aspect ratio.
     * @return array The calculated dimensions [$newWidth, $newHeight].
     */
    private function calculateFitDimensions($width, $height, $aspectRatio): array
    {
        if (!$width && !$height) {
            throw new InvalidArgumentException('At least one of width or height must be provided for fit operation.');
        }

        if (!$width) {
            $width = $height * $aspectRatio;
        }

        if (!$height) {
            $height = $width / $aspectRatio;
        }

        return [$width, $height];
    }
}
