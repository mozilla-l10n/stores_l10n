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
                '',
            ],
            // Store APIs
            [
                ['path' => 'api/google/storelocales/'],
                'storelocales',
            ],
            [
                ['path' => 'api/google/localesmapping/'],
                'localesmapping',
            ],
            // Product APIs
            [
                ['path' => 'api/fx_android/supportedlocales/release/'],
                'supportedlocales',
            ],
            [
                ['path' => 'api/fx_ios/done/beta/'],
                'done',
            ],
            [
                ['path' => 'api/fx_android/translation/beta/de/'],
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
                ['path' => 'api/v1/google/storelocales/'],
                true,
            ],
            [
                ['path' => 'api/v1/google/localesmapping/'],
                true,
            ],
            [
                ['path' => 'api/v1/fx_android/done/release/'],
                true,
            ],
            [
                ['path' => 'api/v1/fx_android/listing/release/'],
                true,
            ],
            [
                ['path' => 'api/v1/fx_android/whatsnew/release/'],
                true,
            ],
            [
                ['path' => 'api/v1/fx_android/translation/beta/de/'],
                true,
            ],
            // Legacy call (products: google, apple), unsupported
            [
                ['path' => 'api/v1/apple/done/release/'],
                false,
            ],
            [
                ['path' => 'api/google/whatsnew/release/'],
                false,
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

    public function isValidAPIVersionDP()
    {
        return [
            [
                'v1',
                true,
            ],
            [
                'foo',
                false,
            ],
            [
                'f1',
                false,
            ],
            [
                'ver1',
                false,
            ],
            [
                'v20',
                true,
            ],
        ];
    }

    /**
     * @dataProvider isValidAPIVersionDP
     */
    public function testIsValidAPIVersion($a, $b)
    {
        $obj = new _API('');
        $this
            ->boolean($obj->isValidAPIVersion($a))
                ->isEqualTo($b);
    }

    public function invalidAPICallDP()
    {
        return [
            [
                // Valid path
                ['path'  => 'api/google/storelocales/'],
                ['error' => 'LEGACY request without version. Fall back to v1.'],
            ],
            [
                // Valid path
                ['path'  => 'api/v1/google/storelocales/'],
                ['error' => null],
            ],
            [
                // Unsupported version
                ['path'  => 'api/v3/google/storelocales/'],
                ['error' => 'Unsupported API version: v3'],
            ],
            [
                // Invalid path
                ['path'  => 'api/toto/storelocales/'],
                ['error' => 'Store (toto) is invalid.'],
            ],
            [
                // Invalid path
                ['path'  => 'api/toto/supportedlocales/'],
                ['error' => 'Product (toto) is invalid.'],
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

    public function isTranslationRequiredDP()
    {
        return [
            [
                ['path' => 'test'],
                false,
            ],
            // Store APIs
            [
                ['path' => 'api/google/storelocales/'],
                false,
            ],
            [
                ['path' => 'api/google/localesmapping/'],
                false,
            ],
            // Product APIs
            [
                ['path' => 'api/fx_android/supportedlocales/release/'],
                false,
            ],
            [
                ['path' => 'api/fx_ios/done/beta/'],
                true,
            ],
            [
                ['path' => 'api/fx_android/translation/beta/de/'],
                true,
            ],
        ];
    }

    /**
     * @dataProvider isTranslationRequiredDP
     */
    public function testIsTranslationRequired($a, $b)
    {
        $obj = new _API($a);
        $this
            ->boolean($obj->isTranslationRequired())
                ->isEqualTo($b);
    }
}
