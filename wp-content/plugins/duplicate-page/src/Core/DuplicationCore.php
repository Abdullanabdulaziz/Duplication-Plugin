<?php

namespace DuplicatePage\Core;

use DuplicatePage\Factory\PageBuilderFactory;

class DuplicationCore {
    private $pageBuilder;

    public function __construct() {
        $this->pageBuilder = null;

        // Hook into Elementor save process to apply word replacements after Elementor content is saved
        add_action('elementor/editor/after_save', [$this, 'apply_word_replacement_after_elementor_save'], 10, 2);
    }

    public function duplicatePage($post_id, $parent_id = null) {
        $post = get_post($post_id);
        if (!$post) return new \WP_Error('post_not_found', __('Original page not found.', 'duplicate-page'));

        $search_word = get_option('duplicate_page_search_word', '');
        $replace_word = get_option('duplicate_page_replace_word', '');

        // Insert the duplicated post
        $new_post_id = wp_insert_post([
            'post_author'  => get_current_user_id(),
            'post_content' => $this->applyWordReplacement($post->post_content, $search_word, $replace_word),
            'post_title'   => $post->post_title,
            'post_status'  => 'publish',
            'post_type'    => $post->post_type,
        ]);

        if (is_wp_error($new_post_id)) return $new_post_id;

        // Copy Elementor data and Post Meta with replacements
        $this->copyElementorData($post_id, $new_post_id, $search_word, $replace_word);
        $this->copyPostMeta($post_id, $new_post_id, $search_word, $replace_word);

        // Regenerate Elementor CSS for the duplicated page
        $this->regenerateElementorCSS($new_post_id);

        return $new_post_id;
    }

    private function applyWordReplacement($content, $search, $replace) {
        return empty($search) || empty($replace) ? $content : str_ireplace($search, $replace, $content);
    }

    private function copyElementorData($from_id, $to_id, $search_word, $replace_word) {
        $meta_keys = ['_elementor_data', '_elementor_page_settings'];

        foreach ($meta_keys as $key) {
            $data = get_post_meta($from_id, $key, true);

            if (!$data) continue;

            if (is_string($data)) {
                $decoded_data = json_decode($data, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $data = $this->applyWordReplacementInSerializedData($decoded_data, $search_word, $replace_word);
                    update_post_meta($to_id, $key, wp_slash(json_encode($data)));
                } else {
                    error_log("Invalid JSON in $key for Post ID $from_id");
                }
            } elseif (is_array($data)) {
                $data = $this->applyWordReplacementInSerializedData($data, $search_word, $replace_word);
                update_post_meta($to_id, $key, $data);
            }
        }
    }

    private function applyWordReplacementInSerializedData($data, $search, $replace) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->applyWordReplacementInSerializedData($value, $search, $replace);
            }
        } elseif (is_string($data)) {
            $data = str_ireplace($search, $replace, $data);
        }
        return $data;
    }

    private function copyPostMeta($from_id, $to_id, $search_word, $replace_word) {
        $meta_keys = get_post_custom_keys($from_id);
        if (empty($meta_keys)) return;

        foreach ($meta_keys as $key) {
            $meta_values = get_post_custom_values($key, $from_id);
            foreach ($meta_values as $value) {
                $value = maybe_unserialize($value);
                $value = $this->applyWordReplacementInSerializedData($value, $search_word, $replace_word);
                add_post_meta($to_id, $key, maybe_serialize($value));
            }
        }
    }

    private function regenerateElementorCSS($post_id) {
        if (!class_exists('\Elementor\Plugin')) {
            error_log('Elementor is not active.');
            return;
        }

        $elementor = \Elementor\Plugin::instance();

        if (isset($elementor->posts_css_manager)) {
            error_log("Regenerating Elementor CSS for Post ID: $post_id");

            // Regenerate Elementor CSS safely
            $elementor->posts_css_manager->clear_cache();
            $elementor->posts_css_manager->save_post_css($post_id);
        } else {
            error_log("Elementor CSS Manager not available.");
        }
    }

    public function apply_word_replacement_after_elementor_save($post_id, $data) {
        $search_word = get_option('duplicate_page_search_word', '');
        $replace_word = get_option('duplicate_page_replace_word', '');

        if ($search_word && $replace_word) {
            $content = get_post_field('post_content', $post_id);
            $content = str_ireplace($search_word, $replace_word, $content);
            wp_update_post(['ID' => $post_id, 'post_content' => $content]);

            $this->copyElementorData($post_id, $post_id, $search_word, $replace_word);
            $this->regenerateElementorCSS($post_id);
        }
    }
}
