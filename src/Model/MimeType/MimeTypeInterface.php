<?php

namespace MLAB\FileManipulation\Model\MimeType;

use MLAB\FileManipulation\Model\FileInterface;

/**
 * @ Author: Marco De Felice
 * @ Create Time: 2024-02-14 09:01:48
 * @ Description: image base interface model
 */

/**
 * Interface MimeTypeInterface
 * Represents an interface for handling image resizing and saving operations.
 */
interface MimeTypeInterface
{
    /**
     * Resize an image with various options.
     *
     * @param FileInterface $file The file to resize.
     * @param int|null $width The target width.
     * @param int|null $height The target height.
     * @param string $resizeType The type of resize operation: 'fit', 'crop', 'stretch'.
     * @return self The resized image instance.
     */
    public static function resize(FileInterface $file, $width, $height, $resizeType = 'fit'): self;

    /**
     * Save the new image.
     *
     * @param string|null $path The path to save the image. If null, the image is not saved to disk.
     * @param string|null $newName The new name for the saved image. If null, the original name is used.
     * @param int $quality The quality of the saved image. Default is -1, which uses the default quality.
     * @return bool Returns true if the image is successfully saved, otherwise false.
     */
    public function save(?string $path = null, ?string $newName = null, int $quality = -1): bool;
}

