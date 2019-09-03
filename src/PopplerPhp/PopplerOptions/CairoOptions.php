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

/**
 * Trait CairoOptions
 * @package NcJoes\PopplerPhp\PopplerOptions
 */
trait CairoOptions
{
    /**
     * @return mixed
     */
    public function getOutputFormat()
    {
        return $this->format;
    }

    /**
     * @param $format
     * @return $this
     */
    public function setOutputFormat($format)
    {
        if (in_array($format, $this->cairoFormatFlags())) {
            $this->format = $format;

            return $this->setFlag($format);
        }

        return $this;
    }

    /**
     * @param $options
     * @return mixed
     */
    public function setTiffCompression($options)
    {
        return $this->setOption(C::_TIFF_COMP, $options);
    }

    /**
     * @param $rx
     * @param null $ry
     * @return mixed
     */
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

    /**
     * @param $px
     * @param null $py
     * @return mixed
     */
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

    /**
     * @param $x
     * @param $y
     * @return mixed
     */
    public function cropAreaOrigin($x, $y)
    {
        $this->setOption(C::_CROP_X, $x);

        return $this->setOption(C::_CROP_Y, $y);
    }

    /**
     * @param $width
     * @param null $height
     * @return mixed
     */
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

    /**
     * @return mixed
     */
    public function useCropBox()
    {
        return $this->setFlag(C::_CROP_BOX);
    }

    /**
     * @return mixed
     */
    public function noCrop()
    {
        return $this->setFlag(C::_NO_CROP);
    }

    /**
     * @return mixed
     */
    public function monochrome()
    {
        return $this->setFlag(C::_MONO);
    }

    /**
     * @return mixed
     */
    public function grayscale()
    {
        return $this->setFlag(C::_GRAY);
    }

    /**
     * @return mixed
     */
    public function transparentBg()
    {
        return $this->setFlag(C::_TRANSP);
    }

    /**
     * @param $options
     * @return mixed
     */
    public function setAntiAlias($options)
    {
        return $this->setOption(C::_ANTI_ALIAS, $options);
    }

    /**
     * @param $profile
     * @return mixed
     */
    public function setIccProfile($profile)
    {
        return $this->setOption(C::_ICC, $profile);
    }

    /**
     * @param $level
     * @return $this
     */
    public function setPostScriptLevel($level)
    {
        if (in_array($level, $this->postScriptLevelFlags()))
            return $this->setFlag($level);
        else
            return $this;
    }

    /**
     * @return array
     */
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

    /**
     * @return array
     */
    protected function cairoFormatFlags()
    {
        return [C::_PNG, C::_JPEG, C::_TIFF, C::_PS, C::_EPS, C::_PDF, C::_SVG];
    }

    /**
     * @return array
     */
    protected function cropFlags()
    {
        return [C::_CROP_BOX];
    }

    /**
     * @return array
     */
    protected function colorFlags()
    {
        return [C::_MONO, C::_GRAY];
    }

    /**
     * @return array
     */
    protected function bgFlags()
    {
        return [C::_TRANSP];
    }

    /**
     * @return array
     */
    protected function postScriptLevelFlags()
    {
        return [C::_LEVEL2, C::_LEVEL3];
    }

    /**
     * @return array
     */
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

    /**
     * @return array
     */
    protected function tiffOptions()
    {
        return [
            C::_TIFF_COMP => C::T_STRING,
        ];
    }

    /**
     * @return array
     */
    protected function resolutionOptions()
    {
        return [
            C::_R  => C::T_DOUBLE,
            C::_RX => C::T_DOUBLE,
            C::_RY => C::T_DOUBLE,
        ];
    }

    /**
     * @return array
     */
    protected function scaleOptions()
    {
        return [
            C::_SCALE_TO   => C::T_INTEGER,
            C::_SCALE_TO_X => C::T_INTEGER,
            C::_SCALE_TO_Y => C::T_INTEGER,
        ];
    }

    /**
     * @return array
     */
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

    /**
     * @return array
     */
    protected function antiAliasOptions()
    {
        return [
            C::_ANTI_ALIAS => C::T_STRING,
        ];
    }

    /**
     * @return array
     */
    protected function iccProfileOptions()
    {
        return [
            C::_ICC => C::T_STRING,
        ];
    }
}
