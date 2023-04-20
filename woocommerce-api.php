<?php
/**
 * WooCommerce API integration.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class My_Plugin_WC_API
 */
class My_Plugin_WC_API {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'woocommerce_api_create_product', array( $this, 'create_product' ) );
	}

	/**
	 * Create product.
	 *
	 * @param array $data Request data.
	 * @return bool|int|WP_Error
	 */
	public function create_product( $data ) {
		$product = array(
			'name'        => $data['name'],
			'type'        => 'simple',
			'description' => $data['description'],
			'regular_price' => $data['price'],
			'stock_status' => 'instock',
			'manage_stock' => false,
		);

		$id = wc_create_product( $product );

		if ( is_wp_error( $id ) ) {
			return $id;
		}

		return $id;
	}
}
