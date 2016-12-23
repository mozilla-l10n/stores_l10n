<?php
namespace Stores;

use Json\Json;

// Create our API object
$request = new API($url);
$response = new Json;

// Check if valid API call
if ($request->isValidRequest()) {
    include MODELS . 'api_model.php';
} else {
    $json = $response->outputContent($request->invalidAPICall());
}

include VIEWS . 'json_view.php';
exit;
