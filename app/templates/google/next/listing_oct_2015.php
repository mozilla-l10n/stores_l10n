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
