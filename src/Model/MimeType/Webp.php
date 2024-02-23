<?php

namespace MLAB\FileManipulation\Model\MimeType;

use GdImage;
use MLAB\FileManipulation\Exceptions\ImageFileException;
use MLAB\FileManipulation\Model\FileInterface;

/**
 * @ Author: Marco De Felice
 * @ Create Time: 2024-02-14 09:01:48
 * @ Description: Jpeg file netity
 */

final class Webp implements MimeTypeInterface, FileInterface
{
    public const MIME_TYPE = 'image/webp';
    public const EXTENSION = '.webp';

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
    public static function resize(FileInterface $file, $w, $h, $crop = FALSE): self
    {
        list($width, $height) = $file->size();
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width-($width*abs($r-$w/$h)));
            } else {
                $height = ceil($height-($height*abs($r-$w/$h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w/$h > $r) {
                $newwidth = $h*$r;
                $newheight = $h;
            } else {
                $newheight = $w/$r;
                $newwidth = $w;
            }
        }
        $src = imagecreatefromwebp($file->path(true));
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        return new Webp($dst, $file);
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
            $path = $this->file->setNewName($newName);
        }
        
        $fullPath = $path.$this->file->name().'.jpeg';
        if(imagewebp($this->image,$fullPath,$quality)) {
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
