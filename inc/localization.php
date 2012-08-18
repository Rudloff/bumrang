<?php
/**
 * Load localization (with Gettext)
 * 
 * PHP version 5.3.10
 * 
 * @category PHP
 * @package  Bumrang
 * @author   Pierre Rudloff <rudloff@strasweb.fr>
 * @license  New BSD License http://opensource.org/licenses/BSD-3-Clause
 * @link     http://svn.strasweb.fr
 * */
if (function_exists("bindtextdomain")) {
    putenv("LC_ALL=".$config->locale);
    setlocale(LC_ALL, $config->locale);
    bindtextdomain("messages", "./locale");
    bind_textdomain_codeset("messages", "UTF-8");
    textdomain("messages");
} else {
    if (!function_exists("_")) {
        /**
         * Dummy gettext function
         * 
         * @param string $string String
         * 
         * @return string
         * */
        function _($string)
        {
            return $string;
        }
    }
}


?>
