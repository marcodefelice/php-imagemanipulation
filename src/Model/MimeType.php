<?php
namespace MLAB\FileManipulation\Model;

/**
 * @ Author: Marco De Felice
 * @ Create Time: 2024-02-14 09:01:48
 * @ Description: image model
 */

 use MLAB\FileManipulation\Exceptions\ValueError;

enum MimeType: string {

    case jpeg = 'image/jpeg';
    case pjpeg = 'image/pjpeg';
    case png = 'image/png';
    case giff = 'image/giff';
    case tiff = 'image/tiff';
    case webp = 'image/webp';
    case bmp = 'image/bmp';
    case svg = 'image/svg';


    public static function fromName(string $name): MimeType
    {
        foreach (self::cases() as $status) {
            if( $name === $status->name ){
                return $status;
            }
        }

        throw new ValueError("$name is not a valid backing value for enum " . self::class, 500);
    }

    public static function fromValues(string $value): MimeType
    {
        foreach (self::cases() as $status) {
            if($status->value == $value) {
                return $status;
            }
        }

        throw new ValueError("$value is not a valid backing value for enum " . self::class, 500);

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
