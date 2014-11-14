
    /**
     * @deprecated
     * @return array
     */
    public function getQueryResult() {
      $out = [];

      $xml = $this->getXML();
      $xml = simplexml_load_string($xml); //now an object representation.

      $out['versionName'] = (string)$xml->xpath('/manifest')[0]->attributes('http://schemas.android.com/apk/res/android')->versionName;


      return $out;
    }


    /**
     * @param string $xpath
     *
     * @deprecated
     * @return array
     */
    public function getAttributes($xpath = '/manifest') {
      $xml = simplexml_load_string(
        $this->getXML()
      );

      $result = [];

      $nodes = $xml->xpath($xpath);
      foreach ($nodes as $index => $node) {

        $node_name = $node->getName();
        $result[ $node_name ] = [];

        //get all like "android:XYZ" for example: "android:versionCode"
        $attributes = $node->attributes('http://schemas.android.com/apk/res/android');
        foreach ($attributes as $attribute_name => $attribute_value)
          $result[ $node_name ][ $attribute_name ] = (string)$attribute_value;

        //get all ''regular'' like "XYZ" for example: "package"   --- and add them
        $attributes = $node->attributes();
        foreach ($attributes as $attribute_name => $attribute_value)
          $result[ $node_name ][ $attribute_name ] = (string)$attribute_value;
      }

      return $result;
    }


    //aggregates the attributes of same node name and attribute name

    /**
     * Aggregates values in case there is "same node name" /on "same attribute name" ----> it makes a list of values,
     * and if there is a single value it may just use the value itself.
     *
     * @param string $xpath
     *
     * @deprecated
     * @return array
     */
    public function getAttributesJoined($xpath = '/manifest', $isDropSingleCellArray = false) {
      $xml = simplexml_load_string(
        $this->getXML()
      );

      $result = [];

      $nodes = $xml->xpath($xpath);
      foreach ($nodes as $index => $node) {
        $node_name = $node->getName();
        $result[ $node_name ] = isset($result[ $node_name ]) ? $result[ $node_name ] : [];

        $attributes = $node->attributes('http://schemas.android.com/apk/res/android');        //get all like "android:XYZ" for example: "android:versionCode"
        foreach ($attributes as $attribute_name => $attribute_value) {
          $result[ $node_name ][ $attribute_name ] = isset($result[ $node_name ][ $attribute_name ]) ? $result[ $node_name ][ $attribute_name ] : [];

          array_push($result[ $node_name ][ $attribute_name ], (string)$attribute_value);
        }

        $attributes = $node->attributes();        //get all ''regular'' like "XYZ" for example: "package"   --- and add them
        foreach ($attributes as $attribute_name => $attribute_value) {
          $result[ $node_name ][ $attribute_name ] = isset($result[ $node_name ][ $attribute_name ]) ? $result[ $node_name ][ $attribute_name ] : [];

          array_push($result[ $node_name ][ $attribute_name ], (string)$attribute_value);
        }


        if ($isDropSingleCellArray === true) { //optionally flatten the structure to single value instead of an array
          $attributes = $node->attributes('http://schemas.android.com/apk/res/android');        //get all like "android:XYZ" for example: "android:versionCode"
          foreach ($attributes as $attribute_name => $attribute_value)
            $result[ $node_name ][ $attribute_name ] = $result[ $node_name ][ $attribute_name ][0];

          $attributes = $node->attributes();        //get all ''regular'' like "XYZ" for example: "package"   --- and add them
          foreach ($attributes as $attribute_name => $attribute_value) {
            foreach ($attributes as $attribute_name => $attribute_value)
              $result[ $node_name ][ $attribute_name ] = $result[ $node_name ][ $attribute_name ][0];
          }
        }

//        print_r(
//          $parser->getAttributesJoined('/manifest',true)
//        );
//        print_r(
//          $parser->getAttributes('/manifest/uses-permission')
//        );


//        if ($isDropSingleCellArray === true) { //optionally flatten the structure to single value instead of an array
//          foreach ($attributes as $attribute_name => $attribute_value) {
//            if (count($result[ $node_name ][ $attribute_name ]) === 1)
//              $result[ $node_name ][ $attribute_name ] = array_pop($result[ $node_name ]);
//          }
//        }


      }

      return $result;
    }

//      $node = $xml->xpath($xpath)[0];
//
//      $result = [];
//      foreach ($attributes as $attribute_name => $attribute_value)
//        $result[$attribute_name] = (string)$attribute_value;
//
//      return $result;

