<?php

  class ApkImage {
    /**
     * returns an associative-array of images, and their basic meta-data such as height, width, channel level, bits for
     * each color, and mime-type.
     *
     * @param       $apk_file_path - an operation-system-sensitive path to the apk file
     *
     * @return array
     */
    public static
    function get_array_of_images_from_apk($apk_file_path) {
      $icon_paths = [
        //used in google or new packages
        'res/mipmap-mdpi/ic_launcher.png',              // 48x48 pixels
        'res/mipmap-hdpi/ic_launcher.png',              // 72x72 pixels
        'res/mipmap-xhdpi/ic_launcher.png',             // 96x96 pixels
        'res/mipmap-xxhdpi/ic_launcher.png',            // 144x144 pixels
        'res/mipmap-xxxhdpi/ic_launcher.png',           // 192x192 pixels

        //used in very old structure packages
        'res/drawable/icon.png',                         // 72x72 pixels || any (not constant..)
        'res/drawable/ic_launcher.png',                  // 72x72 pixels || any (not constant..)

        //used in most packages
        'res/drawable-ldpi/ic_launcher.png',             // 36x36 pixels (not constant..)
        'res/drawable-mdpi/ic_launcher.png',             // 48x48 pixels (not constant..)
        'res/drawable-hdpi/ic_launcher.png',             // 72x72 pixels (not constant..)
        'res/drawable-xhdpi/ic_launcher.png',            // 96x96 pixels (not constant..)
      ];

      $images_data = [];

      foreach ($icon_paths as $icon_path) {
        $path = 'zip://' . $apk_file_path . '#' . $icon_path;

        $img = @file_get_contents($path);
        $isValid = !!$img;

        if ($isValid) {
          $img = self::getImageData($img);
          $img['path'] = $icon_path;
          array_push($images_data, $img);
        }
      }

      if (count($images_data) === 0) {
        $img = @file_get_contents('./assets/default.png'); //use default image
        $img = self::getImageData($img);
        $img['path'] = "*external_default*";
        array_push($images_data, $img);
      }

      return $images_data;
    }


    /**
     * @param $binary_image - a binary content of an image.
     *
     * @return array        - an associative array of an image, and image meta-data.
     */
    public static
    function getImageData($binary_image) {
      $img_metadata = @getimagesizefromstring($binary_image);
      $image_data = [
        'width'               => isset($img_metadata[0]) ? $img_metadata[0] : 0,
        'height'              => isset($img_metadata[1]) ? $img_metadata[1] : 0,
        'channels'            => isset($img_metadata[2]) ? ($img_metadata[2] === 3 ? 'RGB' : 'CMYK') : 'RGB',
        'bits_for_each_color' => isset($img_metadata['bits']) ? $img_metadata['bits'] : 0,
        'mime_type'           => isset($img_metadata['mime']) ? $img_metadata['mime'] : 'image/png',
      ];

      $image_data['base64_prefix'] = "data:" . $image_data['mime_type'] . ";base64,";
      $image_data['image'] = base64_encode($binary_image);

      //debug:
      $image_data['base64_with_prefix'] = $image_data['base64_prefix'] . $image_data['image'];
      unset($image_data['image']);

      return $image_data;
    }


  }

?>
