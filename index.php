<?php
date_default_timezone_set("Asia/Jerusalem");
setlocale(LC_ALL, 'en_US.UTF-8');
mb_internal_encoding('UTF-8');
header('Content-Type: text/html; charset=utf-8');

require_once("./ApkInfo.php");

$files = files_in('./resources', '/.(apk|zip|tar|gzip)$/');
$datas = [];
foreach ($files as $file)
  array_push(
    $datas,
    getApkFileInfo(
      './resources/' . $file
      , true //save all images to files in the operation system
      , true //save the data as a JSON file
    )
  );
?><!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="robots" content="noodp,noydir,noindex,nofollow,noarchive"/>
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
  <link rel="icon" href="favicon.ico" type="image/x-icon"/>
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

  <link rel="stylesheet" href="assets/jquery.mobile-1.3.1.css"/>
  <link rel="stylesheet" href="assets/jquery.mobile-1.4.2.min.css"/>

  <style type="text/css">
    @-ms-viewport {
      width: device-width;
    }

    @viewport {
      width: device-width;
    }

    * {
      -moz-osx-font-smoothing: grayscale;
      -webkit-font-smoothing: antialiased;
      -webkit-font-smoothing: subpixel-antialiased;
      text-shadow: 0 0 1px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>

<body>
<pre>
<?php
  print_r(
    $datas
  );
?>
</pre>
</body>
</html>
