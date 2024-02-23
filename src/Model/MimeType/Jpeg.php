<?php

namespace MLAB\FileManipulation\Model\MimeType;

use GdImage;
use MLAB\FileManipulation\Exceptions\ImageFileException;
use MLAB\FileManipulation\Library\ResizeLib;
use MLAB\FileManipulation\Model\FileInterface;
use MLAB\FileManipulation\Model\MimeType\MimeTypeInterface;

/**
 * @ Author: Marco De Felice
 * @ Create Time: 2024-02-14 09:01:48
 * @ Description: Jpeg file netity
 */

final class Jpeg implements MimeTypeInterface, FileInterface
{
    public const MIME_TYPE = 'image/jpeg';
    public const EXTENSION = '.jpg';
    
    private GdImage $image;
    private FileInterface $file;

    public function __construct(GdImage $newImage, FileInterface $file)
    {
        $this->image = $newImage;
        $this->file = $file;
    }

    /**
     * resize an image
     */
    public static function resize(FileInterface $file, $w, $h, $resizeType = 'fit'): MimeTypeInterface
    {
        $ressize = new ResizeLib(Jpeg::class);
        return $ressize->resize($file, $w, $h, $resizeType);

    }

    /**
     * save the new image
     * @param string $path to save image
     * @param int $quality
     * 
     * @return true
     */
    public function save(?string $path = null, ?string $newName = null, int $quality = -1): bool
    {   

        if(is_null($path)) {
            $path = $this->file->path();
        }

        if(!is_null($newName)) {
            $this->file->setNewName($newName);
        }

        $fullPath = $path.$this->file->name();

        if(imagejpeg($this->image,$fullPath,$quality)) {
            return true;
        }

        throw new ImageFileException($this->file, 'Unable to save new file');
    }

    /**
     * return a mime type of an image
     * 
     * @return string
     */
    public function mimeType(): string
    {
        return $this->file->mimeType();
    }

    /**
     * return image name with extension
     * 
     * @return string
     */
    public function name(): string
    {
        return $this->file->name();
    }

    /**
     * set a new image name
     * @param string $newName
     * 
     * @return string
     */
    public function setNewName(string $newName): self
    {
        $this->file->setNewName($newName);
        return $this;
    }

    /**
     * return image size
     * 
     * @return int
     */
    public function size(): int
    {
        return $this->file->size();
    }

    /**
     * return image path
     * @param bool $fullPath if true returh the image path with it's name
     * 
     * @return string
     */
    public function path(bool $fullPath = false): string
    {
        return $this->file->path($fullPath);
    }

    /**
     * return image stream
     * 
     * @return string
     */
    public function stream(): string
    {
        return $this->file->stream();
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
        //TODO:
    }

}
