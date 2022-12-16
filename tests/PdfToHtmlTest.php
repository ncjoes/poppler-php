<?php

/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/14/2016
 * Time:    4:46 AM
 **/

use NcJoes\PopplerPhp\Config;
use NcJoes\PopplerPhp\Exceptions\PopplerPhpException;
use NcJoes\PopplerPhp\PdfToHtml;
use PHPUnit\Framework\TestCase;
use NcJoes\PopplerPhp\Constants as C;

/**
 * Class PdfToHtmlTest
 */
class PdfToHtmlTest extends PHPUnit\Framework\TestCase
{
    /**
     *
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @throws PopplerPhpException
     */
    public function testGenerateMethod()
    {
        Config::setOutputDirectory(Config::getOutputDirectory(true), true);
        $DS = DIRECTORY_SEPARATOR;
        $file = __DIR__ . $DS . "sources{$DS}test1.pdf";
        $pdfToHtml = new PdfToHtml($file);

        //$cairo->oddPagesOnly();
        //$cairo->generatePNG();

        //$cairo->startFromPage(1)->stopAtPage(1);
        //$cairo->generateSVG();

        $pdfToHtml->startFromPage(1)->stopAtPage(5);
        $pdfToHtml->generateSingleDocument();
        $pdfToHtml->noFrames();
        $pdfToHtml->oddPagesOnly();
        $pdfToHtml->generate();
        $outputPath = $pdfToHtml->getOutputPath();
        $this->assertFileExists($outputPath . C::DS . 'test1.html');
    }
}
