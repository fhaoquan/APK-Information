(function (window) {
  "use strict";
  var
    template,
    unzip = function (zipped_data) {
      return JSON.parse(JXG.decompress(zipped_data));
    }
    ;

  window.num = 0;
  window.collected_data = [];

  $.get('list.php', {
    'small': true,
    'zip':   true
  }).done(function (files_data) {
    files_data = unzip(files_data.zip);

    window.num = files_data.length;

    $.each(files_data, function (index, element) {
      $.get('anlz.php', {
        'file': './resources/' + element,
        'small': true,
        'zip':   true
      }).done(function (anlz_data) {
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
