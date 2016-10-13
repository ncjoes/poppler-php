# Php-PDF-Suite: PHP wrapper for Poppler-utils

This package is brought to you so you can use php and poppler-utils to convert your pdf files to any of these formats

*   HTML5
*   JPG, PNG, TIFF
*   PostScript (PS)
*   Encapsulated PostScript (EPS)
*   Scalable Vector Graphic (SVG)
*   Plain Text

You can also use this package to split, combine, detach embedded items and combine pdf files from within your php script.
With the `NcJoes\PdfInfo` class, you can query meta-data of any pdf file.

## Important Notes

...

## Installation

When you are in your active directory apps, you can just run this command to add this package on your app

```shell
composer require ncjoes/php-pdf-suite:dev-master
```

Or add this package to your `composer.json`

```json
{
	"ncjoes/php-pdf-suite": "dev-master"
}
```

## Requirements
1. Poppler-Utils (if you are using Ubuntu Distro, just install it from apt )
	`sudo apt-get install poppler-utils`
2. PHP Configuration with shell access enabled

## Usage

Here is the sample.

```php
<?php

?>
```

## Usage note for Windows Users
For those who need this package in windows, there is a way. First download poppler-utils for windows here <http://blog.alivate.com.au/poppler-windows/>. And download the latest binary.

Extract the downloaded archive and copy the contents of the `bin` directory to `your-project-path/vendor/poppler/`.

```php
<?php

?>
```

## Usage note for OS/X Users

**1. Install brew**

Brew is a famous package manager on OS/X : http://brew.sh/ (aptitude style).

**2. Install poppler**

```bash
brew install poppler
```

**3. Verify the path of the bin directory**

**4. Whatever the paths are, use ```NcJoes\Php\Config::set``` to set them in your php code**. Obviously, use the same path as the one given by the ```which``` command;

```php
<?php

?>
```

## Feedback & Contribute

Send me an issue for improvement or any buggy thing. Thanks :+1:
