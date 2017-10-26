<?php
namespace Stores;

// Include closure needed in template
include INC . 'utilities.php';

$app_title = function ($translations) use ($_) {
    return $_('Firefox Web Browser');
};

$app_subtitle = function ($translations) use ($_) {
    return $_('Fast and private browsing');
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

{$_('FAST. SMART. YOURS.')}
{$_('Firefox is made with you in mind and gives you the power to take back control of your Web experience.')}
{$_('That’s why we design the product with smart features that take the guesswork out of browsing.')}

{$_('SEARCH INTELLIGENTLY & GET THERE FASTER')}
- {$_('Firefox anticipates your needs and intuitively provides multiple suggested and previously searched results across your favorite search engines. Every time.')}
- {$_('Easily access shortcuts to search providers including Wikipedia, Twitter and Amazon.')}

{$_('BROWSE PRIVATELY')}
- {$_('Your personal information belongs to you. In Private Browsing mode, Firefox won’t remember any of your history or cookies, but new bookmarks will be saved.')}
- {$_('Delete your browsing history, passwords and more in a single tap.')}
- {$_('Choose the private data you want to remove.')}

{$_('SYNC FIREFOX ACROSS YOUR DEVICES')}
- {$_('With a Firefox Account, access your history, bookmarks and open tabs from your desktop on your smartphone and tablet.')}
- {$_('Firefox also safely remembers your passwords across devices so you don’t have to.')}

{$_('INTUITIVE VISUAL TABS')}
- {$_('Intuitive visual and numbered tabs easily let you find content for future reference.')}
- {$_('Open as many tabs as you like without losing track of your open Web pages.')}

{$_('EASY ACCESS TO YOUR TOP SITES')}
- {$_('Spend your time reading your favorites sites instead of looking for them.')}

{$_('Learn more about Firefox for iOS:')}
- {$_('Have questions or need help? Visit {{support_link}}', $replacements)}
- {$_('Read about Firefox permissions: {{permission_link}}', $replacements)}
- {$_('Learn more about what’s up at Mozilla: {{blog_link}}', $replacements)}
- {$_('Like Firefox on Facebook: {{facebook_link}}', $replacements)}
- {$_('Follow Firefox on Twitter: {{twitter_link}}', $replacements)}

<b>{$_('ABOUT MOZILLA')}</b>
{$_('Mozilla exists to build the Internet as a public resource accessible to all because we believe open and free is better than closed and controlled.')} {$_('We build products like Firefox to promote choice and transparency and give people more control over their lives online.')} {$_('Learn more at {{mozilla_org_link}}', $replacements)}

{$_('Privacy Policy: {{privacy_link}}', $replacements)}
OUT;
};

$screenshots = function ($translations) use ($_) {
    return <<<OUT
<b>{$_('Fast. Smart. Yours')}</b>
{$_('Upgrade to the power of Firefox and<br>join hundreds of millions of<br>Firefox users on desktop and mobile.')}

<b>{$_('Fast. Smart. Yours')}</b>
{$_('Upgrade to the power of Firefox and<br>join hundreds of millions of Firefox users')}

<b>{$_('Fast. Smart. Yours')}</b>
{$_('Upgrade to Firefox and join<br>hundreds of millions of Firefox users')}

{$_('Announcing<br>Firefox for iOS<br>Download now!')}

<b>{$_('Intuitive visual tab design')}</b>
{$_('Quickly find and manage<br>your open browser tabs')}

<b>{$_('Intelligent searches')}</b>
{$_('Get accurate, predictive results <br>before you finish typing')}

<b>{$_('Seamless browsing <br>with Sync')}</b>
{$_('Instantly access your bookmarks, <br>history, open tabs and passwords <br>everywhere you use Firefox')}

<b>{$_('Private Browsing')}</b>
{$_('Make specific tabs private and browse<br>the Web without your history being saved')}
OUT;
};

$keywords = function ($translations) use ($_) {
    return $_('internet,safari,chrome,opera,explorer,search,adblock,flash,browser,browsing,incognito,private,browse');
};

$other = function ($translations) use ($_) {
    return <<<OUT
    {$_('© Mozilla and its contributors {{year}}', ['{{year}}' => 2015])}

    {$_('This update contains stability improvements and bug fixes.')}
OUT;
};

$current_locale = '';
if (isset($request)) {
    $current_locale = is_array($request)
        ? $request['locale'] // HTML view
        : $request->query['locale']; // API object
} else {
    // Home view
    if (isset($store_locale)) {
        $current_locale = $store_locale;
    }
}

if (in_array($current_locale, ['de', 'en-US'])) {
    $whatsnew = function ($translations) use ($_) {
        return <<<OUT
• {$_('Firefox has a new look and feel that we call “Photon.” It’s a modern design that puts users’ needs first - with easier access to the menu, rearranged menu items and an updated minimalist look. Take a peek!')}
• {$_('“Highlights” appear when opening a new tab to allow you to easily jump back to a previously viewed site.')}
• {$_('Search suggestions are enabled by default, unless you have previously opted out.')}
• {$_('Added “No Image” mode to allow you to automatically block images from loading.')}
• {$_('Added trending stories from Pocket in your new tab.')}
OUT;
    };
} else {
    $whatsnew = function ($translations) use ($_) {
        return <<<OUT
• {$_('Firefox has a new look and feel that we call “Photon.” It’s a modern design that puts users’ needs first - with easier access to the menu, rearranged menu items and an updated minimalist look. Take a peek!')}
• {$_('“Highlights” appear when opening a new tab to allow you to easily jump back to a previously viewed site.')}
• {$_('Search suggestions are enabled by default, unless you have previously opted out.')}
• {$_('Added “No Image” mode to allow you to automatically block images from loading.')}
OUT;
    };
}
