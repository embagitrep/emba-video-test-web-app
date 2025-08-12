<?php

/** This file is part of KCFinder project
 *
 *      @desc Base configuration file
 *
 *   @version 2.51
 *
 *    @author Pavel Tzonkov <pavelc@users.sourceforge.net>
 * @copyright 2010, 2011 KCFinder Project
 *   @license http://www.opensource.org/licenses/gpl-2.0.php GPLv2
 *   @license http://www.opensource.org/licenses/lgpl-2.1.php LGPLv2
 *
 *      @link http://kcfinder.sunhater.com
 */

// IMPORTANT!!! Do not remove uncommented settings in this file even if
// you are using session configuration.
// See http://kcfinder.sunhater.com/install for setting descriptions

$_CONFIG = [

    'disabled' => false,
    'denyZipDownload' => false,
    'denyUpdateCheck' => false,
    'denyExtensionRename' => false,

    'theme' => 'oxygen',

    'uploadURL' => '/public/uploads',
    'uploadDir' => '',

    'dirPerms' => 0755,
    'filePerms' => 0644,
    'chmodFiles' => 0777,
    'chmodFolders' => 0755,

    'access' => [

        'files' => [
            'upload' => true,
            'delete' => true,
            'copy' => true,
            'move' => true,
            'rename' => true,
        ],

        'dirs' => [
            'create' => true,
            'delete' => true,
            'rename' => true,
        ],
    ],

    'deniedExts' => 'exe com msi bat php phps phtml php3 php4 cgi pl',

    'types' => [

        // CKEditor & FCKEditor types
        'files' => '',
        'flash' => 'swf',
        'images' => '*img',

        // TinyMCE types
        'file' => '',
        'media' => 'swf flv avi mpg mpeg qt mov wmv asf rm',
        'image' => '*img',
    ],

    'filenameChangeChars' => [
        ' ' => '_',
        ':' => '.',
    ],

    'dirnameChangeChars' => [/*
        ' ' => "_",
        ':' => "."
    */],

    'mime_magic' => '',

    'maxImageWidth' => 0,
    'maxImageHeight' => 0,

    'thumbWidth' => 100,
    'thumbHeight' => 100,

    'thumbsDir' => '.thumbs',

    'jpegQuality' => 90,

    'cookieDomain' => '',
    'cookiePath' => '',
    'cookiePrefix' => 'KCFINDER_',

    // THE FOLLOWING SETTINGS CANNOT BE OVERRIDED WITH SESSION CONFIGURATION
    '_check4htaccess' => true,
    // '_tinyMCEPath' => "/tiny_mce",

    '_sessionVar' => &$_SESSION['KCFINDER'],
    // '_sessionLifetime' => 30,
    // '_sessionDir' => "/full/directory/path",

    // '_sessionDomain' => ".mysite.com",
    // '_sessionPath' => "/my/path",
];
