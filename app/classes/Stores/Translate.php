<?php
namespace Stores;

/*
 * Stores class
 *
 * This class is for all the methods we use to output translated strings
 *
 *
 * @package Stores
 */
class Translate extends DotLangParser
{
    /**
     * Array of source strings
     *
     * @var Array
     */
    protected $source_strings = [];

    /**
     * Array of translations
     *
     * @var Array
     */
    protected $translations = [];

    /**
     * Locale currently parsed
     *
     * @var string
     */
    protected $locale;

    /**
     * Path to the /locales folder storing translation files
     *
     * @var string
     */
    protected $locales_path;

    public function __construct($locale, $files, $locales_path)
    {
        $this->locale = $locale;
        $this->locales_path = $locales_path;
        // We are passing several files
        if (is_array($files)) {
            $translations = $source_strings = [];
            foreach ($files as $file) {
                $translations = array_merge(
                    $translations,
                    $this->parseFile($this->locales_path . $this->locale . '/' . $file)['strings']
                );

                $source_strings = array_merge(
                    $source_strings,
                    array_keys($this->parseFile($this->locales_path . 'en-US/' . $file)['strings'])
                );
            }
            $this->translations = $translations;
            $this->source_strings = $source_strings;
        } else {
            $this->translations = $this->parseFile($this->locales_path . $this->locale . '/' . $files)['strings'];
            $this->source_strings = array_keys($this->parseFile($this->locales_path . 'en-US/' . $files)['strings']);
        }
    }

    /**
     * Return the translation for a string
     *
     * @param string $string The string we want to translate
     *
     * @return string The translation of the string or the source string if not translated
     */
    public function get($string)
    {
        if (isset($this->translations[$string])) {
            return Utils::cleanString($this->translations[$string]);
        }

        return $string;
    }

    /**
     * Check if a string is translated
     *
     * @param string $string The string we want to check
     *
     * @return boolean True if translated, false if not
     */
    public function isStringTranslated($string)
    {
        // String doesn't exist
        if (! isset($this->translations[$string])) {
            return false;
        }

        // String is identical to source
        if ($string == $this->translations[$string]) {
            return false;
        }

        return true;
    }

    /**
     * Check if a file is fully translated
     *
     * @return boolean True if Translated, false is not translated or if
     *                 file doesn't exist
     */
    public function isFileTranslated()
    {
        // Source file is empty or missing, doesn't mean there is nothing to do
        if (empty($this->source_strings)) {
            return false;
        }

        foreach ($this->source_strings as $value) {
            // Missing string in localized file
            if (! isset($this->translations[$value])) {
                return false;
            }

            // Untranslated string in localized file
            if ($value == $this->translations[$value]) {
                return false;
            }
        }

        return true;
    }
}
