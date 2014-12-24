/**
 * maintain "every APK has a JSON-data file" status.
 *   - listing APKs is done by calling:  list_apks.php (it shows which ones has/has no JSON, and sums if everyone has JSON: true/false-- for speedy check..).
 *   - ACTIVE: for each APK, generating JSON with the details analayzed by the APK is done by calling anlz_apk?file=______  -> generated ./resources/______.apk.json.
 *   - * every
 */
(function (window, unzip, log) {
  "use strict";

  function template_handle(template, data) {
    template = Handlebars.compile(template); //let handlebars process the raw template.
    template = template(data); //embed the DATA into the template.

    $('body').html(template);
  }

  function all_json(data) {
    var template;

    data = unzip(data);

    data = {'files': data}; //re-format the data, for easier HANDLEBARS management (mostly initial loop..)


    template = $.jStorage.get("template");
    if (!template) {
      log("fetching template from remote-resource.");
      $.get('index.mustache.php', {'small': true, 'zip': true}).done(function (template) {
        template = unzip(template);
        $.jStorage.set("template", template);

        template_handle.call(this, template.html, data);
      }); //done once..
    } else {
      log("taking template from local-storage.");
      template_handle.call(this, template.html, data);
    }
  }

  function is_done_check(data) {
    setTimeout(function () { //timeout helps preventing.. something...

      if (true === unzip(data).is_all_have_json)
        $.get('all_json.php', {'small': true, 'zip': true}).done(all_json); //done once..

    }, 50);
  }

  function anlz_apk(data) {
    $.get('list_apks.php', {'small': true, 'zip': true}).done(is_done_check); //list_apks.php - json for all?
  }

  function each_anlz(index, element) {
    $.get('anlz_apk.php', {'small': true, 'zip': true, 'nodata': true, 'file': element}).done(anlz_apk); //anlz_apk - creates jsons
  }

  function all_unprocessed_apks(data) {
    //if all JSON files already generated the following will run 0 times.
    $.each(unzip(data).packages_without_json, each_anlz); //each apk

    //so we can skip ahead and check "anyway", "if done?"
    is_done_check(data);
  }

  //start here
  (function () {
    $.get('list_apks.php', {
      'small': true,
      'zip':   true
    }).done(all_unprocessed_apks); //list_apks.php - packages_without_json
  }());

}(
  window,
  /**
   * UNZIP :: FUNCTION relays on jsxcompressor.min.js
   * wrap for JXG.decompress,
   * with support for my implementation of zipped data storage format {'zip':'......'}
   *
   * @param   {string} data - text based64 of binary gzipped compressed data.
   * @return  {string}
   */
  function (data) {
    if ("undefined" !== typeof data.zip)
      data = data.zip;

    return JSON.parse(JXG.decompress(data));
  },

  /**
   * LOG :: Function to wrap-around console.log
   * @param  {string} string
   * @return {string}
   */
  function (string) {
    console.log(string);
    return string;
  }
));
