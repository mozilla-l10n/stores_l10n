<?php
namespace Stores;

switch ($request->getService()) {
    case 'storelocales':
        $json = $project->getStoreLocales($request->query['store']);
        break;
    case 'firefoxlocales':
       $json = $project->getFirefoxLocales($request->query['store'], $request->query['channel']);
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
        $view = 'api';
        include MODELS . 'locale_model.php';
        $json = [
            'title'      => $app_title($translate),
            'short_desc' => $short_desc($translate),
            'long_desc'  => str_replace(["\r", "\n"], "\n", $description($translate)),
        ];
        break;
    case 'done':
        $done = [];

        foreach ($project->getFirefoxLocales($request->query['store'], $request->query['channel']) as $lang) {
            $obj = new Translate($lang, $project->getLangFile($request->query['store'], $request->query['channel']));
            if ($obj->isFileTranslated()) {
                $done[] = $lang;
            }
        }

        $supported = array_unique(array_values($project->getLocalesMapping($request->query['store'])));

        $json = array_values(array_intersect($done, $supported));

        break;
    default:
        http_response_code(400);
        $json = ['error' => 'Not a valid API call.'];
        break;
}

$json = $response->output($json, false, true);
