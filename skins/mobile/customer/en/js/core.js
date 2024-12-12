/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Configurations
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

jQuery.extend(
  jQuery.support,
  {
    dynamicBaseTag: true
  }
);

var popupOpened = false;

var core = {
  getValueFromClass: function(obj, prefix)
  {
    var m = jQuery(obj)
      .attr('class')
      .match(new RegExp(prefix + '-([^ ]+)( |$)'));

    return m ? m[1] : null;
  },

  getCommentedData: function(obj, name)
  {
    var children = jQuery(obj).get(0).childNodes;
    var re = /DATACELL/;
    var m = false;

    for (var i = 0; i < children.length && !m; i++) {
      if (8 === children[i].nodeType && -1 != children[i].data.search(re)) {
        m = children[i].data.replace(re, '');
        m = m.replace(/^\n\r/, '').replace(/\r\n$/, '');
        try {
          m = eval('(' + m + ')');
        } catch(e) {
          m = false;
        }
      }
    }

    if (m && name) {
      m = 'undefined' == typeof(m[name]) ? null : m[name];
    }

    return m ? m : null;
  },

  get: function(url, callback)
  {
    return jQuery.ajax({
      url: url
    }).done(function( data ) {
      callback(data);
    });
  },

  loadWidgetsCollection: function (base, collectionName, params, restoreCallback)
  {
    this.get(
      URLHandler.buildURL(array_merge({'target': 'widgets_collection', 'action': 'get', 'widget': collectionName}, params)),
      function (data) {
        try {
          data = JSON.parse(data);
          for (key in data) {
            jQuery('.' + data[key].view, jQuery(base)).replaceWith(data[key].content);
            core.unshadowWidget(base, '.' + data[key].view);
            restoreCallback();
          }
        } catch (error) {
          console.log(error.message);
        }
      }
    );
  },

  shadowCollection: function (base, collection) {
    for (key in collection) {
      jQuery(collection[key], jQuery(base)).after('<div class="single-progress-mark"></div>');
    }
  },

  unshadowWidget: function (base, widget) {
    jQuery('.single-progress-mark', jQuery(widget, jQuery(base)).parent()).remove();
  },

  // Collections of the getters which return the parameters of the widgets to get via widgets collection process
  widgetsParamsGetters: {},

  registerWidgetsParamsGetter: function (widgetsId, getter)
  {
    if (!this.widgetsParamsGetters[widgetsId]) {
        this.widgetsParamsGetters[widgetsId] = [];
    }
    this.widgetsParamsGetters[widgetsId].push(getter);
  },

  getWidgetsParams: function (widgetsId, paramsToCall)
  {
    var params = [];
    for (var key in this.widgetsParamsGetters[widgetsId]) {
      params = array_merge(params, this.widgetsParamsGetters[widgetsId][key](paramsToCall));
    }
    return params;
  },

  widgetsTriggers: {},

  registerWidgetsTriggers: function (widgetsId, triggersGetter)
  {
    if (!this.widgetsTriggers[widgetsId]) {
      this.widgetsTriggers[widgetsId] = [];
    }
    this.widgetsTriggers[widgetsId].push(triggersGetter);
  },

  getWidgetsTriggers: function (widgetsId)
  {
    var triggers = [];
    for (var key in this.widgetsTriggers[widgetsId]) {
      triggers.push(this.widgetsTriggers[widgetsId][key]());
    }
    return triggers;
  },

  shadowWidgets: {},

  registerShadowWidgets: function (widgetsId, shadowGetter)
  {
    if ("undefined" === typeof(this.shadowWidgets[widgetsId])) {
      this.shadowWidgets[widgetsId] = [];
    }
    this.shadowWidgets[widgetsId].push(shadowGetter);
  },

  getShadowWidgets: function (widgetsId)
  {
    var shadow = [];
    for (var key in this.shadowWidgets[widgetsId]) {
      shadow.push(this.shadowWidgets[widgetsId][key]());
    }
    return array_unique(shadow);
  },

  widgetsTriggersBind: {},

  registerTriggersBind: function (widgetsId, triggersGetter)
  {
    if (!this.widgetsTriggersBind[widgetsId]) {
      this.widgetsTriggersBind[widgetsId] = [];
    }
    this.widgetsTriggersBind[widgetsId].push(triggersGetter);
  },

  callTriggersBind: function (widgetsId)
  {
    for (var key in this.widgetsTriggersBind[widgetsId]) {
      this.widgetsTriggersBind[widgetsId][key]();
    }
  },

  processUpdateWidgetsCollection: function (widgetsId, widgetsCollection, widgetsCollectionParamsCommon, base)
  {
    // Load widgets
    this.loadWidgetsCollection(
      base,
      widgetsCollection,
      array_merge(
        widgetsCollectionParamsCommon,
        this.getWidgetsParams(widgetsId, widgetsCollectionParamsCommon)
      ),
      function ()
      {
        core.callTriggersBind(widgetsId);
        jQuery('button', jQuery.mobile.activePage).button();
        jQuery('select', jQuery.mobile.activePage).selectmenu("refresh");
        jQuery('input[type="text"], input[type="number"]', jQuery.mobile.activePage).textinput();
      }
    );
  },

  isDebug: false,

  isReady: false,

  isRequesterEnabled: false,

  savedEvents: [],

  messages: jQuery({}),

  // Trigger common message
  trigger: function(name, params)
  {
    var result = true;

    name = name.toLowerCase();

    if (this.isReady) {

      if (this.isDebug && 'undefined' != typeof(window.console)) {
        if (params) {
          console.log('Fire \'' + name + '\' event with arguments: ' + var_export(params, true));

        } else {
          console.log('Fire \'' + name + '\' event');
        }
      }

      result = this.messages.trigger(name, [params]);

    } else {
      this.savedEvents.push(
        {
          name: name,
          params: params
        }
      );
    }

    return result;
  },

  // Bind on common messages
  bind: function(name, callback)
  {
    this.messages.bind(name.toLowerCase(), callback);
  },

  // Unbind on common messages
  unbind: function(name, callback)
  {
    this.messages.unbind(name.toLowerCase(), callback);
  }

};

/* vim: set ts=2 sw=2 sts=2 et: */

