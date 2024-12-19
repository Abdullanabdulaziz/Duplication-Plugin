<?php

namespace DuplicatePage\Admin;

class AdminSettings {
    private $duplicationCore;
    private $ui;

    public function __construct($duplicationCore) {
        $this->duplicationCore = $duplicationCore;
        $this->ui = new AdminUI($this);

        add_action('admin_post_duplicate_page_from_settings', array($this, 'handleDuplicationFromSettings'));
    }

    public function registerMenuPage() {
        add_submenu_page(
            'options-general.php',
            __('Duplicate Page', 'duplicate-page'),
            __('Duplicate Page', 'duplicate-page'),
            'manage_options',
            'duplicate-page',
            array($this->ui, 'renderSettingsPage')
        );
    }

    public function handleDuplication($post_id) {
        if (!current_user_can('edit_posts')) {
            return new \WP_Error('permission_denied', __('You do not have permission to duplicate pages.', 'duplicate-page'));
        }

        return $this->duplicationCore->duplicatePage($post_id);
    }

    public function handleDuplicationFromSettings() {
        if (!isset($_POST['duplicate_page_nonce']) || 
            !wp_verify_nonce($_POST['duplicate_page_nonce'], 'duplicate_page_action')) {
            wp_die(__('Security check failed!', 'duplicate-page'));
        }

        if (!current_user_can('edit_posts')) {
            wp_die(__('You do not have permission to duplicate pages.', 'duplicate-page'));
        }

        $post_id = isset($_POST['post_to_duplicate']) ? absint($_POST['post_to_duplicate']) : 0;
        $search_word = isset($_POST['search_word']) ? sanitize_text_field($_POST['search_word']) : '';
        $replace_word = isset($_POST['replace_word']) ? sanitize_text_field($_POST['replace_word']) : '';

        if (!$post_id) {
            wp_die(__('No page selected to duplicate!', 'duplicate-page'));
        }

        // Store the search and replace words in options for later use
        update_option('duplicate_page_search_word', $search_word);
        update_option('duplicate_page_replace_word', $replace_word);

        // Debugging: Log the search and replace words
        error_log('Search Word: ' . $search_word);
        error_log('Replace Word: ' . $replace_word);

        $result = $this->handleDuplication($post_id);

        if (is_wp_error($result)) {
            wp_die($result->get_error_message());
        }

        wp_redirect(add_query_arg(
            array(
                'page' => 'duplicate-page',
                'duplicated' => '1'
            ),
            admin_url('options-general.php')
        ));
        exit;
    }
}
