{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Vote bar
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="vote-bar">
  <ul>
    {foreach:getStars(),level,star}
      <li class="star-{level}">
        <span{if:star.full} class="full"{end:}>
        {if:star.percent}
          <img src="images/spacer.gif" alt="" style="width: {star.percent}%;" />
        {end:}
        </span>
      </li>
    {end:}
  </ul>
</div>
