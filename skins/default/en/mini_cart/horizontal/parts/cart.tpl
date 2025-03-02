{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Horizontal minicart cart button block
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="minicart.horizontal.buttons", weight="5")
 *}
<widget IF="cart.checkCart()" class="\XLite\View\Button\Link" label="View cart" location="{buildURL(#cart#)}" style="action cart" />
<widget IF="!cart.checkCart()" class="\XLite\View\Button\Link" label="View cart" location="{buildURL(#cart#)}" style="action cart" disabled="true" />
