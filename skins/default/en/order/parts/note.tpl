{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order customer note
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order.children", weight="40")
 *}
<div IF="order.getNotes()" class="customer-note">
  <strong>{t(#Customer note#)}:</strong>
  <div>{order.notes}</div>
</div>
