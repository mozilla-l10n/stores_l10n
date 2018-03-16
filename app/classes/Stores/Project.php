<?php
namespace Stores;

use Json\Json;

/**
 * Project class
 *
 * This class stores all data related to locales.
 *
 * @package Stores
 */
class Project
{
    /**
     * List of RTL locales
     *
     * @var array
     */
    private $rtl = [
        'ar', 'fa', 'he', 'ur',
    ];

    /**
     * Data about products: available channels, store, full name.
     *
     * @var array
     */
    private $products_data = [
        'fx_android' =>
            [
                'channels' => ['beta', 'nightly', 'release'],
                'name'     => 'Firefox for Android',
                'store'    => 'google',
            ],
        'fx_ios' =>
            [
                'channels' => ['release'],
                'name'     => 'Firefox for iOS',
                'store'    => 'apple',
            ],
        'focus_android' =>
            [
                'channels' => ['release'],
                'name'     => 'Focus for Android',
                'store'    => 'google',
            ],
        'focus_ios' =>
            [
                'channels' => ['release'],
                'name'     => 'Focus for iOS',
                'store'    => 'apple',
            ],
        'klar_android' =>
            [
                'channels' => ['release'],
                'name'     => 'Klar for Android',
                'store'    => 'google',
            ],
    ];

    /**
     * Supported stores
     *
     * @var array
     */
    private $supported_stores = ['apple', 'google'];

    /**
     * Locales supported in products and channels.
     *
     * @var array
     */
    private $shipping_locales = [];

    /**
     * Locales mapping between Mozilla and Stores codes. Format:
     * Store Code -> Mozilla Code
     *
     * Sources:
     * Google: https://bugzilla.mozilla.org/show_bug.cgi?id=1090731#c18
     * Apple: https://github.com/fastlane/fastlane/tree/master/deliver#available-language-codes
     *
     * For Apple see also http://www.ibabbleon.com/iOS-Language-Codes-ISO-639.html
     * For Google see also https://support.google.com/googleplay/android-developer/answer/113469
     *
     * If false, locale is unsupported in Mozilla products.
     *
     * @var array
     */
    private $locales_mapping = [
        'apple' => [
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
            'nl-NL'   => 'nl',
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
        ],
        'google' => [
            'af'     => 'af',
            'am'     => false,
            'ar'     => 'ar',
            'be'     => 'be',
            'bg'     => 'bg',
            'bn-BD'  => 'bn-BD',
            'ca'     => 'ca',
            'cs-CZ'  => 'cs',
            'da-DK'  => 'da',
            'de-DE'  => 'de',
            'el-GR'  => 'el',
            'en-GB'  => 'en-GB',
            'en-US'  => 'en-US',
            'es-419' => 'es-MX',
            'es-ES'  => 'es-ES',
            'es-US'  => 'es-MX',
            'et'     => 'et',
            'eu-ES'  => 'eu',
            'fa'     => 'fa',
            'fi-FI'  => 'fi',
            'fil'    => false, // Filipino
            'fr-CA'  => 'fr',
            'fr-FR'  => 'fr',
            'gl-ES'  => 'gl',
            'hi-IN'  => 'hi-IN',
            'hr'     => 'hr',
            'hu-HU'  => 'hu',
            'hy-AM'  => 'hy-AM',
            'id'     => 'id',
            'is-IS'  => 'is',
            'it-IT'  => 'it',
            'iw-IL'  => 'he',
            'ja-JP'  => 'ja',
            'ka-GE'  => 'ka',
            'km-KH'  => 'km',
            'kn-IN'  => 'kn',
            'ko-KR'  => 'ko',
            'lo-LA'  => 'lo',
            'lt'     => 'lt',
            'lv'     => 'lv',
            'mk-MK'  => 'mk',
            'ml-IN'  => 'ml',
            'mn-MN'  => 'mn',
            'mr-IN'  => 'mr',
            'ms'     => 'ms',
            'my-MM'  => 'my',
            'ne-NP'  => 'ne-NP',
            'nl-NL'  => 'nl',
            'no-NO'  => 'nb-NO',
            'pl-PL'  => 'pl',
            'pt-BR'  => 'pt-BR',
            'pt-PT'  => 'pt-PT',
            'rm'     => 'rm',
            'ro'     => 'ro',
            'ru-RU'  => 'ru',
            'si-LK'  => 'si',
            'sk'     => 'sk',
            'sl'     => 'sl',
            'sr'     => 'sr',
            'sv-SE'  => 'sv-SE',
            'sw'     => 'sw',
            'ta-IN'  => 'ta',
            'te-IN'  => 'te',
            'th'     => 'th',
            'tr-TR'  => 'tr',
            'uk'     => 'uk',
            'vi'     => 'vi',
            'zh-CN'  => 'zh-CN',
            'zh-TW'  => 'zh-TW',
            'zu'     => 'zu',
        ],
    ];

