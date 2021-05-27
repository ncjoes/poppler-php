# PopplerPhp: Comprehensive PHP wrapper for Poppler-utils

PopplerPhp is a complete and very flexible PHP wrapper for [Poppler-utils](http://poppler.freedesktop.org/).
This package is brought to you so you can use php and poppler-utils to extract contents from, and convert your pdf files to any of these formats:

*   HTML
*   JPG, PNG, TIFF
*   PostScript (PS)
*   Encapsulated PostScript (EPS)
*   Scalable Vector Graphic (SVG)
*   Plain Text

You can also use this package to split pdf files, combine pdf files, and detach embedded items from pdf files using within your php scripts.
With the `NcJoes\PopplerPhp\PdfInfo` class, you can query meta-data of any pdf file.

## Important Notes

### Installation

It is recommended to install Poppler-PHP through [Composer](http://getcomposer.org/).

Run this command within your project directory

```shell
composer require ncjoes/poppler-php
```

Or add this line to your `composer.json`

```json
{
	"ncjoes/poppler-php": "0.1.*"
}
```

### Dependencies
In order to use Poppler-PHP, you need to install Poppler. Depending of your configuration, please follow the instructions at 
[http://poppler.freedesktop.org/](http://poppler.freedesktop.org/). You will also need to configure your PHP environment to enable shell access.

Briefly,

#### If you are using Ubuntu Distro, just install it from apt: 

```bash
sudo apt-get install poppler-utils
```

#### For Windows Users
First download poppler-utils for windows here <http://blog.alivate.com.au/poppler-windows/>. 

Extract the downloaded archive and copy the contents of the `bin` directory to `your-project-path/vendor/bin/poppler/`.

#### For OS/X Users

**1. Install brew**

Brew is a famous package manager on OS/X : http://brew.sh/ (aptitude style).

**2. Install poppler**

```bash
brew install poppler
```

### Usage

Here are some samples.

```php
<?php
// if you are using composer, just use this
use NcJoes\PopplerPhp\PdfInfo;
use NcJoes\PopplerPhp\Config;
use NcJoes\PopplerPhp\PdfToCairo;
use NcJoes\PopplerPhp\PdfToHtml;
use NcJoes\PopplerPhp\Constants as C;

// set Poppler utils binary location
Config::setBinDirectory('C:/path-to-project/vendor/bin/poppler');

// set output directory
Config::setOutputDirectory('C:/path-to-project/storage/poppler-output');


// get pdf meta-data
$pdf = new PdfInfo('path-to-file\file.pdf');
$info = $pdf->getInfo(); //returns an associative array
$authors = $pdf->getAuthors();
//...e.t.c.

//Convert PDF document to various image formats
$cairo1 = new PdfToCairo(__DIR__.'/sources/test1.pdf');
$cairo2 = clone $cairo1;
$cairo3 = clone $cairo1;
$cairo4 = clone $cairo1;
$cairo5 = clone $cairo1;
$cairo6 = clone $cairo1;

$cairo1->firstPageOnly();
$cairo1->generatePNG();

$cairo2->firstPageOnly();
$cairo2->generateJPG();

//$cairo3->firstPageOnly();
//$cairo3->generateTIFF();
//PDT to TIFF conversion is not working at the moment, hope to fix it soon

$cairo4->startFromPage(1)->stopAtPage(1);
$cairo4->generatePS();

$cairo5->setPostScriptLevel(C::_LEVEL3)->startFromPage(1)->stopAtPage(1);
$cairo5->generateEPS();

$cairo6->startFromPage(1)->stopAtPage(2);
$cairo6->generateSVG();

//generate HTML
$pdfToHtml = new PdfToHtml(__DIR__.'/tests/sources/test1.pdf');
$pdfToHtml->setZoomRatio(1.8);
$pdfToHtml->exchangePdfLinks();
$pdfToHtml->startFromPage(1)->stopAtPage(5);
$pdfToHtml->generateSingleDocument();
$pdfToHtml->noFrames();
$pdfToHtml->oddPagesOnly();
$pdfToHtml->outputToConsole();
print_r($pdfToHtml->generate()); //html string

?>
```

### License
The PopplerPHP package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

### Feedback & Contribute

Notify me of any issues, bugs, or improvements. Thanks :+1:
