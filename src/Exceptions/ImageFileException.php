<?php

namespace MLAB\FileManipulation\Exceptions;

use Exception;
use MLAB\FileManipulation\Model\FileInterface;

/**
 * @ Author: Marco De Felice
 * @ Create Time: 2024-02-14 09:01:48
 * @ Description: Image file exceptions
 */

 class ImageFileException extends Exception {

    public function __construct(FileInterface $file, string $message = '')
    {
        if(!empty($message)) {
            $message = $message;
        } else {
            $message = 'The uploaded image is not valid image';
        }

        $context = $message."\r\n";
        $context .= "File: " .$file->name()."\n\r";
        $context .= "MimeType: " .$file->mimeType()."\n\r";
        $context = "Fize: " .$file->size()."\n\r";
        $context = "Content: " .$file->stream()."\n\r";


        parent::__construct($context, 500);
    }
 }