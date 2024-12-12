{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product details information block
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<h3>{t(#Specification#)}:</h3>
<widget class="\XLite\View\Product\Details\Customer\CommonAttributes" product={product}  />

<ul class="extra-fields other-attributes">
  <list name="product.details.common.product-attributes.attributes" />
</ul>

<list name="product.details.page.tab.description.file-attachments" product="{product}" />
