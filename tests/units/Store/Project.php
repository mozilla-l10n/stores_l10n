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
                ->hassize(51)
            ;
        $this
            ->array($obj->getGoogleStoreLocales(false))
                ->contains('es-419')
                ->hassize(51)
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
                ->hassize(34)
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
    public function testGetLangFile()
    {
        $obj = new _Project();
        $this
            ->string($obj->getLangFile('google', 'release'))
            ->string($obj->getLangFile('google', 'beta'))
            ;
        $this
            ->boolean($obj->getLangFile('google', 'foobar'))
                ->isFalse()
            ;
    }
}
