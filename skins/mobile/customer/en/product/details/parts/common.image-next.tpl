{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product details image box
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<a IF="product.getImages()&!product.countImages()=1" data-role="button" class="custom-arrow gallery-button" data-icon="custom-arrow-r" data-theme="a" data-iconpos="notext" data-mini="false" data-inline="true" href="javascript:void(0);" direction="next">{t(#Next#)}</a>