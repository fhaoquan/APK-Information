<?php
date_default_timezone_set("Asia/Jerusalem");
setlocale(LC_ALL, 'en_US.UTF-8');
mb_internal_encoding('UTF-8');
header('Content-Type: text/html; charset=utf-8');

require_once("./ApkInfo.php");

$files = files_in('./resources', '/.(apk|zip|tar|gzip)$/');
$datas = [];
foreach ($files as $file) {
  $f = './resources' . $file . '.json';

  if (!@file_exists($f)) {
    getApkFileInfo(                            //render data + JSON file + images.
      './resources/' . $file
      , true //save all images to files in the operation system
      , true //save the data as a JSON file
    );
  }
}
?><?php
session_start();
if (!isset($_SESSION['uniqueID'])) {
  $_SESSION['uniqueID'] = uniqid();
}
?><!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
  <meta name="robots" content="noodp,noydir,noindex,nofollow,noarchive"/>
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="canonical" href="http://apk.eladkarako.com"/>
  <link rel="publisher" href="http://apk.eladkarako.com"/>
  <link rel="shortlink" href="http://apk.eladkarako.com"/>
  <meta name="description" content="APK Library"/>
  <meta property="og:url" content="http://apk.eladkarako.com"/>
  <meta property="og:locale" content="en_US"/>
  <meta property="og:image" content="http://apk.eladkarako.com/favicon.ico"/>
  <meta property="og:site_name" content="apk.eladkarako.com"/>
  <meta property="article:publisher" content="http://apk.eladkarako.com"/>
  <meta property="article:tag" content="APK"/>
  <meta property="article:tag" content="apk"/>
  <meta property="article:section" content="software"/>
  <meta property="article:published_time" content="2014-11-15T03:50:00+00:00"/>
  <meta property="article:modified_time" content="2014-11-15T03:50:00+00:00"/>
  <meta property="og:updated_time" content="2014-11-15T03:50:00+00:00"/>
  <title>apk.eladkarako.com</title>

  <link rel="stylesheet" href="assets/jquery.mobile-1.4.2.min.css"/>
  <link rel="stylesheet" href="assets/style.css"/>

  <script>
    window.files =<?php echo toJSON($files,true); ?>;
  </script>
</head>

<!--<body style="display:none;">-->
<body>
<div data-role="page" id="pageone">
  <div data-role="panel" id="myPanelDefault">
    <h2>Panel Header</h2>

    <p>You can close the panel by clicking outside the panel, pressing the Esc key, by swiping, or by clicking the
      button below:</p>
    <a href="#pageone" data-rel="close"
       class="ui-btn ui-btn-inline ui-shadow ui-corner-all ui-btn-a ui-icon-delete ui-btn-icon-left">Close panel</a>
  </div>

  <div data-role="panel" id="myPanelFixed" data-position-fixed="true">
    <h2>Panel Header</h2>

    <p>You can close the panel by clicking outside the panel, pressing the Esc key, by swiping, or by clicking the
      button below:</p>
    <a href="#pageone" data-rel="close"
       class="ui-btn ui-btn-inline ui-shadow ui-corner-all ui-btn-a ui-icon-delete ui-btn-icon-left">Close panel</a>
  </div>

  <!--
      <div data-role="header" data-position="fixed" data-fullscreen="true">
        <h1></h1>
      </div>
  -->

  <div data-role="main" class="ui-content"><br><br>
    <!--
          <p>Click on both buttons and start to scroll the page.</p>
          <a href="#myPanelDefault" class="ui-btn ui-btn-inline ui-corner-all ui-shadow">Open Default Panel</a>
          <a href="#myPanelFixed" class="ui-btn ui-btn-inline ui-corner-all ui-shadow">Open Panel with data-position-fixed="true"</a>

          <p><b>Tip:</b> Quickly search for a song by any letters appearing in the title. give it a try.</p>
    -->
    <form class="ui-filterable"><input id="myFilter" data-type="search"></form>

    <ul id="filelist" data-role="listview" data-filter="true" data-input="#myFilter"
        data-autodividers="true" data-inset="true"></ul>
  </div>

  <!--
    <div data-role="footer" style="text-align:center;" data-position="fixed" data-fullscreen="true">
      <a href="#myPanelFixed" class="ui-btn ui-corner-all ui-shadow ui-icon-info ui-btn-icon-left">מידע</a>
    </div>
  -->
</div>

<script src="assets/jquery-1.10.2.min.js"></script>
<script src="assets/jquery.mobile-1.4.2.min.js"></script>


<script>
  setTimeout(function () {
    var i, len = window.files.length, file;

    Array.prototype.nPush = function () {
      Array.prototype.push.apply(this, arguments);
      return this;
    };

    for (i = 0; i < len; i += 1) {
      file = './resources/' + files[i] + '.json';

      $.getJSON(file, function (data) {
        var html = [];
        html
          .nPush('<li data-identification="').nPush(data['name']).nPush('" >')
          .nPush('<img class="package_logo" width="96" height="96" src="').nPush(data['image_main']['dirname']).nPush('/').nPush(data['image_main']['basename_escape']).nPush('" />')
          .nPush('</li>');

        $('#filelist').append(html);
        console.log(html.join(''));
      });
    }
//    $.each(window.files, function (index, file) {
//
//      $.getJSON(file, function (data) {
//        var html = (function (data) {
//          var sb = [];
//
//
//          return sb.join('');
//        }(data));
//
//        console.log(html);
//      });
//
//    });

  }, 30);
</script>

</body>
</html>
