<?php
  header('Content-Type: text/json; charset=utf-8');

  require_once("./ApkInfo.php");

  $file = $_REQUEST['file'];
  $is_small = isset($_REQUEST['issmall']);
  $data = [];

  if (!empty($file) || !@file_exists($file)) {
    $data = getApkFileInfo(                            //render data + JSON file + images.
      $file,
      true, //save all images to files in the operation system
      true //save the data as a JSON file
    );
  }

  echo toJSON($data, $is_small);
