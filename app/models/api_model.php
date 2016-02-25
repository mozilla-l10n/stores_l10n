<?php
namespace Stores;

switch ($request->getService()) {
    case 'storelocales':
        $json = $project->getStoreLocales($request->query['store']);
        break;
    case 'firefoxlocales':
        $json = $project->getFirefoxLocales(
            $request->query['store'],
            $request->query['channel']
        );
        break;
    case 'localesmapping':
        $json = $project->getLocalesMapping(
            $request->query['store'],
            $reverse = isset($_GET['reverse'])
        );
        break;
    case 'translation':
        $request = [
            'locale'  => $request->query['locale'],
            'store'   => $request->query['store'],
            'channel' => $request->query['channel'],
        ];
        include MODELS . 'locale_model.php';
        $json = [];
        if ($request['store'] == 'google') {
            $json = [
                'title'      => $app_title($translations),
                'short_desc' => $short_desc($translations),
                'long_desc'  => str_replace(["\r", "\n"], "\n", $description($translations)),
                'whatsnew'   => $whatsnew($translations),
            ];
        }
        if ($request['store'] == 'apple') {
            $json = [
                'title'       => $app_title($translations),
                'description' => strip_tags(br2nl($description($translations))),
                'keywords'    => $keywords($translations),
                'screenshots' => $screenshots_api,
            ];
        }
        break;
    case 'whatsnew':
        $done = [];

        foreach ($project->getFirefoxLocales('google', $request->query['channel']) as $lang) {
            $translations = new Translate(
                $lang,
                $project->getWhatsnewFiles('google', $request->query['channel'])
            );

            $translations::$log_errors = false;

            if ($translations->isFileTranslated()) {
                // Include the current template
                require TEMPLATES . $project->getTemplate('google', $request->query['channel']);

                if ($set_limit(500, $whatsnew($translations))) {
                    $done[] = $lang;
                }
            }
        }

        $supported = array_unique(array_values($project->getLocalesMapping('google')));
        $json = array_values(array_intersect($done, $supported));
        break;
    case 'listing':
        $done    = [];
        $store   = $request->query['store'];
        $channel = $request->query['channel'];
        foreach ($project->getFirefoxLocales($store, $channel) as $lang) {
            $translations = new Translate($lang, $project->getListingFiles($store, $channel));
            $translations::$log_errors = false;

            if ($translations->isFileTranslated()) {
                require TEMPLATES . $project->getTemplate($store, $channel);
                // The Google Store has string lengths constraints
                if ($store == 'google') {
                    $desc       = $set_limit(4000, $description($translations));
                    $title      = $set_limit(30, $app_title($translations));
                    $short_desc = $set_limit(80, $short_desc($translations));

                    if (($desc + $title + $short_desc) == 3) {
                        $done[] = $lang;
                    }
                }

                // The Apple AppStore has keywords lengths constraints
                if ($store == 'apple') {
                    if ($set_limit(100, $keywords($translations))) {
                        $done[] = $lang;
                    }
                }
            }
        }

        $supported = array_unique(array_values($project->getLocalesMapping($store)));
        $json = array_values(array_intersect($done, $supported));
        break;
    default:
        $request->error = 'Not a valid API call.';
        $json = $request->invalidAPICall();
        break;
}

$json = $response->output($json);