    /**
     * List of products and associated templates
     *
     * This is the structure of the array:
     *
     * PRODUCT_ID => [
     *     CHANNEL_ID => [
     *         'template' => PATH TO LOCAL TEMPLATE,
     *         'listing' => LANG FILE USED FOR LISTING,
     *         'whatsnew' => LANG FILE USED FOR WHATSNEW,
     *     ],
     *
     * It's possible to define a 'supported_locales' key if the product/channel
     * needs to support only a subset of the shipping languages. E.g.
     *
     * PRODUCT_ID => [
     *     CHANNEL_ID => [
     *         'template' => PATH TO LOCAL TEMPLATE,
     *         'listing' => LANG FILE USED FOR LISTING,
     *         'whatsnew' => LANG FILE USED FOR WHATSNEW,
     *         'supported_locales' => ['it'],
     *     ],
     *
     * @var array
     */
    public $templates = [
        'fx_android' => [
            'release' => [
                'template' => 'fx_android/release/listing_apr_2016.php',
                'listing'  => 'fx_android/description_release.lang',
                'whatsnew' => 'fx_android/whatsnew/android_59.lang',
            ],
            'beta' => [
                'template' => 'fx_android/beta/listing_may_2015.php',
                'listing'  => 'fx_android/description_beta.lang',
                'whatsnew' => 'fx_android/whatsnew/android_60.lang',
            ],
            'nightly' => [
                'template' => 'fx_android/nightly/listing_may_2017.php',
                'listing'  => 'fx_android/description_nightly.lang',
            ],
        ],
        'fx_ios' => [
            'release' => [
                'template' => 'fx_ios/release/listing_sept_2015.php',
                'listing'  => 'fx_ios/description_release.lang',
                'whatsnew' => 'fx_ios/whatsnew/ios_11.lang',
            ],
        ],
        'focus_ios' => [
            'release' => [
                'template'    => 'focus_ios/release/listing_jan_2017.php',
                'listing'     => 'focus_ios/description_release.lang',
                'whatsnew'    => 'focus_ios/whatsnew/focus_3_1.lang',
                'screenshots' => 'focus_ios/screenshots_v2_1.lang',
            ],
        ],
        'focus_android' => [
            'release' => [
                'template'    => 'focus_android/release/listing_mar_2017.php',
                'listing'     => 'focus_android/description_release.lang',
                'screenshots' => 'focus_android/screenshots_v1.lang',
            ],
        ],
        'klar_android' => [
            'release' => [
                'template'    => 'klar_android/release/listing_mar_2017.php',
                'listing'     => 'klar_android/description_release.lang',
            ],
        ],
    ];

    /**
     * List of locale specific template overrides
     *
     * The array includes a list of locales, and for each locale the same
     * structure used in $template. Only changed values need to be added
     * to the array. For example:
     *
     * LOCALE => [
     *     PRODUCT_ID => [
     *         CHANNEL_ID => [
     *             'template' => PATH TO ALTERNATIVE TEMPLATE,
     *         ]
     *     ]
     * ],
     *
     * @var array
     */
    public $templates_overrides = [];

    public function __construct()
    {
        $json_object = new Json;
        $config_folder = realpath(__DIR__ . '/../../config/');

        $this->shipping_locales = $json_object
            ->setURI("{$config_folder}/shipping_locales.json")
            ->fetchContent();

        // Clean up list of locales supported in iOS products
        $this->shipping_locales['fx_ios']['release'] = self::cleanUpiOS($this->shipping_locales['fx_ios']['release']);
        $this->shipping_locales['focus_ios']['release'] = self::cleanUpiOS($this->shipping_locales['focus_ios']['release']);
    }

