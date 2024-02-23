<?php

namespace MLAB\FileManipulation\Model\MimeType;

use MLAB\FileManipulation\Exceptions\ImageFileException;
use MLAB\FileManipulation\Model\FileInterface;

/**
 * @ Author: Marco De Felice
 * @ Create Time: 2024-02-14 09:01:48
 * @ Description: PNG file netity
 */

final class Svg
{
    public const MIME_TYPE = 'image/svg';
    public const EXTENSION = '.svg';

    public function __construct(FileInterface $imageSourse)
    {
        if($imageSourse->mimeType() !== self::MIME_TYPE) {
            throw new ImageFileException($imageSourse, $imageSourse->name()." is not valid");
        }
        
    }


}
