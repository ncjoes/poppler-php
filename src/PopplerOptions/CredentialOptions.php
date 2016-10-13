<?php
/**
 * Php-PDF-Suite
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/12/2016
 * Time:    5:29 PM
 **/

namespace NcJoes\PhpPdfSuite\PopplerOptions;

use NcJoes\PhpPdfSuite\Constants as C;

trait CredentialOptions
{
    public function credentialOptions()
    {
        return [
            [C::_OPW => C::T_STRING],
            [C::_UPW => C::T_STRING]
        ];
    }

    public function setOwnerPassword($pswd)
    {
        return $this->setOption(C::_OPW, $pswd);
    }

    public function unsetOwnerPassword()
    {
        return $this->unsetOption(C::_OPW);
    }

    public function setUserPassword($pswd)
    {
        return $this->setOption(C::_UPW, $pswd);
    }

    public function unsetUserPassword()
    {
        return $this->unsetOption(C::_UPW);
    }

}