<?php
namespace Stores;

/**
 * Project class
 *
 * This class stores all data related to locales.
 *
 * @package Stores
 */
class Project
{
    // Source : http://hg.mozilla.org/releases/mozilla-release/raw-file/tip/mobile/android/locales/maemo-locales
    // Source : http://hg.mozilla.org/releases/mozilla-beta/raw-file/tip/mobile/android/locales/maemo-locales
    // Source : http://hg.mozilla.org/releases/mozilla-aurora/raw-file/tip/mobile/android/locales/maemo-locales
    private $android_locales_release = [
        'an', 'as', 'be', 'bn-IN', 'ca', 'cs', 'cy', 'da', 'de',
        'es-AR', 'es-ES', 'es-MX', 'et', 'eu', 'fi', 'ff', 'fr',
        'fy-NL', 'ga-IE', 'gd', 'gl' ,'gu-IN', 'hi-IN', 'hu',
        'hy-AM', 'id', 'is', 'it', 'ja', 'kk', 'kn', 'ko', 'lt',
        'lv', 'ml', 'mr', 'ms', 'nb-NO', 'nl', 'or', 'pa-IN',
        'pl', 'pt-BR', 'pt-PT', 'ro', 'ru', 'sq', 'sk', 'sl',
        'sv-SE', 'ta', 'te', 'th', 'tr', 'uk', 'zh-CN', 'zh-TW',
    ];

    private $android_locales_marketing = [
        'de', 'es-ES', 'es-MX', 'fr', 'id', 'it', 'ja', 'pt-BR',
        'ru', 'zh-CN',
    ];

    private $android_locales_aurora = [];

    private $android_locales_beta = [];

    // source: https://l10n.mozilla-community.org/~flod/webstatus/api/?product=firefox-ios
    // translations are at: http://svn.mozilla.org/projects/l10n-misc/trunk/firefox-ios/
    // For iOS we used the locale code es for Spanish from Spain, that was a mistake, this is
    // why I changed it to es-ES in the array below, otherwise the Spanish team would have
    // to work in the es-ES folder for Android and the es folder for iOS
    private $ios_locales_release = [
        'bg', 'bn-IN', 'br', 'cs', 'cy', 'da', 'de', 'dsb', 'en-US', 'es-ES',
        'es-MX', 'fr', 'fy-NL', 'ga-IE', 'gd', 'gl', 'hsb', 'id', 'is', 'it',
        'ja', 'ko', 'lt', 'nb-NO', 'nl', 'nn-NO', 'pl', 'pt-BR', 'pt-PT', 'ru',
        'sk', 'sl', 'son', 'sv-SE', 'templates', 'tr', 'uk', 'uz', 'zh-CN',
        'zh-TW',
    ];

    private $ios_locales_aurora = [];
    private $ios_locales_beta = [];

    private $google_locales_mapping = [
        'af'     => 'af',
        'ar'     => 'ar',
        'am'     => false,
        'be'     => 'be',
        'bg'     => 'bg',
        'cs-CZ'  => 'cs',
        'ca'     => 'ca',
        'da-DK'  => 'da',
        'de-DE'  => 'de',
        'el-GR'  => 'el',
        'en-GB'  => 'en-GB',
        'es-419' => 'es-MX', // Spanish, South America
        'es-ES'  => 'es-ES',
        'es-US'  => 'es-MX', // Spanish, South America
        'et'     => 'et',
        'fa'     => 'fa',
        'fi-FI'  => 'fi',
        'fil'    => false, // Filipino
        'fr-CA'  => 'fr',
        'fr-FR'  => 'fr',
        'hi-IN'  => 'hi-IN',
        'hu-HU'  => 'hu',
        'hr'     => 'hr',
        'id'     => 'id',
        'it-IT'  => 'it',
        'iw-IL'  => 'he',
        'ja-JP'  => 'ja',
        'ko-KR'  => 'ko',
        'lt'     => 'lt',
        'lv'     => 'lv',
        'ms'     => 'ms',
        'nl-NL'  => 'nl',
        'no-NO'  => 'nb-NO',
        'pl-PL'  => 'pl',
        'pt-BR'  => 'pt-BR',
        'pt-PT'  => 'pt-PT',
        'rm'     => 'rm',
        'ro'     => 'ro',
        'ru-RU'  => 'ru',
        'sk'     => 'sk',
        'sl'     => 'sl',
        'sr'     => 'sr',
        'sv-SE'  => 'sv-SE',
        'sw'     => 'sw',
        'th'     => 'th',
        'tr-TR'  => 'tr',
        'uk'     => 'uk',
        'vi'     => 'vi',
        'zh-CN'  => 'zh-CN',
        'zh-TW'  => 'zh-TW',
        'zu'     => 'zu',
    ];

