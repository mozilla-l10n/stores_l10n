<?php
namespace Stores;

use Langchecker\DotLangParser as Dotlang;
use Langchecker\Utils as Utils;

/*
 * Stores class
 *
 * This class is for all the methods we use to output translated strings
 *
 *
 * @package Stores
 */
class Translate extends Dotlang
{
    protected $source_strings;
    protected $translations;
    protected $locale;
    public $repo;

    public function __construct($locale, $files)
    {
        $this->locale = $locale;
        $this->repo   = LOCALES;
        // We are passing several files
        if (is_array($files)) {
            $translations = $source_strings = [];
            foreach ($files as $file) {
                $translations  = array_merge(
                    $translations,
                    $this->parseFile($this->repo . $this->locale . '/' . $file)['strings']
                );

                $source_strings = array_merge(
                    $source_strings,
                    array_keys($this->parseFile($this->repo . 'en-US/' . $file)['strings'])
                );
            }
            $this->translations =  [
                'activated' => false,
                'strings'   => $translations,
                'errors'    => ['ignoredstrings' => []],
            ];
            $this->source_strings = $source_strings;
        } else {
            $this->translations = $this->parseFile($this->repo . $this->locale . '/' . $files);
            $this->source_strings = array_keys($this->parseFile($this->repo . 'en-US/' . $files)['strings']);
        }
    }

    /**
     * Return the translation for a string
     * @param  string $string The string we want the translation for
     * @return string The translation of the string or the source string if not translated
     */
    public function get($string)
    {
        if (isset($this->translations['strings'][$string])) {
            return Utils::cleanString($this->translations['strings'][$string]);
        }

        return $string;
    }

    /**
     * Check if a string is translated
     * @param  string  $string The string we want to check
     * @return boolean True if translated, False if not
     */
    public function isStringTranslated($string)
    {
        if ($string == $this->translations['strings'][$string]) {
            return false;
        }

        // the string doesn't exist
        if (! isset($this->translations['strings'][$string])) {
            return false;
        }

        return true;
    }

    /**
     * Check if a file is fully translated
     * @return boolean True if Translated, False is not translated or if file doesn't exist
     */
    public function isFileTranslated()
    {
        // Source file is empty or missing, doesn't mean there is nothing to do
        if (empty($this->source_strings)) {
            return false;
        }

        foreach ($this->source_strings as $value) {
            // Missing string in localized file
            if (! isset($this->translations['strings'][$value])) {
                return false;
            }

            // Untranslated string in localized file
            if ($value == $this->translations['strings'][$value]) {
                return false;
            }
        }

        return true;
    }
}
