<?php

namespace DuplicatePage\PageBuilder;

use DuplicatePage\Contracts\IPageBuilder;

class ElementorBuilder implements IPageBuilder {
    public function isSupported($post_id): bool {
        return get_post_meta($post_id, '_elementor_edit_mode', true) === 'builder';
    }

    public function duplicateContent($from_id, $to_id): bool {
        // Copy Elementor data
        $elementor_data = get_post_meta($from_id, '_elementor_data', true);
        if (!empty($elementor_data)) {
            update_post_meta($to_id, '_elementor_data', wp_slash($elementor_data));
        }

        // Copy other Elementor meta
        $elementor_meta_keys = [
            '_elementor_edit_mode',
            '_elementor_template_type',
            '_elementor_version',
            '_elementor_pro_version',
            '_elementor_css'
        ];

        foreach ($elementor_meta_keys as $meta_key) {
            $meta_value = get_post_meta($from_id, $meta_key, true);
            if ($meta_value) {
                update_post_meta($to_id, $meta_key, $meta_value);
            }
        }

        return true;
    }
}
