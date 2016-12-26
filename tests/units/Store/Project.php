<?php
namespace tests\units\Stores;

use atoum;
use Stores\Project as _Project;

require_once __DIR__ . '/../bootstrap.php';

class Project extends atoum\test
{
    public function testCleanUpiOS()
    {
        $obj = new _Project();
        $shipping_locales = ['ar', 'es', 'en-GB', 'ses', 'son', 'ta'];
        $shipping_locales = $obj->cleanUpiOS($shipping_locales);

        $this
            ->boolean(in_array('en-US', $shipping_locales))
                ->isTrue();
        $this
            ->boolean(in_array('es-ES', $shipping_locales))
                ->isTrue();
        $this
            ->boolean(in_array('es', $shipping_locales))
                ->isFalse();
        $this
            ->boolean(in_array('son', $shipping_locales))
                ->isTrue();
        $this
            ->boolean(in_array('ses', $shipping_locales))
                ->isFalse();
    }

    public function testIsRTL()
    {
        $obj = new _Project();
        $this
            ->boolean($obj->isRTL('ar'))
                ->isTrue();
        $this
            ->boolean($obj->isRTL('fa'))
                ->isTrue();
        $this
            ->boolean($obj->isRTL('fr'))
                ->isFalse();
        $this
            ->boolean($obj->isRTL('he'))
                ->isTrue();
        $this
            ->boolean($obj->isRTL('ur'))
                ->isTrue();
    }

    public function testGetGoogleMozillaCommonLocales()
    {
        $obj = new _Project();
        $this
            ->array($obj->getGoogleMozillaCommonLocales('release'))
                ->contains('ca')
                ->notContains('af')
                ->notContains('am')
                ->hassize(38);
    }

    public function testGetAppleMozillaCommonLocales()
    {
        $obj = new _Project();
        $this
            ->array($obj->getAppleMozillaCommonLocales('release'));
    }

    public function testGetStoreMozillaCommonLocales()
    {
        $obj = new _Project();
        $this
            ->array($obj->getStoreMozillaCommonLocales('google', 'release'));
        $this
            ->array($obj->getStoreMozillaCommonLocales('google', 'beta'));
        $this
            ->array($obj->getStoreMozillaCommonLocales('apple', 'release'));
        $this
            ->boolean($obj->getStoreMozillaCommonLocales('apple', 'beta'))
                ->isFalse();
        $this
            ->boolean($obj->getStoreMozillaCommonLocales('FAKE_STORE', 'beta'))
                ->isFalse();
    }

    public function testGetStoreLocales()
    {
        $obj = new _Project();

        // Unsupported store
        $this
            ->boolean($obj->getStoreLocales('foobar', false))
                ->isFalse();

        // Google Play
        $this
            ->array($obj->getStoreLocales('google', true))
                ->hasKey('es-419')
                ->contains('de')
                ->hassize(51);
        $this
            ->array($obj->getStoreLocales('google', false))
                ->contains('es-419')
                ->hassize(51);

        // AppStore
        $this
            ->array($obj->getStoreLocales('apple', true))
                ->hasKey('zh-Hans')
                ->contains('zh-CN')
                ->hassize(28);
        $this
            ->array($obj->getStoreLocales('apple', false))
                ->contains('fr-CA')
                ->hassize(28);
    }

    public function testGetFirefoxLocales()
    {
        $obj = new _Project();
        $this
            ->array($obj->getFirefoxLocales('google', true));
        $this
            ->array($obj->getFirefoxLocales('google', false));
        $this
            ->array($obj->getFirefoxLocales('apple', true));
        $this
            ->array($obj->getFirefoxLocales('apple', false));
        $this
            ->boolean($obj->getFirefoxLocales('foobar', false))
                ->isFalse();
    }

    public function testGetLocalesMapping()
    {
        $obj = new _Project();

        // Unsupported store
        $this
            ->boolean($obj->getLocalesMapping('foobar', false))
                ->isFalse();

        // Google Play
        $this
            ->array($obj->getLocalesMapping('google', false))
                ->hasKey('es-419')
                ->contains('de')
                ->hassize(51);
        $this
            ->array($obj->getLocalesMapping('google', true))
                ->contains('de-DE')
                ->hassize(47);

        // AppStore
        $this
            ->array($obj->getLocalesMapping('apple', false))
                ->hasKey('zh-Hans')
                ->contains('zh-CN')
                ->hassize(28);
        $this
            ->array($obj->getLocalesMapping('apple', true))
                ->hasKey('zh-TW')
                ->contains('zh-Hant')
                ->hassize(25);
    }

    public function testGetTemplate()
    {
        $obj = new _Project();
        $this
            ->string($obj->getTemplate('google', 'release'))
            ->string($obj->getTemplate('google', 'beta'));
        $this
            ->boolean($obj->getTemplate('google', 'foobar'))
                ->isFalse();
    }
    public function testGetListingFiles()
    {
        $obj = new _Project();
        $this
            ->string($obj->getListingFiles('google', 'release'))
            ->string($obj->getListingFiles('google', 'beta'));
        $this
            ->boolean($obj->getListingFiles('google', 'foobar'))
                ->isFalse();
    }
    public function testGetWhatsnewFiles()
    {
        $obj = new _Project();
        $this
            ->string($obj->getWhatsnewFiles('google', 'release'));
        $this
            ->string($obj->getWhatsnewFiles('google', 'beta'));
    }
}
