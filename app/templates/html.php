<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?=$title?></title>
    <base href="<?=BASE_HTML_URL?>">
    <link href="media/css/base.css" rel="stylesheet">
    <link rel="stylesheet" href="media/assets/styles/atelier-dune.light.css">
    <script src="media/assets/highlight.pack.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
</head>

<body class="sand">
<div id="outer-wrapper">
    <div id="wrapper">
    <?php if ( $view == 'home'):?>
    <div class="topbutton"><a href="./api/">API&nbsp;»</a></div>
    <?php else:?>
    <div class="topbutton"><a href="./">«&nbsp;Home</a></div>
    <?php endif;?>
<?=$content?>
    </div>
</div>
</body>
</html>
