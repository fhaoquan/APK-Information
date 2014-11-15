1st Thing You Got To Know Is That This Project Is A Part Of A 1-Man 1-Day Hackaton I'm Putting MySelf Through Every Month, This Month I've Started At Nov. 14 - Nov 15. (Saturday Fun), Listening An Endless Loop Of This Track:
![Tron Track](http://icompile.eladkarako.com/wp-content/uploads/2014/11/tron_track.png "Daft Punk - Tron Legacy Reconfigured Remix")

#A PHP APK Parser: 
- Parse **AndroidManifest.xml**
  - Output Plain-Text XML.
    <small>**Easily Parse** It With Any Of **_PHP's Simple XML / DOM-Parsers_**.</small>
  - Get Specific Information From Package.
    - **Package Version** (Human Readable Format).
    - Package Version (Code Format).
    - Package Unified/Fully Qualified **Name**.
    - SDK Minimal-Support Version.
    - SDK Target Version.
    - Application's **Meta-Data**.
    - Package **Permissions**.
    - All Of The **Hardware-Features** Might Be Used Used And If They Are **Required**.
  - Documention Enabled Easily Adding More Query-Like Methods, Quite Easily.
- All **HD Images** Used For Package **Icons**.
 - **Base64** Image
 - Image **Meta-Data**
    - Width
    - Height
    - Color-Channels (RGB, CMYK)
    - Bits For Each Color
    - Mime-Type
    - Base64 ISO Mime-Type Prefix (__to make things easier__)
- APK Information
 -  **Time** Of Creation, Last Access, Last Modification.
 -  File **Size**.
 -  ZIP **Compression Rate**.

- A JSON Format Output, That Can Be Written To Prevent Future Re-Parsing and I/O.

####ApkParser.php Is Modified From [polaris1119](https://github.com/polaris1119/myutility/blob/master/php/apk_parser.php)'s


<br/>
************************************

###Basic Usage
```php5
<?php
  date_default_timezone_set("Asia/Jerusalem");
  setlocale(LC_ALL, 'en_US.UTF-8');
  mb_internal_encoding('UTF-8');
  header('Content-Type: text/plain; charset=utf-8');

  require_once("./ApkInfo.php");

  //$files = files_in('./resources/.', '/.(apk|zip|tar|gzip)$/');

  $info = getApkFileInfo('./resources/920 Text Editor 12.11.23_39.apk');

  print_r($info);
```
###Outputs:

