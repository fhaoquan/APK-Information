<?php
  header('Content-Type: text/json; charset=utf-8');

  require_once("./ApkInfo.php");

  $is_small = isset($_REQUEST['issmall']);
  $is_zip = isset($_REQUEST['iszip']);

  $files = files_in('./resources', '/.(json)$/');
  $datas = [];

  foreach ($files as $file) {
    if (isset($data[ $file ])) continue;

    $datas[ $file ] = json_decode(@file_get_contents('./resources/' . $file), true);
  }

  //----------------------------- make a temporary array that holds the package name and version by key, sort it by key, back to flat array.
  $datas_associative = [];
  foreach ($datas as $data) {
    $key = mb_strtolower($data['name'] . '_' . $data['version']);
    if (!isset($datas_associative[ $key ])) {
      $datas_associative[ $key ] = $data;
    }
  }
  ksort($datas_associative);
  $datas = array_values($datas_associative); //sorted array by package name and version.
//-----------------------------

  echo $is_zip ? toJSON(['gzip' => base64_encode(gzencode(toJSON($datas, $is_small)))],$is_small) : toJSON($datas, $is_small);

  //http://localhost/apk-information/jsons.php?issmall&iszip == no spaces + gzip
  //http://localhost/apk-information/jsons.php?issmall       == json format - no spaces
  //http://localhost/apk-information/jsons.php?              == large json format
