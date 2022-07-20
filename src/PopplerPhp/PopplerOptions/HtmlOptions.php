<?php
/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/12/2016
 * Time:    11:24 PM
 **/

namespace NcJoes\PopplerPhp\PopplerOptions;

use NcJoes\PopplerPhp\Constants as C;

/**
 * Trait HtmlOptions
 * @package NcJoes\PopplerPhp\PopplerOptions
 */
trait HtmlOptions
{
    /**
     * @return mixed
     */
    public function suppressConsoleOutput()
    {
        return $this->setFlag(C::_Q);
    }

    /**
     * @return mixed
     */
    public function outputToConsole()
    {
        return $this->setFlag(C::_STDOUT);
    }

    /**
     * @param $ratio
     * @return mixed
     */
    public function setZoomRatio($ratio)
    {
        return $this->setOption(C::_ZOOM, $ratio);
    }

    /**
     * @return mixed
     */
    public function defaultZoom()
    {
        return $this->unsetOption(C::_ZOOM);
    }

    /**
     * @param $string
     * @return $this
     */
    public function splashImageFormat($string)
    {
        if (in_array($string, ['png', 'jpg']))
            return $this->setOption(C::_FMT, $string);
        else
            return $this;
    }

    /**
     * @param $float
     * @return mixed
     */
    public function setWordBreakThreshold($float)
    {
        return $this->setOption(C::_WBT, $float);
    }

    /**
     * @return mixed
     */
    public function exchangePdfLinks()
    {
        return $this->setFlag(C::_P);
    }

    /**
     * @return mixed
     */
    public function generateComplexDocument()
    {
        return $this->setFlag(C::_C);
    }

    /**
     * @return mixed
     */
    public function generateSingleDocument()
    {
        return $this->setFlag(C::_S);
    }

    /**
     * @return mixed
     */
    public function ignoreImages()
    {
        return $this->setFlag(C::_I);
    }

    /**
     * @return mixed
     */
    public function noFrames()
    {
        return $this->setFlag(C::_NOFRAMES);
    }

    /**
     * @return mixed
     */
    public function xmlOutput()
    {
        return $this->setFlag(C::_XML);
    }

    /**
     * @return mixed
     */
    public function revealHiddenText()
    {
        return $this->setFlag(C::_HIDDEN);
    }

    /**
     * @return mixed
     */
    public function unmergedParagraphs()
    {
        return $this->setFlag(C::_NOMERGE);
    }

    /**
     * @return mixed
     */
    public function noDrm()
    {
        return $this->setFlag(C::_NODRM);
    }

    /**
     * @return mixed
     */
    public function fullFontNames()
    {
        return $this->setFlag(C::_FONT_FN);
    }

    /**
     * @return array
     */
    protected function htmlFlags()
    {
        return [
            C::_P,
            C::_C,
            C::_S,
            C::_I,
            C::_NOFRAMES,
            C::_XML,
            C::_HIDDEN,
            C::_NOMERGE,
            C::_NODRM,
            C::_FONT_FN,
        ];
    }

    /**
     * @return array
     */
    protected function htmlOptions()
    {
        return [
            C::_ZOOM => C::T_DOUBLE,
            C::_FMT  => C::T_STRING,
            C::_WBT  => C::T_DOUBLE,
        ];
    }
}
