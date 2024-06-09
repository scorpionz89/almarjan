<?php

defined('ABSPATH') || exit;

use BigHearts_Theme_Helper as BigHearts;

/**
 * Template for Page 404
 *
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package bighearts
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */

$layout_template = BigHearts::get_option('404_page_type');
if ('custom' === $layout_template) {
    $error_page_id = BigHearts::get_option('404_template_select');
    if (!empty($error_page_id)) {
      $error_page_id = intval($error_page_id);

      if (class_exists('Polylang') && function_exists('pll_current_language')) {
        $currentLanguage = pll_current_language();
        $translations = PLL()->model->post->get_translations($error_page_id);

        $polylang_id = $translations[$currentLanguage] ?? '';
        $error_page_id = $polylang_id ?: $error_page_id;
      }

      if (class_exists('SitePress')) {
        $error_page_id = wpml_object_id_filter($error_page_id, 'elementor_library', false, ICL_LANGUAGE_CODE);
      }

      if (class_exists('\Elementor\Core\Files\CSS\Post')) {
        (new \Elementor\Core\Files\CSS\Post($error_page_id))->enqueue();
      }
    }

  ob_start();
    if (did_action('elementor/loaded')) {
      echo \Elementor\Plugin::$instance->frontend->get_builder_content($error_page_id);
    }
  $render_template = ob_get_clean();

} else {

  $bg_color = BigHearts::get_option('404_page_main_bg_image')['background-color'];
  $bg_image = BigHearts::bg_render('404_page_main');

  $styles = !empty($bg_color) ? 'background-color: ' . $bg_color . ';' : "";
  $styles .= $bg_image ?: "";
  $styles = $styles ? ' style="' . esc_attr($styles) . '"' : "";

}

// Render
get_header();
if ('custom' === $layout_template) {

  echo BigHearts::render_html($render_template);

} else {

?>
<div class="wgl-container full-width">
  <div class="row">
    <div class="wgl_col-12">
      <section class="page_404_wrapper" <?php echo isset($styles) ? BigHearts::render_html($styles) : '' ?>>
        <div class="page_404_wrapper-container">
          <div class="row">
            <div class="wgl_col-12 wgl_col-md-12">
              <div class="main_404-wrapper">
                <div class="banner_404">
                  <img src="<?php echo esc_url(get_template_directory_uri() . "/img/404.png"); ?>" alt="<?php echo esc_attr__('404', 'bighearts'); ?>">
                </div>
                <h2 class="banner_404_title"><span><?php esc_html_e('Sorry We Can`t Find That Page!', 'bighearts'); ?></span></h2>
                <p class="banner_404_text">
                  <?php esc_html_e('The page you are looking for was moved, removed, renamed', 'bighearts'); ?>
                  <br class="d-xl-none">
                  <?php esc_html_e(' or never existed.', 'bighearts'); ?>
                </p>
                <div class="bighearts_404_search">
                  <?php get_search_form(); ?>
                </div>
                <div class="bighearts_404__button">
                  <a class="wgl-button btn-size-lg" href="<?php echo esc_url(home_url('/')); ?>">
                    <div class="button-content-wrapper">
                      <?php esc_html_e('TAKE ME HOME', 'bighearts'); ?>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>

<?php }
get_footer();