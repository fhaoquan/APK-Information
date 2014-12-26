<?php
  /*
   * you can use http://localhost/APK-Information/all_json.php?prefix=[a-n]
   * to get a json of just the files that matches the following regex:
   * /^[a-n].*\.json$/i
   *
   * using no '?prefix=__' will match the following regex
   * /^.*\.json$/i
   * which is essentially correct as well.. (all json files).
   */

  date_default_timezone_set("Asia/Jerusalem");
  setlocale(LC_ALL, 'he_IL.UTF-8');
  mb_internal_encoding('UTF-8');
  header('Content-Type: text/json; charset=utf-8');

  //request arguments.
  //-------------------------------------------------------------------------------------------------------------------
  $is_small = isset($_REQUEST['small']) && (mb_strtolower((string)$_REQUEST['small']) !== 'false'); //this way ?small === ?small=true by not ?small=false
  $is_zip = isset($_REQUEST['zip']) && (mb_strtolower((string)$_REQUEST['zip']) !== 'false');
  $prefix = isset($_REQUEST['prefix']) ? $_REQUEST['prefix'] : '';
  //-------------------------------------------------------------------------------------------------------------------


  require_once("./ApkInfo.php");

  $file_ext = 'json';
  $files = files_in('./resources', '/^' . $prefix . '.*' . '\.' . $file_ext . '$/i');


  $response = '';

  $len_files = count($files) - 1;
  foreach ($files as $index => $file)
    $response .= file_get_contents('./resources/' . $file) . ($len_files === $index ? '' : ','); //don't add ',' after last one.

  $response = json_decode('[' . $response . ']', true); //only make it into a data-collection at the end, 'till now, its just a text (more efficient processing/appending..).

  $response = toJSON($response, $is_small);
  $response = $is_zip ? toJSON(['zip' => base64_encode(gzencode($response))], $is_small) : $response; //optionally zip output.

  echo $response;

