<?php
namespace Play;
use Langchecker\DotLangParser as Dotlang;
use Langchecker\Utils as Utils;
/*
 * Play class
 *
 * This class is for all the methods we use to output translated strings
 *
 *
 * @package Play
 */
class Translate extends Dotlang
{
    protected $translations;
    // protected $locale;
    public $repo;

    public function __construct($locale, $file)
    {
        $this->locale  = $locale;
        $this->repo  = realpath(__DIR__ .'/../../locales') . '/';
        $this->translations = $this->parseFile($this->repo .$this->locale . '/' . $file);
    }

    public function getAllStrings()
    {
        return $this->translations['strings'];
    }

    public function get($string) {
        if (isset($this->translations['strings'][$string])) {
            return Utils::cleanString($this->translations['strings'][$string]);
        }
        return $string;
    }
}
