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
    public string $name;

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

    private function __construct(string $value, string $name)
    {
        $this->value = $value;
        $this->name = $name;
    }


    public static function fromName(string $name): MimeType
    {
        foreach (self::cases as $key => $status) {
            if( $name === $key ){
                return new MimeType($status, $key);
            }
        }

        throw new ValueError("$name is not a valid backing value for enum " . self::class, 500);
    }

    public static function fromValues(string $value): MimeType
    {
        foreach (self::cases as $key => $status) {
            if($status == $value) {
                return new MimeType($status, $key);
            }
        }

        throw new ValueError("$value is not a valid backing value for enum " . self::class, 500);

    }

    public static function values(): array
    {
        $results = [];
        foreach (self::cases as $key => $status) {
            $results[] = $key;
        }
        return $results;
    }
}
