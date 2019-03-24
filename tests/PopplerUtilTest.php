<?php

/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/13/2016
 * Time:    2:31 PM
 **/
use NcJoes\PopplerPhp\Config;
use NcJoes\PopplerPhp\Constants as C;
use NcJoes\PopplerPhp\PdfInfo;
use NcJoes\PopplerPhp\PdfToCairo;

class PopplerUtilTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testSetOutputFileName()
    {
        $DS = DIRECTORY_SEPARATOR;
        $file = __DIR__.$DS."sources{$DS}test1.pdf";
        $pdf = new PdfToCairo($file);
        $pdf->setOutputFilenamePrefix('different-name');

        $this->assertEquals('different-name', $pdf->getOutputFilenamePrefix());
    }

    public function testMakeOptionsMethod()
    {
        $DS = DIRECTORY_SEPARATOR;
        $file = __DIR__.$DS."sources{$DS}test1.pdf";
        $pdf = new PdfInfo($file);

        $pdf->startFromPage(10);
        $this->assertArrayHasKey('-f', $pdf->getOptions());

        $pdf->stopAtPage(20);
        $this->assertArrayHasKey('-l', $pdf->getOptions());

        $pdf->listEncodings();
        $this->assertArrayHasKey('-listenc', $pdf->getFlags());

        $pdf->isoDates();
        $this->assertArrayHasKey('-isodates', $pdf->getFlags());

        $this->assertContains('-f', $pdf->previewShellOptions());
    }

    public function testOutputDirMethodSetterAndGetter()
    {
        Config::setOutputDirectory(Config::getOutputDirectory(C::DFT));
        $this->assertTrue(Config::isKeySet(C::OUTPUT_DIR));

        $DS = DIRECTORY_SEPARATOR;
        $file = __DIR__.$DS."sources{$DS}test1.pdf";
        $cairo = new PdfToCairo($file);

        $this->assertTrue($cairo->getOutputPath() != dirname($file));
    }

    public function testMakeCommandMethod()
    {
        $q = PHP_OS === 'WINNT' ? "\"" : "'";
        $DS = DIRECTORY_SEPARATOR;
        $file = __DIR__.$DS."sources{$DS}test1.pdf";
        $output_file_prefix = 'test-file';

        $pdf = new PdfToCairo($file);
        $pdf->setOutputFilenamePrefix($output_file_prefix);

        $bin_dir = Config::getBinDirectory();
        $bin_file = C::PDF_TO_CAIRO;
        $output_dir = Config::getOutputDirectory();

        $expected_bin = "{$q}{$bin_dir}{$DS}{$bin_file}{$q}";
        $expected_src = "{$q}{$file}{$q}";
        $expected_dest = "{$q}{$output_dir}{$DS}{$output_file_prefix}{$q}";
        $this->assertRegExp(
            "%^{$expected_bin} {$expected_src} {$expected_dest}$%",
            $pdf->previewShellCommand()
        );
    }

    public function testMakeCommandMethodWithSubDirEnabled()
    {
        $q = PHP_OS === 'WINNT' ? "\"" : "'";
        $DS = DIRECTORY_SEPARATOR;
        $file = __DIR__.$DS."sources{$DS}test1.pdf";
        $output_file_prefix = 'test-file';

        $pdf = new PdfToCairo($file);
        $pdf->setSubDirRequired(true);
        $pdf->setOutputFilenamePrefix($output_file_prefix);

        $bin_dir = Config::getBinDirectory();
        $bin_file = C::PDF_TO_CAIRO;
        $output_dir = Config::getOutputDirectory();
        $output_sub_dir = $pdf->getOutputSubDir();

        $expected_bin = "{$q}{$bin_dir}{$DS}{$bin_file}{$q}";
        $expected_src = "{$q}{$file}{$q}";
        $expected_dest = "{$q}{$output_dir}{$DS}{$output_sub_dir}{$DS}{$output_file_prefix}{$q}";
        $this->assertRegExp(
            "%^{$expected_bin} {$expected_src} {$expected_dest}$%",
            $pdf->previewShellCommand()
        );
    }
}
