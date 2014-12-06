<?php
date_default_timezone_set("Asia/Jerusalem");
setlocale(LC_ALL, 'en_US.UTF-8');
mb_internal_encoding('UTF-8');
header('Content-Type: text/html; charset=utf-8');

require_once("./ApkInfo.php");

$files = files_in('./resources', '/.(apk|zip|tar|gzip)$/');
$datas = [];
$data = null;
foreach ($files as &$file) {
  $f = './resources' . '/' . $file . '.json';

  if (true === @file_exists($f)) {
    $data = json_decode(@file_get_contents($f), true);  //use JSON file.
  }
  else {
    $data = getApkFileInfo(                            //render data + JSON file + images.
      './resources/' . $file
      , true //save all images to files in the operation system
      , true //save the data as a JSON file
    );
  }
  //make the JSON text smaller by removing the base64 and base64-with-prefix image representations (after they have already used..)
  foreach($data['images'] as &$image){
    unset($image['image']);
    unset($image['base64_with_prefix']);
  }
  array_push($datas, $data);
}

$datas = [
  'files'  => $datas,
  'length' => count($datas)
];

//server will compress the large amount of text, and base64 it so it will be text.
$compressed_json_data = base64_encode(gzencode(toJSON($datas, true), 9));
?><?php
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

  <script>
    var files = JSON.parse(JXG.decompress('<?php echo $compressed_json_data; ?>'));
  </script>

  <script>
    $.get('index.mustache.html', function (template_raw_content) {
      var result = Handlebars.compile(template_raw_content); /*old:      Mustache.render(template_raw_content, files);  */
      result = result(files);

      $('body').html(result);
    });
  </script>

  <script>
    setTimeout(function () {
      document.querySelector('html').style.display = "";
    }, 50);
  </script>
</head>
<body></body>
</html>
