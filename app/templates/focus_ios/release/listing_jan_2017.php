<?php
namespace Stores;

// Include closure needed in template
include INC . 'utilities.php';

$app_title = function ($translations) use ($_) {
    return $_('Firefox Focus: The privacy browser');
};

$description = function ($translations) use ($_) {
    return <<<OUT
{$_('Browse like no one’s watching.')} {$_('The new Firefox Focus automatically blocks a wide range of online trackers — from the moment you launch it to the second you leave it.')} {$_('Easily erase your history, passwords and cookies, so you won’t get followed by things like unwanted ads.')}

{$_('“Private browsing” on most browsers isn’t comprehensive or easy to use.')} {$_('Focus is next-level privacy that’s free, always on and always on your side — because it’s backed by Mozilla, the non-profit that fights for your rights on the Web.')}

{$_('AUTOMATIC PRIVACY')}
• {$_('Blocks a wide range of common Web trackers without any settings to set')}
• {$_('Easily erases your history — no passwords, no cookies, no trackers')}

{$_('BROWSE FASTER')}
• {$_('By removing trackers and ads, Web pages may require less data and load faster')}

{$_('MADE BY MOZILLA')}
• {$_('We believe everyone should have control over their lives online. That’s what we’ve been fighting for since 1998.')}
OUT;
};

$screenshots = function ($translations) use ($_) {
    return <<<OUT
{$_('Automatically block ads<br>& other Web trackers')}

{$_('Browse Faster<br>Web pages may load faster<br>by removing trackers')}

{$_('Before')}

{$_('After')}

{$_('Tracker')}

{$_('From Mozilla<br>A brand you trust')}
OUT;
};

$keywords = function ($translations) use ($_) {
    return $_('internet,safari,chrome,opera,explorer,search,adblock,flash,browser,browsing,incognito,private,browse');
};

$whatsnew = function ($translations) use ($_) {
    return <<<OUT
• {$_('Change your default search engine')}
• {$_('Added a new button to easily share a webpage or open the existing webpage in Firefox or Safari')}
• {$_('New languages added')}
OUT;
};
