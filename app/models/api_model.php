<?php
namespace Stores;

use Transvision\Json;

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
        $done = $json = [];
        $listing = Json::fetch('http://localhost:8042/api/google/listing/release/');

        foreach ($project->getFirefoxLocales('google',
        $request->query['channel']) as $lang) {
            /*
                Check if description is done by calling listing API.
                Skip locale if not done.
            */
            if (! in_array($lang, array_values($listing))) {
                continue;
            }

            $translations = new Translate(
                $lang,
                $project->getWhatsnewFiles(
                    'google',
                    $request->query['channel'],
                    'whatsnew'
                )
            );
            $translations::$log_errors = false;

            if ($translations->isFileTranslated()) {
                // Include the current template
                require TEMPLATES . $project->getTemplate(
                    'google',
                    $request->query['channel']
                );

                if ($set_limit(500, $whatsnew($translations))) {
                    $done[] = $lang;
                }
            }
        }

        $supported = array_unique(array_values($project->getLocalesMapping('google')));
        $json = empty($json) ? array_values(array_intersect($done, $supported)) : $json;
        break;
    case 'listing':
        $done = [];

        foreach ($project->getFirefoxLocales($request->query['store'],
        $request->query['channel']) as $lang) {
            $translations = new Translate(
                $lang,
                $project->getListingFiles(
                    $request->query['store'],
                    $request->query['channel']
                )
            );
            $translations::$log_errors = false;

            if ($translations->isFileTranslated()) {
                // The Google Store has string lengths constraints
                if ($request->query['store'] == 'google') {
                    // Include the current template
                    require TEMPLATES . $project->getTemplate(
                        'google',
                        $request->query['channel']
                    );

                    $desc       = $set_limit(4000, $description($translations));
                    $title      = $set_limit(30, $app_title($translations));
                    $short_desc = $set_limit(80, $short_desc($translations));

                    if (($desc + $title + $short_desc) == 3) {
                        $done[] = $lang;
                    }
                } elseif ($request->query['store'] == 'apple') {
                    // Include the current template
                    require TEMPLATES . $project->getTemplate(
                        'apple',
                        $request->query['channel']
                    );

                    $keywords = $set_limit(100, $keywords($translations));

                    if ($keywords) {
                        $done[] = $lang;
                    }
                } else {
                    $done[] = $lang;
                }
            }
        }

        $supported = array_unique(array_values(
            $project->getLocalesMapping($request->query['store']))
        );
        $json = empty($json) ? array_values(array_intersect($done, $supported)) : $json;
        break;
    default:
        $request->error = 'Not a valid API call.';
        $json = $request->invalidAPICall();
        break;
}

$json = $response->output($json);
