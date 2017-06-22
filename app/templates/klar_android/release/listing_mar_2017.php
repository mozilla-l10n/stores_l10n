<?php
namespace Stores;

// Include closure needed in template
include INC . 'utilities.php';

// Use new title only if it's translated
if ($translations->isStringTranslated('Firefox Klar: The privacy browser')) {
    $app_title = function ($translations) use ($_) {
        return $_('Firefox Klar: The privacy browser');
    };
} else {
    $app_title = function ($translations) use ($_) {
        return $_('Firefox Klar: Private Browser');
    };
}

$description = function ($translations) use ($_) {
    return <<<OUT
{$_('Browse like no one’s watching.')} {$_('The new Firefox Klar automatically blocks a wide range of online trackers — from the moment you launch it to the second you leave it.')} {$_('Easily erase your history, passwords and cookies, so you won’t get followed by things like unwanted ads.')}

{$_('“Private browsing” on most browsers isn’t comprehensive or easy to use.')} {$_('Klar is next-level privacy that’s free, always on and always on your side — because it’s backed by Mozilla, the non-profit that fights for your rights on the Web.')}

{$_('AUTOMATIC PRIVACY')}
• {$_('Blocks a wide range of common Web trackers without any settings to set')}
• {$_('Easily erases your history — no passwords, no cookies, no trackers')}

{$_('BROWSE FASTER')}
• {$_('By removing trackers and ads, Web pages may require less data and load faster')}

{$_('MADE BY MOZILLA')}
• {$_('We believe everyone should have control over their lives online. That’s what we’ve been fighting for since 1998.')}
OUT;
};

$short_desc = function ($translations) use ($_) {
    return $_('Get The Privacy Browser. Fast & always private from Firefox, a browser you trust');
};

$screenshots = function ($translations) use ($_) {
    return <<<OUT
{$_('Small download<br>Only 3MB')}
OUT;
};
