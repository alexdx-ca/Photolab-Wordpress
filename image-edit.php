<?php
/**
 * Template Name: Image Edit Page
 *
 * The template for displaying the image edit page.
 *
 * @package your-plugin
 */

get_header(); ?>

<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">

    <?php while ( have_posts() ) : the_post(); ?>

      <?php get_template_part( 'template-parts/content', 'page' ); ?>

    <?php endwhile; // End of the loop. ?>

    <?php
      $image_id = $_GET['image_id'];
      $image_size = $_GET['image_size'];
      $image_options = $_GET['image_options'];
    ?>

    <?php if ( $image_id ) : ?>

      <img src="<?php echo wp_get_attachment_image_src( $image_id, $image_size )[0]; ?>" />

      <?php if ( in_array( 'border', $image_options ) ) : ?>
        <img src="<?php echo your_plugin_add_border_to_image( $image_id ); ?>" />
      <?php endif; ?>

      <?php if ( in_array( 'black-and-white', $image_options ) ) : ?>
        <img src="<?php echo your_plugin_convert_image_to_black_and_white( $image_id ); ?>" />
      <?php endif; ?>

      <?php if
