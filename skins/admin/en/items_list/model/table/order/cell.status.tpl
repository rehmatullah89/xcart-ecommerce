{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Status cell
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<span class="status-{entity.getStatus()}"><a href="{buildURL(#order#,##,_ARRAY_(#order_number#^entity.getOrderNumber()))}">{t(getColumnValue(column,entity))}</a></span>
