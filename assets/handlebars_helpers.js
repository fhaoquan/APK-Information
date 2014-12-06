/**
 * provide a reverse lookup for the keys, only handlebars.
 * -------------------------------------
 * if data is like this:
 *   mydata = {
 *     hello : "goodbye",
 *     foo : 1
 *   }
 * -------------------------------------
 *
 * -------------------------------------
 * use:
 *   {{#eachkeys mydata}}
 *     <div>key is {{this.key}}, value is {{this.value}}</div>
 *   {{/eachkeys}}
 * -------------------------------------
 *
 * -------------------------------------
 * result:
 *   <div>key is hello, value is goodbye</div>
 *   <div>key is foo, value is 1</div>
 * -------------------------------------
 */
Handlebars.registerHelper('eachkeys', function (context, options) {
    var fn, inverse, ret, empty, key;

    fn = options.fn;
    inverse = options.inverse;
    ret = "";

    empty = true;
    for (key in context) {
        empty = false;
        break;
    }

    if (!empty) {
        for (key in context) {
            ret = ret + fn({'key': key, 'value': context[key]});
        }
    } else {
        ret = inverse(this);
    }
    return ret;
});
