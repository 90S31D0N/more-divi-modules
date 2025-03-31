<?php
// Fetch all public post types
$post_types = get_post_types(['public' => true], 'objects');

// Get the saved post type from the database
$saved_post_type = get_option('mdm_contact_chip_post_type', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mdm_contact_chip_post_type'])) {
    // Save the selected post type
    $saved_post_type = sanitize_text_field($_POST['mdm_contact_chip_post_type']);
    update_option('mdm_contact_chip_post_type', $saved_post_type);
    echo '<div class="updated"><p>Settings saved.</p></div>';
}
?>

<h1>Contact Chip</h1>
<p>Settings for the Contact Chip module.</p>

<form method="post">
    <label for="mdm_contact_chip_post_type">Select a Post Type:</label>
    <select name="mdm_contact_chip_post_type" id="mdm_contact_chip_post_type">
        <?php foreach ($post_types as $post_type): ?>
            <option value="<?php echo esc_attr($post_type->name); ?>" <?php selected($saved_post_type, $post_type->name); ?>>
                <?php echo esc_html($post_type->label); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>
    <button type="submit" class="button button-primary">Save Settings</button>
</form>