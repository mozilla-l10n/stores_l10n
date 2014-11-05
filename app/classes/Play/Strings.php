<?php
namespace Play;

/**
 * Strings class
 *
 * This class is for all the methods we need to manipulate strings
 *
 * @package Play
 */
class Strings
{
    /**
     * Check if $haystack starts with a string in $needles.
     * $needles can be a string or an array of strings.
     *
     * @param  string  $haystack String to analyse
     * @param  array   $needles  The string to look for
     * @return boolean True if the $haystack string starts with a string in $needles
     */
    public static function startsWith($haystack, $needles)
    {
        foreach((array) $needles as $prefix) {
            if (! strncmp($haystack, $prefix, mb_strlen($prefix))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if $haystack ends with a string in $needles.
     * $needles can be a string or an array of strings.
     *
     * @param  string  $haystack String to analyse
     * @param  array   $needles The strings to look for
     * @return boolean True if the $haystack string ends with a string in $needles
     */
    public static function endsWith($haystack, $needles)
    {
        foreach((array) $needles as $suffix) {
            if (mb_substr($haystack, -mb_strlen($suffix)) === $suffix) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get multibyte UTF-8 string length, html tags stripped
     *
     * @param  string $str A multibyte string
     * @return int    The length of the string after removing all html
     */
    public static function getLength($str)
    {
        return mb_strlen(strip_tags($str), 'UTF-8');
    }
}
