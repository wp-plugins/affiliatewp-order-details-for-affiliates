=== AffiliateWP - Order Details For Affiliates ===
Contributors: sumobi, mordauk
Tags: AffiliateWP, affiliate, Pippin Williamson, Andrew Munro, mordauk, pippinsplugins, sumobi, ecommerce, e-commerce, e commerce, selling, membership, referrals, marketing
Requires at least: 3.3
Tested up to: 4.1.1
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allow affiliates to see order details on referrals they generated.

== Description ==

> This plugin requires [AffiliateWP](http://affiliatewp.com/ "AffiliateWP") in order to function.

This add-on adds a new area to the affiliate’s dashboard that allows a logged-in affiliate to see specific information about the order that their referral generated. Currently it works with both Easy Digital Downloads and WooCommerce. 

**Features:**

1. Affiliates can see order details for each referral they generated from their affiliate dashboard
1. Globally enable access to the order details for all affiliates
1. Enable access on a per-affiliate level to the order details
1. Send an email to the affiliate with the order details included
1. Disable specific information from showing to the affiliate

The following details can be shown an affiliate who has access:

1. Order Number
1. Order Date
1. Order Total
1. Referral Amount
1. Customer Name
1. Customer Email
1. Customer Phone (only available in WooCommerce)
1. Customer Shipping Address
1. Customer Billing Address

These can also be easily turned off via a simple filter (see FAQ tab). In addition to disabling the information that is shown, you can customize the layout by editing the `dashboard-tab-order-details.php` template file from your child theme.

The affiliate will also be emailed these details at the time the referral was created.

**What is AffiliateWP?**

[AffiliateWP](http://affiliatewp.com/ "AffiliateWP") provides a complete affiliate management system for your WordPress website that seamlessly integrates with all major WordPress e-commerce and membership platforms. It aims to provide everything you need in a simple, clean, easy to use system that you will love to use.

== Installation ==

1. Unpack the entire contents of this plugin zip file into your `wp-content/plugins/` folder locally
1. Upload to your site
1. Navigate to `wp-admin/plugins.php` on your site (your WP Admin plugin page)
1. Activate this plugin

OR you can just install it with WordPress by going to Plugins >> Add New >> and type this plugin's name

Then you allow access in one of two ways: 

1. Globally enable access for all affiliates. This can be done via the "Allow Global Access To Order Details" checkbox located in Affiliates &rarr; Settings &rarr; Misc.
2. Enable access on a per-affiliate level. This can be done by editing an affiliate and enabling the "Order Details Access" checkbox located from Affiliates &rarr; Affiliates &rarr; Edit.

Note: When there is global access, the checkbox on the edit affiliate screen is not shown.

== Frequently Asked Questions ==

= How can I disable certain information that is shown on the affiliate dashboard and email? =

See this tutorial: http://docs.affiliatewp.com/category/680-order-details-for-affiliates

== Screenshots ==

== Upgrade Notice ==

== Changelog ==

= 1.0.1 =
* New: EDD integration now supports Shipping Address provided by EDD's [Simple Shipping](https://easydigitaldownloads.com/extensions/simple-shipping/ "Simple Shipping")
* New: EDD integration now supports Billing Address provided by payment gateways

= 1.0 =
* Initial release