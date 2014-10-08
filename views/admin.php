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
//echo '<pre>'; print_r( $current_settings ); echo '</pre>'; exit;

?>

<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<?php if ( isset( $_GET['done'] ) ) { ?>
		<div class="updated"><p><strong><?php _e( 'Settings updated successfully.', $this->plugin_slug ); ?></strong></p></div>
	<?php } ?>

	<form method="post" action="">

		<?php wp_nonce_field( $this->plugin_slug . '_settings', $this->plugin_slug . '_settings_admin_nonce' ); ?>

		<table class="form-table">
			<thead>
				<tr>
					<th><?php _e( 'Size', $this->plugin_slug ); ?></th>
					<th><?php _e( 'Width', $this->plugin_slug ); echo ' (px)'; ?></th>
					<th><?php _e( 'Height', $this->plugin_slug ); echo ' (px)'; ?></th>
					<th><?php _e( 'Cropped?', $this->plugin_slug ); ?></th>
					<th><?php _e( 'Use?', $this->plugin_slug ); ?></th>
					<th><?php _e( 'For this width and below', $this->plugin_slug ); echo ' (px)'; ?></th>
				</tr>
			</thead>
			<tbody>

				<?php foreach ( $this->image_sizes as $size_name => $size_data ) { ?>

					<tr>
						<td><?php echo $size_name; ?></td>
						<td><?php echo $size_data['width']; ?></td>
						<td><?php echo isset( $size_data['height'] ) ? $size_data['height'] : 0; ?></td>
						<td><?php echo isset( $size_data['crop'] ) ? '<div class="dashicons dashicons-yes"></div>' : '<div class="dashicons dashicons-no"></div>'; ?></td>
						<td><input type="checkbox" name="<?php echo $this->plugin_slug . '_use[]'; ?>" value="<?php echo $size_name; ?>"<?php checked( $current_settings['use_' . $size_name ] ); ?>></td>
						<td><input type="text" name="<?php echo $this->plugin_slug . '_' . $size_name; ?>" value="<?php echo $current_settings['for_' . $size_name]; ?>"></td>
					</tr>

				<?php } ?>

				<tr>
					<td colspan="4"><label for="<?php echo $this->plugin_slug . '_retina'; ?>"><input type="checkbox" name="<?php echo $this->plugin_slug . '_retina'; ?>" id="<?php echo $this->plugin_slug . '_retina'; ?>" value="1"<?php checked( $current_settings['retina'] ); ?>> <?php _e( 'Try to add retina sizes', $this->plugin_slug ); ?></label></td>
				</tr>

			</tbody>
		</table>

		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save settings', $this->plugin_slug ); ?>"></p>

	</form>

</div>
