<?php
/*
Plugin Name: My Photo Printing Plugin
Description: Plugin for handling image uploads and WooCommerce integration
Version: 1.0
Author: Your Name
*/

// Add menu item for the plugin
add_action('admin_menu', 'my_photo_printing_menu');
function my_photo_printing_menu() {
    add_menu_page('My Photo Printing Plugin', 'Photo Printing', 'manage_options', 'my-photo-printing-plugin', 'my_photo_printing_page');
}

// Display the plugin page
function my_photo_printing_page() {
    ?>
    <div class="wrap">
        <h1>My Photo Printing Plugin</h1>
        <form id="my-photo-printing-form" method="post" enctype="multipart/form-data">
            <label for="my-photo-printing-file">Select Image(s) to Upload:</label>
            <input type="file" name="my-photo-printing-file[]" multiple>
            <br>
            <?php
            // Get WooCommerce products and display as options
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC'
            );
            $products = new WP_Query($args);
            if ($products->have_posts()) :
            ?>
            <label for="my-photo-printing-product">Select Product:</label>
            <select name="my-photo-printing-product" id="my-photo-printing-product">
                <?php while ($products->have_posts()) : $products->the_post(); ?>
                    <option value="<?php the_ID(); ?>"><?php the_title(); ?></option>
                <?php endwhile; ?>
            </select>
            <br>
            <?php endif; wp_reset_postdata(); ?>
            <input type="submit" value="Upload and Add to Cart">
        </form>
    </div>
    <?php
}

// Handle form submission
add_action('init', 'my_photo_printing_handle_form_submission');
function my_photo_printing_handle_form_submission() {
    if (isset($_POST['my-photo-printing-product']) && isset($_FILES['my-photo-printing-file'])) {
        $product_id = $_POST['my-photo-printing-product'];
        $files = $_FILES['my-photo-printing-file'];
        // Loop through uploaded files and create a new WooCommerce product for each one
        foreach ($files['name'] as $index => $name) {
            $tmp_name = $files['tmp_name'][$index];
            $filetype = wp_check_filetype($name);
            $title = sanitize_title($name);
            $attachment = array(
                'post_mime_type' => $filetype['type'],
                'post_title' => $title,
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attachment_id = wp_insert_attachment($attachment, $tmp_name);
            $attachment_url = wp_get_attachment_url($attachment_id);
            $attachment_metadata = wp_generate_attachment_metadata($attachment_id, $attachment_url);
            wp_update_attachment_metadata($attachment_id, $attachment_metadata);
            $product = wc_get_product($product_id);
            // Add new product variation for the uploaded image
            $variation_data = array(
                'attributes' => array(
                    'pa_size' => '5x7'
                ),
                'regular_price' => '10.00',
                'image_id' => $attachment_id,
                'image_src' => $attachment_url,
                'image_title' => $title
            );
            $product->add_variation
