<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <title><?=$title?></title>
  <base href="<?=BASE_HTML_URL?>">
  <link href="/media/css/base.css" rel="stylesheet">
</head>
<body class="sand">
<div id="outer-wrapper">
    <div id="wrapper">
    <?php if ( $view != 'home'):?>
    <div class="homebutton"><a href="./">«&nbsp;Home</a></div>
    <?php endif;?>
<?=$content?>
    </div>
</div>
</body>
</html>
