<?php
/**
 * Php-PDF-Suite
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/12/2016
 * Time:    6:12 PM
 **/

namespace NcJoes\PhpPdfSuite;

class Constants
{
    //Poppler Utils Binaries
    const PDF_DETACH   = 'pdfdetach';
    const PDF_FONTS    = 'pdffonts';
    const PDF_IMAGES   = 'pdfimages';
    const PDF_INFO     = 'pdfinfo';
    const PDF_SEPARATE = 'pdfseparate';
    const PDF_TO_CAIRO = 'pdftocairo';
    const PDF_TO_HTML  = 'pdftohtml';
    const PDF_TO_PPM   = 'pdftoppm';
    const PDF_TO_PS    = 'pdftops';
    const PDF_TO_TEXT  = 'pdftotext';
    const PDF_UNITE    = 'pdfunite';

    //Poppler Utils flags/option keys
    const _F        = '-f';
    const _L        = '-l';
    const _ISODATES = '-isodates';
    const _RAWDATE  = '-rawdate';
    const _ENC      = '-enc';
    const _LISTENC  = '-listenc';
    const _OPW      = '-opw';
    const _UPW      = '-upw';
    const _V        = '-v';
    const _H        = '-h';
    const _HELP     = '-help';
    const _HELP_    = '--help';
    const _HELP_Q   = '-?';
    const _Q        = '-q';
    const _STDOUT   = '-stdout';
    const _P        = '-p';
    const _C        = '-c';
    const _S        = '-s';
    const _I        = '-i';
    const _NOFRAMES = '-noframes';
    const _ZOOM     = '-zoom';
    const _XML      = '-xml';
    const _HIDDEN   = '-hidden';
    const _NOMERGE  = '-nomerge';
    const _FMT      = '-fmt';
    const _NODRM    = '-nodrm';
    const _WBT      = '-wbt';
    const _FONT_FN  = '-fontfullname';

    //Poppler Option DataTypes
    const T_STRING  = 'string';
    const T_INTEGER = 'integer';
    const T_DOUBLE  = 'double';

}