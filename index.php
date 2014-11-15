<?php
  date_default_timezone_set("Asia/Jerusalem");
  setlocale(LC_ALL, 'en_US.UTF-8');
  mb_internal_encoding('UTF-8');
  header('Content-Type: text/plain; charset=utf-8');

  require_once("./ApkInfo.php");

  //entire folder (but just right files):
  $files = files_in('./resources', '/.(apk|zip|tar|gzip)$/');


  //--------------------------------------------------------------------------------------------------------- single file example
//  print_r(
//    getApkFileInfo('./resources/info.staticfree.android.twentyfourhour_8.apk')
//  );


  //--------------------------------------------------------------------------------------------------------- whole folder example
//  foreach ($files as $file)
//    print_r(
//      getApkFileInfo('./resources/' . $file)
//    );


  //--------------------------------------------------------------------------------------------------------- save I/O example

  foreach ($files as $file) {
    $json_filename = './resources/' . $file . '.json';
    $data = '';

    if (@file_exists($json_filename)) {
      echo "**>  FROM FILE :)  <**\n";
      $data = @file_get_contents($json_filename);
    }
    else {
      echo "**>  LOOKALIVE :)  <**\n";
      $data = getApkFileInfo('./resources/' . $file);
      $data = toJSON($data);
      @file_put_contents($json_filename, $data); //cache.
    }

    $data = json_decode($data);

    print_r($data);
  }
