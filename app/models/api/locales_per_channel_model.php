<?php

namespace Play;

$channel = isset($_GET['channel']) ? $_GET['channel'] : 'org.mozilla.firefox';

switch ($channel) {
    // Aurora
    case 'org.mozilla.fennec_aurora':
        return $android_locales_aurora;
        break;

    // Beta
    case 'org.mozilla.firefox_beta':
        return $android_locales_beta;
        break;

    // Release
    case 'org.mozilla.firefox':
    default:
        return $android_locales_release;
        break;
}
