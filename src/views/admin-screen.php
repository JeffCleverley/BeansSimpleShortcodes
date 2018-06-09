<div class="wrap">
    <h2>
	<?php _e( 'Beans Simple Shortcodes', $this->plugin_textdomain ); ?>
	<span style="float: right; font-size: 10px; color: #888;">
        <?php
        _e( 'Version ', $this->plugin_textdomain );
        echo esc_attr( '1.0' );
        ?>
	</span>
</h2>
	<?php echo beans_options( 'beans_simple_shortcodes_settings' ); ?>
</div>