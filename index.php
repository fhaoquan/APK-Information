<?php
date_default_timezone_set("Asia/Jerusalem");
setlocale(LC_ALL, 'en_US.UTF-8');
mb_internal_encoding('UTF-8');
header('Content-Type: text/html; charset=utf-8');

require_once("./ApkInfo.php");

$files = files_in('./resources', '/.(apk|zip|tar|gzip)$/');

$jsons = [];

foreach ($files as $file) {
  $json_filename = './resources/' . $file . '.json';

  if (!@file_exists($json_filename)) {
    $data = getApkFileInfo('./resources/' . $file);
    $data = toJSON($data);
    @file_put_contents($json_filename, $data); //cache.
  }

  array_push($jsons, $json_filename); //JSON's filename for later.
}

$jsons = (toJSON($jsons, true)); //small content
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

  <link rel="stylesheet" href="assets/jquery.mobile-1.4.2.min.css">
  <style type="text/css">
    * {
      -moz-osx-font-smoothing: grayscale;
      -webkit-font-smoothing: antialiased;
      -webkit-font-smoothing: subpixel-antialiased;
      text-shadow: 0 0 1px rgba(0, 0, 0, 0.2);
    }
  </style>
  <script>window.jsonfiles = <?php echo $jsons; ?>;</script>
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
    <form class="ui-filterable">
      <input id="myFilter" data-type="search">
    </form>

    <ul data-role="listview" data-filter="true" data-input="#myFilter" data-autodividers="true" data-inset="true">
      <!-- <li><a href="http://apk.eladkarako.com/' . $filenamePath . '" data-ajax="false">' . $filename . '</a></li>'); -->
    </ul>
    <br>
  </div>

  <!--
    <div data-role="footer" style="text-align:center;" data-position="fixed" data-fullscreen="true">
      <a href="#myPanelFixed" class="ui-btn ui-corner-all ui-shadow ui-icon-info ui-btn-icon-left">מידע</a>
    </div>
  -->
</div>

<script>
  /*
   $('#filelist')
   .listview({
   autodividers: true,
   autodividersSelector: function (li) {
   return li.attr('data-first-letter');
   }
   })
   .listview('refresh');
   */
</script>


<!--
<script>
window["GoogleAnalyticsObject"] = "ga";
window["ga"] = window["ga"] || function(){
  window["ga"].l = 1 * new Date();

  window["ga"].q = window["ga"].q || [];
  window["ga"].q.push(arguments);
};
</script>
<script src="https://www.google-analytics.com/analytics.js"></script>
<script>
window["ga"]("create", "UA-51722867-1", "eladkarako.com");
window["ga"]("require", "displayfeatures");
window["ga"]("require", "linkid", "linkid.js");
window["ga"]("set", "&uid", "<?php print($_SESSION['uniqueID']); ?>");
window["ga"]("send", "pageview");
</script>
-->

<script src="assets/jquery-1.10.2.min.js"></script>
<script src="assets/jquery.mobile-1.4.2.min.js"></script>
<script>
  setTimeout(function () {
    //  document.getElementsByTagName("body")[0].style.cssText = "";
  }, 10);
</script>
<script>
  (function (jsonfiles) {
    var
      template = '<li><img src="##IMAGE##"/><a href="http://apk.eladkarako.com/##FILENAMEDOWNLOAD##" data-ajax="false">##FILENAMEITEM##</a></li>',
      i, len = jsonfiles.length;

    for (i = 0; i < len; i += 1) {

      $.getJSON(jsonfiles[i], function (data) {
        $("ul").append(
          template
            .replace('##IMAGE##', data.images[0]['base64_with_prefix'])
            .replace('##FILENAMEDOWNLOAD##', '#')
            .replace('##FILENAMEITEM##', data.filename)
        )
      });
    }
  }(window.jsonfiles));
  //      var items = [];
  //      $.each( data, function( key, val ) {
  //        items.push( "<li id='" + key + "'>" + val + "</li>" );
  //      });
  //
  //      $( "<ul/>", {
  //        "class": "my-new-list",
  //        html: items.join( "" )
  //      }).appendTo( "body" );
  //    });

</script>
</body>
</html>
