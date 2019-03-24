<?php
/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/14/2016
 * Time:    3:36 PM
 **/

namespace NcJoes\PopplerPhp;

use NcJoes\PopplerPhp\Constants as C;
use NcJoes\PopplerPhp\Exceptions\PopplerPhpException;

class PdfUnite extends PopplerUtil
{

    /**
     * @param array $srcPdfFiles
     */
    public function __construct($srcPdfFiles)
    {
        parent::__construct();

        if (empty($srcPdfFiles) || count($srcPdfFiles) < 2) {
            throw new PopplerPhpException("At least two pdf files are required");
        }

        $this->bin_file = C::PDF_UNITE;
        $this->output_file_extension = $this->outputExtension();
        $this->setSourcePdfs($srcPdfFiles);
    }

    public function utilOptions()
    {
        // TODO: Implement utilOptions() method.
    }

    public function utilOptionRules()
    {
        // TODO: Implement utilOptionRules() method.
    }

    public function utilFlags()
    {
        // TODO: Implement utilFlags() method.
    }

    public function utilFlagRules()
    {
        // TODO: Implement utilFlagRules() method.
    }

    public function outputExtension()
    {
        return '.pdf';
    }

    public function generate()
    {
        return $this->shellExec();
    }
}
