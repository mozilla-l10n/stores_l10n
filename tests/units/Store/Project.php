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
        $shipping_locales = ['ar', 'es', 'en-US', 'en-GB', 'ses', 'son', 'ta'];
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

    public function testGetSupportedProducts()
    {
        $obj = new _Project();
        $this
            ->array($obj->getSupportedProducts())
                ->isEqualTo(['fx_android', 'fx_ios', 'focus_android', 'focus_ios', 'klar_android']);
    }

    public function testGetSupportedStores()
    {
        $obj = new _Project();
        $this
            ->array($obj->getSupportedStores())
                ->isEqualTo(['apple', 'google']);
    }

    public function testGetProductStore()
    {
        $obj = new _Project();
        $this
            ->string($obj->getProductStore('fx_android'))
                ->isEqualTo('google');
        $this
            ->string($obj->getProductStore('fx_ios'))
                ->isEqualTo('apple');
        $this
            ->string($obj->getProductStore('foobar'))
                ->isEqualTo('');
    }

    public function testGetProductName()
    {
        $obj = new _Project();
        $this
            ->string($obj->getProductName('fx_android'))
                ->isEqualTo('Firefox for Android');
        $this
            ->string($obj->getProductName('fx_ios'))
                ->isEqualTo('Firefox for iOS');
        $this
            ->string($obj->getProductName('foobar'))
                ->isEqualTo('foobar');
    }

    public function testGetProductChannels()
    {
        $obj = new _Project();

        $this
            ->array($obj->getProductChannels('fx_android'))
                ->isEqualTo(['beta', 'nightly', 'release']);
        $this
            ->array($obj->getProductChannels('fx_android', true))
                ->hassize(3)
                ->contains('beta')
                ->contains('nightly');
        $this
            ->array($obj->getProductChannels('fx_ios'))
                ->isEqualTo(['release']);
        $this
            ->array($obj->getProductChannels('foobar'))
                ->isEqualTo([]);
    }

    public function testGetStoreMozillaCommonLocales()
    {
        $obj = new _Project();

        // Google
        $this
            ->array($obj->getStoreMozillaCommonLocales('fx_android', 'release'));
        $this
            ->array($obj->getStoreMozillaCommonLocales('fx_android', 'beta'));

        $tmp_locales = $obj->getStoreMozillaCommonLocales('fx_android', 'release');
        $this
            ->array($tmp_locales)
                ->contains('en-US')
                ->contains('ca')
                ->contains('es-MX')
                ->notContains('af')
                ->notContains('am');

        // App Store
        $this
            ->array($obj->getStoreMozillaCommonLocales('fx_ios', 'release'));
        $this
            ->boolean($obj->getStoreMozillaCommonLocales('fx_ios', 'beta'))
                ->isFalse();
        $tmp_locales = $obj->getStoreMozillaCommonLocales('fx_ios', 'release');
        $this
            ->array($tmp_locales)
                ->contains('en-US')
                ->contains('da')
                ->notContains('af')
                ->notContains('zh-Hans');

        // Unsupported
        $this
            ->boolean($obj->getStoreMozillaCommonLocales('FAKE_PRODUCT', 'beta'))
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
                ->contains('de');
        $this
            ->array($obj->getStoreLocales('google', false))
                ->contains('es-419');

        // App Store
        $this
            ->array($obj->getStoreLocales('apple', true))
                ->hasKey('zh-Hans')
                ->contains('zh-CN');
        $this
            ->array($obj->getStoreLocales('apple', false))
                ->contains('fr-CA');
    }

    public function testGetProductLocales()
    {
        $obj = new _Project();

        // Google
        $this
            ->array($obj->getProductLocales('fx_android', 'release'))
                ->notContains('en-US')
                ->contains('fr');
        $this
            ->array($obj->getProductLocales('fx_android', 'beta'))
                ->notContains('en-US')
                ->contains('fr');
        // Check fallback to release
        $release_locales = $obj->getProductLocales('fx_android', 'release');
        $this
            ->array($obj->getProductLocales('fx_android', false))
                ->isEqualTo($release_locales);
        $this
            ->array($obj->getProductLocales('fx_android', 'foobar'))
                ->isEqualTo($release_locales);

        // App Store
        $this
            ->array($obj->getProductLocales('fx_ios', 'release'))
                ->notContains('en-US')
                ->contains('it');
        $this
            ->array($obj->getProductLocales('fx_ios', 'beta'))
                ->notContains('en-US')
                ->contains('it');

        // Unsupported product
        $this
            ->boolean($obj->getProductLocales('foobar', false))
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
                ->contains('es-MX');
        $this
            ->array($obj->getLocalesMapping('google', true))
                ->contains('de-DE')
                ->notContains('fil');

        // App Store
        $this
            ->array($obj->getLocalesMapping('apple', false))
                ->hasKey('zh-Hans')
                ->contains('zh-CN');
        $this
            ->array($obj->getLocalesMapping('apple', true))
                ->hasKey('zh-TW')
                ->contains('zh-Hant');
    }

    public function testGetTemplate()
    {
        $obj = new _Project();
        $this
            ->string($obj->getTemplate('fr', 'fx_android', 'release'));
        $this
            ->string($obj->getTemplate('it', 'fx_android', 'beta'));
        $this
            ->boolean($obj->getTemplate('ja', 'fx_android', 'foobar'))
                ->isFalse();
    }

    public function testHasWhatsnew()
    {
        $obj = new _Project();
        $this
            ->boolean($obj->hasWhatsnew('fx_android', 'release'))
                ->isTrue();
        $this
            ->boolean($obj->hasWhatsnew('fx_android', 'nightly'))
                ->isFalse();
    }

    public function testGetLangFiles()
    {
        $obj = new _Project();
        $this
            ->array($obj->getLangFiles('fr', 'fx_android', 'release', 'listing'))
                ->hassize(1)
                ->contains('fx_android/description_release.lang');

        $this
            ->array($obj->getLangFiles('fr', 'fx_android', 'beta', 'listing'))
                ->hassize(1)
                ->contains('fx_android/description_beta.lang');

        $this
            ->array($obj->getLangFiles('fr', 'fx_android', 'beta', 'all'))
                ->hassize(2)
                ->contains('fx_android/description_beta.lang');

        $this
            ->array($obj->getLangFiles('fr', 'fx_android', 'foobar', 'listing'))
                ->hassize(0);

        $this
            ->array($obj->getLangFiles('fr', 'fx_android', 'release', 'whatsnew'))
                ->hassize(1);

        $this
            ->array($obj->getLangFiles('fr', 'fx_android', 'beta', 'whatsnew'))
                ->hassize(1);
    }
}
