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
    /**
     * List of RTL locales
     *
     * @var array
     */
    private $rtl = [
        'ar', 'fa', 'he', 'ur',
    ];

    /**
     * Mapping between product and store
     *
     * @var array
     */
    private $products_data = [
        'fx_android' =>
            [
                'channels' => ['beta', 'release'],
                'name'     => 'Firefox for Android',
                'store'    => 'google',
            ],
        'fx_ios' =>
            [
                'channels' => ['release'],
                'name'     => 'Firefox for iOS',
                'store'    => 'apple',
            ],
    ];

    /**
     * Legacy product codes
     * apple = fx_ios
     * google = fx_android
     *
     * @var array
     */
    private $legacy_products = [
        'google' => 'fx_android',
        'apple'  => 'fx_ios',
    ];

    /**
     * Locales supported in products and channels.
     *
     * Sources for Android:
     * http://hg.mozilla.org/releases/mozilla-release/raw-file/tip/mobile/android/locales/maemo-locales
     * http://hg.mozilla.org/releases/mozilla-beta/raw-file/tip/mobile/android/locales/maemo-locales
     * http://hg.mozilla.org/releases/mozilla-aurora/raw-file/tip/mobile/android/locales/maemo-locales
     *
     * Source for Firefox for iOS:
     * https://raw.githubusercontent.com/mozilla/firefox-ios/v6.x/shipping_locales.txt
     *
     * The list for iOS needs to be cleaned up later in the costructor.
     *
     * @var array
     */
    private $supported_locales = [
        'fx_android' => [
            'aurora' => [
                'an', 'as', 'ast', 'az', 'bn-IN', 'br', 'ca', 'cak', 'cs', 'cy',
                'da', 'de', 'dsb', 'en-GB', 'en-ZA', 'eo', 'es-AR', 'es-CL',
                'es-ES', 'es-MX', 'et', 'eu', 'ff', 'fi', 'fr', 'fy-NL',
                'ga-IE', 'gd', 'gl', 'gn', 'gu-IN', 'hi-IN', 'hr', 'hsb', 'hu',
                'hy-AM', 'id', 'is', 'it', 'ja', 'ka', 'kk', 'kn', 'ko', 'lt',
                'lv', 'mai', 'ml', 'mr', 'ms', 'my', 'nb-NO', 'nl', 'nn-NO',
                'or', 'pa-IN', 'pl', 'pt-BR', 'pt-PT', 'rm', 'ro', 'ru', 'sk',
                'sl', 'son', 'sq', 'sr', 'sv-SE', 'ta', 'te', 'th', 'tr', 'uk',
                'uz', 'xh', 'zh-CN', 'zh-TW',
            ],
            'beta' => [
                'an', 'as', 'az', 'bn-IN', 'br', 'ca', 'cak', 'cs', 'cy', 'da',
                'de', 'dsb', 'en-GB', 'en-ZA', 'eo', 'es-AR', 'es-CL', 'es-ES',
                'es-MX', 'et', 'eu', 'ff', 'fi', 'fr', 'fy-NL', 'ga-IE', 'gd',
                'gl', 'gn', 'gu-IN', 'hi-IN', 'hr', 'hsb', 'hu', 'hy-AM', 'id',
                'is', 'it', 'ja', 'kk', 'kn', 'ko', 'lt', 'lv', 'mai', 'ml',
                'mr', 'ms', 'my', 'nb-NO', 'nl', 'nn-NO', 'or', 'pa-IN', 'pl',
                'pt-BR', 'pt-PT', 'rm', 'ro', 'ru', 'sk', 'sl', 'son', 'sq',
                'sr', 'sv-SE', 'ta', 'te', 'th', 'tr', 'uk', 'uz', 'xh',
                'zh-CN', 'zh-TW',
            ],
            'release' => [
                'an', 'as', 'az', 'bn-IN', 'br', 'ca', 'cak', 'cs', 'cy', 'da',
                'de', 'dsb', 'en-GB', 'en-ZA', 'eo', 'es-AR', 'es-CL', 'es-ES',
                'es-MX', 'et', 'eu', 'ff', 'fi', 'fr', 'fy-NL', 'ga-IE', 'gd',
                'gl', 'gn', 'gu-IN', 'hi-IN', 'hr', 'hsb', 'hu', 'hy-AM', 'id',
                'is', 'it', 'ja', 'kk', 'kn', 'ko', 'lt', 'lv', 'mai', 'ml',
                'mr', 'ms', 'my', 'nb-NO', 'nl', 'nn-NO', 'or', 'pa-IN', 'pl',
                'pt-BR', 'pt-PT', 'rm', 'ro', 'ru', 'sk', 'sl', 'son', 'sq',
                'sr', 'sv-SE', 'ta', 'te', 'th', 'tr', 'uk', 'uz', 'xh',
                'zh-CN', 'zh-TW',
            ],
        ],
        'fx_ios' => [
            'release' => [
                'ast', 'az', 'bg', 'bn-BD', 'br', 'ca', 'cs', 'cy', 'da', 'de',
                'dsb', 'en-GB', 'en-US', 'eo', 'es-ES', 'es-CL', 'es-MX', 'eu',
                'fr', 'fy-NL', 'ga-IE', 'gd', 'he', 'hsb', 'hu', 'id', 'is',
                'it', 'ja', 'kab', 'kk', 'km', 'ko', 'lo', 'lt', 'lv', 'nb-NO',
                'ne-NP', 'nl', 'nn-NO', 'pl', 'pt-BR', 'pt-PT', 'rm', 'ro',
                'ru', 'son', 'sk', 'sl', 'sv-SE', 'te', 'th', 'tl', 'tr', 'uk',
                'uz', 'zh-CN', 'zh-TW',
            ],
        ],
    ];

    /**
     * Locales mapping between Mozilla and Stores codes. Format:
     * Store Code -> Mozilla Code
     *
     * Sources:
     * Google: list provided by marketing in https://bugzilla.mozilla.org/show_bug.cgi?id=1090731#c18
     * Apple: https://github.com/KrauseFx/deliver#available-language-codes
     *
     * See also http://www.ibabbleon.com/iOS-Language-Codes-ISO-639.html
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
        ],
        'google' => [
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
        ],
    ];

    /**
     * List of products and associated release channels/templates
     *
     * @var array
     */
    public $templates = [
        'fx_android' => [
            // channel => path to template file
            'release' => [
                'template' => 'fx_android/release/listing_apr_2016.php',
                'langfile' => 'android_release.lang',
                'whatsnew' => 'whatsnew/whatsnew_android_50.lang',
                ],
            'beta' => [
                'template' => 'fx_android/beta/listing_may_2015.php',
                'langfile' => 'description_beta_page.lang',
                'whatsnew' => 'whatsnew/whatsnew_android_51_beta.lang',
                ],
        ],
        'fx_ios' => [
            // channel => path to template file
            'release' => [
                'template' => 'fx_ios/release/listing_sept_2015.php',
                'langfile' => 'apple_description_release.lang',
                'whatsnew' => 'whatsnew/whatsnew_ios_6_0.lang',
            ],
        ],
    ];

    public function __construct()
    {
        /*
            Clean up list of locales supported in Firefox for iOS,
            set beta and aurora channel with the same list as release.
        */
        $fx_ios_locales = self::CleanUpiOS($this->supported_locales['fx_ios']['release']);
        $this->supported_locales['fx_ios'] = [
            'aurora'  => $fx_ios_locales,
            'beta'    => $fx_ios_locales,
            'release' => $fx_ios_locales,
        ];
    }

    /**
     * Clean up the list of shipping locales for iOS
     *
     * @param String $shipping_locales The list of shipping locales
     *
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
     * @param String $locale Locale code to check
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
     * @param String $product Product ID
     *
     * @return string Store's code
     */
    public function getProductStore($product)
    {
        $store = '';
        $product = $this->getUpdatedProductCode($product);
        if (isset($this->products_data[$product])) {
            $store = $this->products_data[$product]['store'];
        } elseif ($this->isLegacyProduct($product)) {
            $store = $product;
        }

        return $store;
    }

    /**
     * Get the name associated to product ID
     *
     * @param String $product Product ID
     *
     * @return string Product's name
     */
    public function getProductName($product)
    {
        $product = $this->getUpdatedProductCode($product);
        $product_name = $product;
        if (isset($this->products_data[$product])) {
            $product_name = $this->products_data[$product]['name'];
        }

        return $product_name;
    }

    /**
     * Get the channels supported for product ID
     *
     * @param String $product Product ID
     *
     * @return array List of supported channels
     */
    public function getProductChannels($product)
    {
        $product = $this->getUpdatedProductCode($product);
        $channels = isset($this->products_data[$product])
            ? $this->products_data[$product]['channels']
            : [];

        return $channels;
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
     * Convert legacy product ID if necessary
     *
     * @param String $product Product ID
     *
     * @return string Product ID, updated if legacy
     */
    public function getUpdatedProductCode($product)
    {
        if ($this->isLegacyProduct($product)) {
            $product = $this->legacy_products[$product];
        }

        return $product;
    }

    /**
     * Check if the product ID is a legacy code
     *
     * @param String $product Product ID
     *
     * @return boolean true if $product is a legacy ID, false otherwise
     */
    public function isLegacyProduct($product)
    {
        return isset($this->legacy_products[$product]);
    }

    /**
     * Get Common Locales supported by the product's store and Mozilla
     *
     * @param string $product Product ID
     * @param string $channel Channel ID
     *
     * @return Mixed Array of locales or false if the call is incorrect
     */
    public function getStoreMozillaCommonLocales($product, $channel)
    {
        // Map product to its store. Support legacy product codes.
        $store = $this->getProductStore($product);
        $product = $this->getUpdatedProductCode($product);

        // Return early if store is unsupported
        if (! isset($this->locales_mapping[$store])) {
            return false;
        }

        $locales = [];
        if ($store == 'google' && in_array($channel, ['beta', 'release'])) {
            if (isset($this->supported_locales[$product][$channel])) {
                $locales = $this->supported_locales[$product][$channel];
            }

            // HACK: adding ar as experiment (bug 1259200)
            if ($channel == 'release') {
                $locales[] = 'ar';
                sort($locales);
            }
        }

        if ($store == 'apple' && in_array($channel, ['release'])) {
            if (isset($this->supported_locales[$product][$channel])) {
                $locales = $this->supported_locales[$product][$channel];
            }
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
     * @return Mixed Array of locales or false if the call is incorrect
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
        $product = $this->getUpdatedProductCode($product);

        // Return requested channel, or fall back to release
        if (isset($this->supported_locales[$product])) {
            return isset($this->supported_locales[$product][$channel])
                ? $this->supported_locales[$product][$channel]
                : $this->supported_locales[$product]['release'];
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
     * @param string $product Product ID
     * @param string $channel Channel ID
     *
     * @return mixed String containing the template path or false
     */
    public function getTemplate($product, $channel)
    {
        $product = $this->getUpdatedProductCode($product);
        if (! isset($this->templates[$product][$channel]['template'])) {
            return false;
        }

        return $this->templates[$product][$channel]['template'];
    }

    /**
     * Get the lang file name(s) for a product and channel.
     * Can be filtered by Section.
     *
     * @param string $product Product ID
     * @param string $channel Channel ID
     * @param string $section Name of the section defined in $this->template
     *                        containing the lang file(s).
     *
     * @return mixed String containing the langfile name(s) or false
     */
    protected function getLangFile($product, $channel, $section)
    {
        $product = $this->getUpdatedProductCode($product);
        if (! isset($this->templates[$product][$channel][$section])) {
            return false;
        }

        return $this->templates[$product][$channel][$section];
    }

    /**
     * Get the lang file name(s) for whatsnew section if it exists. Returns
     * false otherwise.
     *
     * @param string $product Product ID
     * @param string $channel Channel ID
     *
     * @return mixed String containing the langfile name(s) or false
     */
    public function getWhatsnewFiles($product, $channel)
    {
        return $this->getLangFile($this->getUpdatedProductCode($product), $channel, 'whatsnew');
    }

    /**
     * Get the lang file name(s) for listing section if it exists. Returns
     * false otherwise.
     *
     * @param string $product Product ID
     * @param string $channel Channel ID
     *
     * @return mixed String containing the langfile name(s) or false
     */
    public function getListingFiles($product, $channel)
    {
        return $this->getLangFile($this->getUpdatedProductCode($product), $channel, 'langfile');
    }
}
