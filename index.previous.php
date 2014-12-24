
  window.num = 0;
  window.collected_data = [];

  $.get('list_apks.php', {'small': true, 'zip': true})
    .done(function (files_data) {
      files_data = unzip(files_data.zip);
      files_data = files_data.packages_without_json;


      $.each(files_data, function (index, element) {
        $.get('anlz_apk.php', {
          'file':  './resources/' + element,
          'small': true,
          'zip':   true
        }).done(function () {
          $.get('list_apks.php', {
            'small': true,
            'zip':   true
          }).done(function (files_data) {
            files_data = unzip(files_data.zip);
            files_data = files_data.packages_without_json;
            if (0 < files_data.length) return;
            //done
            $.get('all_json.php', {
              'small': true,
              'zip':   true
            }).done(function (alljson_data) {
              console.log(alljson_data);
            });
          });

          anlz_data = unzip(anlz_data.zip);

          window.collected_data.push(anlz_data);
          window.num -= 1;

          if (0 === window.num) {
            //time for template'ing..


            //get template, compile it on dom, embedd data in it.
            $.get('index.mustache.html')
              .done(function (template_data) {
                window.collected_data = {'files': window.collected_data}; //easier for mustache / handlebars to have all under sub-key named 'files'.

                //the items are shown in the dashboard as "name space left brack filename right brack", compare function will act as same pattern.
                window.collected_data.files.sort(function (a, b) { //ordered by package, for presentation in dashboard.
                  a = a.name + " (" + a.filename + ")";
                  b = b.name + " (" + b.filename + ")";
                  return a < b ? -1 : a > b ? 1 : 0;
                });

                window.template = Handlebars.compile(template_data); //let handlebars process the raw template.
                window.template = window.template(window.collected_data); //embedd the data into the template.

                $(document).ready(function () {
                  $('body').html(window.template); //set content, politely using jQuery's html, will not work w/ innerHTML..
                  document.querySelector('html').style.cssText = "";
                });

              });


          }
        });
      });
    });


//
//  /*
//   * load page's template
//   */
//  $.get('index.mustache.html', function (data) {
//    var template;
//    template = Handlebars.compile(data); //let handlebars process the raw template.
//    //template = template(files); //embedd the data into the template.
//  });

//
//  $.when(
//    $.getJSON('file_list.php', function (data) {
//      $(data.has_no_json).each(function (index, element) { //render for missing
//        $.getJSON('file_data.php?file=' + element);
//      });
//    })
//  )
//    .then(function () {
//      setTimeout(function () {
//        $.getJSON('file_list.php', function (data) {
//          console.log(data);
//        });
//
//      }, 20);
//    });
}(window));


/*
 1. *.apk -> ?
 2. for(*.apk as __.apk) do
 "__.apk".json exist? -> continue.
 "__.apk".json not-exist? -> ajax anlz_apk.php -> done? -> continue.
 3. ajax all_json.php
 4. process list-data in client side.

 //
 //  each APK file has a JSON file (and a set of images..)
 //  the existence of the JSON, means the analyse of the APK package has completed successfully ("done").
 //
 //  to prevent server overhead, and long runtime-script,
 //  I am using a "client-side" centralized technique:
 //    - list_apks.php
 //        returns a callback(plain/json) of the APKs in the ./resources/ folder,
 //        aggregated by if the APK has/has no JSON yet.
 //    - anlz_apk.php
 //        it gets a string, a APK-file name (for example: "game.apk"),
 //        and analyze, and dump the data as JSON (for example: "game.apk.json"), along images (its logo).
 //        just running this file (with correct file argument) will generate a JSON file.
 //
 //        anlz_apk.php may be called multiple times from client-side.
 //        after each call -> call list_apks.php (and see if all the APK files has a JSON file generated.
 //
 //        once all APK files has JSON file, time to run all_json.php...
 //    - all_json.php
 //        collect all (JSON files)'s content and return it (one request).
 */