    // Not exactly official, but this is the tool we use for our automation:
    // https://github.com/KrauseFx/deliver#available-language-codes
    private $apple_locales_mapping = [
        'da'      => 'da',
        'de-DE'   => 'de',
        'el'      => 'el',
        'en-AU'   => 'en-GB',
        'en-CA'   => 'en-US',
        'en-GB'   => 'en-GB',
        'en-US'   => 'en-US',
        'es-ES'   => 'es-ES',
        'es-MX'   => 'es-MX',
        'fi'      => 'fi',
        'fr-CA'   => 'fr',
        'fr-FR'   => 'fr',
        'id'      => 'id',
        'it'      => 'it',
        'ja'      => 'ja',
        'ko'      => 'ko',
        'ms'      => 'ms',
        'nl'      => 'nl',
        'no'      => 'nb-NO',
        'pt-BR'   => 'pt-BR',
        'pt-PT'   => 'pt-PT',
        'ru'      => 'ru',
        'sv'      => 'sv-SE',
        'th'      => 'th',
        'tr'      => 'tr',
        'vi'      => 'vi',
        'zh-Hans' => 'zh-CN',
        'zh-Hant' => 'zh-TW',
    ];

    public $templates = [
        'google' => [
            // channel => path to template file
            'release' => [
                'template' => 'google/release/listing_nov_2014.php',
                'langfile' => 'description_page.lang',
                ],
            'beta' => [
                'template' => 'google/beta/listing_may_2015.php',
                'langfile' => 'description_beta_page.lang',
                ],
            'next' => [
                'template' => 'google/next/listing_oct_2015.php',
                'langfile' => [
                    'description_page.lang',
                    'apple_description_release.lang',
                    'android_42_release.lang',
                    ],
                ],
        ],
        'apple' => [
            // channel => path to template file
            'release' => [
                'template' => 'apple/release/listing_sept_2015.php',
                'langfile' => 'apple_description_release.lang',
                ],
        ],
    ];

    public function __construct()
    {
        // As of 2015-06-01, android and ios channels have exactly the same locales list
        $this->android_locales_aurora    = $this->android_locales_release;
        $this->android_locales_beta      = $this->android_locales_release;
        $this->ios_locales_aurora        = $this->ios_locales_release;
        $this->ios_locales_beta          = $this->ios_locales_release;
    }

    /**
     * Return all the locales supported by Google Play
     *
     * @param  boolean $mapping If True, return the Google/mMzilla locale mapping list
     * @return array   List of locales, key is Google code, value is Mozilla code.
     *                         If we don't support a Google locale, the value is False
     */
    public function getGoogleStoreLocales($mapping = false)
    {
        return $mapping
            ? $this->google_locales_mapping
            : array_keys($this->google_locales_mapping);
    }

    /**
     * Return all the locales supported by Apple AppStore
     *
     * @param  boolean $mapping If True, return the Apple/Mozilla locale mapping list
     * @return array   List of locales, key is Apple code, value is Mozilla code.
     *                         If we don't support an Apple locale, the value is False
     */
    public function getAppleStoreLocales($mapping = false)
    {
        return $mapping
            ? $this->apple_locales_mapping
            : array_keys($this->apple_locales_mapping);
    }

    /**
     * Return the intersection of locales supported by both Mozilla and Google Play
     *
     * @param  string $channel The Mozilla channel, can be aurora, beta, release
     * @return array  List of locales
     */
    public function getGoogleMozillaCommonLocales($channel)
    {
        switch ($channel) {
            case 'aurora':
                $locales = $this->android_locales_aurora;
                break;
            case 'beta':
                $locales = $this->android_locales_beta;
                break;
            case 'next':
                $locales = $this->android_locales_marketing;
                break;
            case 'release':
            default:
                $locales = $this->android_locales_release;
                break;
        }

        return array_intersect(
            $locales,
            array_values(array_filter($this->google_locales_mapping))
        );
    }

