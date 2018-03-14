<?php
define('INSTALL_ROOT', realpath(__DIR__ . '/../../') . '/');

// We always work with UTF8 encoding
mb_internal_encoding('UTF-8');

// Make sure we have a timezone set
date_default_timezone_set('Europe/Paris');

require __DIR__ . '/../../vendor/autoload.php';

require INSTALL_ROOT . '/app/inc/init.php';
$android_latest_version = $project->getLatestVersion('fx_android');

// Launch PHP dev server in the background
chdir(INSTALL_ROOT);
exec('./start.sh -tests-server > /dev/null 2>&1 & echo $!', $output);

// We will need the pid to kill it, beware, this is the pid of the bash process started with start.sh
$pid = $output[0];

// Pause to let time for the dev server to launch in the background, also, Travis is slower
if (! getenv('TRAVIS')) {
    sleep(1);
} else {
    sleep(4);
}

$paths = [
    ['', 400, '{"error":"No service requested"}'],
    ['v1/google/storelocales/', 200, '["af","am","ar","be","bg","bn-BD","ca","cs-CZ","da-DK","de-DE","el-GR","en-GB","en-US","es-419","es-ES","es-US","et","eu-ES","fa","fi-FI","fil","fr-CA","fr-FR","gl-ES","hi-IN","hr","hu-HU","hy-AM","id","is-IS","it-IT","iw-IL","ja-JP","ka-GE","km-KH","kn-IN","ko-KR","lo-LA","lt","lv","mk-MK","ml-IN","mn-MN","mr-IN","ms","my-MM","ne-NP","nl-NL","no-NO","pl-PL","pt-BR","pt-PT","rm","ro","ru-RU","si-LK","sk","sl","sr","sv-SE","sw","ta-IN","te-IN","th","tr-TR","uk","vi","zh-CN","zh-TW","zu"]'],
    ['v1/apple/storelocales/', 200, '["da","de-DE","el","en-AU","en-CA","en-GB","en-US","es-ES","es-MX","fi","fr-CA","fr-FR","id","it","ja","ko","ms","nl-NL","no","pt-BR","pt-PT","ru","sv","th","tr","vi","zh-Hans","zh-Hant"]'],
    ['v1/google/localesmapping/', 200, '{"af":"af","am":false,"ar":"ar","be":"be","bg":"bg","bn-BD":"bn-BD","ca":"ca","cs-CZ":"cs","da-DK":"da","de-DE":"de","el-GR":"el","en-GB":"en-GB","en-US":"en-US","es-419":"es-MX","es-ES":"es-ES","es-US":"es-MX","et":"et","eu-ES":"eu","fa":"fa","fi-FI":"fi","fil":false,"fr-CA":"fr","fr-FR":"fr","gl-ES":"gl","hi-IN":"hi-IN","hr":"hr","hu-HU":"hu","hy-AM":"hy-AM","id":"id","is-IS":"is","it-IT":"it","iw-IL":"he","ja-JP":"ja","ka-GE":"ka","km-KH":"km","kn-IN":"kn","ko-KR":"ko","lo-LA":"lo","lt":"lt","lv":"lv","mk-MK":"mk","ml-IN":"ml","mn-MN":"mn","mr-IN":"mr","ms":"ms","my-MM":"my","ne-NP":"ne-NP","nl-NL":"nl","no-NO":"nb-NO","pl-PL":"pl","pt-BR":"pt-BR","pt-PT":"pt-PT","rm":"rm","ro":"ro","ru-RU":"ru","si-LK":"si","sk":"sk","sl":"sl","sr":"sr","sv-SE":"sv-SE","sw":"sw","ta-IN":"ta","te-IN":"te","th":"th","tr-TR":"tr","uk":"uk","vi":"vi","zh-CN":"zh-CN","zh-TW":"zh-TW","zu":"zu"}'],
    ['v1/apple/localesmapping/', 200, '{"da":"da","de-DE":"de","el":"el","en-AU":"en-GB","en-CA":"en-US","en-GB":"en-GB","en-US":"en-US","es-ES":"es-ES","es-MX":"es-MX","fi":"fi","fr-CA":"fr","fr-FR":"fr","id":"id","it":"it","ja":"ja","ko":"ko","ms":"ms","nl-NL":"nl","no":"nb-NO","pt-BR":"pt-BR","pt-PT":"pt-PT","ru":"ru","sv":"sv-SE","th":"th","tr":"tr","vi":"vi","zh-Hans":"zh-CN","zh-Hant":"zh-TW"}'],
    ['v1/fx_android/supportedlocales/release/', 200, false],
    ['v1/fx_android/done/release/', 200, false],
    ['v1/fx_android/done/release/', 200, false],
    ['v1/fx_android/done/beta/', 200, false],
    ['v1/fx_android/done/nightly/', 200, false],
    ['v1/fx_ios/done/release/', 200, false],
    ['v1/focus_android/done/release/', 200, false],
    ['v1/klar_android/done/release/', 200, false],
    ['v1/focus_ios/done/release/', 200, false],
    ['v1/fx_android/translation/release/ja/', 200, false],
    ['v1/fx_android/translation/10/ja/', 400, false],
    ["v1/fx_android/translation/{$android_latest_version}/fr/", 200, false],
    ['v1/fx_android/translation/release/en-US/', 200, false],
    ['v1/fx_android/translation/beta/fr/', 200, false],
    ['v1/fx_android/translation/beta/en-US/', 200, false],
    ['v1/fx_android/translation/nightly/fr/', 200, false],
    ['v1/fx_android/translation/nightly/en-US/', 200, false],
    ['v1/fx_android/whatsnew/release/', 200, false],
    ['v1/fx_android/whatsnew/beta/', 200, false],
    ['v1/fx_ios/whatsnew/release/', 200, false],
    ['v1/focus_ios/whatsnew/release/', 200, false],
    ['v1/fx_android/listing/release/', 200, false],
    // Legacy call without API version
    ['google/storelocales/', 200, '["af","am","ar","be","bg","bn-BD","ca","cs-CZ","da-DK","de-DE","el-GR","en-GB","en-US","es-419","es-ES","es-US","et","eu-ES","fa","fi-FI","fil","fr-CA","fr-FR","gl-ES","hi-IN","hr","hu-HU","hy-AM","id","is-IS","it-IT","iw-IL","ja-JP","ka-GE","km-KH","kn-IN","ko-KR","lo-LA","lt","lv","mk-MK","ml-IN","mn-MN","mr-IN","ms","my-MM","ne-NP","nl-NL","no-NO","pl-PL","pt-BR","pt-PT","rm","ro","ru-RU","si-LK","sk","sl","sr","sv-SE","sw","ta-IN","te-IN","th","tr-TR","uk","vi","zh-CN","zh-TW","zu"]'],
    ['apple/storelocales/', 200, '["da","de-DE","el","en-AU","en-CA","en-GB","en-US","es-ES","es-MX","fi","fr-CA","fr-FR","id","it","ja","ko","ms","nl-NL","no","pt-BR","pt-PT","ru","sv","th","tr","vi","zh-Hans","zh-Hant"]'],
    ['google/localesmapping/', 200, '{"af":"af","am":false,"ar":"ar","be":"be","bg":"bg","bn-BD":"bn-BD","ca":"ca","cs-CZ":"cs","da-DK":"da","de-DE":"de","el-GR":"el","en-GB":"en-GB","en-US":"en-US","es-419":"es-MX","es-ES":"es-ES","es-US":"es-MX","et":"et","eu-ES":"eu","fa":"fa","fi-FI":"fi","fil":false,"fr-CA":"fr","fr-FR":"fr","gl-ES":"gl","hi-IN":"hi-IN","hr":"hr","hu-HU":"hu","hy-AM":"hy-AM","id":"id","is-IS":"is","it-IT":"it","iw-IL":"he","ja-JP":"ja","ka-GE":"ka","km-KH":"km","kn-IN":"kn","ko-KR":"ko","lo-LA":"lo","lt":"lt","lv":"lv","mk-MK":"mk","ml-IN":"ml","mn-MN":"mn","mr-IN":"mr","ms":"ms","my-MM":"my","ne-NP":"ne-NP","nl-NL":"nl","no-NO":"nb-NO","pl-PL":"pl","pt-BR":"pt-BR","pt-PT":"pt-PT","rm":"rm","ro":"ro","ru-RU":"ru","si-LK":"si","sk":"sk","sl":"sl","sr":"sr","sv-SE":"sv-SE","sw":"sw","ta-IN":"ta","te-IN":"te","th":"th","tr-TR":"tr","uk":"uk","vi":"vi","zh-CN":"zh-CN","zh-TW":"zh-TW","zu":"zu"}'],
    ['apple/localesmapping/', 200, '{"da":"da","de-DE":"de","el":"el","en-AU":"en-GB","en-CA":"en-US","en-GB":"en-GB","en-US":"en-US","es-ES":"es-ES","es-MX":"es-MX","fi":"fi","fr-CA":"fr","fr-FR":"fr","id":"id","it":"it","ja":"ja","ko":"ko","ms":"ms","nl-NL":"nl","no":"nb-NO","pt-BR":"pt-BR","pt-PT":"pt-PT","ru":"ru","sv":"sv-SE","th":"th","tr":"tr","vi":"vi","zh-Hans":"zh-CN","zh-Hant":"zh-TW"}'],
    ['fx_android/done/release/', 200, false],
    ['fx_android/done/release/', 200, false],
    ['fx_android/done/beta/', 200, false],
    ['fx_ios/done/release/', 200, false],
    ['fx_android/translation/release/ja/', 200, false],
    ['fx_android/translation/release/en-US/', 200, false],
    ['fx_android/translation/beta/fr/', 200, false],
    ['fx_android/translation/beta/en-US/', 200, false],
    ['fx_android/whatsnew/release/', 200, false],
    ['fx_android/whatsnew/beta/', 200, false],
    ['fx_ios/whatsnew/release/', 200, false],
    ['fx_android/listing/release/', 200, false],
];