//
//      $node = $xml->xpath($xpath)[0];
//      $node_name = $node->getName();
//      $attributes = $node->attributes('http://schemas.android.com/apk/res/android');
//      $children = $node->children();
//
//      //represent
//      $obj = [];
//      $obj[$node_name] = [];
//      foreach ($attributes as $attribute_name => $attribute_value)
//        $obj[$node_name][$attribute_name] = (string)$attribute_value;
//
//      return $obj;




  //
  //    public function getUserPermissions() {
  //      $collection = [
  //        "data"   => [],
  //        "length" => 0
  //      ];
  //
  //      $item = null;
  //
  //      for ($i = 0; true; $i += 1) {
  //        $item = $this->getAttribute("manifest/uses-permission", 'android:name');
  //        if (!$item) break;
  //
  //        var_dump($item);
  //        //array_push($collection['data'], $item);
  //        //$collection['data'] = $i;
  //      }
  //
  //      return $collection;
  //    }
  //  }










  //echo (string)$xml->product->attributes()->id;


  //$simplexml= new SimpleXMLElement($xml);
  //echo (string) $xml->application->activity->attributes('http://schemas.android.com/apk/res/android')->name;


  //  $xml = simplexml_load_string($xml);
  //  $node = $xml->xpath('/manifest')[0];
  //  $attributes = $node->attributes('http://schemas.android.com/apk/res/android');
  //  print_r(
  //    $attributes
  //  );

  //  $children = $node->children();
  //
  //  $r = [];
  //  $r[$node->getName()] = [];
  //  foreach ($attributes as $name => $value){
  //    $r[$node->getName()][$name] = (string)$value;
  //  }
  //
  //
  //  print_r(
  //    $r
  //  );
  //
  //
  //  function enumerator($node) {
  //    $attributes = $node->attributes('http://schemas.android.com/apk/res/android');
  //    $children = $node->children();
  //
  //    $json = "";
  //
  //    if ($node->count() === 0)
  //      $json = json_encode($node);
  //
  //    foreach ($children as $childName => $childValue)
  //      return enumerator($childValue);
  //
  //
  //    echo "name:", "\t", $node->getName(), "\n";
  //    echo "attributes: \n";
  //    foreach ($attributes as $name => $value)
  //      echo "\t", $name, "\t", $value, "\n";
  //
  //    echo "\n";
  //    foreach ($children as $childName => $childValue)
  //      enumerator($childValue);
  //  }
  //
  ////  enumerator($node);
  //

  //$lats =  $simplexml->xpath('/manifest')[0];
  //$lats = $lats->attributes();
  //print_r(
  //$lats
  //);

  //  $xmlObj = @simplexml_load_string(
  //    $parser->getXML(),
  //    'SimpleXMLElement',
  //    LIBXML_NOCDATA | LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG | LIBXML_NOENT |
  //    LIBXML_NONET | LIBXML_NOWARNING | LIBXML_NOXMLDECL | LIBXML_NSCLEAN |
  //    LIBXML_PARSEHUGE | LIBXML_ERR_NONE
  //  );
  //  $xmlObj->

  //
  //  echo json_encode($xmlObj,
  //    JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG | JSON_NUMERIC_CHECK |
  //    JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
  //  );

  //  print_r(
  //    $parser->getApplicationMetaData()
  //  );
  //echo xml2json::convertSimpleXmlElementObjectIntoArray($xml);

  /*
  function json_prepare_xml( $domNode ){
    foreach( $domNode->childNodes as $node)
      if($node->hasChildNodes()) json_prepare_xml($node);
    if( $domNode->hasAttributes() && strlen($domNode->nodeValue) ){
      $domNode->setAttribute("nodeValue", $node->textContent );
      $node->nodeValue = "";
    }
    return $node;
  }


  $dom->loadXML( file_get_contents($xmlfile) );
  json_prepare_xml($dom);
  $sxml = simplexml_load_string( $dom->saveXML() );
  $json = json_decode( json_encode( $sxml ) ) );
*/

  /*
   $feed = simplexml_load_file('http://feeds.feedburner.com/blogspot/MKuf');
$feed->registerXPathNamespace('f', 'http://www.w3.org/2005/Atom');
foreach ($feed->xpath('//f:link[@rel="next"]') as $link) {
    var_dump($link);
}
   */
  //
  //  $xml = str_replace(["\n", "\r", "\t"], '', $xml);
  //  $xml = trim(str_replace('"', "'", $xml));
  //  $simpleXml = simplexml_load_string($xml);
  //  $simpleXml->registerXPathNamespace("f", "http://schemas.android.com/apk/res/android");
  //  foreach ($simpleXml->xpath('//f:link[@rel="next"]') as $link) {
  //    var_dump($link);
  //
  //
  //  }
  //
  //  $nounicode = true;
  //  $beautify = true;
  //
  //  $xml = json_encode($xml,
  //    JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG | JSON_NUMERIC_CHECK |
  //    ($nounicode ? JSON_UNESCAPED_UNICODE : 0) |
  //    ($beautify ? JSON_PRETTY_PRINT : 0)
  //  );
  //
  //  var_dump(json_decode($xml,true));
  //
  //  echo $xml;
  //


  //  //using XPath
  //  print_r(
  //    $parser->getUsesPermissions()
  //  );
  //  echo PHP_EOL;
  //


  //  $apkParser->getPackage() . "\n";
  //  echo $apkParser->getVersionName() . "\n";
  //  echo $apkParser->getVersionCode() . "\n";
  //  echo $apkParser->getXML() . "\n";