/*
 * More info at: http://phpjs.org
 *
 * This is version: 3.18
 * php.js is copyright 2010 Kevin van Zonneveld.
 *
 * Portions copyright Brett Zamir (http://brett-zamir.me), Kevin van Zonneveld
 * (http://kevin.vanzonneveld.net), Onno Marsman, Theriault, Michael White
 * (http://getsprink.com), Waldo Malqui Silva, Paulo Freitas, Jonas Raoni
 * Soares Silva (http://www.jsfromhell.com), Jack, Philip Peterson, Ates Goral
 * (http://magnetiq.com), Legaev Andrey, Ratheous, Alex, Martijn Wieringa,
 * Nate, lmeyrick (https://sourceforge.net/projects/bcmath-js/), Philippe
 * Baumann, Enrique Gonzalez, Webtoolkit.info (http://www.webtoolkit.info/),
 * Ash Searle (http://hexmen.com/blog/), travc, Jani Hartikainen, Carlos R. L.
 * Rodrigues (http://www.jsfromhell.com), Ole Vrijenhoek, WebDevHobo
 * (http://webdevhobo.blogspot.com/), T.Wild,
 * http://stackoverflow.com/questions/57803/how-to-convert-decimal-to-hex-in-javascript,
 * pilus, GeekFG (http://geekfg.blogspot.com), Rafal Kukawski
 * (http://blog.kukawski.pl), Johnny Mast (http://www.phpvrouwen.nl), Michael
 * Grier, Erkekjetter, d3x, marrtins, Andrea Giammarchi
 * (http://webreflection.blogspot.com), stag019, mdsjack
 * (http://www.mdsjack.bo.it), Chris, Steven Levithan
 * (http://blog.stevenlevithan.com), Arpad Ray (mailto:arpad@php.net), David,
 * Joris, Tim de Koning (http://www.kingsquare.nl), Marc Palau, Michael White,
 * Public Domain (http://www.json.org/json2.js), gettimeofday, felix, Aman
 * Gupta, Pellentesque Malesuada, Thunder.m, Tyler Akins (http://rumkin.com),
 * Karol Kowalski, Felix Geisendoerfer (http://www.debuggable.com/felix),
 * Alfonso Jimenez (http://www.alfonsojimenez.com), Diplom@t
 * (http://difane.com/), majak, Mirek Slugen, Mailfaker
 * (http://www.weedem.fr/), Breaking Par Consulting Inc
 * (http://www.breakingpar.com/bkp/home.nsf/0/87256B280015193F87256CFB006C45F7),
 * Josh Fraser
 * (http://onlineaspect.com/2007/06/08/auto-detect-a-time-zone-with-javascript/),
 * Martin (http://www.erlenwiese.de/), Paul Smith, KELAN, Robin, saulius, AJ,
 * Oleg Eremeev, Steve Hilder, gorthaur, Kankrelune
 * (http://www.webfaktory.info/), Caio Ariede (http://caioariede.com), Lars
 * Fischer, Sakimori, Imgen Tata (http://www.myipdf.com/), uestla, Artur
 * Tchernychev, Wagner B. Soares, Christoph, nord_ua, class_exists, Der Simon
 * (http://innerdom.sourceforge.net/), echo is bad, XoraX
 * (http://www.xorax.info), Ozh, Alan C, Taras Bogach, Brad Touesnard, MeEtc
 * (http://yass.meetcweb.com), Peter-Paul Koch
 * (http://www.quirksmode.org/js/beat.html), T0bsn, Tim Wiel, Bryan Elliott,
 * jpfle, JT, Thomas Beaucourt (http://www.webapp.fr), David Randall, Frank
 * Forte, Eugene Bulkin (http://doubleaw.com/), noname, kenneth, Hyam Singer
 * (http://www.impact-computing.com/), Marco, Raphael (Ao RUDLER), Ole
 * Vrijenhoek (http://www.nervous.nl/), David James, Steve Clay, Jason Wong
 * (http://carrot.org/), T. Wild, Paul, J A R, LH, strcasecmp, strcmp, JB,
 * Daniel Esteban, strftime, madipta, Valentina De Rosa, Marc Jansen,
 * Francesco, Stoyan Kyosev (http://www.svest.org/), metjay, Soren Hansen,
 * 0m3r, Sanjoy Roy, Shingo, sankai, sowberry, hitwork, Rob, Norman "zEh"
 * Fuchs, Subhasis Deb, josh, Yves Sucaet, Ulrich, Scott Baker, ejsanders,
 * Nick Callen, Steven Levithan (stevenlevithan.com), Aidan Lister
 * (http://aidanlister.com/), Philippe Jausions
 * (http://pear.php.net/user/jausions), Zahlii, Denny Wardhana, Oskar Larsson
 * Hogfeldt (http://oskar-lh.name/), Brian Tafoya
 * (http://www.premasolutions.com/), johnrembo, Gilbert, duncan, Thiago Mata
 * (http://thiagomata.blog.com), Alexander Ermolaev
 * (http://snippets.dzone.com/user/AlexanderErmolaev), Linuxworld, lmeyrick
 * (https://sourceforge.net/projects/bcmath-js/this.), Jon Hohle, Pyerre,
 * merabi, Saulo Vallory, HKM, ChaosNo1, djmix, Lincoln Ramsay, Adam Wallner
 * (http://web2.bitbaro.hu/), paulo kuong, jmweb, Orlando, kilops, dptr1988,
 * DxGx, Pedro Tainha (http://www.pedrotainha.com), Bayron Guevara, Le Torbi,
 * James, Douglas Crockford (http://javascript.crockford.com), Devan
 * Penner-Woelk, Jay Klehr, Kheang Hok Chin (http://www.distantia.ca/), Luke
 * Smith (http://lucassmith.name), Rival, Amir Habibi
 * (http://www.residence-mixte.com/), Blues (http://tech.bluesmoon.info/), Ben
 * Bryan, booeyOH, Dreamer, Cagri Ekin, Diogo Resende, Howard Yeend, Pul,
 * 3D-GRAF, jakes, Yannoo, Luke Godfrey, daniel airton wermann
 * (http://wermann.com.br), Allan Jensen (http://www.winternet.no), Benjamin
 * Lupton, davook, Atli ?or, Maximusya, Leslie Hoare, Bug?, setcookie, YUI
 * Library: http://developer.yahoo.com/yui/docs/YAHOO.util.DateLocale.html,
 * Blues at http://hacks.bluesmoon.info/strftime/strftime.js, Andreas,
 * Michael, Christian Doebler, Gabriel Paderni, Marco van Oort, Philipp
 * Lenssen, Arnout Kazemier (http://www.3rd-Eden.com), penutbutterjelly, Anton
 * Ongson, DtTvB (http://dt.in.th/2008-09-16.string-length-in-bytes.html),
 * meo, Greenseed, Yen-Wei Liu, mk.keck, William, rem, Jamie Beck
 * (http://www.terabit.ca/), Russell Walker (http://www.nbill.co.uk/),
 * Garagoth, Dino, Andrej Pavlovic, gabriel paderni, FGFEmperor, Scott Cariss,
 * Slawomir Kaniecki, ReverseSyntax, Mateusz "loonquawl" Zalega, Francois,
 * Kirk Strobeck, Billy, vlado houba, Jalal Berrami, date, Itsacon
 * (http://www.itsacon.net/), Martin Pool, Pierre-Luc Paour, ger, john
 * (http://www.jd-tech.net), mktime, Simon Willison
 * (http://simonwillison.net), Nick Kolosov (http://sammy.ru), marc andreu,
 * Arno, Nathan, Kristof Coomans (SCK-CEN Belgian Nucleair Research Centre),
 * Fox, nobbler, stensi, Matteo, Riddler (http://www.frontierwebdev.com/),
 * Tomasz Wesolowski, T.J. Leahy, rezna, Eric Nagel, Alexander M Beedie, baris
 * ozdil, Greg Frazier, Bobby Drake, Ryan W Tenney (http://ryan.10e.us), Tod
 * Gentille, Rafal Kukawski, FremyCompany, Manish, Cord, fearphage
 * (http://http/my.opera.com/fearphage/), Victor, Brant Messenger
 * (http://www.brantmessenger.com/), Matt Bradley, Luis Salazar
 * (http://www.freaky-media.com/), Tim de Koning, taith, Rick Waldron, Mick@el
 *
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL KEVIN VAN ZONNEVELD BE LIABLE FOR ANY CLAIM, DAMAGES
 * OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 *
 * @since   1.0.0
 */

