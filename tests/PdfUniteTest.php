<?php

use NcJoes\PopplerPhp\Config;
use NcJoes\PopplerPhp\Exceptions\PopplerPhpException;
use NcJoes\PopplerPhp\PdfInfo;
use NcJoes\PopplerPhp\PdfUnite;

/**
 * Class PdfUniteTest
 */
class PdfUniteTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @expectedException NcJoes\PopplerPhp\Exceptions\PopplerPhpException
     */
    public function testConstructorThrowsExceptionIfSrcPdfFilesIsEmpty()
    {
        new PdfUnite([]);
    }

    /**
     * @expectedException NcJoes\PopplerPhp\Exceptions\PopplerPhpException
     */
    public function testConstructorThrowsExceptionIfSingleSrcPdfFileIsGiven()
    {
        $DS = DIRECTORY_SEPARATOR;
        new PdfUnite([__DIR__.$DS."sources{$DS}test3.pdf"]);
    }

    /**
     * @throws PopplerPhpException
     */
    public function testGenerate()
    {
        $DS = DIRECTORY_SEPARATOR;
        $file1 = __DIR__.$DS."sources{$DS}test1.pdf";
        $file2 = __DIR__.$DS."sources{$DS}test2.pdf";
        $file3 = __DIR__.$DS."sources{$DS}test3.pdf";
        $output_file_prefix = "test-unite";

        $pdf_unite = new PdfUnite([$file1, $file2, $file3]);
        $pdf_unite->setOutputFilenamePrefix($output_file_prefix);
        $pdf_unite->generate();

        $output_dir = Config::getOutputDirectory();
        $output_file_ext = $pdf_unite->outputExtension();

        $expected_output_file = "{$output_dir}{$DS}{$output_file_prefix}{$output_file_ext}";
        static::assertFileExists($expected_output_file);

        $pdf_info = new PdfInfo($expected_output_file);
        static::assertEquals(16 * 3, intval($pdf_info->getNumOfPages()));
    }

}
