{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product details Weight main block
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="product.details.common.product-attributes.elements", weight="100")
 *}
<li IF="!getWeight()=0">
  <div><strong>{t(#Weight#)}</strong></div>
  <span>{getWeight()} {config.Units.weight_symbol}</span>
</li>
