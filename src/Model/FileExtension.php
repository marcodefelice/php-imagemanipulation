<?php

namespace MLAB\FileManipulation\Model;

/**
 * @ Author: Marco De Felice
 * @ Create Time: 2024-02-14 09:01:48
 * @ Description: image model
 */

 use MLAB\FileManipulation\Exceptions\ValueError;

enum FileExtension: string {

    case jpeg = '.jpeg';
    case pjpeg = '.pjpeg';
    case png = '.png$';
    case gif = '.gif';
    case tiff = '.tiff';
    case webp = '.webp';
    case bmp = '.bmp';
    case svg = '.svg';


    public static function fromName(string $name): FileExtension
    {
        foreach (self::cases() as $status) {
            if( $name === $status->name ){
                return $status;
            }
        }

        throw new ValueError("$name is not a valid backing value for enum " . self::class, 500);
    }

    public static function fromMimeType(string $mimetype): FileExtension
    {
        $type = MimeType::fromValues($mimetype);
        $label = $type->name;
        return FileExtension::fromName($label);

    }

    public static function values(): array
    {
        $results = [];
        foreach (self::cases() as $status) {
            $results[] = $status->name;
        }
        return $results;
    }
}
