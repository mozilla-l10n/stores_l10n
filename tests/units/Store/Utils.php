<?php
namespace tests\units\Stores;

use atoum;
use Stores\Utils as _Utils;

require_once __DIR__ . '/../bootstrap.php';

class Utils extends atoum\test
{
    public function testDetectLocale()
    {
        $obj = new _Utils();

        $this
            ->string($obj->detectLocale())
                ->isEqualTo('en-US');

        $this
            ->string($obj->detectLocale([], 'en-GB'))
                ->isEqualTo('en-GB');

        $this
            ->string($obj->detectLocale(['fr', 'it'], 'en-US', 'it-IT,it;q=0.8,en-US;q=0.5,en;q=0.3'))
                ->isEqualTo('it');

        $this
            ->string($obj->detectLocale(['ff', 'fr', 'it'], 'en-US', 'ff,fr-FR;q=0.8,fr;q=0.7,en-GB;q=0.5,en-US;q=0.3,en;q=0.2'))
                ->isEqualTo('ff');

        $this
            ->string($obj->detectLocale(['fr', 'it'], 'en-US', 'ff,fr-FR;q=0.8,fr;q=0.7,en-GB;q=0.5,en-US;q=0.3,en;q=0.2'))
                ->isEqualTo('fr');

        $this
            ->string($obj->detectLocale(['xh'], 'en-US', 'ff,fr-FR;q=0.8,fr;q=0.7,en-GB;q=0.5,en-US;q=0.3,en;q=0.2'))
                ->isEqualTo('en-US');
    }
}
