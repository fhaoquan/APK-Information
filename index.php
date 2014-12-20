<?php
date_default_timezone_set("Asia/Jerusalem");
setlocale(LC_ALL, 'he_IL.UTF-8');
mb_internal_encoding('UTF-8');
header('Content-Type: text/html; charset=utf-8');

session_start();
if (!isset($_SESSION['uniqueID'])) {
  $_SESSION['uniqueID'] = uniqid();
}
?><!DOCTYPE html>
<html lang="en-US" style="display: none;">
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

  <script src="assets/jsxcompressor.min.js"></script>
  <script src="assets/jquery-1.10.2.min.js"></script>
  <!--  <script src="assets/mustache.min.js"></script>-->
  <script src="assets/handlebars.min.js"></script>
  <script src="assets/handlebars_helpers.js"></script>
  <script src="assets/main.js"></script>

  <script>
//
//    $.ajaxSetup({
//      async: true
//    });
//    $.get('_to_dom.txt', function (data) {
//      "use strict";
//      var data, files, template, template_with_content;
//
//      data = JSON.parse(JXG.decompress(data));
//
//      files = JSON.parse(data.files);
//      template = data.template;
//
//      template_with_content = Handlebars.compile(template); //let handlebars process the raw template.
//      template_with_content = template_with_content(files); //embedd the data into the template.
//
//      $(document).ready(function () {
//        $('body').html(template_with_content); //set content, politely using jQuery's html, will not work w/ innerHTML..
//      })
//    })
//      .fail(function () {
//        $('body').html("<h1>ERROR</h1>"); //set content, politely using jQuery's html, will not work w/ innerHTML..
//      })
//      .always(function () {
//        document.querySelector('html').style.display = ""; //makes all visible again.
//      });

  </script>
</head>
<body></body>
</html>
