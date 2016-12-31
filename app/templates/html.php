<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?=$title?></title>
    <base href="<?=BASE_HTML_URL?>">
    <link rel="stylesheet" href="media/js/styles/zenburn.css">
    <script src="media/js/highlight.pack.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="media/assets/bootstrap/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="media/assets/bootstrap/css/bootstrap-theme.min.css">
    <!-- App specific styles -->
    <link rel="stylesheet" href="media/css/extra.css">
</head>

<body role="document">
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Mozilla - App Stores l10n Dashboard</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="<?=($url['path'] == '/') ? 'active' : ''?>"><a href="#">Home</a></li>
            <li class="<?=($url['path'] == '/documentation') ? 'active' : ''?>"><a href="documentation">API</a></li>
            <li><a href="https://github.com/mozilla-l10n/stores_l10n/">Code on Github</a></li>
            <li><a href="https://github.com/mozilla-l10n/stores_l10n/issues">Report bug</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container theme-showcase" role="main">
        <div><?=$content?></div>
    </div><!-- /.container -->

</body>
</html>
<?php

$time = 'Elapsed time (s): ' . round((microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]), 4);
$memory = 'Memory usage (MB): ' . round(memory_get_peak_usage(true) / (1024 * 1024), 2);

if (defined('DEBUG') && DEBUG) {
    error_log($time);
    error_log($memory);
}

echo "\n<!-- {$time} -->\n<!-- {$memory} -->\n";
