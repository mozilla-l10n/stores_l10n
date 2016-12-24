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
    private $rtl = ['ar', 'fa', 'he', 'ur'];

    /*
        Source : http://hg.mozilla.org/releases/mozilla-release/raw-file/tip/mobile/android/locales/maemo-locales
        Source : http://hg.mozilla.org/releases/mozilla-beta/raw-file/tip/mobile/android/locales/maemo-locales
        Source : http://hg.mozilla.org/releases/mozilla-aurora/raw-file/tip/mobile/android/locales/maemo-locales
    */
    private $android_locales_aurora = [
        'an', 'as', 'ast', 'az', 'bn-IN', 'br', 'ca', 'cak', 'cs', 'cy', 'da',
        'de', 'dsb', 'en-GB', 'en-ZA', 'eo', 'es-AR', 'es-CL', 'es-ES', 'es-MX',
        'et', 'eu', 'ff', 'fi', 'fr', 'fy-NL', 'ga-IE', 'gd', 'gl', 'gn',
        'gu-IN', 'hi-IN', 'hr', 'hsb', 'hu', 'hy-AM', 'id', 'is', 'it', 'ja',
        'ka', 'kk', 'kn', 'ko', 'lt', 'lv', 'mai', 'ml', 'mr', 'ms', 'my',
        'nb-NO', 'nl', 'nn-NO', 'or', 'pa-IN', 'pl', 'pt-BR', 'pt-PT', 'rm',
        'ro', 'ru', 'sk', 'sl', 'son', 'sq', 'sr', 'sv-SE', 'ta', 'te', 'th',
        'tr', 'uk', 'uz', 'xh', 'zh-CN', 'zh-TW',
    ];

    private $android_locales_beta = [
        'an', 'as', 'az', 'bn-IN', 'br', 'ca', 'cak', 'cs', 'cy', 'da', 'de',
        'dsb', 'en-GB', 'en-ZA', 'eo', 'es-AR', 'es-CL', 'es-ES', 'es-MX', 'et',
        'eu', 'ff', 'fi', 'fr', 'fy-NL', 'ga-IE', 'gd', 'gl', 'gn', 'gu-IN',
        'hi-IN', 'hr', 'hsb', 'hu', 'hy-AM', 'id', 'is', 'it', 'ja', 'kk', 'kn',
        'ko', 'lt', 'lv', 'mai', 'ml', 'mr', 'ms', 'my', 'nb-NO', 'nl', 'nn-NO',
        'or', 'pa-IN', 'pl', 'pt-BR', 'pt-PT', 'rm', 'ro', 'ru', 'sk', 'sl',
        'son', 'sq', 'sr', 'sv-SE', 'ta', 'te', 'th', 'tr', 'uk', 'uz', 'xh',
        'zh-CN', 'zh-TW',
    ];

    private $android_locales_release = [
        'an', 'as', 'az', 'bn-IN', 'br', 'ca', 'cak', 'cs', 'cy', 'da', 'de',
        'dsb', 'en-GB', 'en-ZA', 'eo', 'es-AR', 'es-CL', 'es-ES', 'es-MX', 'et',
        'eu', 'ff', 'fi', 'fr', 'fy-NL', 'ga-IE', 'gd', 'gl', 'gn', 'gu-IN',
        'hi-IN', 'hr', 'hsb', 'hu', 'hy-AM', 'id', 'is', 'it', 'ja', 'kk', 'kn',
        'ko', 'lt', 'lv', 'mai', 'ml', 'mr', 'ms', 'my', 'nb-NO', 'nl', 'nn-NO',
        'or', 'pa-IN', 'pl', 'pt-BR', 'pt-PT', 'rm', 'ro', 'ru', 'sk', 'sl',
        'son', 'sq', 'sr', 'sv-SE', 'ta', 'te', 'th', 'tr', 'uk', 'uz', 'xh',
        'zh-CN', 'zh-TW',
    ];

    /*
        source: https://raw.githubusercontent.com/mozilla/firefox-ios/v6.x/shipping_locales.txt
        This list needs to be cleaned up later in the costructor.
    */
    private $ios_locales_release = [
        'ast', 'az', 'bg', 'bn-BD', 'br', 'ca', 'cs', 'cy', 'da', 'de', 'dsb',
        'en-GB', 'en-US', 'eo', 'es-ES', 'es-CL', 'es-MX', 'eu', 'fr', 'fy-NL',
        'ga-IE', 'gd', 'he', 'hsb', 'hu', 'id', 'is', 'it', 'ja', 'kab', 'kk',
        'km', 'ko', 'lo', 'lt', 'lv', 'nb-NO', 'ne-NP', 'nl', 'nn-NO', 'pl',
        'pt-BR', 'pt-PT', 'rm', 'ro', 'ru', 'son', 'sk', 'sl', 'sv-SE', 'te',
        'th', 'tl', 'tr', 'uk', 'uz', 'zh-CN', 'zh-TW',
    ];

    /*
        Original list provided by marketing in https://bugzilla.mozilla.org/show_bug.cgi?id=1090731#c18
     */
    private $google_locales_mapping = [
        'af'     => 'af',
        'ar'     => 'ar',
        'am'     => false,
        'bg'     => 'bg',
        'cs-CZ'  => 'cs',
        'ca'     => 'ca',
        'da-DK'  => 'da',
        'de-DE'  => 'de',
        'el-GR'  => 'el',
        'en-GB'  => 'en-GB',
        'en-US'  => 'en-US',
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

    /*
        Not exactly official, but this is the tool we use for our automation:
        https://github.com/KrauseFx/deliver#available-language-codes
    */
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
                'template' => 'google/release/listing_apr_2016.php',
                'langfile' => 'android_release.lang',
                'whatsnew' => 'whatsnew/whatsnew_android_50.lang',
                ],
            'beta' => [
                'template' => 'google/beta/listing_may_2015.php',
                'langfile' => 'description_beta_page.lang',
                'whatsnew' => 'whatsnew/whatsnew_android_51_beta.lang',
                ],
        ],
        'apple' => [
            // channel => path to template file
            'release' => [
                'template' => 'apple/release/listing_sept_2015.php',
                'langfile' => 'apple_description_release.lang',
                'whatsnew' => 'whatsnew/whatsnew_ios_6_0.lang',
            ],
        ],
    ];

    public function __construct()
    {
        $this->ios_locales_release = self::CleanUpiOS($this->ios_locales_release);
    }

    /**
     * Clean up the list of shipping locales for iOS
     *
     * @param  String $shipping_locales The list of shipping locales
     * @return String Cleaned up list of locales
     */
    public function cleanUpiOS($shipping_locales)
    {
        /*
            Some changes are needed from the raw list of locales for iOS:
            * es -> es-ES
            * ses -> son
            * drop en-US
        */
        if (in_array('es', $shipping_locales)) {
            $shipping_locales = array_diff($shipping_locales, ['es']);
            $shipping_locales[] = 'es-ES';
        }

        if (in_array('ses', $shipping_locales)) {
            $shipping_locales = array_diff($shipping_locales, ['ses']);
            $shipping_locales[] = 'son';
        }

        $shipping_locales[] = 'en-US';

        // Make sure the list doesn't have duplicates and it's sorted
        $shipping_locales = array_unique($shipping_locales);
        sort($shipping_locales);

        return $shipping_locales;
    }

    /**
     * Check if a locale is Right-To-Left
     *
     * @param  String  $locale Locale code to check
     * @return boolean true if $locale is a Right-To-Left locale, false otherwise.
     */
    public function isRTL($locale)
    {
        return in_array($locale, $this->rtl);
    }

    /**
     * Return all the locales supported by Google Play
     *
     * @param  boolean $mapping If True, return the Google/Mozilla locale mapping list
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
            case 'release':
            default:
                $locales = $this->android_locales_release;
                // HACK: adding ar as experiment (bug 1259200)
                $locales[] = 'ar';
                sort($locales);
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
            /*
                Return the same list for all channels. There are no other
                channels for iOS besides release
            */
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
            if (in_array($channel, ['beta', 'release'])) {
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
                case 'release':
                default:
                    return $this->android_locales_release;
            }
        }

        if ($store == 'apple') {
            switch ($channel) {
                /*
                    Return the same list for all channels. There are no other
                    channels for iOS besides release
                */
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
     * Get the lang file name(s) for a Store and Channel. Can be filtered by Section.
     * @param  string $store   Name of the Store
     * @param  string $channel Name of the channel
     * @param  string $section Name of the section defined in $this->template
     *                         containing the lang file(s).
     * @return mixed  String containing the langfile name(s) or False
     */
    protected function getLangFile($store, $channel, $section)
    {
        if (! isset($this->templates[$store][$channel][$section])) {
            return false;
        }

        return $this->templates[$store][$channel][$section];
    }

    /**
     * Get the lang file name(s) for whatsnew section if it exists. Returns
     * false otherwise.
     * @param  string $store   Name of the Store
     * @param  string $channel Channel of the store
     * @return mixed  String containing the langfile name(s) or False
     */
    public function getWhatsnewFiles($store, $channel)
    {
        return $this->getLangFile($store, $channel, 'whatsnew');
    }

    /**
     * Get the lang file name(s) for listing section if it exists. Returns
     * false otherwise.
     * @param  string $store   Name of the Store
     * @param  string $channel Channel of the store
     * @return mixed  String containing the langfile name(s) or False
     */
    public function getListingFiles($store, $channel)
    {
        return $this->getLangFile($store, $channel, 'langfile');
    }
}
