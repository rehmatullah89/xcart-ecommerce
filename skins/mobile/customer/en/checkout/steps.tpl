{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Steps block
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="steps" data-role="collapsible-set" data-inset="false">
{foreach:getMobileSteps(),stepKey,stepWidget}
  <div
    data-role="collapsible" data-theme="{if:isCurrentStep(stepWidget.widget)}b{else:}c{end:}"data-content-theme="d"
    data-collapsed="{if:isCurrentStep(stepWidget.widget)}false{else:}true{end:}"
    class="step {stepKey}-step
    {if:!isCurrentStep(stepWidget.widget)}{if:!isCompletedStep(stepWidget.widget)}ui-disabled{end:}{end:}
    {if:isCurrentStep(stepWidget.widget)}current{end:}">
    <h4>{if:stepWidget.stepNumber}{stepWidget.stepNumber}. {end:}{t(stepWidget.widget.getTitle())}</h4>
    <div class="step-box">{stepWidget.widget.display()}</div>
  </div>
{end:}
</div>
