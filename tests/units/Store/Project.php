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

    public function testIsLegacyProduct()
    {
        $obj = new _Project();
        $this
            ->boolean($obj->isLegacyProduct('google'))
                ->isTrue();
        $this
            ->boolean($obj->isLegacyProduct('apple'))
                ->isTrue();
        $this
            ->boolean($obj->isLegacyProduct('fx_ios'))
                ->isFalse();
    }

    public function testGetUpdatedProductCode()
    {
        $obj = new _Project();
        $this
            ->string($obj->getUpdatedProductCode('google'))
                ->isEqualTo('fx_android');
        $this
            ->string($obj->getUpdatedProductCode('apple'))
                ->isEqualTo('fx_ios');
        $this
            ->string($obj->getUpdatedProductCode('fx_android'))
                ->isEqualTo('fx_android');
    }

    public function testGetSupportedProducts()
    {
        $obj = new _Project();
        $this
            ->array($obj->getSupportedProducts())
                ->isEqualTo(['fx_android', 'fx_ios', 'focus_android', 'focus_ios']);
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
            ->string($obj->getProductStore('google'))
                ->isEqualTo('google');
        $this
            ->string($obj->getProductStore('fx_ios'))
                ->isEqualTo('apple');
        $this
            ->string($obj->getProductStore('apple'))
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
            ->string($obj->getProductName('google'))
                ->isEqualTo('Firefox for Android');
        $this
            ->string($obj->getProductName('fx_ios'))
                ->isEqualTo('Firefox for iOS');
        $this
            ->string($obj->getProductName('apple'))
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
                ->isEqualTo(['beta', 'release']);
        $this
            ->array($obj->getProductChannels('fx_android', true))
                ->hassize(3)
                ->contains('beta')
                ->contains('aurora');
        $this
            ->array($obj->getProductChannels('google'))
                ->isEqualTo(['beta', 'release']);
        $this
            ->array($obj->getProductChannels('fx_ios'))
                ->isEqualTo(['release']);
        $this
            ->array($obj->getProductChannels('apple'))
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
                ->notContains('af')
                ->notContains('am')
                ->notContains('es-MX')
                ->hassize(37);
        // Legacy product code
        $this
            ->array($obj->getStoreMozillaCommonLocales('google', 'release'))
                ->isEqualTo($tmp_locales);

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
                ->notContains('zh-Hans')
                ->hassize(21);
        // Legacy product code
        $this
            ->array($obj->getStoreMozillaCommonLocales('apple', 'release'))
                ->isEqualTo($tmp_locales);

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
                ->contains('de')
                ->hassize(51);
        $this
            ->array($obj->getStoreLocales('google', false))
                ->contains('es-419')
                ->hassize(51);

        // App Store
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

    public function testGetProductLocales()
    {
        $obj = new _Project();

        // Google
        $this
            ->array($obj->getProductLocales('fx_android', 'release'))
                ->notContains('en-US')
                ->contains('fr');
        $this
            ->array($obj->getProductLocales('google', 'release'))
                ->notContains('en-US')
                ->contains('fr');
        $this
            ->array($obj->getProductLocales('google', 'beta'))
                ->notContains('en-US')
                ->contains('fr');
        // Check fallback to release
        $release_locales = $obj->getProductLocales('google', 'release');
        $this
            ->array($obj->getProductLocales('google', false))
                ->isEqualTo($release_locales);
        $this
            ->array($obj->getProductLocales('google', 'foobar'))
                ->isEqualTo($release_locales);

        // App Store
        $this
            ->array($obj->getProductLocales('fx_ios', 'release'))
                ->notContains('en-US')
                ->contains('it');
        $this
            ->array($obj->getProductLocales('apple', 'release'))
                ->notContains('en-US')
                ->contains('it');
        $this
            ->array($obj->getProductLocales('apple', 'beta'))
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
                ->notContains('es-MX')
                ->hassize(51);
        $this
            ->array($obj->getLocalesMapping('google', true))
                ->contains('de-DE')
                ->notContains('es-US')
                ->hassize(45);

        // App Store
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
            ->string($obj->getTemplate('fr', 'fx_android', 'release'));
        $this
            ->string($obj->getTemplate('it', 'fx_android', 'beta'));
        $this
            ->boolean($obj->getTemplate('ja', 'fx_android', 'foobar'))
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