$obj = new \pchevrel\Verif('Check API responses');
$obj
    ->setHost('localhost:8083')
    ->setPathPrefix('api/');

$check = function ($object, $paths) {
    foreach ($paths as $values) {
        list($path, $http_code, $content) = $values;

        $object
            ->setPath($path)
            ->fetchContent()
            ->hasResponseCode($http_code)
            ->isJson();

        if ($content !== false) {
            $object->isEqualTo($content);
        }
    }
};

$check($obj, $paths);

$obj
    ->setPath('fx_android/translation/release/ja/')
    ->fetchContent()
    ->hasKeys(['title', 'short_desc', 'long_desc']);

$obj
    ->setPath('fx_ios/translation/release/fr/')
    ->fetchContent()
    ->hasKeys(['title', 'description', 'keywords', 'whatsnew']);

$obj
    ->setPath('fx_android/translation/release/fr/')
    ->fetchContent()
    ->hasKeys(['title',  'short_desc', 'long_desc', 'whatsnew']);

$obj
    ->setPath('fx_android/translation/beta/fr/')
    ->fetchContent()
    ->hasKeys(['title',  'short_desc', 'long_desc', 'whatsnew']);

$obj
    ->setPath("fx_android/translation/{$android_latest_version}/fr/")
    ->fetchContent()
    ->hasKeys(['whatsnew']);

$obj->report();

// Kill PHP dev server by killing all children processes of the bash process we opened in the background
exec('pkill -P ' . $pid);
die($obj->returnStatus());
