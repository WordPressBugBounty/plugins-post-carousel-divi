<?php

/*
Plugin Name: Post Carousel Divi
Plugin URI:  https://www.learnhowwp.com/divi-post-carousel
Description: Adds a Post Carousle module to the Divi builder.
Version:     1.2.3
Author:      Learnhowwp.com
Author URI:  https://www.learnhowwp.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: lwp-divi-module
Domain Path: /languages

Post Carousel is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Post Carousel is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Post Carousel. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/
//======================================================================================
//======================================================================================
if ( !function_exists( 'lwp_pcdivi_fs' ) ) {
    // Create a helper function for easy SDK access.
    function lwp_pcdivi_fs() {
        global $lwp_pcdivi_fs;
        if ( !isset( $lwp_pcdivi_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $lwp_pcdivi_fs = fs_dynamic_init( array(
                'id'             => '8089',
                'slug'           => 'post-carousel-divi',
                'type'           => 'plugin',
                'public_key'     => 'pk_a804bd198a264b58adb12d2112832',
                'is_premium'     => false,
                'has_addons'     => false,
                'has_paid_plans' => true,
                'navigation'     => 'tabs',
                'anonymous_mode' => true,
                'menu'           => array(
                    'slug' => 'lwp_post_carousel',
                ),
                'is_live'        => true,
            ) );
        }
        return $lwp_pcdivi_fs;
    }

    // Init Freemius.
    lwp_pcdivi_fs();
    // Signal that SDK was initiated.
    do_action( 'lwp_pcdivi_fs_loaded' );
}
// Display annual pricing instead of monthly pricing on Freemius Pricing page.
lwp_pcdivi_fs()->add_filter( 'pricing/show_annual_in_monthly', function () {
    return false;
} );
// Include the settings page class to initialize settings page.
require_once plugin_dir_path( __FILE__ ) . 'includes/class-lwp-pc-settings-page.php';
add_action( 'plugins_loaded', function () {
    if ( is_admin() ) {
        new Lwp_Pc_Settings_Page();
    }
} );
//======================================================================================
if ( !function_exists( 'lwp_initialize_post_carousel_extension' ) ) {
    /**
     * Creates the extension's main class instance.
     *
     * @since 1.0.0
     */
    function lwp_initialize_post_carousel_extension() {
        require_once plugin_dir_path( __FILE__ ) . 'includes/PostCarousel.php';
    }

    add_action( 'divi_extensions_init', 'lwp_initialize_post_carousel_extension' );
}
if ( !function_exists( 'lwp_post_carousel_style' ) ) {
    function lwp_post_carousel_style(
        $carousel_style,
        $post_title_output,
        $post_meta_output,
        $post_excerpt_output,
        $button_output,
        $featured_image_src,
        $post_permalink,
        $has_featured_image,
        $carousel_image_position,
        $featured_image_url
    ) {
        $output = '';
        $post_thumbnail_output = '';
        if ( $has_featured_image ) {
            $post_thumbnail_output = '<div class="lwp_post_carousel_image">
			<a class="lwp_carousel_featured_image" href="' . $post_permalink . '">
			' . $featured_image_src . '
			</a>
		</div>';
        }
        if ( $carousel_style == 'default' ) {
            $output = '<div class="lwp_post_carousel_item">
			<div class="lwp_post_carousel_item_inner lwp_carousel_default">' . $post_thumbnail_output . $post_title_output . $post_meta_output . $post_excerpt_output . '<div class="lwp_post_carousel_read_more">
					' . $button_output . '
				</div>
			</div>
		</div>';
        } else {
            if ( $carousel_style == 'side' ) {
                $position_class = 'lwp_image_position_' . $carousel_image_position;
                $post_thumbnail_output_side = '';
                if ( $has_featured_image ) {
                    $post_thumbnail_output_side = '
				<div class="lwp_image_side">' . $post_thumbnail_output . '</div>';
                }
                $output = '<div class="lwp_post_carousel_item">
			<div class="lwp_post_carousel_item_inner lwp_carousel_side ' . $position_class . '">' . $post_thumbnail_output_side . '<div class="lwp_content_side">' . $post_title_output . $post_meta_output . $post_excerpt_output . '<div class="lwp_post_carousel_read_more">
						' . $button_output . '
					</div>
				</div>	
			</div>
		</div>';
            } else {
                if ( $carousel_style == 'overlay' || $carousel_style == 'hover' ) {
                    $featured_image_style = '';
                    $hover_class = '';
                    $featured_image_class = '';
                    if ( $has_featured_image ) {
                        $featured_image_style = 'style="background-image:url(' . $featured_image_url . ');"';
                        $featured_image_class = 'lwp_has_featured_image';
                    }
                    if ( $carousel_style == 'hover' ) {
                        $hover_class = 'lwp_carousel_hover';
                    }
                    $output = '<div class="lwp_post_carousel_item">
			<div class="lwp_post_carousel_item_inner lwp_carousel_overlay ' . $hover_class . ' ' . $featured_image_class . '" ' . $featured_image_style . '>
				<div class="lwp_overlay_container"></div>' . '<div class="lwp_content_overlay">' . $post_title_output . $post_meta_output . $post_excerpt_output . '<div class="lwp_post_carousel_read_more">
						' . $button_output . '
					</div>
				</div>	
			</div>
		</div>';
                } else {
                    if ( $carousel_style == 'overlay_box' ) {
                        $featured_image_style = '';
                        $featured_image_class = '';
                        if ( $has_featured_image ) {
                            $featured_image_style = 'style="background-image:url(' . $featured_image_url . ');"';
                            $featured_image_class = 'lwp_has_featured_image';
                        }
                        $output = '<div class="lwp_post_carousel_item">
			<div class="lwp_post_carousel_item_inner lwp_carousel_overlay_box ' . $featured_image_class . '" ' . $featured_image_style . '>' . '<div class="lwp_content_overlay">' . $post_title_output . $post_meta_output . $post_excerpt_output . '<div class="lwp_post_carousel_read_more">
						' . $button_output . '
					</div>
				</div>	
			</div>
		</div>';
                    } else {
                        if ( $carousel_style == 'overlap_content' ) {
                            $post_thumbnail_output_overlap = '';
                            $featured_image_class = '';
                            if ( $has_featured_image ) {
                                $featured_image_class = 'lwp_has_featured_image';
                                $post_thumbnail_output_overlap = '
				<div class="lwp_image_overlap">' . $post_thumbnail_output . '</div>';
                            }
                            $output = '<div class="lwp_post_carousel_item">
			<div class="lwp_post_carousel_item_inner lwp_carousel_overlap ' . $featured_image_class . '">' . $post_thumbnail_output_overlap . '<div class="lwp_overlap_content_outer">
					<div class="lwp_overlap_content">' . $post_title_output . $post_meta_output . $post_excerpt_output . '
					</div>
					<div class="lwp_overlap_button">
						<div class="lwp_post_carousel_read_more">
						' . $button_output . '
						</div>				
					</div>
				</div>
			</div>
		</div>';
                        }
                    }
                }
            }
        }
        return $output;
    }

}
if ( !function_exists( 'lwp_get_carousel_posts' ) ) {
    add_action( 'wp_ajax_lwp_get_carousel_posts', 'lwp_get_carousel_posts' );
    function lwp_get_carousel_posts() {
        if ( isset( $_POST['et_admin_load_nonce_'] ) && !wp_verify_nonce( sanitize_key( $_POST['et_admin_load_nonce_'] ), 'et_admin_load_nonce' ) ) {
            die( 'Nonce verification failed.' );
        }
        /*Post settings*/
        $post_title_level = 'h4';
        $post_count = 9;
        $post_type = 'post';
        $featured_image_size = '';
        $post_categories = array();
        $use_manual_excerpt = 'off';
        if ( isset( $_POST['post_type'] ) && !empty( $_POST['post_type'] ) ) {
            $post_type = sanitize_text_field( $_POST['post_type'] );
        }
        if ( isset( $_POST['post_count'] ) && !empty( $_POST['post_count'] ) ) {
            $post_count = sanitize_option( 'posts_per_page', $_POST['post_count'] );
        }
        if ( isset( $_POST['featured_image_size'] ) && !empty( $_POST['featured_image_size'] ) ) {
            $featured_image_size = sanitize_text_field( $_POST['featured_image_size'] );
        }
        if ( isset( $_POST['post_categories'] ) && !empty( $_POST['post_categories'] ) ) {
            $post_categories = wp_parse_id_list( $_POST['post_categories'] );
        }
        if ( isset( $_POST['use_manual_excerpt'] ) && !empty( $_POST['use_manual_excerpt'] ) ) {
            $use_manual_excerpt = sanitize_text_field( $_POST['use_manual_excerpt'] );
        }
        $order = 'DESC';
        $orderby = 'date';
        $post_offset = 0;
        $show_title = 'on';
        $show_featured_image = 'on';
        $show_excerpt = 'on';
        $show_author = 'on';
        $show_date = 'on';
        $show_categories = 'on';
        $show_comments = 'on';
        $show_button = 'on';
        $post_meta_separator = '|';
        $excerpt_length = 170;
        $button_text = 'Read More';
        $date_format = 'M j, Y';
        $carousel_style = 'default';
        $carousel_image_position = 'left';
        if ( $post_type !== 'post' ) {
            $post_categories = '';
        }
        $post_query = new WP_Query(array(
            'post_type'      => $post_type,
            'posts_per_page' => $post_count,
            'offset'         => $post_offset,
            'cat'            => $post_categories,
            'post_status'    => 'publish',
            'order'          => $order,
            'orderby'        => $orderby,
        ));
        $post_output = '';
        while ( $post_query->have_posts() ) {
            $post_query->the_post();
            $button_output = '';
            if ( $show_button == 'on' ) {
                $button_output = '<div class="et_pb_button_wrapper">
				<a class="et_pb_button" href="#">' . $button_text . '</a>
			</div>';
            }
            $post_thumbnail_output = '';
            $has_featured_image = false;
            $post_permalink = get_permalink();
            $featured_image_src = get_the_post_thumbnail( get_the_ID(), $featured_image_size );
            $featured_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $featured_image_size );
            if ( has_post_thumbnail() && $show_featured_image == 'on' ) {
                $has_featured_image = true;
            }
            $post_title_output = '';
            if ( $show_title == 'on' ) {
                $post_title_output = '<div class="lwp_post_carousel_title">
				<' . $post_title_level . ' class="lwp_post_carousel_heading">
					<a class="lwp_post_title" href="' . get_permalink() . '">' . get_the_title() . '</a>
				</' . $post_title_level . '>
			</div>';
            }
            $post_excerpt_output = '';
            if ( $show_excerpt == 'on' ) {
                $excerpt_text = '';
                if ( has_excerpt() && $use_manual_excerpt == 'on' ) {
                    $excerpt_text = get_the_excerpt();
                } else {
                    $excerpt_text = substr( wp_strip_all_tags( preg_replace( "~(?:\\[/?)[^/\\]]+/?\\]~s", '', get_the_content() ) ), 0, $excerpt_length );
                }
                $post_excerpt_output = '<div class="lwp_post_carousel_excerpt">' . $excerpt_text . '</div>';
            }
            $post_meta_output = '';
            $post_meta_array = array();
            $post_author_output = '';
            $post_date_output = '';
            $post_category_output = '';
            $post_comment_output = '';
            if ( $show_author == 'on' ) {
                $post_author_output = '<span class="lwp_meta_by">' . esc_html__( "by", "lwp-divi-module" ) . '</span> ' . get_the_author_posts_link();
                array_push( $post_meta_array, $post_author_output );
            }
            if ( $show_date == 'on' ) {
                $post_date_output = '<span class="lwp_meta_date">' . get_the_time( $date_format ) . '</span>';
                array_push( $post_meta_array, $post_date_output );
            }
            if ( $show_categories == 'on' && $post_type === 'post' ) {
                $post_category_output = '<span class="lwp_meta_categories">' . get_the_category_list( ', ' ) . '</span>';
                array_push( $post_meta_array, $post_category_output );
            }
            if ( $show_comments == 'on' ) {
                $post_comment_output = '<span class="lwp_meta_comments">' . get_comments_number_text( __( "0 Comments", "lwp-divi-module" ) ) . '</span>';
                array_push( $post_meta_array, $post_comment_output );
            }
            $post_meta_output = $post_meta_output . '<p class="lwp_post_carousel_meta">';
            $meta_count = count( $post_meta_array );
            for ($i = 0; $i < $meta_count; $i++) {
                $post_meta_output = $post_meta_output . $post_meta_array[$i];
                if ( $meta_count == 1 || $i == $meta_count - 1 ) {
                    continue;
                } else {
                    $post_meta_output = $post_meta_output . ' <span class="lwp_meta_separator">' . $post_meta_separator . '</span> ';
                }
            }
            $post_meta_output = $post_meta_output . '</p>';
            $post_output = $post_output . lwp_post_carousel_style(
                $carousel_style,
                $post_title_output,
                $post_meta_output,
                $post_excerpt_output,
                $button_output,
                $featured_image_src,
                $post_permalink,
                $has_featured_image,
                $carousel_image_position,
                $featured_image_url[0]
            );
        }
        wp_reset_postdata();
        $result = [
            'html' => $post_output,
        ];
        echo json_encode( $result );
        wp_die();
    }

}
/*
Rating Notice
*/
if ( !function_exists( 'lwp_post_carousel_activation_time' ) ) {
    function lwp_post_carousel_activation_time() {
        $get_activation_time = strtotime( "now" );
        add_option( 'lwp_post_carousel_activation_time', $get_activation_time );
    }

    register_activation_hook( __FILE__, 'lwp_post_carousel_activation_time' );
}
if ( !function_exists( 'lwp_post_carousel_check_installation_time' ) ) {
    function lwp_post_carousel_check_installation_time() {
        $install_date = get_option( 'lwp_post_carousel_activation_time' );
        $spare_me = get_option( 'lwp_post_carousel_spare_me' );
        $past_date = strtotime( '-7 days' );
        if ( $past_date >= $install_date && $spare_me == false ) {
            add_action( 'admin_notices', 'lwp_post_carousel_rating_admin_notice' );
        }
    }

    add_action( 'admin_init', 'lwp_post_carousel_check_installation_time' );
}
if ( !function_exists( 'lwp_post_carousel_rating_admin_notice' ) ) {
    /*
    Display Admin Notice, asking for a review
    */
    function lwp_post_carousel_rating_admin_notice() {
        global $pagenow;
        if ( $pagenow == 'index.php' || $pagenow == 'admin.php' || $pagenow == 'plugins.php' ) {
            $dont_disturb = esc_url( add_query_arg( array(
                'lwp_post_carousel_spare_me' => '1',
                '_wpnonce'                   => wp_create_nonce( 'lwp_post_carousel_spare_me_nonce' ),
            ), get_admin_url() ) );
            $dont_show = esc_url( add_query_arg( array(
                'lwp_post_carousel_spare_me' => '1',
                '_wpnonce'                   => wp_create_nonce( 'lwp_post_carousel_spare_me_nonce' ),
            ), get_admin_url() ) );
            $plugin_info = 'Divi Post Carousel';
            $reviewurl = esc_url( 'https://wordpress.org/support/plugin/post-carousel-divi/reviews/#new-post' );
            printf(
                '<div class="wrap notice notice-info">
							<div style="margin:10px 0px;">
								Hello! Seems like you are using <strong> %s </strong> plugin to build your Divi website - Thanks a lot! Could you please do us a BIG favor and give it a 5-star rating on WordPress? This would boost our motivation and help other users make a comfortable decision while choosing the plugin.
							</div>	
							<div class="button-group" style="margin:10px 0px;">
								<a href="%s" class="button button-primary" target="_blank" style="margin-right:10px;">Ok,you deserve it</a>
								<span class="dashicons dashicons-smiley"></span><a href="%s" class="button button-link" style="margin-right:10px; margin-left:3px;">I already did</a>
								<a href="%s" class="button button-link"> Don\'t show this again.</a>							
							</div>
						</div>',
                esc_html( $plugin_info ),
                esc_url( $reviewurl ),
                esc_url( $dont_disturb ),
                esc_url( $dont_show )
            );
        }
    }

}
if ( !function_exists( 'lwp_post_carousel_spare_me' ) ) {
    function lwp_post_carousel_spare_me() {
        if ( isset( $_GET['lwp_post_carousel_spare_me'] ) && !empty( $_GET['lwp_post_carousel_spare_me'] ) ) {
            $lwp_post_carousel_spare_me = sanitize_text_field( $_GET['lwp_post_carousel_spare_me'] );
            if ( $lwp_post_carousel_spare_me == 1 && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( sanitize_key( $_GET['_wpnonce'] ), 'lwp_post_carousel_spare_me_nonce' ) ) {
                add_option( 'lwp_post_carousel_spare_me', TRUE );
            }
        }
    }

    add_action( 'admin_init', 'lwp_post_carousel_spare_me', 5 );
}