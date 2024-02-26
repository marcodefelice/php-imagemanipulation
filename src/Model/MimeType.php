<?php
namespace MLAB\FileManipulation\Model;

/**
 * @ Author: Marco De Felice
 * @ Create Time: 2024-02-14 09:01:48
 * @ Description: image model
 */

 use MLAB\FileManipulation\Exceptions\ValueError;

class MimeType {

    public string $value;

    const cases = [
        "jpeg" => 'image/jpeg',
        "pjpeg" => 'image/pjpeg',
        "png" => 'image/png',
        "giff" => 'image/giff',
        "tiff" => 'image/tiff',
        "webp" => 'image/webp',
        "bmp" => 'image/bmp',
        "svg" => 'image/svg',
    ];

    private function __construct(string $value)
    {
        $this->value = $value;
    }


    public static function fromName(string $name): MimeType
    {
        foreach (self::cases as $status) {
            if( $name === $status->name ){
                return new MimeType($status);
            }
        }

        throw new ValueError("$name is not a valid backing value for enum " . self::class, 500);
    }

    public static function fromValues(string $value): MimeType
    {
        foreach (self::cases as $status) {
            if($status == $value) {
                return new MimeType($status);
            }
        }

        throw new ValueError("$value is not a valid backing value for enum " . self::class, 500);

    }

    public static function values(): array
    {
        $results = [];
        foreach (self::cases as $status) {
            $results[] = $status->name;
        }
        return $results;
    }
}
