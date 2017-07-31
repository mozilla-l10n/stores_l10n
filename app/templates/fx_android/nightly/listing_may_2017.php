<?php
namespace Stores;

// Include closure needed in template
include INC . 'utilities.php';

$replacements = [
    '{{dawn_post}}'         => 'https://hacks.mozilla.org/2017/04/simplifying-firefox-release-channels/',
    '{{download_link}}'     => 'https://play.google.com/store/apps/details?id=org.mozilla.firefox',
    '{{bug_link}}'          => 'http://mzl.la/android_bugs',
    '{{telemetry_link}}'    => 'https://www.mozilla.org/privacy/firefox/#telemetry',
    '{{permissions_link}}'  => 'http://mzl.la/Permissions',
    '{{requirements_link}}' => 'https://www.mozilla.org/firefox/mobile/platforms/',
    '{{privacy_link}}'      => 'https://www.mozilla.org/privacy/firefox/',
];

$description = function ($translations) use ($_, $replacements) {
    return <<<OUT
{$_('Firefox Nightly is a developmental channel for new Mozilla Firefox releases.')}

{$_('Please note that Firefox Aurora is no longer available and has transitioned to Firefox Nightly. More details here: {{dawn_post}}', $replacements)}

{$_('Download the release version of Firefox here: {{download_link}}', $replacements)}

{$_('Firefox Nightly is designed to showcase the more experimental builds of Firefox. The Nightly channel allows users to experience the newest Firefox innovations in an unstable environment and provide feedback on features and performance to help determine what makes the final release.')}

{$_('Found a bug? Report it at {{bug_link}}', $replacements)}

{$_('Firefox Nightly automatically sends feedback to Mozilla: {{telemetry_link}}', $replacements)}

{$_('Want to know more about the permissions Firefox requests? {{permissions_link}}', $replacements)}

{$_('See our list of supported devices and latest minimum system requirements at {{requirements_link}}', $replacements)}

{$_('Mozilla marketing: In order to understand the performance of certain Mozilla marketing campaigns, Firefox sends data, including a Google advertising ID, IP address, timestamp, country, language/locale, operating system, app version, to our third party vendor. Learn more by reading our Privacy Notice here: {{privacy_link}}', $replacements)}
OUT;
};

$short_desc = function ($translations) use ($_) {
    return $_('For Developers - Be the first to test future releases of Firefox');
};

$app_title = function ($translations) use ($_) {
    return $_('Firefox Nightly for Developers');
};
