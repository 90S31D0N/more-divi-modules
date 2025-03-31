<?php

class ContactChipModule extends ET_Builder_Module
{

    public $slug = 'mdm-contact-chip-module'; //Unique Module Slug
    public $vb_support = 'on'; // Visual Builder Support Status

    //Module Footer Credit
    protected $module_credits = array(
        'module_uri' => '',
        'author' => 'Noël Schaller',
        'author_uri' => '',
    );

    public function init()
    {
        //Defining Module Name
        $this->name = esc_html__('Contact Chip', 'mdm-contact-chip-module');
    }

    //Module's Necessary Fields
    public function get_fields()
    {

        return array(
            'post_select' => [
                'label' => esc_html__('Select Person', 'mdm-contact-chip-module'),
                'type' => 'select',
                'options' => $this->get_custom_post_options(),
                'description' => esc_html__('Select a Person', 'mdm-contact-chip-module'),
                'toggle_slug' => 'main_content',
            ]
        );
    }

    //Module Rendering in php
    public function render($attrs, $content = null, $render_slug)
    {
        $post_id = $this->props['post_select'];
        // Get the post title
        $post_title = get_the_title($post_id);
        // Get the featured image URL
        $post_thumbnail_url = get_the_post_thumbnail_url($post_id, 'full'); // 'full' can be changed to 'thumbnail', 'medium', 'large', etc.

        $id = sprintf(
            '
            <div class="mdm-contact-chip">
                <img src="%2$s" alt="%1$s"></img>
                <h1>%1$s</h1>
            </div>
            ',
            esc_html__($post_title),
            esc_url($post_thumbnail_url)
        );

        $module = $id;
        return $module;

    }

    private function get_custom_post_options()
    {
        // Retrieve the saved post type from the settings
        $saved_post_type = get_option('mdm_contact_chip_post_type', 'post'); // Default to 'post' if no value is saved
        // Log the saved post type to the console
        //echo '<script>console.log("Saved Post Type: ' . esc_js($saved_post_type) . '");</script>';
        // Fetch posts of the selected post type
        $posts = get_posts([
            'post_type' => $saved_post_type, // Use the saved post type
            'numberposts' => -1,              // Fetch all posts
            'post_status' => 'publish',       // Only published posts
        ]);

        $options = [];

        if (!empty($posts)) {
            foreach ($posts as $post) {
                $options[$post->ID] = $post->post_title; // Map post ID to post title
            }
        } else {
            $options[''] = esc_html__('No posts found', 'divi-child');
        }

        return $options;
    }

}

new ContactChipModule;