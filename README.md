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

<br/>
************************************
#### In My Examples Here I Am Using Official YouTube APK
##### From [ApkMirror.com](http://www.apkmirror.com/apk/google-inc/youtube/youtube-5-17-6-2-apk/ "http://www.apkmirror.com/apk/google-inc/youtube/youtube-5-17-6-2-apk/"), It Provides A Very Rich XML To Work With.
************************************

<br/><br/>

#ApkParser.php
> Modified From [https://github.com/polaris1119/myutility/blob/master/php/apk_parser.php](https://github.com/polaris1119/myutility/blob/master/php/apk_parser.php "https://github.com/polaris1119/myutility/blob/master/php/apk_parser.php")

<br/>

## For The _Binary-Compressed_ AndroidManifest.xml File
### Reads Directly From The APK File. **No Unzipping**, **Zero Hassle**.

************************************
<br/>
************************************

###Example #1 
Parse Binary XML, Output Plain-Text (Beautified And Human-Readble XML)


	<?php
	  setlocale(LC_ALL, 'en_US.UTF-8');
	  mb_internal_encoding('UTF-8');
	  header('Content-Type: text/plain; charset=utf-8');

	  require_once("./ApkParser.php");

	  $parser = new ApkParser();
	  $parser->open('./com.google.android.youtube-5.17.6-51706300-minAPI15.apk');

	  $xml = $parser->getXML();

	  echo $xml;


Page Output:

	<?xml version="1.0" encoding="utf-8"?>
	<manifest xmlns:android="http://schemas.android.com/apk/res/android" android:versionCode="51706300" android:versionName="5.17.6" package="com.google.android.youtube">
	  <uses-permission android:name="android.permission.INTERNET"></uses-permission>
	  <uses-permission android:name="android.permission.ACCESS_NETWORK_STATE"></uses-permission>
	  <uses-permission android:name="android.permission.CHANGE_NETWORK_STATE"></uses-permission>
	  <uses-permission android:name="android.permission.ACCESS_WIFI_STATE"></uses-permission>
	  <uses-permission android:name="android.permission.WRITE_EXTERNAL_STORAGE"></uses-permission>
	  <uses-permission android:name="android.permission.RECEIVE_BOOT_COMPLETED"></uses-permission>
	  <uses-permission android:name="android.permission.MANAGE_DOCUMENTS"></uses-permission>
	  <uses-permission android:name="android.permission.GET_ACCOUNTS"></uses-permission>
	  <uses-permission android:name="android.permission.MANAGE_ACCOUNTS"></uses-permission>
	  <uses-permission android:name="android.permission.USE_CREDENTIALS"></uses-permission>
	  <uses-permission android:name="com.google.android.providers.gsf.permission.READ_GSERVICES"></uses-permission>
	  <uses-permission android:name="com.google.android.googleapps.permission.GOOGLE_AUTH"></uses-permission>
	  <uses-permission android:name="com.google.android.googleapps.permission.GOOGLE_AUTH.youtube"></uses-permission>
	  <uses-permission android:name="com.google.android.googleapps.permission.GOOGLE_AUTH.YouTubeUser"></uses-permission>
	  <uses-permission android:name="com.google.android.c2dm.permission.RECEIVE"></uses-permission>
	  <uses-permission android:name="android.permission.WAKE_LOCK"></uses-permission>
	  <uses-permission android:name="android.permission.NFC"></uses-permission>
	  <uses-permission android:name="android.permission.CAMERA"></uses-permission>
	  <permission android:name="com.google.android.youtube.permission.C2D_MESSAGE" android:protectionLevel="0x00000002"></permission>
	  <uses-permission android:name="com.google.android.youtube.permission.C2D_MESSAGE"></uses-permission>
	  <uses-feature android:name="android.hardware.camera" android:required="false"></uses-feature>
	  <uses-sdk android:minSdkVersion="15" android:targetSdkVersion="19"></uses-sdk>
	  <application android:theme="@7F0E00B7" android:label="@7F0A01D9" android:icon="@7F030000" android:name="com.google.android.apps.youtube.app.YouTubeApplication" android:allowBackup="false" android:logo="@7F02005B" android:hardwareAccelerated="true" android:largeHeap="true">
		<meta-data android:name="to.dualscreen" android:value="true">
		</meta-data>
		<meta-data android:name="com.google.android.apps.youtube.config.BuildType" android:value="RELEASE"></meta-data>
		<activity android:name="com.google.android.apps.youtube.app.honeycomb.phone.NewVersionAvailableActivity" android:launchMode="2" android:configChanges="0x00000420"></activity>
		<activity android:name="com.google.android.apps.youtube.app.StartupPromoActivity"></activity>
		<activity android:name="com.google.android.apps.youtube.app.MusicPostPurchaseActivity"></activity>
		<activity android:theme="@android:01030055" android:name="com.google.android.apps.youtube.app.honeycomb.Shell$HomeActivity"></activity>
		<activity android:theme="@7F0E00C2" android:name="com.google.android.apps.youtube.app.WatchWhileActivity" android:launchMode="2" android:configChanges="0x000006A0">
		  <meta-data android:name="android.app.searchable" android:resource="@7F060009"></meta-data>
		  <intent-filter>
			<action android:name="android.intent.action.SEARCH"></action>
		  </intent-filter>
		</activity>
		<activity android:theme="@android:01030055" android:name="com.google.android.apps.youtube.app.honeycomb.Shell$ResultsActivity">
		  <intent-filter>
			<action android:name="android.intent.action.SEARCH"></action>
			<action android:name="android.intent.action.MEDIA_SEARCH"></action>
			<category android:name="android.intent.category.DEFAULT"></category>
		  </intent-filter>
		  <meta-data android:name="android.app.searchable" android:resource="@7F060009"></meta-data>
		</activity>
		<activity android:theme="@android:01030055" android:name="com.google.android.apps.youtube.app.honeycomb.Shell$UploadActivity">
		  <intent-filter>
			<action android:name="com.google.android.youtube.intent.action.UPLOAD"></action>
			<category android:name="android.intent.category.DEFAULT"></category>
			<data android:mimeType="video/*"></data>
		  </intent-filter>
		</activity>
		<activity android:name="com.google.android.apps.youtube.app.honeycomb.phone.UploadActivity" android:configChanges="0x000000A0" android:windowSoftInputMode="0x00000002"></activity>
		<activity android:name="com.google.android.apps.youtube.app.honeycomb.phone.EditVideoActivity" android:configChanges="0x000000A0" android:windowSoftInputMode="0x00000002"></activity>
		<activity android:theme="@7F0E00C3" android:name="com.google.android.apps.youtube.app.honeycomb.phone.ScreenPairingActivity" android:configChanges="0x00000020" android:windowSoftInputMode="0x00000012">
		  <intent-filter>
			<action android:name="android.intent.action.VIEW"></action>
			<category android:name="android.intent.category.DEFAULT"></category>
			<category android:name="android.intent.category.BROWSABLE"></category>
			<data android:scheme="remote"></data>
			<data android:host="youtube.com"></data>
			<data android:host="www.youtube.com"></data>
			<data android:host="m.youtube.com"></data>
			<data android:pathPrefix="/remote"></data>
			<data android:pathPrefix="/ytremote"></data>
		  </intent-filter>
		</activity>
		<activity android:theme="@7F0E00C3" android:name="com.google.android.apps.youtube.app.honeycomb.phone.PostPairingActivity" android:configChanges="0x00000020" android:windowSoftInputMode="0x00000012"></activity>
		<activity android:theme="@7F0E00C3" android:name="com.google.android.apps.youtube.app.honeycomb.phone.ScreenManagementActivity" android:configChanges="0x00000020" android:windowSoftInputMode="0x00000013"></activity>
		<activity android:theme="@android:01030055" android:name="com.google.android.apps.youtube.app.honeycomb.Shell$UrlActivity"></activity>
		<activity android:theme="@android:01030055" android:name="com.google.android.apps.youtube.app.honeycomb.Shell$MediaSearchActivity">
		  <intent-filter>
			<action android:name="android.media.action.MEDIA_PLAY_FROM_SEARCH"></action>
			<category android:name="android.intent.category.DEFAULT"></category>
		  </intent-filter>
		</activity>
		<activity android:theme="@7F0E00C3" android:label="@7F0A01DE" android:name="com.google.android.apps.youtube.app.honeycomb.SettingsActivity" android:configChanges="0x00000020"></activity>
		<activity android:theme="@android:01030055" android:name="com.google.android.apps.youtube.app.honeycomb.Shell$SettingsActivity"></activity>
		<activity android:theme="@7F0E00C7" android:label="@7F0A0119" android:name="com.google.android.apps.youtube.core.LicensesActivity" android:configChanges="0x000004A0">
		</activity>
		<meta-data android:name="android.app.default_searchable" android:value="com.google.android.apps.youtube.app.honeycomb.Shell$ResultsActivity"></meta-data>
		<service android:name="com.google.android.apps.youtube.core.transfer.UploadService"></service>
		<provider android:name="com.google.android.apps.youtube.app.suggest.YouTubeSuggestionProvider" android:exported="false" android:authorities="com.google.android.youtube.SuggestionProvider"></provider>
		<service android:name="com.google.android.apps.youtube.app.task.YouTubeNetworkTaskService" android:permission="com.google.android.gms.permission.BIND_NETWORK_TASK_SERVICE" android:exported="true">
		  <intent-filter>
			<action android:name="com.google.android.gms.gcm.nts.TASK_READY"></action>
		  </intent-filter>
		</service>
		<service android:name="com.google.android.apps.youtube.core.transfer.DownloadService"></service>
		<receiver android:name="com.google.android.apps.youtube.core.transfer.DownloadService$BootReceiver">
		  <intent-filter>
			<action android:name="android.intent.action.BOOT_COMPLETED"></action>
		  </intent-filter>
		</receiver>
		<service android:name="com.google.android.apps.youtube.app.offline.transfer.OfflineTransferService"></service>
		<receiver android:name="com.google.android.apps.youtube.app.offline.transfer.OfflineTransferService$DeviceStateReceiver">
		  <intent-filter>
			<action android:name="android.intent.action.BOOT_COMPLETED"></action>
		  </intent-filter>
		</receiver>
		<service android:name="com.google.android.apps.youtube.core.player.preload.PreloadVideosTransferService"></service>
		<receiver android:name="com.google.android.apps.youtube.core.player.preload.PreloadVideosTransferService$DeviceStateReceiver">
		  <intent-filter>
			<action android:name="android.intent.action.BOOT_COMPLETED"></action>
		  </intent-filter>
		</receiver>
		<service android:name="com.google.android.apps.youtube.app.system.LocaleUpdatedService"></service>
		<receiver android:name="com.google.android.apps.youtube.app.system.LocaleUpdatedReceiver">
		  <intent-filter>
			<action android:name="android.intent.action.LOCALE_CHANGED"></action>
		  </intent-filter>
		</receiver>
		<service android:name="com.google.android.apps.youtube.core.identity.AccountsChangedService"></service>
		<receiver android:name="com.google.android.apps.youtube.core.identity.AccountsChangedReceiver">
		  <intent-filter>
			<action android:name="android.accounts.LOGIN_ACCOUNTS_CHANGED"></action>
		  </intent-filter>
		</receiver>
		<activity android:theme="@android:01030007" android:name="com.google.zxing.client.android.CaptureActivity" android:screenOrientation="0" android:configChanges="0x000000A0" android:windowSoftInputMode="0x00000003">
		  <intent-filter>
			<action android:name="com.google.zxing.client.android.YOUTUBE_SCAN"></action>
			<category android:name="android.intent.category.DEFAULT"></category>
		  </intent-filter>
		</activity>
		<service android:label="@7F0A01DA" android:name="com.google.android.youtube.api.service.YouTubeService" android:permission="android.permission.INTERNET" android:exported="true" android:process="com.google.android.youtube.player">
		  <intent-filter>
			<action android:name="com.google.android.youtube.api.service.START"></action>
			<category android:name="android.intent.category.DEFAULT"></category>
		  </intent-filter>
		</service>
		<service android:name="com.google.android.apps.youtube.core.player.BackgroundPlayerService" android:exported="false"></service>
		<receiver android:name="com.google.android.apps.youtube.core.player.notification.ExternalPlaybackControllerV14$RemoteControlIntentReceiver" android:exported="true"></receiver>
		<activity android:theme="@android:01030011" android:label="@7F0A01DB" android:name="com.google.android.youtube.api.StandalonePlayerActivity" android:permission="android.permission.INTERNET" android:exported="true" android:process="com.google.android.youtube.player" android:configChanges="0x000004A0">
		  <intent-filter>
			<action android:name="com.google.android.youtube.api.StandalonePlayerActivity.START"></action>
			<category android:name="android.intent.category.DEFAULT"></category>
		  </intent-filter>
		</activity>
		<activity android:name="com.google.android.apps.youtube.app.honeycomb.LogCollectorActivity">
		  <intent-filter>
			<action android:name="com.google.android.youtube.action.bugreport"></action>
			<category android:name="android.intent.category.DEFAULT"></category>
		  </intent-filter>
		</activity>
		<receiver android:name="com.google.android.apps.youtube.app.notification.GcmBroadcastReceiver" android:permission="com.google.android.c2dm.permission.SEND" android:exported="true">
		  <intent-filter>
			<action android:name="com.google.android.c2dm.intent.RECEIVE"></action>
			<category android:name="com.google.android.youtube"></category>
		  </intent-filter>
		</receiver>
		<service android:label="@7F0A02EA" android:name="com.google.android.youtube.app.remote.YouTubeTvRouteProviderService">
		  <intent-filter>
			<action android:name="android.media.MediaRouteProviderService"></action>
		  </intent-filter>
		</service>
		<provider android:name="android.support.v4.content.FileProvider" android:exported="false" android:authorities="com.google.android.youtube.fileprovider" android:grantUriPermissions="true">
		  <meta-data android:name="android.support.FILE_PROVIDER_PATHS" android:resource="@7F060003"></meta-data>
		</provider>
		<meta-data android:name="com.google.android.gms.version" android:value="@7F0C0002"></meta-data>
		<activity-alias android:name="com.google.android.youtube.app.honeycomb.Shell$HomeActivity" android:exported="true" android:targetActivity="com.google.android.apps.youtube.app.honeycomb.Shell$HomeActivity">
		  <intent-filter>
			<action android:name="android.intent.action.MAIN"></action>
			<category android:name="android.intent.category.DEFAULT"></category>
			<category android:name="android.intent.category.LAUNCHER"></category>
		  </intent-filter>
		</activity-alias>
		<activity-alias android:name="com.google.android.youtube.HomeActivity" android:exported="true" android:targetActivity="com.google.android.apps.youtube.app.honeycomb.Shell$HomeActivity"></activity-alias>
		<activity-alias android:name="com.google.android.youtube.UploadIntentHandlingActivity" android:targetActivity="com.google.android.apps.youtube.app.honeycomb.Shell$UploadActivity">
		  <intent-filter android:label="@7F0A01D9">
			<action android:name="android.intent.action.SEND"></action>
			<action android:name="android.intent.action.SEND_MULTIPLE"></action>
			<category android:name="android.intent.category.ALTERNATIVE"></category>
			<category android:name="android.intent.category.DEFAULT"></category>
			<data android:mimeType="video/*"></data>
		  </intent-filter>
		</activity-alias>
		<activity-alias android:theme="@android:01030055" android:name="com.google.android.youtube.UrlActivity" android:exported="true" android:targetActivity="com.google.android.apps.youtube.app.honeycomb.Shell$UrlActivity">
		  <intent-filter>
			<action android:name="android.intent.action.VIEW"></action>
			<action android:name="android.media.action.MEDIA_PLAY_FROM_SEARCH"></action>
			<action android:name="android.nfc.action.NDEF_DISCOVERED"></action>
			<category android:name="android.intent.category.DEFAULT"></category>
			<category android:name="android.intent.category.BROWSABLE"></category>
			<data android:scheme="http"></data>
			<data android:scheme="https"></data>
			<data android:host="youtube.com"></data>
			<data android:host="www.youtube.com"></data>
			<data android:host="m.youtube.com"></data>
			<data android:host="youtu.be"></data>
			<data android:pathPattern=".*"></data>
		  </intent-filter>
		  <intent-filter>
			<action android:name="android.intent.action.VIEW"></action>
			<action android:name="android.media.action.MEDIA_PLAY_FROM_SEARCH"></action>
			<action android:name="android.nfc.action.NDEF_DISCOVERED"></action>
			<category android:name="android.intent.category.DEFAULT"></category>
			<category android:name="android.intent.category.BROWSABLE"></category>
			<data android:scheme="vnd.youtube"></data>
			<data android:scheme="vnd.youtube.launch"></data>
		  </intent-filter>
		</activity-alias>
		<activity-alias android:theme="@7F0E00C3" android:label="@7F0A01DE" android:name="com.google.android.youtube.ManageNetworkUsageActivity" android:enabled="false" android:targetActivity="com.google.android.apps.youtube.app.honeycomb.Shell$SettingsActivity">
		  <intent-filter>
			<action android:name="android.intent.action.MANAGE_NETWORK_USAGE"></action>
			<category android:name="android.intent.category.DEFAULT"></category>
		  </intent-filter>
		</activity-alias>
	  </application>
	</manifest>



###Example #2
Outputs Some Isolated Information From The XML.

	<?php
	  setlocale(LC_ALL, 'en_US.UTF-8');
	  mb_internal_encoding('UTF-8');
	  header('Content-Type: text/plain; charset=utf-8');

	  require_once("./ApkParser.php");

	  $parser = new ApkParser();
	  $parser->open('./resources/com.google.android.youtube-5.17.6-51706300-minAPI15.apk');

	  echo
	  'Version Name', "\t", $parser->getVersionName(), "\n",
	  'Version Code', "\t", $parser->getVersionCode(), "\n",
	  'Package Name', "\t", $parser->getPackage(), "\n",
	  'SDK Minimal-Version Support', "\t", $parser->getUsesSDKMin(), "\n",
	  'SDK Target-Version', "\t", $parser->getUsesSDKTarget(), "\n";

	  echo "\n";

	  echo 'Application Meta-Data', "\t";
	  print_r($parser->getApplicationMetaData());
	  echo "\n";

	  echo "\n";

	  echo 'Permissions', "\t";
	  print_r($parser->getUsesPermissions());
	  echo "\n";

	  echo 'Hardware-Features', "\t";
	  print_r($parser->getUsesFeature());
	  echo "\n";


Page Output:



	Version Name	5.17.6
	Version Code	51706300
	Package Name	com.google.android.youtube
	SDK Minimal-Version Support	15
	SDK Target-Version	19

	Application Meta-Data	Array
	(
		[to.dualscreen] => true
		[com.google.android.apps.youtube.config.BuildType] => RELEASE
		[android.app.default_searchable] => com.google.android.apps.youtube.app.honeycomb.Shell$ResultsActivity
		[com.google.android.gms.version] => @7F0C0002
	)


	Permissions	Array
	(
		[0] => android.permission.INTERNET
		[1] => android.permission.ACCESS_NETWORK_STATE
		[2] => android.permission.CHANGE_NETWORK_STATE
		[3] => android.permission.ACCESS_WIFI_STATE
		[4] => android.permission.WRITE_EXTERNAL_STORAGE
		[5] => android.permission.RECEIVE_BOOT_COMPLETED
		[6] => android.permission.MANAGE_DOCUMENTS
		[7] => android.permission.GET_ACCOUNTS
		[8] => android.permission.MANAGE_ACCOUNTS
		[9] => android.permission.USE_CREDENTIALS
		[10] => com.google.android.providers.gsf.permission.READ_GSERVICES
		[11] => com.google.android.googleapps.permission.GOOGLE_AUTH
		[12] => com.google.android.googleapps.permission.GOOGLE_AUTH.youtube
		[13] => com.google.android.googleapps.permission.GOOGLE_AUTH.YouTubeUser
		[14] => com.google.android.c2dm.permission.RECEIVE
		[15] => android.permission.WAKE_LOCK
		[16] => android.permission.NFC
		[17] => android.permission.CAMERA
		[18] => com.google.android.youtube.permission.C2D_MESSAGE
	)

	Hardware-Features	Array
	(
		[0] => Array
			(
				[name] => android.hardware.camera
				[is_required] => false
			)

	)







    
