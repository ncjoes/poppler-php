<?php

use NcJoes\PopplerPhp\Config;
use NcJoes\PopplerPhp\Exceptions\PopplerPhpException;
use NcJoes\PopplerPhp\PdfInfo;
use NcJoes\PopplerPhp\PdfUnite;

/**
 * Class PdfUniteTest
 */
class PdfUniteTest extends PHPUnit\Framework\TestCase
{

    /**
     *
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testConstructorThrowsExceptionIfSrcPdfFilesIsEmpty()
    {
        $this->expectException(NcJoes\PopplerPhp\Exceptions\PopplerPhpException::class);
        new PdfUnite([]);
    }

    public function testConstructorThrowsExceptionIfSingleSrcPdfFileIsGiven()
    {
        $this->expectException(NcJoes\PopplerPhp\Exceptions\PopplerPhpException::class);
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
