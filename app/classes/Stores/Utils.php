<?php
namespace Stores;

/**
 * Utils class
 *
 * Utility functions like string management.
 *
 *
 * @package Stores
 */
class Utils
{
    /**
     * Remove a substring from the left of a string, return the trimmed result
     *
     * @param string $origin    Original string
     * @param string $substring Substring to remove
     *
     * @return string Resulting string
     */
    public static function leftStrip($origin, $substring)
    {
        // Lang file common cases: reference string or comment
        if ($substring === ';' || $substring === '#') {
            return trim(mb_substr($origin, 1));
        }

        return trim(mb_substr($origin, mb_strlen($substring)));
    }

    /**
     * Return a string without extra tags like {ok}
     *
     * @param string $origin Original string
     *
     * @return string String cleaned from extra-tags
     */
    public static function cleanString($origin)
    {
        return trim(str_ireplace('{ok}', '', $origin));
    }

    /**
     * Check if $haystack starts with a string in $needles.
     * $needles can be a string or an array of strings.
     *
     * @param string $haystack String to analyse
     * @param array  $needles  The strings to look for
     *
     * @return boolean True       if the $haystack string starts with a
     *                 string in $needles
     */
    public static function startsWith($haystack, $needles)
    {
        // Lang file common case: reference string
        if ($needles === ';') {
            return $haystack[0] == ';';
        }

        // Lang file common case: comment
        if ($needles === '#') {
            return $haystack[0] == '#';
        }

        foreach ((array) $needles as $needle) {
            if (mb_strpos($haystack, $needle, 0) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Print error, quit application if requested
     *
     * @param string $message Message to display
     * @param string $action  If 'quit', leave the app
     */
    public static function logger($message, $action = '')
    {
        error_log($message . "\n");
        if ($action == 'quit') {
            die;
        }
    }
}
