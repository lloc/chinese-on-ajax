<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo $str_title[basename($_SERVER['PHP_SELF'])]; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="<?php echo $lang; ?>" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="keywords" content="<?php echo $str_keywords[basename($_SERVER['PHP_SELF'])]; ?>" />
        <meta name="description" content="<?php echo $str_description[basename($_SERVER['PHP_SELF'])]; ?>" />
        <meta name="robots" content="index,follow" />
        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        <script type="text/javascript">google.load("prototype", "1.6.0.3");</script>
        <script type="text/javascript" src="cookiemanager.js"></script>
        <link type="text/css" rel="stylesheet" href="/chinese-on-ajax/pinyin.css" />
        <link rel="shortcut icon" href="/favicon.ico" />
    </head>
    <body>
        <div class="headline">
            <h1><a href="/chinese-on-ajax/">Chinese on Ajax</a></h1>
            <div id="flags">
                <a title="Deutsch" href="<?php echo (basename($_SERVER['PHP_SELF']) != 'index.php' ? basename($_SERVER['PHP_SELF']) : '/chinese-on-ajax/'); ?>"><img id="lang_de" src="de.jpg" alt="Deutsch" /></a>
                <a title="Italiano" href="<?php echo (basename($_SERVER['PHP_SELF']) != 'index.php' ? basename($_SERVER['PHP_SELF']) : '/chinese-on-ajax/'); ?>?lang=it"><img id="lang_it" src="it.jpg" alt="Italiano" /></a>
            </div>
        </div>