    /**
     * Return the intersection of locales supported by both Mozilla and AppStore
     *
     * @param  string $channel The Mozilla channel, can be aurora, beta, release
     * @return array  List of locales
     */
    public function getAppleMozillaCommonLocales($channel)
    {
        switch ($channel) {
            case 'aurora':
                $locales = $this->ios_locales_aurora;
                break;
            case 'beta':
                $locales = $this->ios_locales_beta;
                break;
            case 'release':
            default:
                $locales = $this->ios_locales_release;
                break;
        }

        return array_intersect(
            $locales,
            array_values(array_filter($this->apple_locales_mapping))
        );
    }

    /**
     * Get Common Locales supported by the store and Mozilla
     * @param  string $store   Name of the store, ex: google, apple
     * @param  string $channel Name of the channel, can be release or beta
     * @return Mixed  Array of locales of False if the call is incorrect
     */
    public function getStoreMozillaCommonLocales($store, $channel)
    {
        if ($store == 'google') {
            if (in_array($channel, ['beta', 'release', 'next'])) {
                return $this->getGoogleMozillaCommonLocales($channel);
            }
        }
        if ($store == 'apple') {
            if (in_array($channel, ['release'])) {
                return $this->getAppleMozillaCommonLocales($channel);
            }
        }

        return false;
    }

    /**
     * Get Locales supported by the store
     * @param  string  $store   Name of the store, ex: google, apple
     * @param  boolean $mapping Return the Mozilla/Store locale mapping, False by Default
     * @return Mixed   Array of locales of False if the call is incorrect
     */
    public function getStoreLocales($store, $mapping = false)
    {
        if ($store == 'google') {
            return $this->getGoogleStoreLocales($mapping);
        }

        if ($store == 'apple') {
            return $this->getAppleStoreLocales($mapping);
        }

        return false;
    }

    /**
     * Get List of Firefox Locales for a product/channel combination
     * @param  string $store   Name of store
     * @param  string $channel Name of channel
     * @return mixed  Array of locales of False
     */
    public function getFirefoxLocales($store, $channel)
    {
        if ($store == 'google') {
            switch ($channel) {
                case 'aurora':
                    return $this->android_locales_aurora;
                case 'beta':
                    return $this->android_locales_beta;
                case 'next':
                    return $this->android_locales_marketing;
                case 'release':
                default:
                    return $this->android_locales_release;
            }
        }

        if ($store == 'apple') {
            switch ($channel) {
                case 'aurora':
                    return $this->ios_locales_aurora;
                case 'beta':
                    return $this->ios_locales_beta;
                case 'release':
                default:
                    return $this->ios_locales_release;
            }
        }

        return false;
    }

    /**
     * Get mapping of locales for a Store
     * @param  string  $store   Name of the store
     * @param  boolean $reverse Optional, flip array keys and values
     * @return mixed   List of locales or False
     */
    public function getLocalesMapping($store, $reverse = false)
    {
        if (! in_array($store, array_keys($this->templates))) {
            return false;
        }

        if ($store == 'google') {
            $data = $this->google_locales_mapping;
        }

        if ($store == 'apple') {
            $data = $this->apple_locales_mapping;
        }

        return $reverse ? array_flip(array_filter($data)) : $data;
    }

    /**
     * Get the template path for a Store and channel
     * @param  string $store   Name of the store
     * @param  string $channel Name of the channel
     * @return mixed  String containing the template path or False
     */
    public function getTemplate($store, $channel)
    {
        if (! isset($this->templates[$store][$channel]['template'])) {
            return false;
        }

        return $this->templates[$store][$channel]['template'];
    }

    /**
     * Get the lang file name for a Store and Channel
     * @param  string $store   Name of the Store
     * @param  string $channel Name of the Channel
     * @return mixed  String containing the langfile name or False
     */
    public function getLangFile($store, $channel)
    {
        if (! isset($this->templates[$store][$channel]['langfile'])) {
            return false;
        }

        return $this->templates[$store][$channel]['langfile'];
    }
}
