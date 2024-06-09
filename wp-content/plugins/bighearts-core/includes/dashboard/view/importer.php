<?php

$wp_content_url = trailingslashit(wp_normalize_path((is_ssl() ? str_replace('http://', 'https://', WGL_CORE_URL) : WGL_CORE_URL)));
$dir_name = 'includes/wgl_importer/';
$demo_data_url = trailingslashit($wp_content_url . $dir_name) . 'demo-data/';

echo '<div class="wgl_importer">';
$nonce = wp_create_nonce("wgl_importer");
$imported = false;
$field['wgl_demo_imports'] = apply_filters("wgl_importer_files", array());
echo '<div class="theme-browser">';
    echo '<div class="themes" data-nonce="' . $nonce . '">';
        if (!empty($field['wgl_demo_imports'])) {

            $get_licence = get_option('wgl_licence_validated');
            $get_licence = empty($get_licence) ? get_option(WGL_Theme_Verify::get_instance()->item_id) : $get_licence;

            if (!empty($get_licence)) {
                $extra_class = 'not-imported';
            } else {
                $extra_class = 'not-licence';
            }
            echo '<div class="themes__sidebar">';
            foreach ($field['wgl_demo_imports'] as $section => $imports) {
                if (empty($imports)) {
                    continue;
                }

                if ('full' === $imports['directory']
                ) {
                    echo '<div class="theme-screenshot">';
                    if (isset($imports['image']) && !empty($imports['image'])) {
                        echo '<img class="wgl_image" src="' . esc_attr(esc_url($demo_data_url . $imports['directory'] . '/' . $imports['image'])) . '"/>';
                    }
                    echo '</div>';
                }
            }
            echo '</div>';

            echo '<div class="themes__content">';

            echo '<div class="import__select">';
                echo '<h2>'.esc_html__('Demo Importer', 'bighearts-core').'</h2>';
                echo '<p>'.esc_html__('To avoid any conflicts an Installation should be done in clear environments.', 'bighearts-core').'</p>';
                echo '<p>'.esc_html__('Images are not included in demo import. If you want to use images from demo content, you should check the license for every single image.', 'bighearts-core').'</p>';
                                
                echo '<div class="wgl-importer-choose">';
                echo '<label class="control-label">', esc_html__('Import Option', 'bighearts-core'), '</label>';
                echo '<select class="form-control input-sm select2 wgl_import_option" name="wgl_import_option">';
                echo '<option value="all">', esc_html__('Entire demo data', 'bighearts-core'), '</option>';
                echo '<option value="partial">',  esc_html__('Partial', 'bighearts-core'), '</option>';
                echo '</select>';
                echo '</div>';

                foreach ($field['wgl_demo_imports'] as $section => $imports) {
                    if (empty($imports)) {
                        continue;
                    }

                    $class_directory = ' ' . $imports['directory'];
                    echo '<div class="wrap-importer ' . $extra_class . $class_directory . '" data-demo-id="' . esc_attr($section) . '">';
                    if ('pages' === $imports['directory']
                    ) {
                        echo '<div class="theme-list wgl-custom-pages">';
                        echo '<div class="container">';
                        echo '<label class="control-label">' . esc_html__('Which pages do you want to import?', 'bighearts-core') . '</label>';
                        echo '<select class="form-control input-sm select2 select2-multiple select2-custom-pages" multiple>';
                        foreach ($imports['custom_pages'] as $f) {
                            $f = str_replace('.xml', '', $f);
                            echo '<option value="' . $f . '">' . strtoupper($f) . '</option>';
                        }
                        echo '</select>';
                        echo '</div>';
                        echo '</div>';
                    }
                    echo '</div>';
                }

                echo '<div class="wrap-importer partial-options"><label class="checkbox-container">' . esc_html__('Widgets', 'bighearts-core') . '<input type="checkbox" id="widgets" name="widgets"><span class="checkmark"></span></label></div>';
                echo '<div class="wrap-importer partial-options"><label class="checkbox-container">' . esc_html__('Theme Options', 'bighearts-core') . '<input type="checkbox" id="options" name="options"><span class="checkmark"></span></label></div>';
                if (class_exists('RevSlider')) {
                    echo '<div class="wrap-importer partial-options"><label class="checkbox-container">' . esc_html__('Revolution Sliders', 'bighearts-core') . '<input type="checkbox" id="rev-slider" name="rev-slider"><span class="checkmark"></span></label></div>';
                }
                foreach ($field['wgl_demo_imports'] as $section => $imports) {
                    if (empty($imports)) {
                        continue;
                    }
                    if ('cpt' === $imports['directory']
                    ) { 
                        echo '<div class="wrap-importer partial-options сpt-wrapper">';
                        echo '<label class="control-label cpt-label__headings">' . esc_html__('Which Custom post types do you want to import?', 'bighearts-core') . '</label>';
                        foreach ($imports['cpt'] as $k => $f) {
                            $f = str_replace('.xml', '', $f);
                            echo '<label class="checkbox-container">' . esc_html__($f, 'bighearts-core') . '<input type="checkbox" id="'.esc_attr($f).'" name="'.esc_attr($f).'" data-folder="'.esc_attr($k).'"><span class="checkmark"></span></label>';
                        }
                        echo '</div>';
                    }
                }

                echo '<div class="theme-actions">';
                    echo '<div class="wgl-importer-buttons">';
                        if (!empty($get_licence)) {
                            echo '<span class="spinner">' . esc_html__('Please Wait...', 'bighearts-core') . '</span>';
                            echo '<span class="button-primary importer-button import-demo-data">' . __('Import Demo', 'bighearts-core') . '</span>';
                        }else{
                            echo '<span class="button-primary not-license"  data-url="'.esc_url( admin_url( 'admin.php?page=wgl-activate-theme-panel' ) ).'">' . __( 'Unlock', 'thepascal-core' ) . '</span>';
                        }
                    echo '</div>';
                echo '</div>';
                echo '<div class="overlay__import"></div>';
            echo '</div>';

            echo '<div class="importer_status clear" style="opacity:0;">';
                echo '<div class="progressbar">';
                    echo '<div class="progressbar_content" style="width: 0%;">';
                        echo '<div class="progressbar_value">0%</div>';
                    echo '</div>';
                    echo '<div class="progressbar_condition">';
                        echo '<div class="progressbar_filled" style="width: 0%;"></div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';

            echo '<div id="info-opt-info-success">';
                echo '<i class="fa fa-check"></i>';
                esc_html_e('Import is completed', 'bighearts-core');
            echo '</div>';

            echo '</div>';
        } else {
            echo "<h5>" . esc_html__('No Demo Data Provided', 'bighearts-core') . "</h5>";
        }
    echo '</div>';
echo '</div>';
echo '<div class="clear"></div>';
