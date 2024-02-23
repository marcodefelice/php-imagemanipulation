<?php

namespace MLAB\FileManipulation\Model;

/**
 * @ Author: Marco De Felice
 * @ Create Time: 2024-02-14 09:01:48
 * @ Description: image model
 */

use Exception;
use GuzzleHttp\Psr7\MimeType;
use Psr\Http\Message\UploadedFileInterface;
use MLAB\FileManipulation\Exceptions\ImageFileException;
use MLAB\FileManipulation\Model\MimeType\MimeTypeInterface;
use MLAB\FileManipulation\Model\MimeType\Jpeg;
use MLAB\FileManipulation\Model\MimeType\PJpeg;
use MLAB\FileManipulation\Model\MimeType\Png;
use MLAB\FileManipulation\Model\MimeType\Giff;
use MLAB\FileManipulation\Model\MimeType\Bmp;
use MLAB\FileManipulation\Model\MimeType\Webp;
use MLAB\FileManipulation\Model\MimeType\Svg;

class Image extends File implements FileInterface
{
    protected UploadedFileInterface $file;
    protected string $path;

    protected $allowdMimeType = [
        Jpeg::MIME_TYPE,
        PJpeg::MIME_TYPE,
        Png::MIME_TYPE,
        Giff::MIME_TYPE,
        Bmp::MIME_TYPE,
        Webp::MIME_TYPE,
        Svg::MIME_TYPE,
    ];

    /**
     * @param int|null $w
     * @param int|null $h
     * @param bool $crop
     * 
     * @return MimeTypeInterface
     */
    function resize($w, $h, $crop = FALSE): MimeTypeInterface
    {
        $this->move($this->path(true), false);
        $file = $this->file;
        switch ($file->getClientMediaType()) {
            case Jpeg::MIME_TYPE:
                return Jpeg::resize($this, $w, $h, $crop);
                break;

            case Png::MIME_TYPE:
                return Png::resize($this, $w, $h, $crop);
                break;

            case Giff::MIME_TYPE:
                return Giff::resize($this, $w, $h, $crop);
                break;

            case Bmp::MIME_TYPE:
                return Bmp::resize($this, $w, $h, $crop);
                break;

            case Webp::MIME_TYPE:
                return Webp::resize($this, $w, $h, $crop);
                break;

                //TODO:
                // case 'image/tiff':
                //     $image = new Tiff($this);
                //     break;

                // case 'image/svg':
                //     $image = new Svg($this);
                //     break;

            default:
                throw new ImageFileException(new self($this->file, $this->path), 'Unable to resize this type of image');
        }
    }
}
