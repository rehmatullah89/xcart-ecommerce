<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * X-Cart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.x-cart.com/license-agreement.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@x-cart.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not modify this file if you wish to upgrade X-Cart to newer versions
 * in the future. If you wish to customize X-Cart for your needs please
 * refer to http://www.x-cart.com/ for more information.
 *
 * @category  X-Cart 5
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

/*
 * Output a configuration checking page body
 */

if (!defined('XLITE_INSTALL_MODE')) {
    die('Incorrect call of the script. Stopping.');
}


function get_lc_config_file_description()
{
    return xtr(
        'lc_config_file_description', 
        array(
            ':dir'   => LC_DIR_CONFIG,
            ':file1' => constant('LC_DEFAULT_CONFIG_FILE'), 
            ':file2' => constant('LC_CONFIG_FILE'),
        )
    );
}

function get_lc_php_version_description()
{
    return xtr('lc_php_version_description', array(':phpver' => phpversion()));
}

function get_lc_php_disable_functions_description()
{
    return xtr('lc_php_disable_functions_description');
}

function get_lc_php_memory_limit_description()
{
    return xtr('lc_php_memory_limit_description', array(':minval' => constant('LC_PHP_MEMORY_LIMIT_MIN')));
}

function get_lc_php_pdo_mysql_description()
{
    return xtr('lc_php_pdo_mysql_description');
}

function get_lc_file_permissions_description($requirements)
{
    return $requirements['lc_file_permissions']['description'];
}

function get_lc_php_file_uploads_description()
{
    return xtr('lc_php_file_uploads_description');
}

function get_lc_php_upload_max_filesize_description()
{
    return xtr('lc_php_upload_max_filesize_description');
}

function get_lc_php_gdlib_description()
{
    return xtr('lc_php_gdlib_description');
}

function get_lc_php_phar_description()
{
    return xtr('lc_php_phar_description');
}

function get_lc_https_bouncer_description()
{
    return xtr('lc_https_bouncer_description');
}

function get_lc_xml_support_description()
{
    return xtr('lc_xml_support_description');
}

function get_lc_docblocks_support_description()
{
    return xtr('lc_docblocks_support_description');
}

?>

<div class="requirements-report">

<div class="requirements-list">

<?php

$reqsNotes = array();

// Go through steps list...
foreach ($steps as $stepData) {

    // Index for colouring table rows
    $colorNumber = '1';

?>

    <div class="section-title"><?php echo $stepData['title']; ?></div>

<?php

    // Go through requirements list of current step...
    foreach ($stepData['requirements'] as $reqName) {

        $reqData = $requirements[$reqName];

        $errorsFound = ($errorsFound || (!$reqData['status'] && $reqData['critical']));
        $warningsFound = ($warningsFound || (!$reqData['status'] && !$reqData['critical']));

?>

    <div class="list-row color-<?php echo $colorNumber; ?>">
        <div class="field-left"><?php echo $reqData['title']; ?> ... <?php echo $reqData['value']; ?></div>
        <div class="field-right">
<?php

        echo isset($reqData['skipped']) ? status_skipped() : status($reqData['status'], $reqName);

        if (!$reqData['status']) {
?>

            <img id="failed-image-<?php echo $reqName; ?>" class="link-expanded" style="display: none;" src="<?php echo $skinsDir; ?>images/arrow_red.png" alt="" />

<?php
        }
?>
        </div>
    </div>

<?php

        $colorNumber = ('2' === $colorNumber) ? '1' : '2';

        // Prepare data for requirement notes displaying
        $label = $reqName . '_description';
        $labelText = null;
        $funcname = 'get_' . $label;

        if (function_exists($funcname)) {
            $labelText = $funcname($requirements);

        } else {

            $labelText = xtr($label);

            if ($label === $labelText) {
                $labelText = null;
            }
        }

        if (!is_null($labelText)) {
            $reqsNotes[] = array(
                'reqname' => $reqName,
                'title'   => $stepData['error_msg'],
                'text'    => $labelText,
            );
        }

    } // foreach ($stepData['requirements']...

} // foreach ($steps...

?>


</div>

<div class="requirements-notes">

<div id="headerElement"></div>

<div id="detailsElement"></div>

<div id="status-report" class="status-report-box" style="display: none;">

    <div id="status-report-detailsElement"></div>

    <div class="status-report-box-text">
        <?php echo xtr('requirements_failed_text'); ?>
    </div>

    <input type="button" class="active-button" value="<?php echo xtr('Send a report'); ?>" onclick="javascript: document.getElementById('report-layer').style.display = 'block';" />

</div>

<div id="suppose-cloud" class="cloud-box" style="display: none;">

    <div class="grey-line">
        <div class="or-cloud"><i class="fa fa-cloud"></i><span>OR</span></div>
    </div>

    <div class="cloud-header"><?php echo xtr('Consider X-Cart Cloud'); ?></div>
    <div class="cloud-text"><?php echo xtr('The same solution. You can even customize it. Without installation hassle.'); ?></div>
    <a href="http://www.x-cart.com/x-cart-cloud" target="_blank"><?php echo xtr('View details'); ?></a>
</div>

<?php

foreach ($reqsNotes as $reqNote) {

?>

    <div id="<?php echo $reqNote['reqname']; ?>" style="display: none">
        <div id="<?php echo $reqNote['reqname']; ?>-error-title"><div class="error-title <?php echo $reqNote['reqname']; ?>"><?php echo $reqNote['title']; ?></div></div>
        <div id="<?php echo $reqNote['reqname']; ?>-error-text"><div class="error-text <?php echo $reqNote['reqname']; ?>"><?php echo $reqNote['text']; ?></div></div>
    </div>

<?php

}

?>

<div class="requirements-success" style="display: none;" id="test_passed_icon">
   <img class="requirements-success-image" src="<?php echo $skinsDir; ?>images/passed_icon.png" border="0" alt="" />
   <br />
   Passed
</div>

</div>

<div class="clear"></div>

</div>


<script type="text/javascript">
    var first_code = '<?php echo ($first_error) ? $first_error : ''; ?>';
    showDetails(first_code, <?php echo isHardError($first_error) ? 'true' : 'false'; ?>);
</script>

<?php

    if (!$requirements['lc_file_permissions']['status']) {

?>

<P>
<?php $requirements['lc_file_permissions']['description'] ?>
</P>

<?php

    }

	// Save report to file if errors found
	if ($errorsFound || $warningsFound) {

?>

        <script type="text/javascript">visibleBox("status-report", true);</script>

<?php

	}

    if (!$errorsFound && $warningsFound) {

?>

<div class="requirements-warning-text"><?php echo xtr('requirement_warning_text'); ?></div>

<span class="checkbox-field">
    <input type="checkbox" id="continue" onclick="javascript: setNextButtonDisabled(!this.checked);" />
    <label for="continue"><?php echo xtr('Yes, I want to continue the installation.'); ?></label>
</span>

<?php
    }
?>
