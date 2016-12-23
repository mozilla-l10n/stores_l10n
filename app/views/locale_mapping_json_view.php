<?php
namespace Stores;

use Json\Json;

$json_data = new Json;
die($json_data->outputContent($mapping));
