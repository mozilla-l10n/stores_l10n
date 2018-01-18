<?php
namespace Stores;

// Include closure needed in template
include INC . 'utilities.php';

$app_title = function ($translations) use ($_) {
    return $_('Firefox Browser fast & private');
};

$description = function ($translations) use ($_) {
    $replacements = [
        '{{support_link}}'     => 'https://support.mozilla.org/mobile',
        '{{permission_link}}'  => 'http://mzl.la/Permissions',
        '{{blog_link}}'        => 'https://blog.mozilla.org',
        '{{facebook_link}}'    => 'http://mzl.la/FXFacebook',
        '{{twitter_link}}'     => 'http://mzl.la/FXTwitter',
        '{{mozilla_org_link}}' => 'https://www.mozilla.org',
        '{{privacy_link}}'     => 'http://www.mozilla.org/legal/privacy/firefox.html',
    ];

    return <<<OUT
{$_('Experience a fast, smart and personal Web.')} {$_('Firefox is the independent, people-first browser made by Mozilla, voted the Most Trusted Internet Company for Privacy.')} {$_('Upgrade today and join hundreds of millions who depend on Firefox for a more personal browsing experience.')}

<strong>{$_('FAST. SMART. YOURS.')}</strong>
{$_('Firefox is made with you in mind and gives you the power to take back control of your Web experience.')}
{$_('That’s why we design the product with smart features that take the guesswork out of browsing.')}

<strong>{$_('SEARCH INTELLIGENTLY & GET THERE FASTER')}</strong>
- {$_('Firefox anticipates your needs and intuitively provides multiple suggested and previously searched results across your favorite search engines. Every time.')}
- {$_('Easily access shortcuts to search providers including Wikipedia, Twitter and Amazon.')}

<strong>{$_('NEXT LEVEL PRIVACY')}</strong>
- {$_('Your privacy has been upgraded.')} {$_('Private Browsing with Tracking Protection blocks parts of Web pages that may track your browsing activity.')}

<strong>{$_('SYNC FIREFOX ACROSS YOUR DEVICES')}</strong>
- {$_('With a Firefox Account, access your history, bookmarks and open tabs from your desktop on your smartphone and tablet.')}
- {$_('Firefox also safely remembers your passwords across devices so you don’t have to.')}

<strong>{$_('INTUITIVE VISUAL TABS')}</strong>
- {$_('Intuitive visual and numbered tabs easily let you find content for future reference.')}
- {$_('Open as many tabs as you like without losing track of your open Web pages.')}

<strong>{$_('EASY ACCESS TO YOUR TOP SITES')}</strong>
- {$_('Spend your time reading your favorites sites instead of looking for them.')}

<strong>{$_('ADD-ONS FOR EVERYTHING')}</strong>
- {$_('Take control of your Web experience by personalizing Firefox with add-ons like ad blockers, password and download managers and more.')}

<strong>{$_('QUICK SHARE')}</strong>
- {$_('Firefox remembers your most recently used apps to help you easily share content to Facebook, Twitter, WhatsApp, Skype and more.')}

<strong>{$_('TAKE IT TO THE BIG SCREEN')}</strong>
- {$_('Send video and Web content from your smartphone or tablet to any TV equipped with supported streaming capabilities.')}

{$_('Learn more about Firefox for Android:')}
- {$_('Have questions or need help? Visit {{support_link}}', $replacements)}
- {$_('Read about Firefox permissions: {{permission_link}}', $replacements)}
- {$_('Learn more about what’s up at Mozilla: {{blog_link}}', $replacements)}
- {$_('Like Firefox on Facebook: {{facebook_link}}', $replacements)}
- {$_('Follow Firefox on Twitter: {{twitter_link}}', $replacements)}

<strong>{$_('ABOUT MOZILLA')}</strong>
{$_('Mozilla exists to build the Internet as a public resource accessible to all because we believe open and free is better than closed and controlled.')} {$_('We build products like Firefox to promote choice and transparency and give people more control over their lives online.')} {$_('Learn more at {{mozilla_org_link}}', $replacements)}

{$_('Privacy Policy: {{privacy_link}}', $replacements)}
OUT;
};

$screenshots = function ($translations) use ($_) {
    return <<<OUT
<b>{$_('Fast. Smart. Yours')}</b>
{$_('Upgrade to Firefox and join<br>hundreds of millions of Firefox users')}

<b>{$_('Intuitive visual tab design')}</b>
{$_('Quickly find and manage<br>your open browser tabs')}

<b>{$_('Intelligent searches')}</b>
{$_('Get accurate, predictive results <br>before you finish typing')}

<b>{$_('Seamless browsing <br>with Sync')}</b>
{$_('Instantly access your bookmarks, <br>history, open tabs and passwords <br>everywhere you use Firefox')}

<b>{$_('Next level privacy')}</b>
{$_('Private Browsing with Tracking <br>Protection blocks parts of Web <br>pages that may track your browsing activity')}

<b>{$_('Add-ons for everything')}</b>
{$_('Personalize your Web browser with <br>add-ons like ad blockers, password <br>and download managers and more.')}

<b>{$_('Quick Share')}</b>
{$_('Firefox remembers your recently <br>used apps to help you get the <br>word out the way you want')}

<b>{$_('Send to device')}</b>
{$_('Send video and Web content from <br>your smartphone or tablet <br>to any supported device')}

OUT;
};

$short_desc = function ($translations) use ($_) {
    return $_('Get the customizable, private & free mobile browser that syncs across devices.');
};

$whatsnew = function ($translations) use ($_) {
    return <<<OUT
* {$_('Added the ability for users to add websites to home screen like native applications')}
* {$_('Added support for FLAC (Free Lossless Audio Codec) playback')}
* {$_('Added Bengali from Bangladesh (bn-BD) and Nepali (ne-NP) locales')}
* {$_('Removed the Firefox Search widget from home screen')}
OUT;
};
