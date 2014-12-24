<?php
  date_default_timezone_set("Asia/Jerusalem");
  setlocale(LC_ALL, 'he_IL.UTF-8');
  mb_internal_encoding('UTF-8');
  header('Content-Type: text/json; charset=utf-8');

  $is_small = isset($_REQUEST['small']);
  $is_zip = isset($_REQUEST['zip']); //base64_encode(gzencode(toJSON($datas, $is_small)))],$is_small)

  require_once("./ApkInfo.php");

  $files = files_in('./resources', '/.(json)$/');
  $response = [];

  foreach ($files as $file)
    array_push($response, file_get_contents('./resources/' . $file));

  $response = '[' . implode(',', $response) . ']';
  $response = json_decode($response, true);         //only make it into a data-collection at the end, 'till now, its just a text (more efficient processing/appending..).

  $response = toJSON($response, $is_small);
  $response = $is_zip ? toJSON(['zip' => base64_encode(gzencode($response))], $is_small) : $response; //optionally zip output.

  echo $response;
