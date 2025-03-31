<?php

function mdm_settings_page() {
    add_menu_page(
        'More Divi Modules Settings',           // Page title
        'Divi Modules',                         // Menu title
        'manage_options',                       // Capability required to access the page
        'my_plugin_settings',                   // Menu slug
        'mdm_settings_page_html',               // Function to render the settings page
        'dashicons-index-card'                  // Icon
    );
}
add_action( 'admin_menu', 'mdm_settings_page' );

function mdm_settings_page_html() {
    // Get all modules with a settings.php file
    $modules = mdm_get_modules_with_settings();

    ?>
    <div class="wrap">
        <h1>More Divi Modules Settings</h1>
        <h2 class="nav-tab-wrapper">
            <?php foreach ($modules as $slug => $module): ?>
                <a href="#<?php echo esc_attr($slug); ?>" class="nav-tab"><?php echo esc_html($module['name']); ?></a>
            <?php endforeach; ?>
        </h2>
        <?php foreach ($modules as $slug => $module): ?>
            <div id="<?php echo esc_attr($slug); ?>" class="tab-content" style="display: none;">
                <?php include $module['path']; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <script>
        // Simple tab switching logic
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.nav-tab');
            const contents = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => {
                tab.addEventListener('click', function (e) {
                    e.preventDefault();
                    tabs.forEach(t => t.classList.remove('nav-tab-active'));
                    contents.forEach(c => c.style.display = 'none');
                    tab.classList.add('nav-tab-active');
                    document.querySelector(tab.getAttribute('href')).style.display = 'block';
                });
            });
            // Activate the first tab by default
            if (tabs.length > 0) {
                tabs[0].click();
            }
        });
    </script>
    <?php
}

function mdm_get_modules_with_settings() {
    $modules = [];
    $modules_dir = plugin_dir_path(__FILE__) . 'modules/'; // Adjust path if needed

    if (is_dir($modules_dir)) {
        $dirs = scandir($modules_dir);
        foreach ($dirs as $dir) {
            if ($dir === '.' || $dir === '..') {
                continue;
            }
            $settings_file = $modules_dir . $dir . '/settings.php';
            if (is_file($settings_file)) {
                $modules[$dir] = [
                    'name' => ucfirst($dir), // Use folder name as module name
                    'path' => $settings_file,
                ];
            }
        }
    }

    return $modules;
}