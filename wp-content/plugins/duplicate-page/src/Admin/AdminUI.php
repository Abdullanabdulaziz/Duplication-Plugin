<?php

namespace DuplicatePage\Admin;

class AdminUI {
    private $admin;

    public function __construct($admin) {
        $this->admin = $admin;
        add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'));
    }

    public function enqueueScripts($hook) {
        if ('settings_page_duplicate-page' !== $hook) {
            return;
        }

        wp_enqueue_style(
            'duplicate-page-admin',
            plugins_url('assets/css/admin.css', dirname(dirname(__FILE__))),
            array(),
            '1.0.0'
        );
    }

    public function renderSettingsPage() {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        if (isset($_GET['duplicated'])) {
            add_settings_error(
                'duplicate_page',
                'success',
                __('Page duplicated successfully!', 'duplicate-page'),
                'success'
            );
        }
        ?>
        <div class="wrap">
            <h1><?php _e('Duplicate a Page', 'duplicate-page'); ?></h1>
            <?php settings_errors(); ?>

            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('duplicate_page_action', 'duplicate_page_nonce'); ?>
                <input type="hidden" name="action" value="duplicate_page_from_settings">
                
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('Page to Duplicate', 'duplicate-page'); ?></th>
                        <td>
                            <select name="post_to_duplicate" class="regular-text">
                                <?php
                                $pages = get_pages();
                                foreach ($pages as $page) {
                                    printf(
                                        '<option value="%d">%s</option>',
                                        esc_attr($page->ID),
                                        esc_html($page->post_title)
                                    );
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <!-- Word Replacement Section -->
                    <tr>
                        <th scope="row"><?php _e('Search Word', 'duplicate-page'); ?></th>
                        <td><input type="text" name="search_word" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e('Replacement Word', 'duplicate-page'); ?></th>
                        <td><input type="text" name="replace_word" class="regular-text"></td>
                    </tr>
                </table>

                <?php submit_button(__('Duplicate This Page', 'duplicate-page'), 'primary', 'duplicate_page_submit'); ?>
            </form>
        </div>
        <?php
    }
}
