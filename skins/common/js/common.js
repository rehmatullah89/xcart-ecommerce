/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Common functions
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */
var URLHandler = {

  mainParams: {target: true, action: true},

  baseURLPart: ('undefined' != typeof(window.xliteConfig) ? xliteConfig.script : 'admin.php') + '?',
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

/**
 * Columns selector
 */
jQuery(document).ready(
  function() {
    jQuery('input.column-selector').click(
      function(event) {
        if (!this.columnSelectors) {
          var idx = jQuery(this).parents('th').get(0).cellIndex;
          var table = jQuery(this).parents('table').get(0);
          this.columnSelectors = jQuery('tr', table).find('td:eq('+idx+') :checkbox');
        }

        this.columnSelectors.attr('checked', this.checked ? 'checked' : '');
      }
    );
  }
);

// Dialog

// Abstract open dialog
function openDialog(selector, additionalOptions)
{
  if (!jQuery('.ui-dialog ' + selector).length) {

    var options =  {
      dialogClass: 'popup',
      draggable:   false,
      modal:       true,
      resizable:   false,
      minWidth:    350,
      minHeight:   150,
      create:      function(event, ui) {
        jQuery('.ui-dialog').css(
          {
            'overflow': 'visible',
            'z-index':  10000
          }
        );
      },
      close:       function (event) {
        jQuery('form', jQuery('.ui-dialog ' + selector)).each(function (index, elem) {
          jQuery(elem).validationEngine('hide');
        });
      }
    }

    if (additionalOptions) {
      for (var k in additionalOptions) {

        options[k] = additionalOptions[k];
      }
    }

    // Grab title from h2/h1 tag
    var hTags = ['h2','h1'];
    var tagSelector;
    var elm;

    for (var i in hTags) {

      tagSelector = hTags[i] + ':first-child';
      elm = jQuery(selector + ' ' + tagSelector);

      if (!options.title && jQuery(elm).length && !jQuery(elm).hasClass('no-replace')) {

        options.title = jQuery(elm).html();

        jQuery(elm).remove();

        break;
      }
    }

    jQuery(selector).dialog(options);

  } else {

    jQuery(selector).dialog('open');
  }
}

// Loadable dialog
function loadDialog(url, dialogOptions, callback, link, $this)
{
  openWaitBar();

  var selector = 'tmp-dialog-' + (new Date()).getTime() + '-' + jQuery(link).attr('class').toString().replace(/ /g, '-');

  core.get(
    url,
    function(ajax, status, data) {
      if (data) {
        var div = jQuery(document.body.appendChild(document.createElement('div')))
          .hide()
          .html(jQuery.trim(data));

        if (1 == div.get(0).childNodes.length) {
          div = jQuery(div.get(0).childNodes[0]);
        }

        // Specific CSS class to manage this specific popup window
        div.addClass(selector);

        // Every popup window (even hidden one) has this one defined CSS class.
        // You should use this selector to manage any popup window entry.
        div.addClass('popup-window-entry');

        div.find('form').each(
          function() {
            new CommonForm(this);
          }
        );
        core.microhandlers.runAll(div);

        openDialog('.' + selector, dialogOptions);

        closeWaitBar();

        if (callback) {
          callback.call($this, '.' + selector, link);
        }
      }
    }
  );

  return '.' + selector;
}

// Load dialog by link
function loadDialogByLink(link, url, options, callback, $this)
{
  // Close every popup window opened before. Only one popup window is allowed to be displayed at once.
  jQuery('.popup-window-entry').dialog('close');

  if (!link.linkedDialog) {
    link.linkedDialog = loadDialog(url, options, callback, link, $this);

  } else {
    openDialog(link.linkedDialog, options, callback);
  }
}

function openWaitBar()
{
  if (typeof(window._waitBar) == 'undefined') {
    window._waitBar = document.body.appendChild(document.createElement('div'));
    var selector = 'wait-bar-' + (new Date()).getTime();
    window._waitBar.style.display = 'none';
    window._waitBar.className = 'wait-box ' + selector;

    var box = window._waitBar.appendChild(document.createElement('div'));
    box.className = 'box';

    window._waitBar = '.' + selector;
  }

  if (jQuery('.ui-dialog ' + window._waitBar).length) {
    jQuery(window._waitBar).dialog('open');

  } else {

    var options =  {
      dialogClass:   'popup',
      draggable:     false,
      modal:         true,
      resizable:     false,
      closeOnEscape: false,
      minHeight:     11,
      width:         200,
      open:          function() {
        jQuery(window._waitBar).css({
          'min-height': 'auto',
          'z-index':    999999
        });
        jQuery('.ui-dialog-titlebar', jQuery(window._waitBar).parents('.ui-dialog').eq(0)).remove();
      }
    };

    jQuery(window._waitBar).dialog(options);
  }
}

function closeWaitBar()
{
  if (typeof(window._waitBar) != 'undefined') {
    jQuery(window._waitBar).dialog('destroy');
  }
}

// Check for the AJAX support
function hasAJAXSupport()
{
  if (typeof(window.ajaxSupport) == 'undefined') {
    window.ajaxSupport = false;
    try {

      var xhr = window.ActiveXObject ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest();
      window.ajaxSupport = xhr ? true : false;

    } catch(e) { }
  }

  return window.ajaxSupport;
}

// Check list of checkboxes
function checkMarks(form, reg, lbl) {
  var is_exist = false;

  if (!form || form.elements.length == 0)
    return true;

  for (var x = 0; x < form.elements.length; x++) {
    if (
      form.elements[x].type == 'checkbox'
      && form.elements[x].name.search(reg) == 0
      && !form.elements[x].disabled
    ) {
      is_exist = true;

      if (form.elements[x].checked)
        return true;
    }
  }

  if (!is_exist)
    return true;

  if (lbl) {
    alert(lbl);

  } else if (lbl_no_items_have_been_selected) {
    alert(lbl_no_items_have_been_selected);

  }

  return false;
}

/*
  Parameters:
  checkboxes       - array of tag names
  checkboxes_form    - form name with these checkboxes
*/
function change_all(flag, formname, arr) {
  if (!formname)
    formname = checkboxes_form;
  if (!arr)
    arr = checkboxes;
  if (!document.forms[formname] || arr.length == 0)
    return false;
  for (var x = 0; x < arr.length; x++) {
    if (arr[x] != '' && document.forms[formname].elements[arr[x]] && !document.forms[formname].elements[arr[x]].disabled) {
         document.forms[formname].elements[arr[x]].checked = flag;
      if (document.forms[formname].elements[arr[x]].onclick)
        document.forms[formname].elements[arr[x]].onclick();
    }
  }
}

function checkAll(flag, form, prefix) {
  if (!form) {
    return;
  }

  if (prefix) {
    var reg = new RegExp('^' + prefix, '');
  }
  for (var i = 0; i < form.elements.length; i++) {
    if (
      form.elements[i].type == "checkbox"
      && (!prefix || form.elements[i].name.search(reg) == 0)
      && !form.elements[i].disabled
    ) {
      form.elements[i].checked = flag;
    }
  }
}

/*
  Opener/Closer HTML block
*/
function visibleBox(id, skipOpenClose)
{
  var elm1 = document.getElementById('open' + id);
  var elm2 = document.getElementById('close' + id);
  var elm3 = document.getElementById('box' + id);

  if(!elm3) {
    return false;
  }

  if (skipOpenClose) {
    elm3.style.display = (elm3.style.display == '') ? 'none' : '';

  } else if (elm1) {
    if (elm1.style.display == '') {
      elm1.style.display = 'none';

      if (elm2) {
        elm2.style.display = '';
      }

      elm3.style.display = 'none';
      jQuery('.DialogBox').css('height', '1%');

    } else {
      elm1.style.display = '';
      if (elm2) {
        elm2.style.display = 'none';
      }

      elm3.style.display = '';
    }
  }

  return true;
}

/**
 * Attach tooltip to some element on hover action
 */
function attachTooltip(elm, content) {
  jQuery(elm).each(
    function () {
      var block = this;
      var $block = jQuery(this);

      var hide = function () {
        $block.validationEngine('hide');
      }
      var startHide = function () {
        block.timeoutId = setTimeout(hide, 300);
      }
      var clearHide = function () {
        if ('undefined' != typeof(block.timeoutId) && block.timeoutId) {
          clearTimeout(block.timeoutId);
          block.timeoutId = false;
        }
      }

      $block.mouseover(
        function() {
          clearHide();
          jQuery('.formError').remove();
          $block.validationEngine('showPrompt', content, 'load', 'bottomLeft');
          var box = jQuery('.formError .formErrorContent');
          var l = box.offset().left;
          var w = jQuery(window).width();
          var bw = w - l;
          box.css('max-width', (bw - Math.round(bw * 0.1)) + 'px');
          jQuery('.formError').css('display', 'block');
          box.mouseover(clearHide);
          box.mouseout(startHide);
        }
      );

      $block.mouseout(startHide);
    }
  );
}

/**
 * State widget specific objects and methods (used in select_country.js )
 * @TODO : Move it to the one object after dynamic loading widgets JS implementation
 */
var statesList = [];
var stateSelectors = [];

function UpdateStatesList(base)
{
  var _stateSelectors;

  base = base || document;

  jQuery('.country-selector', base).each(function (index, elem) {
    statesList = array_merge(statesList, core.getCommentedData(elem, 'statesList'));
    _stateSelectors = core.getCommentedData(elem, 'stateSelectors');

    stateSelectors[_stateSelectors.fieldId] = new StateSelector(
      _stateSelectors.fieldId,
      _stateSelectors.stateSelectorId,
      _stateSelectors.stateInputId
    );
  });
}

jQuery(document).ready(
  function() {
    // Open warning popup
    core.microhandlers.add(
      'OverlayHeightResize',
      '*:first',
      function(event) {
        jQuery('.ui-widget-overlay').css('height', jQuery(document).height());
        jQuery('.ui-widget-overlay').css('width', jQuery('body').innerWidth());
      }
    );
});
