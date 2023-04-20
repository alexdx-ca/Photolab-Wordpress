<?php
/**
 * WooCommerce support functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Get product by SKU.
 *
 * @param string $sku Product SKU.
 * @return false|\WC_Product_Simple
 */
function my_plugin_get_product_by_sku( $sku ) {
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => 1,
		'meta_key'       => '_sku',
		'meta_value'     => $sku,
	);

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		$product = wc_get_product( $query->post->ID );
		return $product;
	}

	return false;
}

/**
 * Get product variation ID by attributes.
 *
 * @param int $product_id Product ID.
 * @param array $attributes Product attributes.
 * @return bool|int
 */
function my_plugin_get_product_variation_id( $product_id, $attributes ) {
	$product = wc_get_product( $product_id );
	if ( ! $product->is_type( 'variable' ) ) {
		return false;
	}

	$variations = $product->get_available_variations();
	foreach ( $variations as $variation ) {
		if ( $variation['attributes'] == $attributes ) {
			return $variation['variation_id'];
		}
	}

	return false;
}

/**
 * Create product variation.
 *
 * @param int $product_id Product ID.
 * @param array $attributes Product attributes.
 * @param array $data Product variation data.
 * @return bool|int|WP_Error
 */
function my_plugin_create_product_variation( $product_id, $attributes, $data ) {
	$product = wc_get_product( $product_id );
	if ( ! $product->is_type( 'variable' ) ) {
		return new WP_Error( 'invalid_product_type', __( 'Invalid product type.', 'my-plugin' ) );
	}

	$variation_data = array(
		'attributes'         => $attributes,
		'regular_price'      => $data['price'],
		'sku'                => $data['sku'],
		'manage_stock'       => false,
	);

	$variation_id = $product->get_matching_variation( $
