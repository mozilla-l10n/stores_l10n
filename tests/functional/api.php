<?php
define('INSTALL_ROOT',  realpath(__DIR__ . '/../../') . '/');

// We always work with UTF8 encoding
mb_internal_encoding('UTF-8');

// Make sure we have a timezone set
date_default_timezone_set('Europe/Paris');

require __DIR__ . '/../../vendor/autoload.php';

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
    ['google/storelocales/', 200, '["af","ar","am","bg","cs-CZ","ca","da-DK","de-DE","el-GR","en-GB","en-US","es-419","es-ES","es-US","et","fa","fi-FI","fil","fr-CA","fr-FR","hi-IN","hu-HU","hr","id","it-IT","iw-IL","ja-JP","ko-KR","lt","lv","ms","nl-NL","no-NO","pl-PL","pt-BR","pt-PT","rm","ro","ru-RU","sk","sl","sr","sv-SE","sw","th","tr-TR","uk","vi","zh-CN","zh-TW","zu"]'],
    ['apple/storelocales/', 200, '["da","de-DE","el","en-AU","en-CA","en-GB","en-US","es-ES","es-MX","fi","fr-CA","fr-FR","id","it","ja","ko","ms","nl","no","pt-BR","pt-PT","ru","sv","th","tr","vi","zh-Hans","zh-Hant"]'],
    ['google/localesmapping/', 200, '{"af":"af","ar":"ar","am":false,"bg":"bg","cs-CZ":"cs","ca":"ca","da-DK":"da","de-DE":"de","el-GR":"el","en-GB":"en-GB","en-US":"en-US","es-419":"es-MX","es-ES":"es-ES","es-US":"es-MX","et":"et","fa":"fa","fi-FI":"fi","fil":false,"fr-CA":"fr","fr-FR":"fr","hi-IN":"hi-IN","hu-HU":"hu","hr":"hr","id":"id","it-IT":"it","iw-IL":"he","ja-JP":"ja","ko-KR":"ko","lt":"lt","lv":"lv","ms":"ms","nl-NL":"nl","no-NO":"nb-NO","pl-PL":"pl","pt-BR":"pt-BR","pt-PT":"pt-PT","rm":"rm","ro":"ro","ru-RU":"ru","sk":"sk","sl":"sl","sr":"sr","sv-SE":"sv-SE","sw":"sw","th":"th","tr-TR":"tr","uk":"uk","vi":"vi","zh-CN":"zh-CN","zh-TW":"zh-TW","zu":"zu"}'],
    ['apple/localesmapping/', 200, '{"da":"da","de-DE":"de","el":"el","en-AU":"en-GB","en-CA":"en-US","en-GB":"en-GB","en-US":"en-US","es-ES":"es-ES","es-MX":"es-MX","fi":"fi","fr-CA":"fr","fr-FR":"fr","id":"id","it":"it","ja":"ja","ko":"ko","ms":"ms","nl":"nl","no":"nb-NO","pt-BR":"pt-BR","pt-PT":"pt-PT","ru":"ru","sv":"sv-SE","th":"th","tr":"tr","vi":"vi","zh-Hans":"zh-CN","zh-Hant":"zh-TW"}'],
    ['google/firefoxlocales/release/', 200, '["an","as","az","bn-IN","br","ca","cak","cs","cy","da","de","dsb","es-CL","en-GB","en-ZA","eo","es-AR","es-ES","es-MX","et","eu","fi","ff","fr","fy-NL","ga-IE","gd","gl","gn","gu-IN","hi-IN","hr","hsb","hu","hy-AM","id","is","it","ja","kk","kn","ko","lt","lv","mai","ml","mr","ms","my","nb-NO","nl","nn-NO","or","pa-IN","pl","pt-BR","pt-PT","rm","ro","ru","sk","sl","son","sq","sr","sv-SE","ta","te","th","tr","uk","uz","xh","zh-CN","zh-TW"]'],
    ['google/done/release/', 200, false],
    ['google/done/beta/', 200, false],
    ['apple/done/release/', 200, false],
    ['google/translation/release/ja/', 200, false],
    ['google/translation/beta/fr/', 200, false],
    ['google/whatsnew/release/', 200, false],
    ['google/whatsnew/beta/', 200, false],
    ['apple/whatsnew/release/', 200, false],
    ['google/listing/release/', 200, false],
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
    ->setPath('google/translation/release/ja/')
    ->fetchContent()
    ->hasKeys(['title', 'short_desc', 'long_desc']);

$obj
    ->setPath('apple/translation/release/fr/')
    ->fetchContent()
    ->hasKeys(['title', 'description', 'keywords', 'screenshots', 'whatsnew']);

$obj
    ->setPath('google/translation/release/fr/')
    ->fetchContent()
    ->hasKeys(['title',  'short_desc', 'long_desc', 'whatsnew']);

$obj
    ->setPath('google/translation/beta/fr/')
    ->fetchContent()
    ->hasKeys(['title',  'short_desc', 'long_desc', 'whatsnew']);

$obj->report();

// Kill PHP dev server by killing all children processes of the bash process we opened in the background
exec('pkill -P ' . $pid);
die($obj->returnStatus());
