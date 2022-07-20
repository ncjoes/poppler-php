<?php
/**
 * Poppler-PHP
 *
 * Author:  Chukwuemeka Nwobodo (jcnwobodo@gmail.com)
 * Date:    10/12/2016
 * Time:    6:12 PM
 **/

namespace NcJoes\PopplerPhp;

/**
 * Class Constants
 * @package NcJoes\PopplerPhp
 */
abstract class Constants
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
    const _F           = '-f';
    const _L           = '-l';
    const _ISODATES    = '-isodates';
    const _RAWDATE     = '-rawdate';
    const _ENC         = '-enc';
    const _LISTENC     = '-listenc';
    const _OPW         = '-opw';
    const _UPW         = '-upw';
    const _V           = '-v';
    const _H           = '-h';
    const _HELP        = '-help';
    const _HELP_       = '--help';
    const _HELP_Q      = '-?';
    const _Q           = '-q';
    const _STDOUT      = '-stdout';
    const _P           = '-p';
    const _C           = '-c';
    const _S           = '-s';
    const _I           = '-i';
    const _NOFRAMES    = '-noframes';
    const _ZOOM        = '-zoom';
    const _XML         = '-xml';
    const _HIDDEN      = '-hidden';
    const _NOMERGE     = '-nomerge';
    const _FMT         = '-fmt';
    const _NODRM       = '-nodrm';
    const _WBT         = '-wbt';
    const _FONT_FN     = '-fontfullname';
    const _PNG         = '-png';
    const _JPEG        = '-jpeg';
    const _TIFF        = '-tiff';
    const _TIFF_COMP   = '-tiffcompression';
    const _PS          = '-ps';
    const _EPS         = '-eps';
    const _PDF         = '-pdf';
    const _SVG         = '-svg';
    const _ODD_ONLY    = '-o';
    const _EVEN_ONLY   = '-e';
    const _SINGLE_FILE = '-singlefile';
    const _R           = '-r';
    const _RX          = '-rx';
    const _RY          = '-ry';
    const _SCALE_TO    = '-scale-to';
    const _SCALE_TO_X  = '-scale-to-x';
    const _SCALE_TO_Y  = '-scale-to-y';
    const _CROP_X      = '-x';
    const _CROP_Y      = '-y';
    const _CROP_WIDTH  = '-W';
    const _CROP_HEIGHT = '-H';
    const _CROP_SQUARE = '-sz';
    const _CROP_BOX    = '-cropbox';
    const _NO_CROP     = '-nocrop';
    const _MONO        = '-mono';
    const _GRAY        = '-gray';
    const _TRANSP      = '-transp';
    const _ANTI_ALIAS  = '-antialias';
    const _ICC         = '-icc';
    const _LEVEL2      = '-level2';
    const _LEVEL3      = '-level3';
    const _BBOX_LAYOUT = '-bbox-layout';
    const _LAYOUT      = '-layout';
    const _BOX         = '-box';

    //Poppler Option DataTypes
    const T_STRING  = 'string';
    const T_INTEGER = 'integer';
    const T_DOUBLE  = 'double';

    //Directory Helpers
    const DS          = DIRECTORY_SEPARATOR;
    const BIN_DIR     = 'ncjoes.poppler-php.bin_dir';
    const OUTPUT_DIR  = 'ncjoes.poppler-php.output_dir';
    const OUTPUT_NAME = 'ncjoes.poppler-php.output_name';

    const DEFAULT_OUTPUT_DIR = 'tests/results';

    //Config Helpers
    const DFT = '_d_';
}
