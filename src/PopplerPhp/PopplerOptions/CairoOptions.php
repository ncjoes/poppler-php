<?php
/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/13/2016
 * Time:    8:38 AM
 **/

namespace NcJoes\PopplerPhp\PopplerOptions;

use NcJoes\PopplerPhp\Constants as C;

trait CairoOptions
{
    public function getOutputFormat()
    {
        return $this->format;
    }

    public function setOutputFormat($format)
    {
        if (in_array($format, $this->cairoFormatFlags())) {
            $this->format = $format;

            return $this->setFlag($format);
        }

        return $this;
    }

    public function setTiffCompression($options)
    {
        return $this->setOption(C::_TIFF_COMP, $options);
    }

    public function setResolution($rx, $ry = null)
    {
        if (is_null($ry)) {
            return $this->setOption(C::_R, $rx);
        }
        else {
            $this->setOption(C::_RX, $rx);

            return $this->setOption(C::_RY, $ry);
        }
    }

    public function scalePagesTo($px, $py = null)
    {
        if (is_null($py)) {
            return $this->setOption(C::_SCALE_TO, $px);
        }
        else {
            $this->setOption(C::_SCALE_TO_X, $px);

            return $this->setOption(C::_SCALE_TO_Y, $py);
        }
    }

    public function cropAreaOrigin($x, $y)
    {
        $this->setOption(C::_CROP_X, $x);

        return $this->setOption(C::_CROP_Y, $y);
    }

    public function cropAreaSize($width, $height = null)
    {
        if (is_null($height)) {
            return $this->setOption(C::_CROP_SQUARE, $width);
        }
        else {
            $this->setOption(C::_CROP_WIDTH, $width);

            return $this->setOption(C::_CROP_HEIGHT, $height);
        }
    }

    public function useCropBox()
    {
        return $this->setFlag(C::_CROP_BOX);
    }

    public function noCrop()
    {
        return $this->setFlag(C::_NO_CROP);
    }

    public function monochrome()
    {
        return $this->setFlag(C::_MONO);
    }

    public function grayscale()
    {
        return $this->setFlag(C::_GRAY);
    }

    public function transparentBg()
    {
        return $this->setFlag(C::_TRANSP);
    }

    public function setAntiAlias($options)
    {
        return $this->setOption(C::_ANTI_ALIAS, $options);
    }

    public function setIccProfile($profile)
    {
        return $this->setOption(C::_ICC, $profile);
    }

    public function setPostScriptLevel($level)
    {
        if (in_array($level, $this->postScriptLevelFlags()))
            return $this->setFlag($level);
        else
            return $this;
    }

    protected function cairoFlags()
    {
        return array_merge(
            $this->cairoFormatFlags(),
            $this->cropFlags(),
            $this->colorFlags(),
            $this->bgFlags(),
            $this->postScriptLevelFlags()
        );
    }

    protected function cairoFormatFlags()
    {
        return [C::_PNG, C::_JPEG, C::_TIFF, C::_PS, C::_EPS, C::_PDF, C::_SVG];
    }

    protected function cropFlags()
    {
        return [C::_CROP_BOX];
    }

    protected function colorFlags()
    {
        return [C::_MONO, C::_GRAY];
    }

    protected function bgFlags()
    {
        return [C::_TRANSP];
    }

    protected function postScriptLevelFlags()
    {
        return [C::_LEVEL2, C::_LEVEL3];
    }

    protected function cairoOptions()
    {
        return array_merge(
            $this->tiffOptions(),
            $this->resolutionOptions(),
            $this->scaleOptions(),
            $this->cropOptions(),
            $this->antiAliasOptions(),
            $this->iccProfileOptions()
        );
    }

    protected function tiffOptions()
    {
        return [
            C::_TIFF_COMP => C::T_STRING,
        ];
    }

    protected function resolutionOptions()
    {
        return [
            C::_R  => C::T_DOUBLE,
            C::_RX => C::T_DOUBLE,
            C::_RX => C::T_DOUBLE,
        ];
    }

    protected function scaleOptions()
    {
        return [
            C::_SCALE_TO   => C::T_INTEGER,
            C::_SCALE_TO_X => C::T_INTEGER,
            C::_SCALE_TO_Y => C::T_INTEGER,
        ];
    }

    protected function cropOptions()
    {
        return [
            C::_CROP_X      => C::T_INTEGER,
            C::_CROP_Y      => C::T_INTEGER,
            C::_CROP_WIDTH  => C::T_INTEGER,
            C::_CROP_HEIGHT => C::T_INTEGER,
            C::_CROP_SQUARE => C::T_INTEGER,
        ];
    }

    protected function antiAliasOptions()
    {
        return [
            C::_ANTI_ALIAS => C::T_STRING,
        ];
    }

    protected function iccProfileOptions()
    {
        return [
            C::_ICC => C::T_STRING,
        ];
    }
}