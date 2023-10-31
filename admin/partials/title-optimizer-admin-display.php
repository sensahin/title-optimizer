<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://twitter.com/sengpt
 * @since      1.0.0
 *
 * @package    Title_Optimizer
 * @subpackage Title_Optimizer/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<h2>Welcome to Title Optimizer</h2>
<p>Use the power of OpenAI to enhance your WordPress titles.</p>
<form method="post" action="options.php">
    <?php settings_fields('title_optimizer_options_group'); ?>
    <label for="api_key">OpenAI API Key:</label>
    <input type="text" id="api_key" name="title_optimizer_api_key" value="<?php echo get_option('title_optimizer_api_key'); ?>" />
    <br/>
    <label for="enable">
        Enable
    </label>
    <input type="checkbox" id="enable" name="title_optimizer_enable" value="1" <?php checked(1, get_option('title_optimizer_enable'), true); ?> />
    <?php submit_button(); ?>
</form>

