<?php
namespace Stores;

// Include closure needed in template
include INC . 'utilities.php';

$app_title1 = function ($translate) use ($_) {
    return $_('Firefox Web Browser');
};

$app_title2 = function ($translate) use ($_) {
    return $_('Firefox for Android');
};

$screenshots = function ($translate) use ($_) {
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
