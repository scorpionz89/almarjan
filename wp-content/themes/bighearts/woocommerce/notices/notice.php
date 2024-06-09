<?php
/**
 * Show messages
 *
 * This template is overridden by WebGeniusLab team.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 8.5.0
 */

if ( ! defined( 'ABSPATH' ) ) { 
	exit; // Exit if accessed directly.
}

if ( ! $notices ) {
	return;
}

?>

<?php foreach ( $notices as $notice ) : ?>
	<div class="woocommerce-info bighearts_module_message_box type_info closable"<?php echo wc_get_notice_data_attr( $notice ); ?>>
		<div class="message_icon_wrap"><i class="message_icon "></i></div>
		<div class="message_content">
			<div class="message_text">
				<?php echo wc_kses_notice( $notice['notice'] ); ?>
			</div>
		</div>
		<span class="message_close_button"></span>
	</div>
<?php endforeach; ?>
