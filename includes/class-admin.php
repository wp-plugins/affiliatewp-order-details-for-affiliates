<?php

class AffiliateWP_Order_Details_For_Affiliates_Admin {
	
	public function __construct() {
		// update the affiliate
		add_action( 'affwp_update_affiliate', array( $this, 'update_affiliate' ), 0 );

		// add checkbox to edit affiliate screen
		add_action( 'affwp_edit_affiliate_bottom', array( $this, 'admin_field' ) );

		// add global option for access to order details
		add_filter( 'affwp_settings_misc', array( $this, 'order_details_access' ) );
	}

	/**
	 * Save share details option in user meta table
	 *
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function update_affiliate( $data ) {

		if ( empty( $data['affiliate_id'] ) ) {
			return false;
		}

		if ( ! current_user_can( 'manage_affiliates' ) ) {
			return;
		}

		$share_purchase_details = isset( $data['order_details_access'] ) ? $data['order_details_access'] : '';

		if ( $share_purchase_details ) {
			update_user_meta( affwp_get_affiliate_user_id( $data['affiliate_id'] ), 'affwp_order_details_access', $share_purchase_details );
		} else {
			delete_user_meta( affwp_get_affiliate_user_id( $data['affiliate_id'] ), 'affwp_order_details_access' );
		}
		
	}

	/**
	 * Add checkbox to edit affiliate page
	 *
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function admin_field( $affiliate ) {
		$affwp_odfa = affiliatewp_order_details_for_affiliates();

		// if all affiliates are allowed to access order details don't bother showing this option on the edit affiliate screen
		if ( $affwp_odfa->global_order_details_access() ) {
			return;
		}

		$checked = get_user_meta( $affiliate->user_id, 'affwp_order_details_access', true );
	?>
		<table class="form-table">
			<tr class="form-row form-required">
				<th scope="row">
					<label for="order-details-access"><?php _e( 'Order Details Access', 'affiliatewp-order-details-for-affiliates' ); ?></label>
				</th>
				<td>
					<input type="checkbox" name="order_details_access" id="order-details-access" value="1" <?php checked( $checked, 1 ); ?> />
					<p class="description"><?php _e( 'Allow affiliate to see the order details for each referral on their affiliate dashboard.', 'affiliatewp-order-details-for-affiliates' ); ?></p>
				</td>
			</tr>
		</table>

	<?php		
	}

	/**
	 * Option to globally allow all affiliates to access order details
	 *
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function order_details_access( $fields ) {
		
		$fields['order_details_access'] = array(
			'name' => __( 'Allow Global Access To Order Details', 'affiliatewp-order-details-for-affiliates' ),
			'desc' => __( 'Check this box if you would like all affiliates to have access to order details.', 'affiliatewp-order-details-for-affiliates' ),
			'type' => 'checkbox'
		);

		return $fields;
	}

}
$affiliatewp_admin = new AffiliateWP_Order_Details_For_Affiliates_Admin;