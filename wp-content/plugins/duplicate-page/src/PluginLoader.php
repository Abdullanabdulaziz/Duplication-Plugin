<?php

namespace DuplicatePage;

use DuplicatePage\Core\DuplicationCore;
use DuplicatePage\Admin\AdminSettings;

class PluginLoader {
    private $admin;

    public function __construct() {
        // Initialize core components
        $duplicationCore = new DuplicationCore();
        $this->admin = new AdminSettings($duplicationCore);

        // Add menu items
        add_action('admin_menu', array($this->admin, 'registerMenuPage'));

        // Add duplicate link to row actions
        add_filter('post_row_actions', array($this, 'addDuplicateLink'), 10, 2);
        add_filter('page_row_actions', array($this, 'addDuplicateLink'), 10, 2);

        // Handle duplication
        if (isset($_GET['action']) && $_GET['action'] === 'duplicate' && isset($_GET['post'])) {
            add_action('admin_init', array($this, 'handleDuplicationRequest'));
        }
    }

    public function addDuplicateLink($actions, $post) {
        if (current_user_can('edit_posts')) {
            $nonce = wp_create_nonce('duplicate_page_' . $post->ID);
            $actions['duplicate'] = sprintf(
                '<a href="%s">%s</a>',
                esc_url(add_query_arg(
                    array(
                        'action' => 'duplicate',
                        'post' => $post->ID,
                        'duplicate_page_nonce' => $nonce
                    ),
                    admin_url('admin.php')
                )),
                __('Duplicate', 'duplicate-page')
            );
        }
        return $actions;
    }

    public function handleDuplicationRequest() {
        if (!isset($_GET['post']) || !isset($_GET['duplicate_page_nonce'])) {
            return;
        }

        $post_id = absint($_GET['post']);
        
        if (!wp_verify_nonce($_GET['duplicate_page_nonce'], 'duplicate_page_' . $post_id)) {
            wp_die(__('Security check failed!', 'duplicate-page'));
        }

        $result = $this->admin->handleDuplication($post_id);
        
        if (is_wp_error($result)) {
            wp_die($result->get_error_message());
        }

        wp_redirect(admin_url('post.php?action=edit&post=' . $result));
        exit;
    }
}