    /**
     * Clean up the list of shipping locales for iOS
     *
     * @param string $shipping_locales The list of shipping locales
     *
     * @return string Cleaned up list of locales
     */
    public function cleanUpiOS($shipping_locales)
    {
        /*
            Some changes are needed from the raw list of locales for iOS:
            * es -> es-ES
            * ses -> son
        */
        if (in_array('es', $shipping_locales)) {
            $shipping_locales = array_diff($shipping_locales, ['es']);
            $shipping_locales[] = 'es-ES';
        }

        if (in_array('ses', $shipping_locales)) {
            $shipping_locales = array_diff($shipping_locales, ['ses']);
            $shipping_locales[] = 'son';
        }

        // Make sure the list doesn't have duplicates and it's sorted
        $shipping_locales = array_unique($shipping_locales);
        sort($shipping_locales);

        return $shipping_locales;
    }

    /**
     * Check if a locale is Right-To-Left
     *
     * @param string $locale Locale code to check
     *
     * @return boolean true if $locale is a Right-To-Left locale, false otherwise
     */
    public function isRTL($locale)
    {
        return in_array($locale, $this->rtl);
    }

    /**
     * Get the store associated to a product ID
     *
     * @param string $product Product ID
     *
     * @return string Store's code
     */
    public function getProductStore($product)
    {
        $store = '';
        if (isset($this->products_data[$product])) {
            $store = $this->products_data[$product]['store'];
        }

        return $store;
    }

    /**
     * Get the name associated to product ID
     *
     * @param string $product Product ID
     *
     * @return string Product's name
     */
    public function getProductName($product)
    {
        return isset($this->products_data[$product])
            ? $this->products_data[$product]['name']
            : $product;
    }

    /**
     * Extract the latest version of product ID from the lang filename
     *
     * @param string $product Product ID
     *
     * @return string Latest version
     */
    public function getLatestVersion($product)
    {
        $latest_version = 0;
        $supported_channels = $this->getProductChannels($product);
        foreach ($supported_channels as $channel) {
            if ($this->hasWhatsnew($product, $channel)) {
                $whatsnewfiles = $this->getLangFiles('en-US', $product, $channel, 'whatsnew');
                $matches = [];
                // Examples of lang file name: android_60.lang, android_60a.lang, android_60_b.lang
                if (preg_match('/.*_(\d+)(?:[_a-z])*\.lang/i', $whatsnewfiles[0], $matches)) {
                    $version_number = $matches[1];
                    if (intval($version_number) > $latest_version) {
                        $latest_version = intval($version_number);
                    }
                }
            }
        }

        return $latest_version;
    }

    /**
     * Get the channels supported for product ID
     *
     * @param string  $product  Product ID
     * @param boolean $shipping If true, returns all locales supported
     *                          by product, not just those supported
     *                          for store localization
     *
     * @return array List of supported channels
     */
    public function getProductChannels($product, $shipping = false)
    {
        if ($shipping) {
            return isset($this->shipping_locales[$product])
                ? array_keys($this->shipping_locales[$product])
                : [];
        }

        return isset($this->products_data[$product])
            ? $this->products_data[$product]['channels']
            : [];
    }

    /**
     * Get a list of supported product IDs
     *
     * @return array List of supported product IDs
     */
    public function getSupportedProducts()
    {
        return array_keys($this->products_data);
    }

    /**
     * Get a list of supported stores
     *
     * @return array List of supported stores
     */
    public function getSupportedStores()
    {
        return $this->supported_stores;
    }

    /**
     * Check if the product supports only a subset of the shipping locales
     *
     * @param string $product Product ID
     * @param string $channel Channel ID
     *
     * @return array List of supported locales, either by the product or
     *               by the template (if a subset is defined)
     */
    public function getSupportedLocales($product, $channel)
    {
        if (isset($this->templates[$product][$channel]['supported_locales'])) {
            return $this->templates[$product][$channel]['supported_locales'];
        }

        return isset($this->shipping_locales[$product][$channel])
            ? $this->shipping_locales[$product][$channel]
            : [];
    }

