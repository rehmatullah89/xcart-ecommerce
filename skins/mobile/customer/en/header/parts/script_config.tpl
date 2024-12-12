{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Head list children
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}


<script type="text/javascript">
var xliteConfig = {
  script:   '{getScript():h}',
  language: '{currentLanguage.getCode()}',
  form_id: '{xlite.formId}',
  form_id_name: '{%\XLite::FORM_ID%}'
};
var minicartTotalItems = {getCartQuantity()};

/**
 * Text variables
 */
var txtQuanity = '{t(#Quantity#)}',
    txtSortBy = '{t(#Sort by#)}';
    
/**
 * Product comparison
 */
var productComparison = {getComparisonData():h};

/**
 * Device detection
 */
var pagesTransition = '{getMobilePagesTransition()}';
</script>
