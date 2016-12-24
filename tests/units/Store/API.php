<?php
namespace tests\units\Stores;

use atoum;
use Stores\API as _API;

require_once __DIR__ . '/../bootstrap.php';

class API extends atoum\test
{
    public function getServiceDP()
    {
        return [
            [
                ['path' => 'test'],
                'Invalid service',
            ],
            [
                ['path' => 'api/google/storelocales/'],
                'storelocales',
            ],
            [
                ['path' => 'api/google/firefoxlocales/release/'],
                'firefoxlocales',
            ],
            [
                ['path' => 'api/google/localesmapping/'],
                'localesmapping',
            ],
            [
                ['path' => 'api/apple/done/beta/'],
                'done',
            ],
            [
                ['path' => 'api/google/translation/beta/de/'],
                'translation',
            ],
        ];
    }

    /**
     * @dataProvider getServiceDP
     */
    public function testGetService($a, $b)
    {
        $obj = new _API($a);
        $this
            ->string($obj->getService())
                ->isEqualTo($b);
    }

    public function isValidRequestDP()
    {
        return [
            [
                ['path' => 'test'],
                false,
            ],
            [
                ['path' => 'api/google/storelocales/'],
                true,
            ],
            [
                ['path' => 'api/google/firefoxlocales/release/'],
                true,
            ],
            [
                ['path' => 'api/google/localesmapping/'],
                true,
            ],
            [
                ['path' => 'api/google/done/release/'],
                true,
            ],
            [
                ['path' => 'api/google/listing/release/'],
                true,
            ],
            [
                ['path' => 'api/google/whatsnew/release/'],
                true,
            ],
            [
                ['path' => 'api/google/translation/beta/de/'],
                true,
            ],
        ];
    }

    /**
     * @dataProvider isValidRequestDP
     */
    public function testIsValidRequest($a, $b)
    {
        $obj = new _API($a);
        $this
            ->boolean($obj->isValidRequest())
                ->isEqualTo($b);
    }

    public function invalidAPICallDP()
    {
        return [
            [
                // Valid path
                ['path'  => 'api/google/storelocales/'],
                ['error' => null],
            ],
            [
                // invalid path
                ['path'  => 'api/toto/storelocales/'],
                ['error' => 'The store (toto) is invalid.'],
            ],
        ];
    }

    /**
     * @dataProvider invalidAPICallDP
     */
    public function testInvalidAPICall($a, $b)
    {
        $obj = new _API($a);
        $obj->isValidRequest();
        $this
            ->array($obj->invalidAPICall())
                ->isEqualTo($b);
    }
}
