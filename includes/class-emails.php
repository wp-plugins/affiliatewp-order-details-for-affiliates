<?php
/**
 * Emails class
 */
class AffiliateWP_Order_Details_For_Affiliates_Emails {

	public function __construct() {
		// send the emails when the referral is complete
		add_action( 'affwp_complete_referral',  array( $this, 'complete_referral' ), 10, 3 );
	}

	/**
	 * Can the affiliate receive an email?
	 *
	 * @since 1.0
	 *
	 * @return boolean true or false
	 */
	public function can_receive_email( $affiliate_id ) {
		// true by default
		$can_receive = apply_filters( 'affwp_odfa_can_receive_email', true, $affiliate_id );

		if ( $can_receive ) {
			return (bool) true;
		}

		return (bool) false;
	}

	/**
	 * When the referral is complete, send email to the affiliate with the customer details
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function complete_referral( $referral_id, $referral, $reference ) {

		// get referral details
		$referral     = affwp_get_referral( $referral_id );
		$affiliate_id = $referral->affiliate_id;
		$email        = affwp_get_affiliate_email( $affiliate_id );

		// email subject
		$subject      = apply_filters( 'affwp_odfa_email_subject', __( 'The order details for your most recent referral', 'affiliatewp-order-details-for-affiliates' ) );
		
		// get our message
		$message      = $this->get_email_message( $referral, $affiliate_id );

		// only send email to affiliates that are allowed to receive purchase details
		if ( affiliatewp_order_details_for_affiliates()->can_access_order_details( affwp_get_affiliate_user_id( $affiliate_id ) ) && $this->can_receive_email( $affiliate_id ) ) {

			// if EDD, use EDD's email class
			if ( 'edd' == $referral->context ) {
				EDD()->emails->send( $email, $subject, $message );
			}
			else {
				add_filter( 'wp_mail_content_type',  array( $this, 'set_html_content_type' ) );
				affiliate_wp()->emails->send( $email, $subject, $message );
				remove_filter( 'wp_mail_content_type', array( $this, 'set_html_content_type' ) );
			}

		}
		
	}

	/**
	 * The email message that is sent to the affiliate
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function get_email_message( $referral = array(), $affiliate_id = 0 ) {

		$affwp_odfa                = affiliatewp_order_details_for_affiliates();
		$is_allowed                = $affwp_odfa->order_details->allowed();

		$affiliate_name            = affiliate_wp()->affiliates->get_affiliate_name( $affiliate_id );
		
		$order_number              = $affwp_odfa->order_details->get( $referral, 'order_number' );
		$order_date                = $affwp_odfa->order_details->get( $referral, 'order_date' );
		$order_total               = $affwp_odfa->order_details->get( $referral, 'order_total' );
		$referral_amount           = $affwp_odfa->order_details->get( $referral, 'referral_amount' );
		$customer_name             = $affwp_odfa->order_details->get( $referral, 'customer_name' );
		$customer_email            = $affwp_odfa->order_details->get( $referral, 'customer_email' );
		$customer_phone            = $affwp_odfa->order_details->get( $referral, 'customer_phone' );
		$customer_shipping_address = $affwp_odfa->order_details->get( $referral, 'customer_shipping_address' );
		$customer_billing_address  = $affwp_odfa->order_details->get( $referral, 'customer_billing_address' );

		ob_start();
		?>

		<p><?php _e( 'Hi', 'affiliatewp-order-details-for-affiliates' ); ?> <?php echo $affiliate_name; ?>,</p>
		<p><?php _e( 'Here are the order details for your most recent referral:', 'affiliatewp-order-details-for-affiliates' ); ?></p>


		<?php if ( $is_allowed['order_number'] && isset( $order_number ) ) : ?>
		<p>
			<strong><?php _e( 'Order Number:', 'affiliatewp-order-details-for-affiliates' ); ?></strong><br />
			<?php echo $order_number; ?>
		</p>
		<?php endif; ?>

		<?php if ( $is_allowed['order_date'] && isset( $order_date ) ) : ?>
		<p>
			<strong><?php _e( 'Order Date:', 'affiliatewp-order-details-for-affiliates' ); ?></strong><br />
			<?php echo $order_date; ?>
		</p>
		<?php endif; ?>

		<?php if ( $is_allowed['order_total'] && isset( $order_total ) ) : ?>
		<p>
			<strong><?php _e( 'Order Total:', 'affiliatewp-order-details-for-affiliates' ); ?></strong><br />
			<?php echo $order_total; ?>
		</p>
		<?php endif; ?>

		<?php if ( $is_allowed['referral_amount'] && isset( $referral_amount ) ) : ?>
		<p>
			<strong><?php _e( 'Referral Amount:', 'affiliatewp-order-details-for-affiliates' ); ?></strong><br />
			<?php echo $referral_amount; ?>
		</p>
		<?php endif; ?>

		<?php if ( $is_allowed['customer_name'] && isset( $customer_name ) ) : ?>
		<p><strong><?php _e( 'Customer Name:', 'affiliatewp-order-details-for-affiliates' ); ?></strong><br /><?php echo $customer_name; ?></p>
		<?php endif; ?>

		<?php if ( $is_allowed['customer_email'] && isset( $customer_email ) ) : ?>
		<p>		
			<strong><?php _e( 'Customer Email:', 'affiliatewp-order-details-for-affiliates' ); ?></strong><br /><?php echo $customer_email; ?>
		</p>
		<?php endif; ?>

		<?php if ( $is_allowed['customer_phone'] && isset( $customer_phone ) ) : ?>
		<p>	
			<strong><?php _e( 'Customer Phone:', 'affiliatewp-order-details-for-affiliates' ); ?></strong><br /><?php echo $customer_phone; ?>
		</p>	
		<?php endif; ?>
		
		<?php if ( $is_allowed['customer_shipping_address'] && isset( $customer_shipping_address ) ) : ?>
			<p><strong><?php _e( 'Customer Shipping Address:', 'affiliatewp-order-details-for-affiliates' ); ?></strong><br/> <?php echo $customer_shipping_address; ?></p>
		<?php endif; ?>

		<?php if ( $is_allowed['customer_billing_address'] && isset( $customer_billing_address ) ) : ?>
			<p><strong><?php _e( 'Customer Billing Address:', 'affiliatewp-order-details-for-affiliates' ); ?></strong><br/> <?php echo $customer_billing_address; ?></p>
		<?php endif; ?>

	<?php
		$email = ob_get_clean();
		return apply_filters( 'affwp_odfa_email_message', $email, $referral, $affiliate_id );
	}

	/**
	 *  Set the content type to text/html
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function set_html_content_type() {
	    return 'text/html';
	}


}