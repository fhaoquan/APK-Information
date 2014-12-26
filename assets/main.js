/**
 * maintain "every APK has a JSON-data file" status.
 *   - listing APKs is done by calling:  list_apks.php (it shows which ones has/has no JSON, and sums if everyone has JSON: true/false-- for speedy check..).
 *   - ACTIVE: for each APK, generating JSON with the details analayzed by the APK is done by calling anlz_apk?file=______  -> generated ./resources/______.apk.json.
 *   - * every
 */
(function (window, unzip, log) {
  "use strict";

  function template_handle(template, data) {
    data.files.sort(function (a, b) { //ordered by package, for presentation in dashboard.
      a = a.name + " (" + a.filename + ")";
      b = b.name + " (" + b.filename + ")";
      return a < b ? -1 : a > b ? 1 : 0;
    });


    template = Handlebars.compile(template); //let handlebars process the raw template.
    template = template(data); //embed the DATA into the template.

    $('body').html(template);
  }

  function all_json(data) {
    var template;
    data = unzip(data);

    data = {'files': data}; //re-format the data, for easier HANDLEBARS management (mostly initial loop..)

    $.get('index.mustache.php', {'small': true, 'zip': true}).done(function (template) {
      template = unzip(template);
      //$.jStorage.set("template", template);

      template_handle.call(this, template.html, data);
    }); //done once..
//
//    template = $.jStorage.get("template");
//    if (!template) {
//      log("fetching template from remote-resource.");
//      $.get('index.mustache.php', {'small': true, 'zip': true}).done(function (template) {
//        template = unzip(template);
//        $.jStorage.set("template", template);
//
//        template_handle.call(this, template.html, data);
//      }); //done once..
//    } else {
//      log("taking template from local-storage.");
//      template_handle.call(this, template.html, data);
//    }
  }


  /**
   * try to lower the server-side CPU + Memory consumption,
   * request can fetch fewer files, based on naming,
   *   abcdef   -> a-f
   *   ghijkl   -> g-l
   *   mnopqr   -> m-r
   *   stuvwxyz -> s-z
   *
   * what happens in the server-side when using 'prefix=[a-f]' ?
   * ----- at 'all_json.php' only files matches /^[a-f].*\.json$/i contents is being read..
   */
  function is_done_check(data) {
    setTimeout(function () { //timeout helps preventing.. something...

      if (true === unzip(data).is_all_have_json) {
//        $.when(
//          $.get('all_json.php', {'small': true, 'zip': false, 'prefix': '[a-f]'}),
//          $.get('all_json.php', {'small': true, 'zip': false, 'prefix': '[g-l]'}),
//          $.get('all_json.php', {'small': true, 'zip': false, 'prefix': '[m-r]'}),
//          $.get('all_json.php', {'small': true, 'zip': false, 'prefix': '[s-z]'})
//        )
//          .done(function () {
//            var files = [];
//
//            $.each(arguments, function (index, element) {
//              $.each(element[0], function (index, element) {
//                files.push(element);
//              })
//            });
//
//            all_json(files);
//          });

        $.when(
          $.get('all_json.php', {'small': true, 'zip': true, 'prefix': '[a-f]'}),
          $.get('all_json.php', {'small': true, 'zip': true, 'prefix': '[g-l]'}),
          $.get('all_json.php', {'small': true, 'zip': true, 'prefix': '[m-r]'}),
          $.get('all_json.php', {'small': true, 'zip': true, 'prefix': '[s-z]'})
        )
          .done(function () {
            var files = [];

            $.each(arguments, function (index, element) {
              element = unzip(element[0]); //compatible! if you use zip:true or either zip:false

              $.each(element, function (index, element) {
                files.push(element);
              })
            });

            all_json(files);
          });

      }

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
   * wrap around the JXG decompression,
   * @param data   - if data has .zip its compressed, otherwise just return same.
   * @return {*}
   */
  function (data) {
    return ("undefined" !== typeof data['zip']) ? JSON.parse(JXG.decompress(data.zip)) : data;
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
