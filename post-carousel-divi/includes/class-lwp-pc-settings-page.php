<?php
/**
 * LWP Post Carousel Settings Page
 *
 * This file contains the class responsible for creating the admin settings page
 * for the Divi Post Carousel plugin.
 *
 * @package Post_Carousel_Divi
 * @since 1.2.3
 */

/**
 * Class LWP_Carousel_Admin_Page
 * Handles the creation of the admin page for the Post Carousel plugin.
 */
class Lwp_Pc_Settings_Page {

	/**
	 * Constructor to initialize the class.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
	}

	/**
	 * Adds the options page to the WordPress admin menu.
	 */
	public function add_options_page() {
		add_menu_page(
			__( 'Divi Post Carousel', 'lwp-divi-module' ),
			__( 'Divi Post Carousel', 'lwp-divi-module' ),
			'manage_options',
			'lwp_post_carousel',
			array( $this, 'render_options_page' ),
			'dashicons-slides',
			100
		);
	}

	/**
	 * Renders the HTML content of the options page.
	 */
	public function render_options_page() {
		?>
		<style>
			.lwp-button {
				background-color: #ff8906;
				border: none;
				color: white;
				padding: 10px 24px;
				text-align: center;
				text-decoration: none;
				display: inline-block;
				font-size: 16px;
			}
			.lwp-button:hover {
				color: white;
			}
			.lwp-btn-demo{
				background-color:#34c5a8;
			}
			.lwp-heading{
				font-size:23px;
				font-weight:bold;
				margin-top:40px;
			}
			.lwp-flex-container{
				display: flex;
				flex-direction: row;
				flex-wrap: wrap;			  			
			}
			.lwp-flex-container.lwp-module-row div {
				width: 33%!important;
				padding-right: 0px;
				padding-left: 0px;
				margin-top:30px;
			}
			.lwp-flex-container>div{
				padding-left:20px;
				padding-right:20px;
			}
			.lwp-flex-container>div:first-child{
				padding-left:0px;
			}
			@media(max-width:767px){
				.lwp-flex-container.lwp-module-row div {
					width: 100%!important;
				}			
			}		
		</style>

		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<p class="lwp-main-text">Documentation for the plugin can be found <a href="https://www.learnhowwp.com/documentation/post-carousel-divi/">here</a>. You can check a demo of the plugin on this <a href="https://www.learnhowwp.com/divi-post-carousel/">link</a>. If you have any questions please feel free to open a support ticket on the plugin page <a href="#">here.</a></p>
			
			<div class="lwp-flex-container">
				<div>
					<h3>Free Features</h3>
					<ul>
						<li>* Visual Builder Supported</li>
						<li>* Autoplay Animation</li>
						<li>* Stop autoplay on hover</li>
						<li>* Autoplay animation controls</li>
						<li>* Slide animation controls</li>
						<li>* Infinite Animation</li>
						<li>* Show/Hide Arrows</li>
						<li>* Show/Hide Dots</li>
						<li>* Arrow and Dot styles</li>
						<li>* Choose the number of posts you want to show in the carousel.</li>
						<li>* Choose the number of post to scroll when the arrow is clicked or on autoplay.</li>
						<li>* Responsive options. Set different number of slides for Desktop, Tablet and Phones.</li>
						<li>* Many more options</li>
					</ul>
				</div>
				<div>
					<h3>Pro Features</h3>
					<ul>
						<li>* <strong>5 Premium Carousel Styles!</strong></li>
						<li>* Order Ascending or Descending</li>
						<li>* Random Order</li>
						<li>* Order by Comment Count</li>
						<li>* Change Post offset</li>
						<li>* Change Excerpt legnth</li>
						<li>* Change Button text</li>
						<li>* Set Date Format</li>
						<li>* Option to turn off featured image, title, excerpt, button and every field in post meta</li>
						<li><strong>And Many More Features!</strong></li>
					</ul>
					<a class="lwp-button" href="<?php echo esc_url( admin_url( 'admin.php?page=lwp_post_carousel-pricing' ) ); ?>">Upgrade</a>				
				</div>
			</div>

			<h2 class="wrap lwp-heading">More Modules</h2>
			
			<div class="lwp-flex-container lwp-module-row">
				<div>
					<h3>Divi Contact Form DB</h3>
					<p>Save Divi Contact Form Submissions in the database.</p>
					<a href="https://wordpress.org/plugins/contact-form-db-divi/" class="lwp-button" target="_blank">Download</a>
					<a href="https://www.learnhowwp.com/divi-contact-form-db/" class="lwp-button lwp-btn-demo" target="_blank">Demo</a>
				</div>
				<div>
					<h3>Divi Breadcrumbs</h3>
					<p>Easily add breadcrumbs to your website using a breadcrumbs module.</p>
					<a href="https://wordpress.org/plugins/breadcrumbs-divi-module/" class="lwp-button" target="_blank">Download</a>
					<a href="https://www.learnhowwp.com/divi-breadcrumbs-module/" class="lwp-button lwp-btn-demo" target="_blank">Demo</a>
				</div>
				<div>
					<h3>Divi Overlay Image Module</h3>
					<p>Easily add images with overlay text that shows on hover</p>
					<a href="https://wordpress.org/plugins/overlay-image-divi-module/" class="lwp-button" target="_blank">Download</a>
					<a href="https://www.learnhowwp.com/divi-overlay-images/" class="lwp-button lwp-btn-demo" target="_blank">Demo</a>
				</div>
				<div>
					<h3>Divi Menu Cart Module</h3>
					<p>Easily add a cart icon with price and item count.</p>
					<a href="https://www.learnhowwp.com/divi-menu-cart/" class="lwp-button" target="_blank">Download</a>
					<a href="https://wordpress.org/plugins/menu-cart-divi/" class="lwp-button lwp-btn-demo" target="_blank">Demo</a>
				</div>
				<div>
					<h3>Divi Flip Cards</h3>
					<p>Easily add flip cards to your website using a flip cards module.</p>				
					<a href="https://wordpress.org/plugins/flip-cards-module-divi/" class="lwp-button" target="_blank">Download</a>
					<a href="https://www.learnhowwp.com/divi-flip-cards-plugin/" class="lwp-button lwp-btn-demo" target="_blank">Demo</a>
				</div>
				<div>
					<h3>Divi Image Carousel</h3>
					<p>Easily add image carousel to your website using an image carouse module.</p>				
					<a href="https://wordpress.org/plugins/image-carousel-divi/" class="lwp-button" target="_blank">Download</a>
					<a href="https://www.learnhowwp.com/divi-image-carousel-plugin/" class="lwp-button lwp-btn-demo" target="_blank">Demo</a>
				</div>						
			</div>

		</div>
		<?php
	}
}
