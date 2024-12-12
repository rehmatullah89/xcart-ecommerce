/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Popup controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

var popup = {};

/**
 * Properties
 */

// Loading status
popup.isLoading = false;

// Request type status - POST or GET
popup.isPostRequest = false;

// Current unblock event handler
popup.currentUnblockCallback = null;

// Identifier of the element displayed in the popup
popup.elementId = false;

/**
 * Methods
 */

// Load data to popup
popup.load = function(url, id, unblockCallback, timeout, noWait)
{

  var result = false;
  if (core.isRequesterEnabled) {
    var method = null;
    if (url.constructor == String) {
      method = 'loadByURL';

    } else if (url.constructor == HTMLFormElement) {
      method = 'loadByForm';

    } else if (url.constructor == HTMLAnchorElement) {
      method = 'loadByLink';

    } else if (url.constructor == HTMLButtonElement) {
      method = 'loadByButton';

    }

    if (method) {
      this.isLoading = true;
      this.currentUnblockCallback = unblockCallback;

      if (this.elementId == id) {
        // Reload popup content only
        this.shade();

      } else if (!noWait) {
        // Close current popup then open the new one
        this.openAsWait();
      }

      this.elementId = id ? id : null;

      this.isPostRequest = false;
      result = this[method](url, timeout);
    }
  }

  return result;
}

// Load by URL
popup.loadByURL = function(url, timeout)
{
  return core.get(
    this.preprocessURL(url),
    _.bind(this.postprocessRequest, this),
    null,
    {
      timeout: timeout
    }
  );
}

// Load by form element
popup.loadByForm = function(form)
{
  form = jQuery(form).get(0);

  form.setAttribute('action', this.preprocessURL(form.getAttribute('action')));

  return form ? form.submitBackground(_.bind(this.postprocessRequest, this)) : false;
}

// Load by link element
popup.loadByLink = function(link)
{
  link = jQuery(link).eq(0);

  var href = (1 == link.length && link.attr('href')) ? link.attr('href') : false;

  return href
    ? core.get(this.preprocessURL(href), _.bind(this.postprocessRequest, this))
    : false;
}

