<?php

namespace MLAB\FileManipulation\Service;

use MLAB\FileManipulation\Model\FileInterface;

/**
 * @ Author: Marco De Felice
 * @ Create Time: 2024-02-14 09:01:48
 * @ Description: upload image library
 */

abstract class FileService {

    protected FileInterface $file;
    protected string $pathToUpload = __DIR__ . '/../../storage/';


    public function __construct(FileInterface $file)
    {
        $this->file = $file;
    }

    /**
     * Upload an image from a specific source.
     *
     * @param mixed $source Image source (file path, URL, GD resource, etc.).
     * @return mixed Object representing the image.
     */
    abstract public function load(): string;

    /**
     * Save an image to a specific destination.
     *
     * @param string $imageName Image object to save.
     * @param string $pathToUpload $destination Destination of the image (file path, URL, etc.).
     * @param int $qality
     * @return void
     */
    abstract public function save(string $imageName, string $pathToUpload, int $quality = -1): void;

    /**
     * delete file from disk
     */
    public function delete()
    {
        @unlink($this->file->path() . $this->file->name());
    }

    /**
     *  change directory file
     *  @param string $toDir
     * @param $createDir true if you want to create a new directory
     * 
     * @return self
     */
    public function moveToDir(string $toDir, bool $createDir = true): self
    {
        if (!file_exists($toDir) && $createDir === true) {
            mkdir($toDir, 0775, true);
        }
        $from = $this->file->path() . $this->file->name();
        move_uploaded_file($from, $toDir);

        return $this;
    }


    /**
     * Get the value of file
     *
     * @return mixed
     */
    public function getFile(): FileInterface
    {
        return $this->file;
    }
}