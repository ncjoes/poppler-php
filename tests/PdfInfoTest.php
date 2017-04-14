<?php
/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/13/2016
 * Time:    11:35 AM
 **/

use NcJoes\PopplerPhp\PdfInfo;
use NcJoes\PopplerPhp\Config;
use NcJoes\PopplerPhp\Constants as C;

class PdfInfoTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
        Config::setOutputDirectory(C::DFT);
    }

    public function testGetInfo()
    {
        $file = realpath(dirname(__FILE__).'\sources\test1.pdf');
        $pdf_info = new PdfInfo($file);

        //print_r($pdf_info->getInfo());
        $this->assertArrayHasKey('pages', $pdf_info->getInfo());
        $this->addToAssertionCount(sizeof($pdf_info->getInfo()));
    }

    public function testGetters()
    {
        $file = dirname(__FILE__).'\sources\test1.pdf';
        $pdf_info = new PdfInfo($file);

        $info = [
            'Authors'           => $pdf_info->getAuthors(),
            'Creation Date'     => $pdf_info->getCreationDate(),
            'Creator'           => $pdf_info->getCreator(),
            'File Size'         => $pdf_info->getFileSize(),
            'Modification Date' => $pdf_info->getModificationDate(),
            'Num. of Pages'     => $pdf_info->getNumOfPages(),
            'Page Rot'          => $pdf_info->getPageRot(),
            'Page Size'         => $pdf_info->getPageSize(),
            'PDF Version'       => $pdf_info->getPdfVersion(),
            'Producer'          => $pdf_info->getProducer(),
            'Is Tagged?'        => (int)$pdf_info->isTagged(),
            'Is Optimized'      => (int)$pdf_info->isOptimized(),
            'Page Width'        => $pdf_info->getPageWidth(),
            'Page Height'       => $pdf_info->getPageHeight(),
            'Unit'              => $pdf_info->getSizeUnit(),
        ];

        //print_r($info);
        $this->addToAssertionCount(sizeof($info));
    }
}
