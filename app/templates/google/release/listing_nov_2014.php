<?php
namespace Stores;

// Include closure needed in template
include INC . 'utilities.php';

$top_10 = function ($translate) use ($_) {
    return <<<OUT
{$_('Sync')} &mdash;
{$_('Bring your passwords, bookmarks, open tabs and more everywhere you go.')}

<br/><br/>
{$_('Add-ons')} &mdash;
{$_('Customize your Home panels with the Web content you want.')}

<br/><br/>
{$_('Quick Share')} &mdash;
{$_('The most adaptive way to share anything.')}

<br/><br/>
{$_('Private Browsing')} &mdash;
{$_('Browse the Web without any of your history being remembered.')}

<br/><br/>
{$_('Guest Browsing')} &mdash;
{$_('Share your browser with friends and keep your data private.')}

<br/><br/>
{$_('Reader Mode')} &mdash;
{$_('Clear website clutter to make articles easier to read.')}

<br/><br/>
{$_('Home Panels')} &mdash;
{$_('Display your Home panels in any order you like.')}

<br/><br/>
{$_('Custom Search')} &mdash;
{$_('Add any search engine and make it your default.')}

<br/><br/>
{$_('Language Display')} &mdash;
{$_('Change your browser language quickly and easily.')}

<br/><br/>
{$_('Send to Device')} &mdash;
{$_('Stream video content from your device to your TV.')}

OUT;
};

$description = function ($translate) use ($_) {
    $replacements = [
        '{{support_link}}'     => 'https://support.mozilla.org/mobile',
        '{{features_link}}'    => 'http://mzl.la/FXFeatures',
        '{{permission_link}}'  => 'http://mzl.la/Permissions',
        '{{blog_link}}'        => 'https://blog.mozilla.org',
        '{{facebook_link}}'    => 'http://mzl.la/FXFacebook',
        '{{twitter_link}}'     => 'http://mzl.la/FXTwitter',
        '{{amo_link}}'         => 'https://addons.mozilla.org/android/',
        '{{mozilla_org_link}}' => 'https://www.mozilla.org',
    ];

    return <<<OUT
{$_('We make it Firefox. You make it your own.')}
{$_('Meet our most customizable Android browser yet.')}
{$_('Fast, smart and safe, the official Firefox for Android browser from Mozilla offers more ways than ever to make your mobile browsing experience uniquely yours.')}


{$_('FAST.')}
{$_('Access, browse and search the Web at blazing speeds.')}

{$_('SMART.')}
{$_('Share and search just how you like, and keep your favorite Web content a tap away with our most customizable and intuitive features yet.')}

{$_('SAFE.')}
{$_('Make sure your browsing stays safe and private with extensive security settings, add-ons and features like Do Not Track.')}

<b>{$_('Key Features:')}</b>

<b>• {$_('Customizable Home Panels:')}</b>
{$_('Customize and display your Home panels however you like. Add new Web content any time and access your favorite feeds — like Instagram and Pocket Hits — instantly.')}

<b>• {$_('Sync:')}</b>
{$_('Sync your Firefox desktop tabs, history, bookmarks and passwords to all your devices and streamline your browsing.')}

<b>• {$_('Add-ons:')}</b>
{$_('Customize your Web browser just the way you like it with add-ons including Ad-Blocker, Password Manager and more.')}

<b>• {$_('Speed:')}</b>
{$_('Get to the Internet faster, with quick startup and page load times.')}

<b>• {$_('Accessibility:')}</b>
{$_('Over 59 supported languages can be easily selected through the browser settings.')}

<b>• {$_('HTML5:')}</b>
{$_('Experience the unlimited possibilities of the Internet on mobile with support for HTML5 and Web APIs.')}

<b>• {$_('Mobile Video:')}</b>
{$_('Firefox for Android has mobile video support for a wide range of video formats, including H.264.')}

<b>• {$_('Security:')}</b>
{$_('Keep your browsing safe and private. Control your privacy, security and how much data you share on the Web.')}


{$_('For a complete list of features, check out {{features_link}}', $replacements)}

<b>{$_('Learn more about Firefox for Android:')}</b>

• {$_('Have questions or need help? Visit {{support_link}}', $replacements)}

• {$_('Read about Firefox permissions: {{permission_link}}', $replacements)}

• {$_('Learn more about what’s up at Mozilla: {{blog_link}}', $replacements)}

• {$_('Like Firefox on Facebook: {{facebook_link}}', $replacements)}

• {$_('Follow Firefox on Twitter: {{twitter_link}}', $replacements)}


{$_('Curious about add-ons? Check them out on {{amo_link}} :', $replacements)}

<b>• {$_('Browsing:')}</b>&nbsp;
{$_('Adblock Plus, AutoPager, Full Screen mobile and more')}


<b>• {$_('Security:')}</b>&nbsp;
{$_('LastPass Password Manager, NoScript, Dr. Web LinkChecker and more')}


<b>• {$_('Reading:')}</b>&nbsp;
{$_('AutoPager, X-Notifier lite and more')}

<b>• {$_('Watching:')}</b>&nbsp;
{$_('Low Quality Flash, ProxTube and more')}

<b>• {$_('Social Networks:')}</b>&nbsp;
{$_('Shareaholic, Foursquare and more')}


<b>{$_('ABOUT MOZILLA')}</b>

{$_("Mozilla is a proudly non-profit organization dedicated to keeping the power of the Web in people's hands.")}
{$_("We're a global community of users, contributors and developers working to innovate on your behalf.")}
{$_('When you use Firefox, you become a part of that community, helping us build a brighter future for the Web.')}
{$_('Learn more at {{mozilla_org_link}}.', $replacements)}
OUT;
};

$short_desc = function ($translate) use ($_) {
    return $_('We make it Firefox. You make it your own.');
};

$app_title = function ($translate) use ($_) {
    return $_('Firefox for Android');
};
