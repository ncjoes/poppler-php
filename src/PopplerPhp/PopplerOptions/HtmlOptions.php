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

trait HtmlOptions
{
    public function suppressConsoleOutput()
    {
        return $this->setFlag(C::_Q);
    }

    public function outputToConsole()
    {
        return $this->setFlag(C::_STDOUT);
    }

    public function setZoomRatio($ratio)
    {
        return $this->setOption(C::_ZOOM, $ratio);
    }

    public function defaultZoom()
    {
        return $this->unsetOption(C::_ZOOM);
    }

    public function splashImageFormat($string)
    {
        if (in_array($string, ['png', 'jpg']))
            return $this->setOption(C::_FMT, $string);
        else
            return $this;
    }

    public function setWordBreakThreshold($float)
    {
        return $this->setOption(C::_WBT, $float);
    }

    public function exchangePdfLinks()
    {
        return $this->setFlag(C::_P);
    }

    public function generateComplexDocument()
    {
        return $this->setFlag(C::_C);
    }

    public function generateSingleDocument()
    {
        return $this->setFlag(C::_S);
    }

    public function ignoreImages()
    {
        return $this->setFlag(C::_I);
    }

    public function noFrames()
    {
        return $this->setFlag(C::_NOFRAMES);
    }

    public function xmlOutput()
    {
        return $this->setFlag(C::_XML);
    }

    public function revealHiddenText()
    {
        return $this->setFlag(C::_HIDDEN);
    }

    public function unmergedParagraphs()
    {
        return $this->setFlag(C::_NOMERGE);
    }

    public function noDrm()
    {
        return $this->setFlag(C::_NODRM);
    }

    public function fullFontNames()
    {
        return $this->setFlag(C::_FONT_FN);
    }

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

    protected function htmlOptions()
    {
        return [
            C::_ZOOM => C::T_DOUBLE,
            C::_FMT  => C::T_STRING,
            C::_WBT  => C::T_DOUBLE,
        ];
    }
}