<?php
/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/12/2016
 * Time:    5:29 PM
 **/

namespace NcJoes\PopplerPhp\PopplerOptions;

use NcJoes\PopplerPhp\Constants as C;

/**
 * Trait CredentialOptions
 * @package NcJoes\PopplerPhp\PopplerOptions
 */
trait CredentialOptions
{
    /**
     * @param $pswd
     * @return mixed
     */
    public function setOwnerPassword($pswd)
    {
        return $this->setOption(C::_OPW, $pswd);
    }

    /**
     * @return mixed
     */
    public function unsetOwnerPassword()
    {
        return $this->unsetOption(C::_OPW);
    }

    /**
     * @param $pswd
     * @return mixed
     */
    public function setUserPassword($pswd)
    {
        return $this->setOption(C::_UPW, $pswd);
    }

    /**
     * @return mixed
     */
    public function unsetUserPassword()
    {
        return $this->unsetOption(C::_UPW);
    }

    /**
     * @return array
     */
    protected function credentialOptions()
    {
        return [
            C::_OPW => C::T_STRING,
            C::_UPW => C::T_STRING,
        ];
    }

}