function var_export (mixed_expression, bool_return) {
    // http://kevin.vanzonneveld.net
    // +   original by: Philip Peterson
    // +   improved by: johnrembo
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   input by: Brian Tafoya (http://www.premasolutions.com/)
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // -    depends on: echo
    // *     example 1: var_export(null);
    // *     returns 1: null
    // *     example 2: var_export({0: 'Kevin', 1: 'van', 2: 'Zonneveld'}, true);
    // *     returns 2: "array (\n  0 => 'Kevin',\n  1 => 'van',\n  2 => 'Zonneveld'\n)"
    // *     example 3: data = 'Kevin';
    // *     example 3: var_export(data, true);
    // *     returns 3: "'Kevin'"

    var retstr = '',
        iret = '',
        cnt = 0,
        x = [],
        i = 0,
        funcParts = [],
        idtLevel = arguments[2] || 2, // We use the last argument (not part of PHP) to pass in our indentation level
        innerIndent = '', outerIndent = '';

    var getFuncName = function (fn) {
        var name = (/\W*function\s+([\w\$]+)\s*\(/).exec(fn);
        if (!name) {
            return '(Anonymous)';
        }
        return name[1];
    };

    var _makeIndent = function (idtLevel) {
        return (new Array(idtLevel+1)).join(' ');
    };

    var __getType = function (inp) {
        var i = 0;
        var match, type = typeof inp;
        if (type === 'object' && inp !== null && inp.constructor && getFuncName(inp.constructor) === 'PHPJS_Resource') {
            return 'resource';
        }
        if (type === 'function') {
            return 'function';
        }
        if (type === 'object' && !inp) {
            return 'null'; // Should this be just null?
        }
        if (type === "object") {
            if (!inp.constructor) {
                return 'object';
            }
            var cons = inp.constructor.toString();
            match = cons.match(/(\w+)\(/);
            if (match) {
                cons = match[1].toLowerCase();
            }
            var types = ["boolean", "number", "string", "array"];
            for (i=0; i < types.length; i++) {
                if (cons === types[i]) {
                    type = types[i];
                    break;
                }
            }
        }
        return type;
    };
    var type = __getType(mixed_expression);

    if (type === null) {
        retstr = "NULL";
    } else if (type === 'array' || type === 'object') {
        outerIndent = _makeIndent(idtLevel-2);
        innerIndent = _makeIndent(idtLevel);
        for (i in mixed_expression) {
            var value = this.var_export(mixed_expression[i], true, idtLevel+2);
            // FIX - for non-HTML usage
            //value = typeof value === 'string' ? value.replace(/</g, '&lt;').replace(/>/g, '&gt;') : value;
            x[cnt++] = innerIndent+i+' => '+(__getType(mixed_expression[i]) === 'array' ? '\n' : '')+value;
        }
        iret = x.join(',\n');
        retstr = outerIndent+"array (\n"+iret+'\n'+outerIndent+')';
    }
    else if (type === 'function') {
        funcParts = mixed_expression.toString().match(/function .*?\((.*?)\) \{([\s\S]*)\}/);

        // For lambda functions, var_export() outputs such as the following:  '\000lambda_1'
        // Since it will probably not be a common use to expect this (unhelpful) form, we'll use another PHP-exportable
        // construct, create_function() (though dollar signs must be on the variables in JavaScript); if using instead
        // in JavaScript and you are using the namespaced version, note that create_function() will not be available
        // as a global
        retstr = "create_function ('"+funcParts[1]+"', '"+funcParts[2].replace(new RegExp("'", 'g'), "\\'")+"')";
    }
    else if (type === 'resource') {
        retstr = 'NULL'; // Resources treated as null for var_export
    } else {
        retstr = (typeof ( mixed_expression ) !== 'string') ? mixed_expression : "'" + mixed_expression.replace(/(["'])/g, "\\$1").replace(/\0/g, "\\0") + "'";
    }

    if (bool_return !== true) {
        this.echo(retstr);
        return null;
    } else {
        return retstr;
    }
}

function is_null (mixed_var) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: is_null('23');
    // *     returns 1: false
    // *     example 2: is_null(null);
    // *     returns 2: true

    return ( mixed_var === null );
}

function echo () {
    // http://kevin.vanzonneveld.net
    // +   original by: Philip Peterson
    // +   improved by: echo is bad
    // +   improved by: Nate
    // +    revised by: Der Simon (http://innerdom.sourceforge.net/)
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Eugene Bulkin (http://doubleaw.com/)
    // +   input by: JB
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: EdorFaus
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // %        note 1: If browsers start to support DOM Level 3 Load and Save (parsing/serializing),
    // %        note 1: we wouldn't need any such long code (even most of the code below). See
    // %        note 1: link below for a cross-browser implementation in JavaScript. HTML5 might
    // %        note 1: possibly support DOMParser, but that is not presently a standard.
    // %        note 2: Although innerHTML is widely used and may become standard as of HTML5, it is also not ideal for
    // %        note 2: use with a temporary holder before appending to the DOM (as is our last resort below),
    // %        note 2: since it may not work in an XML context
    // %        note 3: Using innerHTML to directly add to the BODY is very dangerous because it will
    // %        note 3: break all pre-existing references to HTMLElements.
    // *     example 1: echo('<div><p>abc</p><p>abc</p></div>');
    // *     returns 1: undefined

    // Fix: This function really needs to allow non-XHTML input (unless in true XHTML mode) as in jQuery

    var arg = '', argc = arguments.length, argv = arguments, i = 0, holder,
        win = this.window,
        d = win.document,
        ns_xhtml = 'http://www.w3.org/1999/xhtml',
        ns_xul = 'http://www.mozilla.org/keymaster/gatekeeper/there.is.only.xul'; // If we're in a XUL context

    var stringToDOM = function (str, parent, ns, container) {
        var extraNSs = '';
        if (ns === ns_xul) {
            extraNSs = ' xmlns:html="' + ns_xhtml + '"';
        }
        var stringContainer = '<' + container + ' xmlns="' + ns + '"' + extraNSs + '>' + str + '</'+container+'>';
        var dils = win.DOMImplementationLS, dp = win.DOMParser, ax = win.ActiveXObject;
        if (dils && dils.createLSInput && dils.createLSParser) {
            // Follows the DOM 3 Load and Save standard, but not
            // implemented in browsers at present; HTML5 is to standardize on innerHTML, but not for XML (though
            // possibly will also standardize with DOMParser); in the meantime, to ensure fullest browser support, could
            // attach http://svn2.assembla.com/svn/brettz9/DOMToString/DOM3.js (see http://svn2.assembla.com/svn/brettz9/DOMToString/DOM3.xhtml for a simple test file)
            var lsInput = dils.createLSInput();
            // If we're in XHTML, we'll try to allow the XHTML namespace to be available by default
            lsInput.stringData = stringContainer;
            var lsParser = dils.createLSParser(1, null); // synchronous, no schema type
            return lsParser.parse(lsInput).firstChild;
        }
        else if (dp) {
            // If we're in XHTML, we'll try to allow the XHTML namespace to be available by default
            try {
                var fc = new dp().parseFromString(stringContainer, 'text/xml');
                if (fc && fc.documentElement &&
                        fc.documentElement.localName !== 'parsererror' &&
                        fc.documentElement.namespaceURI !== 'http://www.mozilla.org/newlayout/xml/parsererror.xml') {
                    return fc.documentElement.firstChild;
                }
                // If there's a parsing error, we just continue on
            }
            catch(e) {
                // If there's a parsing error, we just continue on
            }
        }
        else if (ax) { // We don't bother with a holder in Explorer as it doesn't support namespaces
            var axo = new ax('MSXML2.DOMDocument');
            axo.loadXML(str);
            return axo.documentElement;
        }
        /*else if (win.XMLHttpRequest) { // Supposed to work in older Safari
            var req = new win.XMLHttpRequest;
            req.open('GET', 'data:application/xml;charset=utf-8,'+encodeURIComponent(str), false);
            if (req.overrideMimeType) {
                req.overrideMimeType('application/xml');
            }
            req.send(null);
            return req.responseXML;
        }*/
        // Document fragment did not work with innerHTML, so we create a temporary element holder
        // If we're in XHTML, we'll try to allow the XHTML namespace to be available by default
        //if (d.createElementNS && (d.contentType && d.contentType !== 'text/html')) { // Don't create namespaced elements if we're being served as HTML (currently only Mozilla supports this detection in true XHTML-supporting browsers, but Safari and Opera should work with the above DOMParser anyways, and IE doesn't support createElementNS anyways)
        if (d.createElementNS &&  // Browser supports the method
            (d.documentElement.namespaceURI || // We can use if the document is using a namespace
            d.documentElement.nodeName.toLowerCase() !== 'html' || // We know it's not HTML4 or less, if the tag is not HTML (even if the root namespace is null)
            (d.contentType && d.contentType !== 'text/html') // We know it's not regular HTML4 or less if this is Mozilla (only browser supporting the attribute) and the content type is something other than text/html; other HTML5 roots (like svg) still have a namespace
        )) { // Don't create namespaced elements if we're being served as HTML (currently only Mozilla supports this detection in true XHTML-supporting browsers, but Safari and Opera should work with the above DOMParser anyways, and IE doesn't support createElementNS anyways); last test is for the sake of being in a pure XML document
            holder = d.createElementNS(ns, container);
        }
        else {
            holder = d.createElement(container); // Document fragment did not work with innerHTML
        }
        holder.innerHTML = str;
        while (holder.firstChild) {
            parent.appendChild(holder.firstChild);
        }
        return false;
        // throw 'Your browser does not support DOM parsing as required by echo()';
    };


    var ieFix = function (node) {
        if (node.nodeType === 1) {
            var newNode = d.createElement(node.nodeName);
            var i, len;
            if (node.attributes && node.attributes.length > 0) {
                for (i = 0, len = node.attributes.length; i < len; i++) {
                    newNode.setAttribute(node.attributes[i].nodeName, node.getAttribute(node.attributes[i].nodeName));
                }
            }
            if (node.childNodes && node.childNodes.length > 0) {
                for (i = 0, len = node.childNodes.length; i < len; i++) {
                    newNode.appendChild(ieFix(node.childNodes[i]));
                }
            }
            return newNode;
        }
        else {
            return d.createTextNode(node.nodeValue);
        }
    };

    var replacer = function (s, m1, m2) {
        // We assume for now that embedded variables do not have dollar sign; to add a dollar sign, you currently must use {$$var} (We might change this, however.)
        // Doesn't cover all cases yet: see http://php.net/manual/en/language.types.string.php#language.types.string.syntax.double
        if (m1 !== '\\') {
            return m1 + eval(m2);
        }
        else {
            return s;
        }
    };

    this.php_js = this.php_js || {};
    var phpjs = this.php_js, ini = phpjs.ini, obs = phpjs.obs;
    for (i = 0; i < argc; i++ ) {
        arg = argv[i];
        if (ini && ini['phpjs.echo_embedded_vars']) {
            arg = arg.replace(/(.?)\{?\$(\w*?\}|\w*)/g, replacer);
        }

        if (!phpjs.flushing && obs && obs.length) { // If flushing we output, but otherwise presence of a buffer means caching output
            obs[obs.length-1].buffer += arg;
            continue;
        }

        if (d.appendChild) {
            if (d.body) {
                if (win.navigator.appName === 'Microsoft Internet Explorer') { // We unfortunately cannot use feature detection, since this is an IE bug with cloneNode nodes being appended
                    d.body.appendChild(stringToDOM(ieFix(arg)));
                }
                else {
                    var unappendedLeft = stringToDOM(arg, d.body, ns_xhtml, 'div').cloneNode(true); // We will not actually append the div tag (just using for providing XHTML namespace by default)
                    if (unappendedLeft) {
                        d.body.appendChild(unappendedLeft);
                    }
                }
            } else {
                d.documentElement.appendChild(stringToDOM(arg, d.documentElement, ns_xul, 'description')); // We will not actually append the description tag (just using for providing XUL namespace by default)
            }
        } else if (d.write) {
            d.write(arg);
        }/* else { // This could recurse if we ever add print!
            print(arg);
        }*/
    }
}

function htmlspecialchars (string, quote_style, charset, double_encode) {
    // http://kevin.vanzonneveld.net
    // +   original by: Mirek Slugen
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Nathan
    // +   bugfixed by: Arno
    // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    bugfixed by: Brett Zamir (http://brett-zamir.me)
    // +      input by: Ratheous
    // +      input by: Mailfaker (http://www.weedem.fr/)
    // +      reimplemented by: Brett Zamir (http://brett-zamir.me)
    // +      input by: felix
    // +    bugfixed by: Brett Zamir (http://brett-zamir.me)
    // %        note 1: charset argument not supported
    // *     example 1: htmlspecialchars("<a href='test'>Test</a>", 'ENT_QUOTES');
    // *     returns 1: '&lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt;'
    // *     example 2: htmlspecialchars("ab\"c'd", ['ENT_NOQUOTES', 'ENT_QUOTES']);
    // *     returns 2: 'ab"c&#039;d'
    // *     example 3: htmlspecialchars("my "&entity;" is still here", null, null, false);
    // *     returns 3: 'my &quot;&entity;&quot; is still here'
    var optTemp = 0,
        i = 0,
        noquotes = false;
    if (typeof quote_style === 'undefined' || quote_style === null) {
        quote_style = 2;
    }
    string = string.toString();
    if (double_encode !== false) { // Put this first to avoid double-encoding
        string = string.replace(/&/g, '&amp;');
    }
    string = string.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\s/g, '&nbsp;');

    var OPTS = {
        'ENT_NOQUOTES': 0,
        'ENT_HTML_QUOTE_SINGLE': 1,
        'ENT_HTML_QUOTE_DOUBLE': 2,
        'ENT_COMPAT': 2,
        'ENT_QUOTES': 3,
        'ENT_IGNORE': 4
    };
    if (quote_style === 0) {
        noquotes = true;
    }
    if (typeof quote_style !== 'number') { // Allow for a single string or an array of string flags
        quote_style = [].concat(quote_style);
        for (i = 0; i < quote_style.length; i++) {
            // Resolve string input to bitwise e.g. 'ENT_IGNORE' becomes 4
            if (OPTS[quote_style[i]] === 0) {
                noquotes = true;
            }
            else if (OPTS[quote_style[i]]) {
                optTemp = optTemp | OPTS[quote_style[i]];
            }
        }
        quote_style = optTemp;
    }
    if (quote_style & OPTS.ENT_HTML_QUOTE_SINGLE) {
        string = string.replace(/'/g, '&#039;');
    }
    if (!noquotes) {
        string = string.replace(/"/g, '&quot;');
    }

    return string;
}

function str_replace (search, replace, subject, count) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Gabriel Paderni
    // +   improved by: Philip Peterson
    // +   improved by: Simon Willison (http://simonwillison.net)
    // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   bugfixed by: Anton Ongson
    // +      input by: Onno Marsman
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    tweaked by: Onno Marsman
    // +      input by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   input by: Oleg Eremeev
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Oleg Eremeev
    // %          note 1: The count parameter must be passed as a string in order
    // %          note 1:  to find a global variable in which the result will be given
    // *     example 1: str_replace(' ', '.', 'Kevin van Zonneveld');
    // *     returns 1: 'Kevin.van.Zonneveld'
    // *     example 2: str_replace(['{name}', 'l'], ['hello', 'm'], '{name}, lars');
    // *     returns 2: 'hemmo, mars'
    var i = 0,
        j = 0,
        temp = '',
        repl = '',
        sl = 0,
        fl = 0,
        f = [].concat(search),
        r = [].concat(replace),
        s = subject,
        ra = Object.prototype.toString.call(r) === '[object Array]',
        sa = Object.prototype.toString.call(s) === '[object Array]';
    s = [].concat(s);
    if (count) {
        this.window[count] = 0;
    }

    for (i = 0, sl = s.length; i < sl; i++) {
        if (s[i] === '') {
            continue;
        }
        for (j = 0, fl = f.length; j < fl; j++) {
            temp = s[i] + '';
            repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
            s[i] = (temp).split(f[j]).join(repl);
            if (count && s[i] !== temp) {
                this.window[count] += (temp.length - s[i].length) / f[j].length;
            }
        }
    }
    return sa ? s : s[0];
}

function array_merge () {
    // Merges elements from passed arrays into one array
    //
    // version: 1109.2015
    // discuss at: http://phpjs.org/functions/array_merge
    // +   original by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Nate
    // +   input by: josh
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: arr1 = {"color": "red", 0: 2, 1: 4}
    // *     example 1: arr2 = {0: "a", 1: "b", "color": "green", "shape": "trapezoid", 2: 4}
    // *     example 1: array_merge(arr1, arr2)
    // *     returns 1: {"color": "green", 0: 2, 1: 4, 2: "a", 3: "b", "shape": "trapezoid", 4: 4}
    // *     example 2: arr1 = []
    // *     example 2: arr2 = {1: "data"}
    // *     example 2: array_merge(arr1, arr2)
    // *     returns 2: {0: "data"}
    var args = Array.prototype.slice.call(arguments),
        argl = args.length,
        arg,
        retObj = {},
        k = '',
        argil = 0,
        j = 0,
        i = 0,
        ct = 0,
        toStr = Object.prototype.toString,
        retArr = true;

    for (i = 0; i < argl; i++) {
        if (toStr.call(args[i]) !== '[object Array]') {
            retArr = false;
            break;
        }
    }

    if (retArr) {
        retArr = [];
        for (i = 0; i < argl; i++) {
            retArr = retArr.concat(args[i]);
        }
        return retArr;
    }

    for (i = 0, ct = 0; i < argl; i++) {
        arg = args[i];
        if (toStr.call(arg) === '[object Array]') {
            for (j = 0, argil = arg.length; j < argil; j++) {
                retObj[ct++] = arg[j];
            }
        }
        else {
            for (k in arg) {
                if (arg.hasOwnProperty(k)) {
                    if (parseInt(k, 10) + '' === k) {
                        retObj[ct++] = arg[k];
                    }
                    else {
                        retObj[k] = arg[k];
                    }
                }
            }
        }
    }
    return retObj;
}

function array_unique (inputArr) {
  // http://kevin.vanzonneveld.net
  // +   original by: Carlos R. L. Rodrigues (http://www.jsfromhell.com)
  // +      input by: duncan
  // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   bugfixed by: Nate
  // +      input by: Brett Zamir (http://brett-zamir.me)
  // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   improved by: Michael Grier
  // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
  // %          note 1: The second argument, sort_flags is not implemented;
  // %          note 1: also should be sorted (asort?) first according to docs
  // *     example 1: array_unique(['Kevin','Kevin','van','Zonneveld','Kevin']);
  // *     returns 1: {0: 'Kevin', 2: 'van', 3: 'Zonneveld'}
  // *     example 2: array_unique({'a': 'green', 0: 'red', 'b': 'green', 1: 'blue', 2: 'red'});
  // *     returns 2: {a: 'green', 0: 'red', 1: 'blue'}
  var key = '',
    tmp_arr2 = {},
    val = '';

  var __array_search = function (needle, haystack) {
    var fkey = '';
    for (fkey in haystack) {
      if (haystack.hasOwnProperty(fkey)) {
        if ((haystack[fkey] + '') === (needle + '')) {
          return fkey;
        }
      }
    }
    return false;
  };

  for (key in inputArr) {
    if (inputArr.hasOwnProperty(key)) {
      val = inputArr[key];
      if (false === __array_search(val, tmp_arr2)) {
        tmp_arr2[key] = val;
      }
    }
  }

  return tmp_arr2;
}


var URLHandler = {

  mainParams: {target: true, action: true},

  baseURLPart: 'cart.php?',
  argSeparator: '&',
  nameValueSeparator: '=',

  // Return query param
  getParamValue: function(name, params)
  {
    return name
      + this.nameValueSeparator
      + encodeURIComponent(typeof params[name] === 'boolean' ? Number(params[name]) : params[name]);
  },

  // Get param value for the target and action params
  getMainParamValue: function(name, params)
  {
    return URLHandler.getParamValue(name, params);
  },

  // Get param value for the remained params
  getQueryParamValue: function(name, params)
  {
    return URLHandler.getParamValue(name, params);
  },

  // Build HTTP query
  implodeParams: function(params, method)
  {
    result = '';
    isStarted = false;

    for (x in params) {

      if (isStarted) {
        result += this.argSeparator;
      } else {
        isStarted = true;
      }

      result += method(x, params);
    }

    return result;
  },

  // Implode target and action params
  implodeMainParams: function(params)
  {
    return this.implodeParams(params, this.getMainParamValue);
  },

  // Implode remained params
  implodeQueryParams: function(params)
  {
    return this.implodeParams(params, this.getQueryParamValue);
  },

  // Return some params
  getParams: function(params, toReturn)
  {
    var result = [];

    for (var x in toReturn) {
      if ('undefined' != typeof(params[x])) {
        result[x] = params[x];
      }
    }

    return result;
  },

  // Unset some params
  clearParams: function(params, toClear)
  {
    var result = [];

    for (var x in params) {
      if (!(x in toClear)) {
        result[x] = params[x];
      }
    }

    return result;
  },

  // Compose target and action
  buildMainPart: function(params)
  {
    return this.implodeMainParams(this.getParams(params, this.mainParams));
  },

  // Compose remained params
  buildQueryPart: function(params)
  {
    return this.argSeparator + this.implodeQueryParams(this.clearParams(params, this.mainParams));
  },

  // Compose URL
  buildURL: function(params)
  {
    return this.baseURLPart + this.buildMainPart(params) + this.buildQueryPart(params);
  }
};

function getAttributeValuesParams(product)
{
  var activeAttributeValues = '';
  var base = '.product-info-' + product.product_id;

  jQuery("ul.attribute-values input[type=checkbox]", jQuery(base).last()).each(function(index, elem) {
    activeAttributeValues += jQuery(elem).data('attribute-id') + '_';
    activeAttributeValues += jQuery(elem).is(":checked") ?  jQuery(elem).val() : jQuery(elem).data('unchecked');
    activeAttributeValues += ',';
  });

  jQuery("ul.attribute-values select", jQuery(base).last()).each(function(index, elem) {
    activeAttributeValues += jQuery(elem).data('attribute-id') + '_' + jQuery(elem).val() + ',';
  });

  return {
    attribute_values: activeAttributeValues
  };
}

/**
 * Product attributes triggers are inputs and selectors
 * of the attribute-values block
 *
 * @returns {String}
 */
function getAttributeValuesTriggers()
{
  return 'ul.attribute-values input, ul.attribute-values select';
}

function getAttributeValuesShadowWidgets()
{
  return '.widget-fingerprint-product-price';
}

function bindAttributeValuesTriggers()
{
  var handler = function () {
    core.trigger('update-product-page');
  };
  jQuery("ul.attribute-values input[type='checkbox']", jQuery.mobile.activePage).unbind('change').on('change', function (e) {handler()});
  jQuery("ul.attribute-values select", jQuery.mobile.activePage).unbind('change').on('change', function (e) {handler()});

  jQuery('span.currency', jQuery.mobile.activePage).html(
    jQuery('span.price.product-price', jQuery.mobile.activePage).html()
  );

  jQuery('.save-percent-container .save', jQuery.mobile.activePage).html(
    jQuery('.labels .market-price div', jQuery.mobile.activePage).html()
  );

  if (jQuery('.in-stock-label', jQuery.mobile.activePage).length > 0) {
    // The product IS IN STOCK
    jQuery('.product-quantity-text-top', jQuery.mobile.activePage).removeClass('in-stock').addClass('in-stock').html(
      jQuery('.in-stock-message', jQuery.mobile.activePage).html()
    );
    jQuery('.add-to-cart-button-top').removeClass('ui-disabled');
  } else {
    // The product IS OUT OF STOCK
    jQuery('.product-quantity-text-top', jQuery.mobile.activePage).removeClass('in-stock').html(
      jQuery('.out-of-stock-message', jQuery.mobile.activePage).html()
    );
    jQuery('.add-to-cart-button-top').removeClass('ui-disabled').addClass('ui-disabled');
  }
}

core.registerWidgetsParamsGetter('update-product-page', getAttributeValuesParams);
core.registerWidgetsTriggers('update-product-page', getAttributeValuesTriggers);
core.registerTriggersBind('update-product-page', bindAttributeValuesTriggers);
core.registerShadowWidgets('update-product-page', getAttributeValuesShadowWidgets);


function bindQuantityBoxTriggers()
{
}

function getQuantityBoxShadowWidgets()
{
  return '.widget-fingerprint-product-quantity, .widget-fingerprint-product-add-button';
}

core.registerTriggersBind('update-product-page', bindQuantityBoxTriggers);
core.registerShadowWidgets('update-product-page', getQuantityBoxShadowWidgets);

core.bind('update-product-page', function (event)
{
  var productId = core.getValueFromClass(jQuery('.product-details.hproduct', jQuery.mobile.activePage), 'product-info');
  core.processUpdateWidgetsCollection(
    'update-product-page',
    '\\XLite\\View\\ProductPageCollection',
    {product_id: productId},
    '.product-info-' + productId
  );
});

jQuery(document).bind('pagebeforeshow', function(e, data)
{
  // Common onready event handler
  core.isReady = true;
  core.trigger('load');
  for (var i = 0; i < core.savedEvents.length; i++) {
    core.trigger(core.savedEvents[i].name, core.savedEvents[i].params);
  }
  core.savedEvents = [];

  if (jQuery('.product-details.hproduct', jQuery.mobile.activePage).length > 0) {
    core.trigger('update-product-page');
  }

  /**
   * Status message
   */
  if (jQuery('#status-messages') && !popupOpened) {
    var popup_message = jQuery('#status-messages');
    // Popup initialization
    popup_message.popup({
      positionTo: 'window',
      transition: 'slidedown',
      history: false,
      tolerance: '0,0',
      // the overlay layer must have the same height as the active page
      afteropen: function () {jQuery('.ui-popup-screen.ui-overlay-a').height(jQuery.mobile.activePage.height());}
    });
    // Close button initialization
    popup_message.find("a:jqmData(role='button')").button();
    // Open popup
    popup_message.popup('open');
    // AutoClose after delay
    setTimeout(function() {
      popup_message.popup('close');
      popupOpened = true;
    }, 5000);
    // Listen to manual popup closing
    popup_message.bind({
      popupafterclose: function() {
        popupOpened = true;
      }
    });
  }
});

jQuery(document).bind('pageshow', function(event)
{
  // History back through the swipe right
  jQuery(document).on('swiperight', function () {
    var last = jQuery.mobile.urlHistory.getActive();
    jQuery.mobile.changePage(
      last.pageUrl,
    {
      data: '',
      reverse: true
    });
    window.history.back();
  });

  /**
   * Form submit handler
   */
  jQuery('form').on('submit', function() {
    jQuery.mobile.loading('show');
  });

  /**
   * Update minicart number
   */
  var minicart_jelly = jQuery('.minicart-total-items', jQuery.mobile.activePage);
  if (typeof minicartTotalItems !== 'undefined') {
    if (minicartTotalItems >= 1) {
      minicart_jelly.text(minicartTotalItems).show();
    }
  }

  jQuery('.shipping-address-form .field-required', jQuery.mobile.activePage).each(function (index, elem) {
    jQuery(elem).attr({'required': 1});
  });

  /**
   * Sort by select
   */
  var sort_selector = jQuery(this).find('select.sort-crit');
  var option_text = jQuery('select.sort-crit option[selected="selected"]', jQuery.mobile.activePage).last().html();

  sort_selector.prev('.ui-btn-inner').find('.ui-btn-text span').text(txtSortBy + ' ' + option_text);

  sort_selector.on('change', function(event) {
    event.stopPropagation();
    var option_text = jQuery(this).children('option:selected').html();
    jQuery(this).prev('.ui-btn-inner').find('.ui-btn-text span').text(txtSortBy + ' ' + option_text);
  });

  /**
   * Cart page qty select
   */
  var cartItemTimer;
  jQuery('.cart-item .quantity-box-container input', jQuery.mobile.activePage).on('change', function() {
    var o = this;
    if ('undefined' !== typeof cartItemTimer) {
      window.clearTimeout(cartItemTimer);
    }
    cartItemTimer = window.setTimeout(function () {
      jQuery(o).parents('form').submit();
    }, 1500);
  });

  /**
   * Scroll to checkout step
   */
  if (typeof jQuery('.steps .step.current', jQuery.mobile.activePage).get(0) !== 'undefined') {
    var step_scroll = jQuery('.steps .step.current', jQuery.mobile.activePage).offset().top;
    if (step_scroll) {
      jQuery.mobile.silentScroll(parseInt(step_scroll));
    }
  }

  /**
   * Billing address
   */
  if (jQuery('.billing-address-form', jQuery.mobile.activePage).get(0) !== 'undefined') {
    jQuery('.billing-address-form', jQuery.mobile.activePage).toggle(!jQuery('#same_address', jQuery.mobile.activePage).is(':checked'));
  }

  jQuery('#same_address', jQuery.mobile.activePage).click(
    function () {
      jQuery('.billing-address-form', jQuery.mobile.activePage).slideToggle();
    }
  );

  jQuery('.select-address .addresses > li').click(
    function() {
      var form = jQuery('form.select-address').eq(0)
      form.get(0).elements.namedItem('addressId').value = core.getValueFromClass(this, 'address')
      form.submit();
    }
  );

  /**
   * Terms conds agreement
   */
  jQuery('#place_order_agree').on('change', function() {
    jQuery('#place_order_button').toggleClass('ui-disabled', !jQuery(this).is(':checked'));
    jQuery('p.agree-note').toggle(!jQuery(this).is(':checked'));
  });

  jQuery('#create_profile', jQuery.mobile.activePage).on('click', function () {
    jQuery('.item-password', jQuery.mobile.activePage).slideToggle();
    if (jQuery(this).get(0).checked) {
      jQuery('.item-password input', jQuery.mobile.activePage).attr({'required': 'required', 'disabled': false});
    } else {
      jQuery('.item-password input', jQuery.mobile.activePage).attr({'required': false, 'disabled': 'disabled'});
    }
  });

  if (jQuery('#create_profile', jQuery.mobile.activePage).length > 0 && jQuery('#create_profile', jQuery.mobile.activePage).get(0).checked) {
    jQuery('.item-password', jQuery.mobile.activePage).slideDown();
    jQuery('.item-password input', jQuery.mobile.activePage).attr({'required': 'required', 'disabled': false});
  } else {
    jQuery('.item-password', jQuery.mobile.activePage).slideUp();
    jQuery('.item-password input', jQuery.mobile.activePage).attr({'required': false, 'disabled': 'disabled'});
  }

  /**
   * Shipping rates form
   */
  jQuery('.shipping-payment-method button').click(function () {
    jQuery('.shipping-payment-method input[name="sMethodId"]').val(jQuery('ul.shipping-rates input[type="radio"]:checked').val());
    jQuery('.shipping-payment-method input[name="pMethodId"]').val(jQuery('ul.payments input[type="radio"]:checked').val());
    return jQuery(this).closest('form').submit();
  });

  /**
   * Product comparison
   */
  if (jQuery('.add-to-compare.product .compare-button').get(0) !== 'undefined') {
    jQuery('.add-to-compare.product .compare-button').toggle(productComparison.count > 1);
  }

  jQuery('.add-to-compare.product .compare-checkbox input[type="checkbox"]').on('change', function() {
    var compareData = {
      target: 'productComparison',
      action: jQuery(this).is(':checked') ? 'add' : 'delete',
      product_id: jQuery(this).attr('data-id')
    };

    jQuery.ajax({
      type: 'POST',
      url: 'cart.php',
      data: compareData
    }).done(function(msg) {
      productComparison = jQuery.parseJSON(msg);
      jQuery('.compare-button').toggle(productComparison.count > 1);
    });
  });

  /**
   * States widgets fixes
   */
  jQuery('.country-selector', jQuery.mobile.activePage).each(function (index, elem) {
    var $country = jQuery('select', elem);
    var _statesList = core.getCommentedData(elem, 'statesList');
    var _stateSelectors = core.getCommentedData(elem, 'stateSelectors');
    var stateSelectorId = _stateSelectors['stateSelectorId'];
    var stateInputId = _stateSelectors['stateInputId'];
    var $state = jQuery('#' + stateSelectorId, jQuery.mobile.activePage);
    var $stateLine = $state.closest('li');
    var $stateInputLine = jQuery('#' + stateInputId, jQuery.mobile.activePage).closest('li');

    $country.bind('change', function() {
      var country = jQuery(this).val();
      var state = $state.val();
      var states;

      if ('undefined' !== typeof(_statesList[country])) {
        states = '<option value="" selected="selected">Select one</option>';
        for(var key in _statesList[country]) {
          states = states + '<option value="' + _statesList[country][key].key  + '">' + _statesList[country][key].name + '</option>';
        }
        $state.html(states);
        $state.val(state);
        $country.val(country);
        $stateLine.show();
        $stateInputLine.hide();
      } else {
        $stateLine.hide();
        $stateInputLine.show();
      }

      jQuery('select', jQuery.mobile.activePage).selectmenu("refresh");
    });

    $country.change();
  });

});

/**
 * Product Detailed Images popup and gallery
 */
function switchSlide(direction) {
  var slideShow = jQuery('.gallery li');
  var active = jQuery(slideShow).filter(function() {
    return (jQuery(this).css('display') != 'none') ? true : false;
  });
  var current_idx = jQuery(slideShow).index(jQuery(active));
  var length = jQuery(slideShow).size();
  var next;

  if (current_idx >= 0) {
    if (direction == 'next') {
      next = current_idx + 1;
      if (next > (length - 1))
        next = 0;
    } else if (direction == 'prev') {
      next = current_idx - 1;
      if (next == -1)
        next = (length - 1);
    }

    jQuery(slideShow).eq(current_idx).hide();
    jQuery(slideShow).eq(next).fadeIn(250);
  }
  return true;
}

jQuery(document).on("pageinit", function() {

  /**
   * Detailed images gallery
   */
  jQuery('.detailed-image').on({
    popupbeforeposition: function() {
      var maxHeight = jQuery(window).height() - 100 + 'px';
      var maxWidth = jQuery(window).width() - 100 + 'px';
      jQuery(".detailed-image img").css({'max-height': maxHeight, 'max-width': maxWidth});
    }
  });

  jQuery('.product-photo-box a.gallery-button').click(function() {
    switchSlide(jQuery(this).attr('direction'));
  });

  jQuery('.product-photo-box .gallery').on({
    swipeleft: function() {
      switchSlide('next');
    },
    swiperight: function() {
      switchSlide('prev');
    }
  });

  $(document).on(
    "popupafteropen",
    "#quick-search",
    function( event, ui ) {
      jQuery('a', jQuery(this)).button();
    }
  );
});

/**
 * onLoad functions
 */
jQuery(function() {
  if (window.history.length <= 2) {
    jQuery.mobile.activePage.find('a:jqmData(rel="back")').remove();
  }
  /**
   * Switch from mobile to common use
   */
  jQuery(window).on('resize pageshow orientationchange', function(event) {
    var viewport = {
      width: jQuery(window).width(),
      height: jQuery(window).height()
    };

    if ((viewport.width >= 1000 || viewport.height >= 1000)) {
      jQuery('.switch-mobile').css({
        'display': 'block'
      });
    } else {
      jQuery('.switch-mobile').hide();
    }
  });
});

/**
 * Pager function
 */
function changeNavPage(page)
{
  return !jQuery.mobile.changePage(page.href, {reloadPage: true});
}
