<?php
/**
 * Php-PDF-Suite
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/13/2016
 * Time:    1:08 AM
 **/

namespace NcJoes\PhpPdfSuite\PopplerOptions;

use NcJoes\PhpPdfSuite\Constants as C;

trait ConsoleFlags
{
    use HelpFlags;
    use VersionFlags;

    public function consoleFlags()
    {
        return array_merge(
            [
                C::_Q, C::_STDOUT,
            ],
            $this->helpFlags(),
            $this->versionFlags());
    }

    public function suppressConsoleOutput()
    {
        return $this->setFlag(C::_Q);
    }

    public function outputToConsole()
    {
        $this->setFlag(C::_STDOUT);
    }
}