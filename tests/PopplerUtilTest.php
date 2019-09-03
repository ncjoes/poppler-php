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
use NcJoes\PopplerPhp\Exceptions\PopplerPhpException;
use NcJoes\PopplerPhp\PdfInfo;
use NcJoes\PopplerPhp\PdfToCairo;
use NcJoes\PopplerPhp\PdfUnite;

/**
 * Class PopplerUtilTest
 */
class PopplerUtilTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @throws PopplerPhpException
     */
    public function testSetOutputFileName()
    {
        $DS = DIRECTORY_SEPARATOR;
        $file = __DIR__.$DS."sources{$DS}test1.pdf";
        $pdf = new PdfToCairo($file);
        $pdf->setOutputFilenamePrefix('different-name');

        static::assertEquals('different-name', $pdf->getOutputFilenamePrefix());
    }

    /**
     * @throws PopplerPhpException
     */
    public function testMakeOptionsMethod()
    {
        $DS = DIRECTORY_SEPARATOR;
        $file = __DIR__.$DS."sources{$DS}test1.pdf";
        $pdf = new PdfInfo($file);

        $pdf->startFromPage(10);
        static::assertArrayHasKey('-f', $pdf->getOptions());

        $pdf->stopAtPage(20);
        static::assertArrayHasKey('-l', $pdf->getOptions());

        $pdf->listEncodings();
        static::assertArrayHasKey('-listenc', $pdf->getFlags());

        $pdf->isoDates();
        static::assertArrayHasKey('-isodates', $pdf->getFlags());

        static::assertContains('-f', $pdf->previewShellOptions());
    }

    /**
     * @throws PopplerPhpException
     */
    public function testOutputDirMethodSetterAndGetter()
    {
        Config::setOutputDirectory(Config::getOutputDirectory(C::DFT));
        static::assertTrue(Config::isKeySet(C::OUTPUT_DIR));

        $DS = DIRECTORY_SEPARATOR;
        $file = __DIR__.$DS."sources{$DS}test1.pdf";
        $cairo = new PdfToCairo($file);

        static::assertTrue($cairo->getOutputPath() != dirname($file));
    }

    /**
     * @throws PopplerPhpException
     */
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

        $expected_bin = PHP_OS === 'WINNT' ? "{$q}".implode($DS, [$bin_dir, $bin_file])."{$q}" : $q.$bin_file.$q;
        $expected_src = "{$q}{$file}{$q}";
        $expected_dest = "{$q}{$output_dir}{$DS}{$output_file_prefix}{$q}";
        static::assertRegExp("%^{$expected_bin} {$expected_src} {$expected_dest}$%", $pdf->previewShellCommand());
    }

    /**
     * @throws PopplerPhpException
     */
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

        $expected_bin = PHP_OS === 'WINNT' ? "{$q}".implode($DS, [$bin_dir, $bin_file])."{$q}" : $q.$bin_file.$q;
        $expected_src = "{$q}{$file}{$q}";
        $expected_dest = "{$q}{$output_dir}{$DS}{$output_sub_dir}{$DS}{$output_file_prefix}{$q}";
        static::assertRegExp("%^{$expected_bin} {$expected_src} {$expected_dest}$%", $pdf->previewShellCommand());
    }

    /**
     * @throws PopplerPhpException
     */
    public function testMakeCommandMethodWithoutOutputFile()
    {
        $q = PHP_OS === 'WINNT' ? "\"" : "'";
        $DS = DIRECTORY_SEPARATOR;
        $file = __DIR__.$DS."sources{$DS}test1.pdf";

        $expected_page_from = 1;
        $expected_page_to = 2;

        $pdf = new PdfInfo($file);
        $pdf->startFromPage($expected_page_from)->stopAtPage($expected_page_to);

        $bin_dir = Config::getBinDirectory();
        $bin_file = C::PDF_INFO;

        $expected_bin = PHP_OS === 'WINNT' ? "{$q}".implode($DS, [$bin_dir, $bin_file])."{$q}" : $q.$bin_file.$q;
        $expected_option_str = "-f {$expected_page_from} -l {$expected_page_to}";
        $expected_src = "{$q}{$file}{$q}";

        static::assertRegExp("%^{$expected_bin} {$expected_option_str} {$expected_src}$%", $pdf->previewShellCommand());
    }

    /**
     * @throws PopplerPhpException
     */
    public function testMakeCommandMethodWithMultipleSourcePDFs()
    {
        $q = PHP_OS === 'WINNT' ? "\"" : "'";
        $DS = DIRECTORY_SEPARATOR;
        $file1 = __DIR__.$DS."sources{$DS}test1.pdf";
        $file2 = __DIR__.$DS."sources{$DS}test2.pdf";
        $file3 = __DIR__.$DS."sources{$DS}test3.pdf";
        $output_file_prefix = "test-unite";

        $pdf = new PdfUnite([$file1, $file2, $file3]);
        $pdf->setSubDirRequired(true);
        $pdf->setOutputFilenamePrefix($output_file_prefix);

        $bin_dir = Config::getBinDirectory();
        $bin_file = C::PDF_UNITE;

        $output_dir = Config::getOutputDirectory();
        $output_sub_dir = $pdf->getOutputSubDir();
        $output_file_ext = $pdf->outputExtension();

        $expected_bin = PHP_OS === 'WINNT' ? "{$q}".implode($DS, [$bin_dir, $bin_file])."{$q}" : $q.$bin_file.$q;
        $expected_src = "{$q}{$file1}{$q} {$q}{$file2}{$q} {$q}{$file3}{$q}";
        $expected_dest = "{$q}{$output_dir}{$DS}{$output_sub_dir}{$DS}{$output_file_prefix}{$output_file_ext}{$q}";

        static::assertRegExp("%^{$expected_bin} {$expected_src} {$expected_dest}$%", $pdf->previewShellCommand());
    }
}
