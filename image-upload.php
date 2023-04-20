<?php
/**
 * Template Name: Image Upload Page
 *
 * The template for displaying the image upload page.
 *
 * @package your-plugin
 */

get_header(); ?>

<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">

    <?php while ( have_posts() ) : the_post(); ?>

      <?php get_template_part( 'template-parts/content', 'page' ); ?>

    <?php endwhile; // End of the loop. ?>

    <form id="image-upload-form" method="post" action="" enctype="multipart/form-data">

      <label for="image-file"><?php _e( 'Select image:', 'your-plugin' ); ?></label>
      <input type="file" name="image-file" id="image-file" />

      <label for="image-size"><?php _e( 'Select image size:', 'your-plugin' ); ?></label>
      <select name="image-size" id="image-size">
        <option value="small"><?php _e( 'Small', 'your-plugin' ); ?></option>
        <option value="medium"><?php _e( 'Medium', 'your-plugin' ); ?></option>
        <option value="large"><?php _e( 'Large', 'your-plugin' ); ?></option>
      </select>

      <label for="image-options"><?php _e( 'Select image options:', 'your-plugin' ); ?></label>
      <select name="image-options[]" id="image-options" multiple>
        <option value="black-and-white"><?php _e( 'Black and white', 'your-plugin' ); ?></option>
        <option value="sepia"><?php _e( 'Sepia', 'your-plugin' ); ?></option>
        <option value="border"><?php _e( 'Border', 'your-plugin' ); ?></option>
      </select>

      <button type="submit" name="image-upload-submit"><?php _e( 'Upload', 'your-plugin' ); ?></button>

    </form>

  </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
