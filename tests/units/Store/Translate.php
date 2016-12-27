<?php
namespace tests\units\Stores;

use atoum;
use Stores\Translate as _Translate;

require_once __DIR__ . '/../bootstrap.php';

class Translate extends atoum\test
{
    public function testGet()
    {
        $obj = new _Translate('fr', 'foobar1.lang', LOCALES_PATH);
        $this
            ->string($obj->get("This is a string"))
                ->isEqualTo("C'est une chaîne");
    }

    public function testIsStringTranslated()
    {
        $obj = new _Translate('fr', 'foobar1.lang', LOCALES_PATH);
        $this
            ->boolean($obj->isStringTranslated("This is a string"))
                ->isTrue();
        $this
            ->boolean($obj->isStringTranslated("This is another string"))
                ->isFalse();
    }

    public function testIsFileTranslated()
    {
        $obj = new _Translate('fr', 'foobar1.lang', LOCALES_PATH);
        $this
            ->boolean($obj->isFileTranslated())
                ->isFalse();
        $obj = new _Translate('fr', 'foobar2.lang', LOCALES_PATH);
        $this
            ->boolean($obj->isFileTranslated())
                ->isTrue();
        $obj = new _Translate('fr', 'Idontexist.lang', LOCALES_PATH);
        $this
            ->boolean($obj->isFileTranslated())
                ->isFalse();
    }
}
