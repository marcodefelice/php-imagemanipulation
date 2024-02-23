# PHP File Upload adn Manipulation

## Description
The Package was developed in PHP 8 to facilitate the manipulation and uploading of files, with a particular focus on image management.

## Main Features
- Simple and intuitive manipulation of files and images (resize, crop).
- Easy and secure file upload, with support for file type validation.
- Image file support:
- - Jpeg::MIME_TYPE,
- - PJpeg::MIME_TYPE,
- - Png::MIME_TYPE,
- - Giff::MIME_TYPE,
- - Bmp::MIME_TYPE,
- - Webp::MIME_TYPE,
- - Svg::MIME_TYPE,

## Requirements
PHP 8 or later
GD php library

## Installation
You can install the package via Composer
composer require mlab/filemanipulation

## Usage
Here's a basic example of how to use your package:

```
<?php
use MLAB\FileManipulation\Model\Image;
use MLAB\FileManipulation\Model\FileInterface;
use MLAB\FileManipulation\Service\ImageClientService;
use Psr\Http\Message\ServerRequestInterface as Request;

$files = $request->getUploadedFiles();
    foreach($files['file'] as $k => $file) {

        if(!empty($file->getClientMediaType())) {
            //Create and upload image
            $image = new ImageClientService(
                new Image($file,__DIR__.'/../../../../public/img/post/'),
                new Log()
            );

            $newName = trim(uniqid().$k.time());
            $image->resize(null,200)->save($newName,__DIR__.'/../../../../public/img/post/');
            $assets[] = $image;
        }

    }
```


### Contributions
We are open to contributions! If you want to improve this package, fork the repository and open a pull request.

### Bug Report
If you have found a bug or have suggestions for improving the package, open a new issue in our issue tracking system.

### License
This package is distributed under the MIT License.