    /**
     * Get common Locales supported by the product's store and Mozilla
     *
     * @param string $product Product ID
     * @param string $channel Channel ID
     *
     * @return mixed Array of locales or false if the call is incorrect
     */
    public function getStoreMozillaCommonLocales($product, $channel)
    {
        // Map product to its store.
        $store = $this->getProductStore($product);

        // Return early if store is unsupported
        if (! isset($this->locales_mapping[$store])) {
            return false;
        }

        $locales = [];
        if ($store == 'google' && in_array($channel, $this->getProductChannels($product))) {
            $locales = $this->getSupportedLocales($product, $channel);
        }

        if ($store == 'apple' && in_array($channel, $this->getProductChannels($product))) {
            $locales = $this->getSupportedLocales($product, $channel);
        }

        if (count($locales) > 0) {
            return array_intersect(
                $locales,
                array_values(array_filter($this->locales_mapping[$store]))
            );
        }

        return false;
    }

    /**
     * Get locales supported by the requested store
     *
     * @param string  $store   Name of the store (google, apple)
     * @param boolean $mapping If false returns mapping as Store->Mozilla,
     *                         if true returns mapping as Mozilla->Store
     *
     * @return mixed Array of locales or false if the call is incorrect
     */
    public function getStoreLocales($store, $mapping = false)
    {
        if (isset($this->locales_mapping[$store])) {
            return $mapping
                ? $this->locales_mapping[$store]
                : array_keys($this->locales_mapping[$store]);
        }

        return false;
    }

    /**
     * Get list of supported locales for a product/channel combination
     *
     * @param string $product Product ID
     * @param string $channel Channel ID
     *
     * @return mixed Array of locales or false
     */
    public function getProductLocales($product, $channel)
    {
        // Return requested channel, or fall back to release
        if (isset($this->shipping_locales[$product])) {
            $locales = isset($this->shipping_locales[$product][$channel])
                ? $this->shipping_locales[$product][$channel]
                : $this->shipping_locales[$product]['release'];

            // Drop en-US
            return array_values(array_diff($locales, ['en-US']));
        }

        return false;
    }

    /**
     * Get mapping of locales for a store
     *
     * @param string  $store   Name of the store
     * @param boolean $reverse Optional, flip array keys and values
     *
     * @return mixed List of locales or false
     */
    public function getLocalesMapping($store, $reverse = false)
    {
        if (! isset($this->locales_mapping[$store])) {
            return false;
        }

        $data = $this->locales_mapping[$store];

        return $reverse ? array_flip(array_filter($data)) : $data;
    }

    /**
     * Get the template path for a product and channel
     *
     * @param string $locale  Locale code
     * @param string $product Product ID
     * @param string $channel Channel ID
     *
     * @return mixed String containing the template path or false
     */
    public function getTemplate($locale, $product, $channel)
    {
        if (isset($this->templates_overrides[$locale][$product][$channel]['template'])) {
            return $this->templates_overrides[$locale][$product][$channel]['template'];
        }

        if (! isset($this->templates[$product][$channel]['template'])) {
            return false;
        }

        return $this->templates[$product][$channel]['template'];
    }

    /**
     * Get the lang file name(s) for a product and channel.
     * Can be filtered by Section.
     *
     * @param string $locale  Locale code
     * @param string $product Product ID
     * @param string $channel Channel ID
     * @param string $section Name of the section defined in $this->template
     *                        containing the lang file(s). If 'all' return
     *                        all lang files defined.
     *
     * @return array Array of langfile names, empty if not supported
     */
    public function getLangFiles($locale, $product, $channel, $section)
    {
        if ($section == 'all') {
            // Take all available sections, filter out known non-sections
            $sections = array_keys($this->templates[$product][$channel]);
            $sections = array_diff($sections, ['template', 'supported_locales']);
        } else {
            $sections = [$section];
        }

        $templates = [];
        foreach ($sections as $section_name) {
            // Check if there is an override, otherwise take the default lang file
            if (isset($this->templates[$product][$channel][$section_name])) {
                $templates[] = isset($this->templates_overrides[$locale][$product][$channel][$section_name])
                    ? $this->templates_overrides[$locale][$product][$channel][$section_name]
                    : $this->templates[$product][$channel][$section_name];
            }
        }

        return $templates;
    }

    /**
     * Return true if whatsnew is available for product/channel
     *
     * @param string $product Product ID
     * @param string $channel Channel ID
     *
     * @return boolean True if product/channel has a whatsnew section,
     *                 false otherwise
     */
    public function hasWhatsnew($product, $channel)
    {
        return in_array('whatsnew', array_keys($this->templates[$product][$channel]));
    }
}
