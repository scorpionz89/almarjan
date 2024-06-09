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
	exit;
}

if ( ! $notices ) {
	return;
}

?>

<?php foreach ( $notices as $notice ) : ?>
	<div class="woocommerce-message bighearts_module_message_box type_success"<?php echo wc_get_notice_data_attr( $notice ); ?> role="alert">
		<div class="message_icon_wrap"><i class="message_icon"></i></div>
		<div class="message_content">
			<div class="message_text">
				<?php echo wc_kses_notice( $notice['notice'] ); ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>