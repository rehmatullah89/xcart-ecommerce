{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Order : total
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="order", weight="300")
 *}

<p class="total">{t(#Order Total X#,_ARRAY_(#total#^getOrderTotal())):h}</p>
