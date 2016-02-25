<?php
namespace Stores;

use Transvision\Json;

// Create our API object
$request = new API($url);
$response = new Json;

/*
    Rename 'done' service into 'listing'.
    e.g. google/done/release/ -> google/listing/release
*/
if ($request->getService() == 'done') {
    $request->query['service'] = $request->parameters[1] = 'listing';
}

// Check if valid API call
if ($request->isValidRequest()) {
    include MODELS . 'api_model.php';
} else {
    $json = $response->output($request->invalidAPICall());
}

include VIEWS . 'json_view.php';
exit;
