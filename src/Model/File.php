<?php

namespace MLAB\FileManipulation\Model;

/**
 * @ Author: Marco De Felice
 * @ Create Time: 2024-02-14 09:01:48
 * @ Description: image model
 */

use Exception;
use Psr\Http\Message\UploadedFileInterface;

/**
 * Class File
 * @package MLAB\FileManipulation\Model
 *
 * @Author: Marco De Felice
 * @Create Time: 2024-02-14 09:01:48
 * @Description: Image model representing an uploaded file.
 */

class File implements FileInterface
{
    protected UploadedFileInterface $file;
    protected string $path;
    protected string $name;
    protected string $fullPath;
    protected string $extension;

    protected $allowdMimeType = [
        
    ];

    /**
     * File constructor.
     *
     * @param UploadedFileInterface $file The uploaded file instance.
     * @param string $path The destination path for the uploaded file.
     * @throws Exception If the file is not provided, has an invalid mime/type, or if the GD extension is not enabled.
     */
    public function __construct(UploadedFileInterface $file, string $path)
    {
        if(empty($file->getClientFilename())) {
            throw new Exception("You must send a file" . $file->getClientMediaType());
        }

        if (!in_array($file->getClientMediaType(), $this->allowdMimeType)) {
            throw new Exception("File is with wrong mime/type :" . $file->getClientMediaType());
        }

        if (extension_loaded('gd') === false) {
            throw new Exception("GD extension must be enabled", 500);
        }

        if(!file_exists($path)) {
            mkdir($path,0775,true);
        }

        $this->file = $file;
        $this->path = $path;
        $this->extension = FileExtension::fromMimeType($file->getClientMediaType())->value;
        $this->name = trim(str_replace($this->extension, '', $file->getClientFilename()));
        $this->fullPath = $path . $this->name();
    }

    /**
     * return a mime type of an image
     * 
     * @return string
     */
    public function mimeType(): string
    {
        return $this->file->getClientMediaType();
    }

    /**
     * return image name with extension
     * 
     * @return string
     */
    public function name(): string
    {
        return $this->name . $this->extension;
    }

    /**
     * set a new image name
     * @param string $newName
     * 
     * @return string
     */
    public function setNewName(string $newName): self
    {
        $this->name = $newName;
        return $this;
    }

    /**
     * return image size
     * 
     * @return int
     */
    public function size(): int
    {
        return $this->file->getSize();
    }

    /**
     * return image path
     * @param bool $fullPath if true returh the image path with it's name
     * 
     * @return string
     */
    public function path(bool $fullPath = false): string
    {
        return $this->path . $this->name();
    }

    /**
     * return image stream
     * 
     * @return string
     */
    public function stream(): string
    {
        return $this->file->getStream();
    }

    /**
     * move uploaded file
     * @param string $file
     * @param bool $override
     * 
     * @return void
     */
    public function move(string $file, bool $override = false): void
    {

        if ($override === false) {
            $this->ifFileExist($file);
        }

        $this->file->moveTo($this->path());
    }

    /**
     * Save the new image.
     *
     * @param string|null $path The path to save the image. If null, the image is not saved to disk.
     * @param string|null $newName The new name for the saved image. If null, the original name is used.
     * @param int $quality The quality of the saved image. Default is -1, which uses the default quality.
     * @return bool Returns true if the image is successfully saved, otherwise false.
     */
    public function save(?string $path = null, ?string $newName = null, int $quality = -1): bool
    {
        //TODO:
        return false;
    }

    /**
     * check if file already exist
     * 
     */
    private function ifFileExist(string $path, $i = 0): void
    {   
        $i = $i+1;
        if (file_exists($path)) {
            $this->name = rtrim($this->name, '') . $i;
            $path = $this->path(true);
            $this->ifFileExist($path, $i);
        }

    }

    /**
     * Get the value of fullPath
     *
     * @return string
     */
    public function getFullPath(): string
    {
        return $this->fullPath;
    }
}
