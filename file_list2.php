<?php
  header('Content-Type: text/json; charset=utf-8');

  require_once("./ApkInfo.php");

  $files = files_in('./resources', '/.(apk|zip|tar|gzip)$/');

  $files_associative = [
    'has_no_json'     => [],
    'with_json'       => [],
    'is_all_with_json' => true //start with true
  ];

  foreach ($files as &$file) {
    if (in_array($file, $files_associative['has_no_json']) || in_array($file, $files_associative['with_json'])) continue;

    $json_file = './resources/' . $file . '.json';
    var_dump(file_exists('./resources/' . $file . '.json'));
//    var_dump(pathinfo($json_file));
//echo realpath(dirname(__FILE__));
    $is_with_json = (true === $json_file);

//    $json_file = @mb_ereg_replace('/','\\',$json_file);
//    var_dump($is_with_json, $json_file);

    if (true === $is_with_json) {
      array_push($files_associative['with_json'], $json_file);
    }
    else {
      array_push($files_associative['has_no_json'], $json_file);
    }

    $files_associative['is_all_with_json'] = $files_associative['is_all_with_json'] && $is_with_json;

  }


  echo toJSON($files_associative, false);
