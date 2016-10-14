# Php-PDF-Suite: PHP wrapper for Poppler-utils

This package is brought to you so you can use php and poppler-utils to convert your pdf files to any of these formats

*   HTML5
*   JPG, PNG, TIFF
*   PostScript (PS)
*   Encapsulated PostScript (EPS)
*   Scalable Vector Graphic (SVG)
*   Plain Text

You can also use this package to split, combine, detach embedded items and combine pdf files from within your php script.
With the `NcJoes\PhpPoppler\PdfInfo` class, you can query meta-data of any pdf file.

## Important Notes

...

## Installation

When you are in your active directory apps, you can just run this command to add this package on your app

```shell
composer require ncjoes/php-poppler:~1
```

Or add this line to your `composer.json`

```json
{
	"ncjoes/php-poppler": "~1"
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
// if you are using composer, just use this
use NcJoes\PhpPoppler\PdfInfo;
use NcJoes\PhpPoppler\Config;
use NcJoes\PhpPoppler\PdfToCairo;
use NcJoes\PhpPoppler\PdfToHtml;

$pdf = new PdfInfo('path-to-file\file.pdf');

// get pdf meta-data
$info = $pdf->getInfo(); //returns an associative array
$authors = $pdf->getAuthors();
//...e.t.c.

// set Poppler utils binary location
Config::setBinDirectory('C:/path-to-project/vendor/bin/poppler');
// set output directory
Config::setOutputDirectory('C:/path-to-project/storage/poppler-output');

//convert pdf to images
$pdfToCairo = new PdfToCairo(__DIR__.'/tests/sources/test1.pdf');

//odd pages only
$pdfToCairo->oddPagesOnly();
$pdfToCairo->generatePNG();

//generate pdf's first page as SVG
$pdfToCairo->firstPageOnly()->generateSVG();

//generate screen shots of first 5 pages
$pdfToCairo->startFromPage(1)->stopAtPage(5);
$pdfToCairo->generateJPG();

//generate HTML
$pdfToHtml = new PdfToHtml(__DIR__.'/tests/sources/test1.pdf');
$pdfToHtml->setZoomRatio(1.8);
$pdfToHtml->exchangePdfLinks();
$pdfToHtml->generate();

?>
```

## Usage note for Windows Users
For those who need this package in windows, there is a way. First download poppler-utils for windows here <http://blog.alivate.com.au/poppler-windows/>. 
And download the latest binary.

Extract the downloaded archive and copy the contents of the `bin` directory to `your-project-path/vendor/bin/poppler/`.

## Usage note for OS/X Users

**1. Install brew**

Brew is a famous package manager on OS/X : http://brew.sh/ (aptitude style).

**2. Install poppler**

```bash
brew install poppler
```

**3. Verify the path of the bin directory**

**4. Whatever the paths are, use ```NcJoes\Php\Config::setBinDirectory``` to set them in your php code**.
Obviously, use the same path as the one given by the ```which``` command;

## Feedback & Contribute

Send me an issue for improvement or any buggy thing. Thanks :+1:
