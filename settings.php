<?php

/**

 * PayPal payments Settings.
 
 *
 
 * Class that renders out the HTML for the settings screen and contains helpful
 
 * methods to simply the maintainance of the admin screen.
 
 *
 * @package		PayPal payments
 
 * @author		Jack Higgins <jack@teamwebusa.com>
 
 * @since		11-11-2011
 
 */
 
class Paypal_Payments_Settings
{
	private $plugin_options;
	private $currency_codes;
	private $donate_buttons;
	private $localized_buttons;

	public function set_options( $options, $code, $buttons, $loc_buttons )
	{
		$this->plugin_options = $options;
		$this->currency_codes = $code;
		$this->donate_buttons = $buttons;
		$this->localized_buttons = $loc_buttons;
	}

	public function render()
	{
?>
<div class=wrap>
    <h2>PayPal Payments</h2>
	
	<form method="post" action="">
	
	<?php wp_nonce_field('update-options'); ?>
	
	<?php // $pd_options = get_option($this->plugin_options); 
	
	$pd_options = $this->plugin_options;
	
	?>
    <table class="form-table">
	
    <tr valign="top">
	
    <th scope="row"><label for="paypal_account"><?php _e( 'PayPal Account', 'paypal-payments' ) ?></label></th>
	
    <td><input name="paypal_account" type="text" id="paypal_account" value="<?php echo $pd_options['paypal_account']; ?>" class="regular-text" />
	
	<span class="setting-description"><br/>
	
	<?php _e( 'Your PayPal email address or your PayPal secure merchant account ID.', 'paypal-payments' ) ?></span></td>
	
    </tr>
	
    <tr valign="top">
	
    <th scope="row"><label for="currency_code"><?php _e( 'Currency', 'paypal-payments' ) ?></label></th>
    <td><select name="currency_code" id="currency_code">
    <?php   if (isset($pd_options['currency_code'])) { $current_currency = $pd_options['currency_code']; } else { $current_currency = 'USD'; }
		foreach ( $this->currency_codes as $key => $code ) {
	        echo '<option value="'.$key.'"';
			if ($current_currency == $key) { echo ' selected="selected"'; }
			echo '>'.$code.'</option>';
		}?></select>
        <span class="setting-description"><br/><?php _e( 'The currency to use for the payments.', 'paypal-payments' ) ?></span></td>
    </tr>
    </table>
	<h3><?php _e( 'Optional Settings', 'paypal-payments' ) ?></h3>
    <table class="form-table">
    <tr valign="top">
    <th scope="row"><label for="page_style"><?php _e( 'Page Style', 'paypal-payments' ) ?></label></th>
    <td><input name="page_style" type="text" id="page_style" value="<?php echo $pd_options['page_style']; ?>" class="regular-text" /><span class="setting-description"><br/>
	<?php _e( 'Specify the name of a custom payment page style from your PayPal account profile.', 'paypal-payments' ) ?></span></td>
    </tr>
    <tr valign="top">
    <th scope="row"><label for="return_page"><?php _e( 'Return Page', 'paypal-payments' ) ?></label></th>
    <td><input name="return_page" type="text" id="return_page" value="<?php echo $pd_options['return_page']; ?>" class="regular-text" />
	<span class="setting-description"><br/><?php _e( 'URL to which the donator comes to after completing the donation; for example, a URL on your site that displays a "Thank you for your donation".', 'paypal-payments' ) ?></span></td>
    </tr>  
    </table>
	<h3><?php _e( 'Defaults', 'paypal-payments' ) ?></h3>
    <table class="form-table">
    <tr valign="top">
    <th scope="row"><label for="amount"><?php _e( 'Amount', 'paypal-payments' ) ?></label></th>
    <td><input name="amount" type="text" id="amount" value="<?php echo $pd_options['amount']; ?>" class="regular-text" /><span class="setting-description"><br/>
	<?php _e( 'The default amount for a donation (Optional).', 'paypal-payments' ) ?></span></td>
    </tr>
    <tr valign="top">
    <th scope="row"><label for="purpose"><?php _e( 'Purpose', 'paypal-payments' ) ?></label></th>
    <td><input name="purpose" type="text" id="purpose" value="<?php echo $pd_options['purpose']; ?>" class="regular-text" /><span class="setting-description"><br/>
	<?php _e( 'The default purpose of a donation (Optional).', 'paypal-payments' ) ?></span></td>
    </tr>
    <tr valign="top">
    <th scope="row"><label for="reference"><?php _e( 'Reference', 'paypal-payments' ) ?></label></th>
    <td><input name="reference" type="text" id="reference" value="<?php echo $pd_options['reference']; ?>" class="regular-text" />
	<span class="setting-description"><br/><?php _e( 'Default reference for the donation (Optional).', 'paypal-payments' ) ?></span></td>
    </tr>    
    </table>
	<h3><?php _e( 'Donation Button', 'paypal-payments' ) ?></h3>
    <table class="form-table">
    <tr>
	<th scope="row"><?php _e( 'Select Button', 'paypal-payments' ) ?></th>
	<td>
	<fieldset><legend class="hidden">PayPal Button</legend>
<?php
	$custom = TRUE;
	if (isset($pd_options['button_localized'])) { $button_localized = $pd_options['button_localized']; } else { $button_localized = 'en_US'; }
	if (isset($pd_options['button'])) { $current_button = $pd_options['button']; } else { $current_button = 'large'; }		foreach ( $this->donate_buttons as $key => $button ) {
		echo "\t<label title='" . esc_attr($key) . "'><input style='padding: 10px 0 10px 0;' type='radio' name='button' value='" . esc_attr($key) . "'";	
		if ( $current_button === $key ) { // checked() uses "==" rather than "==="	
			echo " checked='checked'";
			$custom = FALSE;
		}
		echo " /> <img src='" . str_replace('en_US', $button_localized, $button) . "' alt='" . $key  . "' style='vertical-align: middle;' /></label><br /><br />\n";
	}
	echo '	<label><input type="radio" name="button" value="custom"';
	checked( $custom, TRUE );
	echo '/> ' . __('Custom Button:', 'paypal-payments') . ' </label>';	
?>
	<input type="text" name="button_url" value="<?php echo $pd_options['button_url']; ?>" class="regular-text" /><br/>
	<span class="setting-description"><?php _e( 'Enter a URL to a custom donation button.', 'paypal-payments' ) ?></span>
	</fieldset>
	</td>
	</tr>
    <tr valign="top">
    <th scope="row"><label for="button_localized"><?php _e( 'Country and Language', 'paypal-payments' ) ?></label></th>
    <td><select name="button_localized" id="button_localized">
<?php   foreach ( $this->localized_buttons as $key => $localize ) {
	        echo '<option value="'.$key.'"';
			if ($button_localized == $key) { echo ' selected="selected"'; }
			echo '>'.$localize.'</option>';
		}?></select>	
        <span class="setting-description"><br/><?php _e( 'Localize the language and the country for the button (Updated after saving the settings).', 'paypal-payments' ) ?></span></td>
    </tr>    
    </table>
	<?php
	// Extras
	?>
	<h3><?php _e( 'Extras', 'paypal-payments' ) ?></h3>
	<p>Optional extra settings to fine tune the setup in certain scenarios.</p>
	<?php
	$this->checkbox(
		__('Disable PayPal Statistics', 'paypal-payments'),
		'disable_stats',
		$pd_options['disable_stats']);		
	
	?>	
    <p class="submit">
    <input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Changes', 'paypal-payments' ) ?>" />
    </p>
</div>
<?php
	}
	// -------------------------------------------------------------------------
	// HTML and Form element methods
	// -------------------------------------------------------------------------
	/**
	 * Checkbox.
	 * Renders the HTML for an input checkbox.
	 *
	 * @param	string	$label		The label rendered to screen
	 * @param	string	$name		The unique name to identify the input
	 * @param	boolean	$checked	If the input is checked or not
	 */
	private function checkbox( $label, $name, $checked )
	{
		printf( '<input type="checkbox" name="%s" value="true"', $name );
		if ($checked)
			echo ' checked';
		echo ' />';
		echo ' '.$label.'<br/>';
	}
}
