<?php

namespace MLAB\FileManipulation\Model;

use MLAB\FileManipulation\Model\MimeType\MimeTypeInterface;

/**
 * @ Author: Marco De Felice
 * @ Create Time: 2024-02-14 09:01:48
 * @ Description: image base interface model
 */

interface FileInterface
{

    /**
     * return a mime type of an image
     * 
     * @return string
     */
    public function mimeType(): string;

    /**
     * return image name with extension
     * 
     * @return string
     */
    public function name(): string;

    /**
     * set a new image name
     * @param string $newName
     * 
     * @return string
     */
    public function setNewName(string $newName): self;

    /**
     * return image size
     * 
     * @return int
     */
    public function size(): int;

    /**
     * return image path
     * @param bool $fullPath if true returh the image path with it's name
     * 
     * @return string
     */
    public function path(bool $fullPath = false): string;

    /**
     * return image stream
     * 
     * @return string
     */
    public function stream(): string;

    /**
     * Save the new image.
     *
     * @param string|null $path The path to save the image. If null, the image is not saved to disk.
     * @param string|null $newName The new name for the saved image. If null, the original name is used.
     * @param int $quality The quality of the saved image. Default is -1, which uses the default quality.
     * @return bool Returns true if the image is successfully saved, otherwise false.
     */
    public function save(?string $path = null, ?string $newName = null, int $quality = -1): bool;

    /**
     * move uploaded file
     * @param string $file
     * @param bool $override
     * 
     * @return void
     */
    public function move(string $file, bool $override = false): void;


}
