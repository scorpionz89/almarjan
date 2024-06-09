<?php
defined('ABSPATH') || exit;

/**
 * Template for displaying search forms
 *
 * @package bighearts
 * @author WebGeniusLab <webgeniuslab@gmail.com>
 * @since 1.0.0
 */

$unique_id = uniqid('search-form-');

echo '<form role="search" method="get" action="', esc_url(home_url('/')), '" class="search-form">',
    '<input',
        ' required',
        ' type="text"',
        ' id="', esc_attr($unique_id), '"',
        ' class="search-field"',
        ' placeholder="', esc_attr_x('Search &hellip;', 'placeholder', 'bighearts'), '"',
        ' value="', get_search_query(), '"',
        ' name="s"',
        '>',
    '<input class="search-button" type="submit" value="', esc_attr_e('Search', 'bighearts'), '">',
    '<i class="search__icon flaticon-loupe"></i>',
'</form>';
