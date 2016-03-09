<?php
namespace tests\units\Stores;

use atoum;
use Stores\Project as _Project;

require_once __DIR__ . '/../bootstrap.php';

class Project extends atoum\test
{
    public function testGetGoogleStoreLocales()
    {
        $obj = new _Project();
        $this
            ->array($obj->getGoogleStoreLocales(true))
                ->hasKey('es-419')
                ->contains('de')
                ->hassize(52)
            ;
        $this
            ->array($obj->getGoogleStoreLocales(false))
                ->contains('es-419')
                ->hassize(52)
            ;
    }

    public function testGetAppleStoreLocales()
    {
        $obj = new _Project();
        $this
            ->array($obj->getAppleStoreLocales(true))
                ->hasKey('zh-Hans')
                ->contains('zh-CN')
                ->hassize(28)
            ;
        $this
            ->array($obj->getAppleStoreLocales(false))
                ->contains('fr-CA')
                ->hassize(28)
            ;
    }

    public function testGetGoogleMozillaCommonLocales()
    {
        $obj = new _Project();
        $this
            ->array($obj->getGoogleMozillaCommonLocales('release'))
                ->contains('be')
                ->notContains('af')
                ->notContains('am')
                ->hassize(36)
            ;
    }

    public function testGetAppleMozillaCommonLocales()
    {
        $obj = new _Project();
        $this
            ->array($obj->getAppleMozillaCommonLocales('release'))
            ;
    }

    public function testGetStoreMozillaCommonLocales()
    {
        $obj = new _Project();
        $this
            ->array($obj->getStoreMozillaCommonLocales('google', 'release'))
            ;
        $this
            ->array($obj->getStoreMozillaCommonLocales('google', 'beta'))
            ;
        $this
            ->array($obj->getStoreMozillaCommonLocales('apple', 'release'))
            ;
        $this
            ->boolean($obj->getStoreMozillaCommonLocales('apple', 'beta'))
                ->isFalse()
            ;
        $this
            ->boolean($obj->getStoreMozillaCommonLocales('FAKE_STORE', 'beta'))
                ->isFalse()
            ;
    }

    public function testGetStoreLocales()
    {
        $obj = new _Project();
        $this
            ->array($obj->getStoreLocales('google', true))
            ;
        $this
            ->array($obj->getStoreLocales('google', false))
            ;
        $this
            ->array($obj->getStoreLocales('apple', true))
            ;
        $this
            ->array($obj->getStoreLocales('apple', false))
            ;
        $this
            ->boolean($obj->getStoreLocales('foobar', false))
                ->isFalse()
            ;
    }

    public function testGetFirefoxLocales()
    {
        $obj = new _Project();
        $this
            ->array($obj->getFirefoxLocales('google', true))
            ;
        $this
            ->array($obj->getFirefoxLocales('google', false))
            ;
        $this
            ->array($obj->getFirefoxLocales('apple', true))
            ;
        $this
            ->array($obj->getFirefoxLocales('apple', false))
            ;
        $this
            ->boolean($obj->getFirefoxLocales('foobar', false))
                ->isFalse()
            ;
    }

    public function testGetLocalesMapping()
    {
        $obj = new _Project();
        $this
            ->array($obj->getLocalesMapping('google', true))
            ;
        $this
            ->array($obj->getFirefoxLocales('google', false))
            ;
        $this
            ->array($obj->getFirefoxLocales('apple', true))
            ;
        $this
            ->array($obj->getFirefoxLocales('apple', false))
            ;
        $this
            ->boolean($obj->getFirefoxLocales('foobar', false))
                ->isFalse()
            ;
    }

    public function testGetTemplate()
    {
        $obj = new _Project();
        $this
            ->string($obj->getTemplate('google', 'release'))
            ->string($obj->getTemplate('google', 'beta'))
            ;
        $this
            ->boolean($obj->getTemplate('google', 'foobar'))
                ->isFalse()
            ;
    }
    public function testGetListingFiles()
    {
        $obj = new _Project();
        $this
            ->string($obj->getListingFiles('google', 'release'))
            ->string($obj->getListingFiles('google', 'beta'))
            ;
        $this
            ->boolean($obj->getListingFiles('google', 'foobar'))
                ->isFalse()
            ;
    }
    public function testGetWhatsnewFiles()
    {
        $obj = new _Project();
        $this
            ->string($obj->getWhatsnewFiles('google', 'release'))
            ;
        $this
            ->string($obj->getWhatsnewFiles('google', 'beta'))
            ;
    }
}
