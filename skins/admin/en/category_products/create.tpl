{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Category page template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<widget
  class="XLite\View\Button\Link"
  label="{t(#Add product#)}"
  location="{buildURL(#add_product#,##,_ARRAY_(#category_id#^getCategoryId()))}" />