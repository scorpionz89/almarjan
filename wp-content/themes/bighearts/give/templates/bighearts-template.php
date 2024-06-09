<?php

namespace Give\Views\Form\Templates\Legacy;

use Give\Form\{
    Template,
    Template\Options
};

class BigHearts extends Template
{
    /**
     * @inheritDoc
     */
    public function getID()
    {
        /** Override default `legacy` template */
        return 'legacy';
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return esc_html__('BigHearts Template', 'bighearts');
    }

    /**
     * @inheritDoc
     */
    public function getImage()
    {
        return get_theme_file_uri('/give/templates/screenshot.jpg');
    }

    /**
     * @inheritDoc
     */
    public function getOptionsConfig()
    {
        return [
            'display_settings' => [
                'name' => esc_html__('Form Display', 'bighearts'),
                'fields' => [
                    Options::getDonationLevelsDisplayStyleField(),
                    Options::getDisplayOptionsField([
                        'modal' => esc_html__('Modal', 'bighearts'),
                        'reveal' => esc_html__('Reveal', 'bighearts'),
                    ]),
                    Options::getContinueToDonationFormField(),
                    Options::getCheckoutLabelField(),
                    Options::getFloatLabelsField(),
                    self::get_display_content_field(),
                    self::get_content_placement_field(),
                    Options::getFormContentField(),
                ],
            ],
        ];
    }

    public static function get_display_content_field()
    {
        $display_content = Options::getDisplayContentField();

        $display_content['default'] = 'enabled';

        return $display_content;
    }

    public static function get_content_placement_field()
    {
        $content_placement = Options::getContentPlacementField();

        $new_option_name = 'bighearts_after_form';
        $content_placement['options'] = [
            $new_option_name => esc_html__('After form (theme default)', 'bighearts')
        ] + $content_placement['options'];

        $content_placement['options']['give_pre_form'] = esc_html__('Within form, above fields', 'bighearts');
        $content_placement['options']['give_post_form'] = esc_html__('Within form, below fields', 'bighearts');

        $content_placement['default'] = $new_option_name;

        return $content_placement;
    }
}
