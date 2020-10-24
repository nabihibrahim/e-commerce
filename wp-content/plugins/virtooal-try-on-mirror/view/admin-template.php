<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
echo "<h2>{$title}</h2>";

if ( ( $virtooal_username ) && ( $virtooal_apikey ) ) {
	echo '<p>' . 
		__( 'Seems like everything is OK!', 'virtooal-try-on-mirror' ) . '<br/>';
} else {
	echo "<p>" . 
		__( 'Signup for a free Virtooal account at' , 'virtooal-try-on-mirror' ).' <a href="https://www.virtooal.com/en/pricing-platforms" target="_blank">www.virtooal.com</a>,<br> ' .
		__( 'then copy and paste username and API key from', 'virtooal-try-on-mirror' ).' <a href="http://setup.virtooal.com/en/auth/profile" target="_blank">' .
		__( 'profile\'s page', 'virtooal-try-on-mirror' ).'</a> ' .
		__( 'into the form below:', 'virtooal-try-on-mirror' ).'</p>';
}
echo '<form action="'.$admin_url.'options.php" method="POST">';  
settings_fields( 'virtooal-try-on-mirror' );
?>
<table class="form-table">
    <tbody>
        <tr>
            <th scope="row">
                <label for="virtooal-username">Username<span class="woocommerce-help-tip"></span></label>
            </th>
            <td>
                <input name="virtooal-username" id="virtooal-username" class="regular-text" type="text" style="" value="<?php echo $virtooal_username;?>">
			</td>
        </tr>
		<tr>
            <th scope="row">
                <label for="virtooal-apikey">API key<span class="woocommerce-help-tip"></span></label>
            </th>
            <td>
                <input name="virtooal-apikey" id="virtooal-apikey" class="regular-text" type="text" style="" value="<?php echo $virtooal_apikey;?>">
			</td>
        </tr>
		<tr>
            <th scope="row">
                <label for="virtooal-automirror">Automirror<span class="woocommerce-help-tip"></span></label>
            </th>
            <td>
				<input name="virtooal-automirror" type="checkbox" value="1" <?php echo $virtooal_automirror?'checked':''; ?> /> Enable automirror
				<p class="description" id="new-admin-email-description">Enable the automirror only if you contacted <a href="mailto:support@virtooal.com">Virtooal support</a> regarding custom integration.</p>
			</td>
        </tr>
    </tbody>
</table>
<?php
do_settings_sections( 'virtooal-try-on-mirror' );
submit_button();
?>
</form>