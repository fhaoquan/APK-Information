<?php
  date_default_timezone_set("Asia/Jerusalem");
  setlocale(LC_ALL, 'he_IL.UTF-8');
  mb_internal_encoding('UTF-8');
  header('Content-Type: text/plain; charset=utf-8');

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
    foreach ($data['images'] as &$image) {
      unset($image['image']);
      unset($image['base64_with_prefix']);
    }
    array_push($datas, $data);
  }

//----------------------------- make a temporary array that holds the package name and version by key, sort it by key, back to flat array.
  $datas_associative = [];
  foreach ($datas as $data) {
    $key = mb_strtolower($data['name'] . '_' . $data['version']);
    if (!isset($datas2[ $key ])) {
      $datas_associative[ $key ] = $data;
    }
  }
  ksort($datas_associative);
  $datas = array_values($datas_associative); //sorted array by package name and version.
//-----------------------------

  $datas = [
    'files'  => $datas, //easier to loop in mustache/handlebars on 'inside' element such as 'files'...
    'length' => count($datas)
  ];

  include_once('./index.mustache.html');

  $to_dom = toJSON([
                     'files'    => toJSON($datas, true),
                     'template' => $template
                   ]);
  @file_put_contents('_to_dom.txt', base64_encode(gzencode($to_dom)));

