<?php

/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Responsive_Image_Sizes
 * @author    Steve Taylor
 * @license   GPL-2.0+
 */
$current_settings = $this->get_settings();

?>

<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<?php if ( isset( $_GET['done'] ) ) { ?>
		<div class="updated"><p><strong><?php _e( 'Settings updated successfully.' ); ?></strong></p></div>
	<?php } ?>

	<form method="post" action="">

		<?php wp_nonce_field( $this->plugin_slug . '_settings', $this->plugin_slug . '_settings_admin_nonce' ); ?>

		<table class="form-table">
			<thead>
				<tr>
					<th><?php _e( 'Size', $this->plugin_slug ); ?></th>
					<th><?php _e( 'Width', $this->plugin_slug ); echo ' (px)'; ?></th>
					<th><?php _e( 'Use?', $this->plugin_slug ); ?></th>
					<th><?php _e( 'For this width and below', $this->plugin_slug ); echo ' (px)'; ?></th>
				</tr>
			</thead>
			<tbody>

				<?php foreach ( $this->image_sizes as $size_name => $size_data ) { ?>

					<?php

					// Default "for" to the actual size width
					$size_for = isset( $current_settings['for_' . $size_name] ) && $current_settings['for_' . $size_name] ? $current_settings['for_' . $size_name] : $size_data['width'];

					?>

					<tr>
						<td><?php echo $size_name; ?></td>
						<td><?php echo $size_data['width']; ?></td>
						<td><input type="checkbox" name="<?php echo $this->plugin_slug . '_use[]'; ?>" value="<?php echo $size_name; ?>"></td>
						<td><input type="text" name="<?php echo $this->plugin_slug . '_' . $size_name; ?>" value="<?php echo $size_for; ?>"></td>
					</tr>

				<?php } ?>

			</tbody>
		</table>

		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save settings"></p>

	</form>

</div>
