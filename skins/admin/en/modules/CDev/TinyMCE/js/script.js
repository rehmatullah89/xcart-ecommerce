/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * TinyMCE-based textarea controller
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

var configTinyMCE;

jQuery(function() {

  // Retrive configuration for the tinyMCE object from the PHP settings
  configTinyMCE = core.getCommentedData(jQuery('textarea.tinymce').eq(0).parent().eq(0));

  jQuery('textarea.tinymce').each(function (index, elem) {setSimpleTinymce(jQuery(elem));});
});


function setAdvancedTinymce(obj)
{
  return obj.tinymce({

    // General options
    theme : "advanced", // Use Advanced theme
    skin : "o2k7",
    content_css: configTinyMCE.contentCSS,

    plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

    // TODO ADD the upload images/files feature

    // Theme options
    theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,styleselect,formatselect,fontselect,fontsizeselect,|,link,unlink,anchor,image,cleanup,help,code,|,undo,redo,|,preview",

    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,justifyleft,justifycenter,justifyright,justifyfull,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,insertdate,inserttime,|,forecolor,backcolor,|,charmap,emotions,iespell,media,advhr,|,insertfile,insertimage",

    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,visualchars,nonbreaking,template,pagebreak,|,print,|,ltr,rtl,|,fullscreen,|,cite,abbr,acronym,del,ins,attribs",

    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,
    theme_advanced_resizing_min_height : 250,
    theme_advanced_resizing_min_width : 800,

    // Prevents automatic converting URLs to relative ones.
    convert_urls : false,
    setup : setupTinyMCE
  });
}

function setSimpleTinymce(obj)
{
  return obj.tinymce({
    // General options
    theme : "advanced", // Use Simple theme
    skin : "o2k7",
    content_css: configTinyMCE.contentCSS,

    plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

    // Theme options
    theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,styleselect,formatselect,fontselect,fontsizeselect,|,link,unlink,anchor,image,cleanup,help,code,|,undo,redo,|,preview",

    theme_advanced_buttons2 : "",

    theme_advanced_buttons3 : "",

    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,
    theme_advanced_resizing_min_height : 250,
    theme_advanced_resizing_min_width : 800,

    // Prevents automatic converting URLs to relative ones.
    convert_urls : false,
    setup : setupTinyMCE
  });
}


function setupTinyMCE(ed)
{
  ed.onInit.add(function(ed) {
    var $elem = ed.dom.select('img')[0];
    var newSrc = str_replace(configTinyMCE.shopURLRoot , configTinyMCE.shopURL, ed.dom.getAttrib($elem, 'src'));

    ed.dom.setAttrib($elem, 'src', newSrc);
  });

  ed.onPreProcess.add(function(ed) {
    var $elem = ed.dom.select('img')[0];
    var newSrc = str_replace(configTinyMCE.shopURL, configTinyMCE.shopURLRoot, ed.dom.getAttrib($elem, 'src'));

    ed.dom.setAttrib($elem, 'src', newSrc);
  });
}

//
// TODO refactor to class/object model
//

function cleanTiny(button)
{
  var obj;

  obj = jQuery('.tinymce', jQuery(button).parent().parent());

  obj.tinymce().remove();

  return obj;
}

function makeTinySimple(button)
{
  setSimpleTinymce(cleanTiny(button));
}

function makeTinyAdvanced(button)
{
  setAdvancedTinymce(cleanTiny(button));
}
