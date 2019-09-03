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

/**
 * Class PdfUnite
 * @package NcJoes\PopplerPhp
 */
class PdfUnite extends PopplerUtil
{

    /**
     * @param array $srcPdfFiles
     * @throws PopplerPhpException
     */
    public function __construct($srcPdfFiles)
    {
        parent::__construct();

        if (empty($srcPdfFiles) || count($srcPdfFiles) < 2) {
            throw new PopplerPhpException("At least two pdf files are required");
        }

        $this->binFile = C::PDF_UNITE;
        $this->outputFileExtension = $this->outputExtension();
        $this->setSourcePdfs($srcPdfFiles);
    }

    /**
     * @return mixed|void
     */
    public function utilOptions()
    {
        // TODO: Implement utilOptions() method.
    }

    /**
     * @return mixed|void
     */
    public function utilOptionRules()
    {
        // TODO: Implement utilOptionRules() method.
    }

    /**
     * @return mixed|void
     */
    public function utilFlags()
    {
        // TODO: Implement utilFlags() method.
    }

    /**
     * @return mixed|void
     */
    public function utilFlagRules()
    {
        // TODO: Implement utilFlagRules() method.
    }

    /**
     * @return mixed|string
     */
    public function outputExtension()
    {
        return '.pdf';
    }

    /**
     * @return string
     */
    public function generate()
    {
        return $this->shellExec();
    }
}
