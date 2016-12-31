<?php
namespace Stores;

use Cache\Cache;

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

        if (! is_array($files)) {
            $files = [$files];
        }

        $translations = $source_strings = [];
        foreach ($files as $file) {
            /*
                If the localized file is missing, ignore also en-US strings.
                For example we might have screenshots only for a subset of
                locales, and supported locales are defined in langchecker.
                If the file is missing, it means locale is not supported
                and shouldn't be considered incomplete for these missing
                translations.
            */
            $locale_file = $this->locales_path . $this->locale . '/' . $file;
            if (! file_exists($locale_file)) {
                continue;
            }

            $cache_id = str_replace('-', '_', strtolower($this->locale)) . '_' . str_replace('/', '_', $file);
            if (! $new_localized_strings = Cache::getKey($cache_id)) {
                $new_localized_strings = $this->parseFile($locale_file)['strings'];
                Cache::setKey($cache_id, $new_localized_strings);
            }

            $translations = array_merge(
                $translations,
                $new_localized_strings
            );

            $cache_id = 'enus_' . str_replace('/', '_', $file);
            if (! $new_source_strings = Cache::getKey($cache_id)) {
                $new_source_strings = array_keys($this->parseFile($this->locales_path . 'en-US/' . $file)['strings']);
                Cache::setKey($cache_id, $new_source_strings);
            }

            $source_strings = array_merge(
                $source_strings,
                $new_source_strings
            );
        }
        $this->translations = $translations;
        $this->source_strings = $source_strings;
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
     * @return boolean True if translated, false is not translated
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
