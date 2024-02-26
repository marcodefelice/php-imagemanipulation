<?php

namespace MLAB\FileManipulation\Model;

/**
 * @ Author: Marco De Felice
 * @ Create Time: 2024-02-14 09:01:48
 * @ Description: image model
 */

 use MLAB\FileManipulation\Exceptions\ValueError;

class FileExtension {

    public string $value;
    public string $name;

    const cases = [
        "jpeg"  => '.jpeg',
        "pjpeg" => '.pjpeg',
        "png"   => '.png$',
        "gif"   => '.gif',
        "tiff"  => '.tiff',
        "webp"  => '.webp',
        "bmp"   => '.bmp',
        "svg"   => '.svg',
    ];


    private function __construct(string $value, string $name)
    {
        $this->value = $value;
        $this->name = $name;
    }


    public static function fromName(string $name): FileExtension
    {
        foreach (self::cases as $key => $status) {
            if( $name === $key ){
                return new FileExtension($status, $key);
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
        foreach (self::cases as $key => $status) {
            $results[] = $key;
        }
        return $results;
    }
}
