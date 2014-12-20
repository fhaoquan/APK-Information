<?php
  date_default_timezone_set("Asia/Jerusalem");
  setlocale(LC_ALL, 'he_IL.UTF-8');
  mb_internal_encoding('UTF-8');
  header('Content-Type: text/json; charset=utf-8');

  require_once("./ApkInfo.php");

  $response = [];

  $file = isset($_REQUEST['file']) ? $_REQUEST['file'] : '';

  (empty($file) || !@file_exists($file)) && die("{'error': 'file?'}");

  $is_small = isset($_REQUEST['small']);
  $is_zip = isset($_REQUEST['zip']); //base64_encode(gzencode(toJSON($datas, $is_small)))],$is_small)

  require_once("./ApkInfo.php");

  $json_file = /* './resources/' . */
    $file . '.json';

  $response = @file_exists($json_file) ? json_decode(@file_get_contents($json_file), true) :
    @getApkFileInfo(
      $file,
      true,  //save all images to files in the operation system.
      true, //save the data as a JSON file.
      true   //overwrite json file.
    );

  (!@file_exists($json_file)) && die("{'error': 'file write error.'}"); //make sure file write successfully.

  $response = toJSON($response, $is_small);
  $response = $is_zip ? toJSON(['zip' => base64_encode(gzencode($response))], $is_small) : $response; //optionally zip output.

  echo $response;

  /*
   * http://localhost/apk-information/anlz.php?file=./resources/info.staticfree.android.twentyfourhour_8.apk
   * http://localhost/apk-information/anlz.php?file=./resources/info.staticfree.android.twentyfourhour_8.apk&small
   * http://localhost/apk-information/anlz.php?file=./resources/info.staticfree.android.twentyfourhour_8.apk&small&zip
   */
