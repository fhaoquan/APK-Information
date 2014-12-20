<?php
  date_default_timezone_set("Asia/Jerusalem");
  setlocale(LC_ALL, 'he_IL.UTF-8');
  mb_internal_encoding('UTF-8');
  header('Content-Type: text/json; charset=utf-8');

  require_once("./ApkInfo.php");

  $files = files_in('./resources', '/.(apk|zip|tar|gzip)$/');

  $is_small = isset($_REQUEST['small']);
  $is_zip = isset($_REQUEST['zip']); //base64_encode(gzencode(toJSON($datas, $is_small)))],$is_small)

  $response = $files;

  $response = toJSON($response, $is_small);
  $response = $is_zip ? toJSON(['zip' => base64_encode(gzencode($response))], $is_small) : $response; //optionally zip output.

  echo $response;