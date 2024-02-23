<?php

namespace MLAB\FileManipulation\Service;

use MLAB\FileManipulation\Model\FileInterface;
use MLAB\FileManipulation\Exceptions\ImageServiceException;
use MLAB\FileManipulation\Model\MimeType\MimeTypeInterface;

/**
 * @ Author: Marco De Felice
 * @ Create Time: 2024-02-14 09:01:48
 * @ Description: upload image library
 */

class ImageClientService extends FileService
{
    protected string $pathToUpload = __DIR__ . '/../../storage/';

    /**
     * resize image before upload
     * 
     * @param int $h
     * @param int $w
     * @param bool $resize
     * 
     * @return self
     */
    public function resize(?int $w, ?int $h = null, $resize = 'fit'): self
    {
        $this->file = $this->file->resize($w, $h, $resize);
        return $this;
    }

    /**
     * Upload an image from a specific source.
     *
     * @param mixed $source Image source (file path, URL, GD resource, etc.).
     * @return mixed Object representing the image.
     */
    public function load(): string
    {
        $content = file_get_contents($this->file->path(true));
        if($content === false) {
            throw new ImageServiceException("Unable to load image file", 500);
        }

        return $content;
    }

    /**
     * Save an image to a specific destination.
     *
     * @param string $fileName Image object to save.
     * @param string $pathToUpload $destination Destination of the image (file path, URL, etc.).
     * @param int $qality
     * @return bool True if the save was successful, otherwise false.
     */
    public function save(string $fileName, string $pathToUpload, int $quality = -1): void
    {  
        $this->file->setNewName($fileName);
        $this->file->save($pathToUpload, $fileName, $quality);
    }
}