// Load by button element
popup.loadByButton = function(button)
{
  var result = false;

  button = jQuery(button);

  if (button.attr('onclick') && -1 !== button.attr('onclick').toString().search(/\.location[ ]*=[ ]*['"].+['"]/)) {

    // By onclick attribute
    var m = button.attr('onclick').toString().match(/\.location[ ]*=[ ]*['"](.+)['"]/);
    result = core.get(this.preprocessURL(m[1]), _.bind(this.postprocessRequest, this));

  } else if (button.data('location')) {

    // By kQuery data cell
    result = core.get(this.preprocessURL(button.data('location')), _.bind(this.postprocessRequest, this));

  } else if (0 < button.parents('form').length) {

    // By button's form
    result = this.loadByForm(jQuery(button).parents('form').eq(0));

  }

  return result;
}

// Preprocess URL
popup.preprocessURL = function(url)
{
  if (url && -1 == url.search(/only_center=1/)) {
    url += (-1 == url.search(/\?/) ? '?' : '&') + 'only_center=1';
  }

  return url;
}

// Postprocess request
popup.postprocessRequest = function(XMLHttpRequest, textStatus, data, isValid)
{
  if (XMLHttpRequest && XMLHttpRequest instanceof jQuery.Event && textStatus) {
    var event      = XMLHttpRequest;
    XMLHttpRequest = textStatus.XMLHttpRequest;
    data           = textStatus.data;
    isValid        = textStatus.isValid;
    textStatus     = textStatus.textStatus;
  }

  if (null !== this.elementId && !this.elementId) {
    return;
  }

  var responseStatus = 4 == XMLHttpRequest.readyState ? parseInt(XMLHttpRequest.getResponseHeader('ajax-response-status')) : 0;

  if (4 != XMLHttpRequest.readyState) {

    // Connection failed
    this.close();
    // TODO - add top message

  } else if (278 == responseStatus) {

    // Redirect
    this.close();
    var url = XMLHttpRequest.getResponseHeader('AJAX-Location');
    if (url) {
      self.location = url;

    } else {
      self.location.reload(true);
    }

  } else if (279 == responseStatus) {

    // Internal redirect
    var url = XMLHttpRequest.getResponseHeader('AJAX-Location');
    if (url) {
      this.load(url, this.elementId, this.currentUnblockCallback);

    } else {
      self.location.reload(true);
    }

  } else if (277 == responseStatus) {

    // Close popup in silence
    this.close();

  } else if (200 == XMLHttpRequest.status) {

    // Load new content
    this.unshade();
    this.place(data);
    core.trigger('afterPopupPlace', {'XMLHttpRequest': XMLHttpRequest, 'textStatus': textStatus, 'data': data, 'isValid': isValid});

  } else {

    // Loading failed
    this.close();

  }
}

// Place request data
popup.place = function(data)
{
  this.isLoading = false;

  if (false !== data) {
    data = jQuery(this.extractRequestData(data));
    this.assignHandlers(data);
    this.open(data);
  }
}

// Extract widget data
popup.extractRequestData = function(data)
{
  return data;
}

popup.assignHandlers = function(data)
{
  core.microhandlers.runAll(data);
}

popup.shade = function()
{
  var box = jQuery('.blockMsg .block-subcontainer');

  if (0 == jQuery(box).length) {
    return;
  }

  var overlay = jQuery(document.createElement('div'))
    .addClass('wait-overlay')
    .appendTo(box);
  var progress = jQuery(document.createElement('div'))
    .addClass('wait-overlay-progress')
    .appendTo(box);
  jQuery(document.createElement('div'))
    .appendTo(progress);

  overlay.width(box.outerWidth())
    .height(box.outerHeight());
}

popup.unshade = function()
{
  jQuery('.blockMsg .wait-overlay').remove();
}

// Popup post processing
popup.postprocess = function()
{
  jQuery('.blockMsg h1#page-title.title').remove();

  jQuery('.blockMsg form').commonController(
    'enableBackgroundSubmit',
    _.bind(this.freezePopup, this),
    _.bind(this.postprocessRequest, this)
  );
}

// Freeze popup content
popup.freezePopup = function()
{
  jQuery('.blockMsg form').each(
    function() {
      jQuery('button,input:image,input:submit', this).each(
        function() {
          if (!this.disabled) {
            this.temporaryDisabled = true;
            this.disabled = true;
        }
        }
      );
    }
  );

  this.shade();
}

// Unfreeze popup content
popup.unfreezePopup = function()
{
  jQuery('.blockMsg form').each(
    function() {
      jQuery('button,input:image,input:submit', this).each(
        function() {
          if (this.temporaryDisabled) {
            this.disabled = false;
            this.temporaryDisabled = true;
          }
        }
      );
    }
  );
}

// Open as wait box
popup.openAsWait = function()
{
  this.open('<div class="block-wait"><div></div></div>');
}

// Open-n-display popup
popup.open = function(box)
{
  if (box && 'undefined' != typeof(box.html)) {
    box = jQuery('<div></div>').append(box).html();
  }

  jQuery.blockUI(
    {
      message: '<a href="#" class="close-link"></a><div class="block-container"><div class="block-subcontainer">' + box + '</div></div>'
    }
  );

  jQuery('.blockMsg').css(
    {
      'z-index':  '1200000',
      'position': 'absolute'
    }
  );

  if (this.elementId) {
    jQuery('.blockMsg').addClass('BlockMsg-' + this.elementId);
  }

  this.reposition();

  // Add close handler
  var o = this;
  jQuery('.blockMsg a.close-link').click(
    function(event) {
      jQuery('form', jQuery(o)).each(function (index, elem) {
        jQuery(elem).validationEngine('hide');
      });
      o.close();
      return false;
    }
  );

  // Modify overlay
  jQuery('.blockOverlay')
    .addClass('popup-overlay')
    .attr('title', 'Click to unblock')
    .css(
      {
        'z-index':          '1100000',
        'background-color': 'inherit',
        'opacity':          'inherit'
      }
    )
    .click(
      function(event) {
        return o.close();
      }
    );

  this.postprocess();
}

// Reposition (center) popup
popup.reposition = function()
{
  var w = jQuery(window);
  var d = jQuery(document);
  var b = jQuery('.blockMsg');

  var l = Math.max(0, Math.round((w.width() - b.width()) / 2)) + d.scrollLeft();
  var t = Math.max(0, Math.round((w.height() - b.height()) / 2)) + d.scrollTop();

  jQuery('.blockMsg').css(
    {
      'left': l + 'px',
      'top':  t + 'px'
    }
  );
}

// Close popup
popup.close = function()
{
  jQuery.unblockUI();

  if (this.currentUnblockCallback && this.currentUnblockCallback.constructor == Function) {
    this.currentUnblockCallback();
  }

  this.elementId = null;
  this.currentUnblockCallback = null;
}

jQuery(document).ready(
  function() {
    if (jQuery.blockUI) {
      jQuery.blockUI.defaults.css =             {};
      jQuery.blockUI.defaults.centerX =         true;
      jQuery.blockUI.defaults.centerY =         true;
      jQuery.blockUI.defaults.bindEvents =      true;
      jQuery.blockUI.defaults.constrainTabKey = true;
      jQuery.blockUI.defaults.showOverlay =     true;
      jQuery.blockUI.defaults.focusInput =      true;
      jQuery.blockUI.defaults.fadeIn =          0;
      jQuery.blockUI.defaults.fadeOut =         0;
    }
  }
);

jQuery(window).resize(
  function(event) {
    popup.reposition();
  }
);
