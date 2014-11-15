<?php
  date_default_timezone_set("Asia/Jerusalem");
  setlocale(LC_ALL, 'en_US.UTF-8');
  mb_internal_encoding('UTF-8');
  header('Content-Type: text/plain; charset=utf-8');

  require_once("./ApkInfo.php");


  $files = files_in('./resources', '/.(apk|zip|tar|gzip)$/');
  foreach ($files as $file) {
    print_r(
      getApkFileInfo('./resources/' . $file)
    );
  }


