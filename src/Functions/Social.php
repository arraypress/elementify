<?php
/**
 * Elementify Library - Flexible Component Utility Functions
 *
 * Enhanced helper functions for creating component HTML elements with more flexible input formats.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Assets;
use Elementify\Element;

if ( ! function_exists( 'el_social_links' ) ) {
	/**
	 * Create a list of social media links with Dashicons.
	 *
	 * @param array $social_profiles Array of social profiles with platform as key and URL as value.
	 * @param array $list_attrs      Attributes for the list element.
	 * @param bool  $show_text       Whether to show the platform name beside the icon.
	 * @param bool  $include_css     Whether to include built-in CSS.
	 *
	 * @return Element
	 */
	function el_social_links( array $social_profiles, array $list_attrs = [], bool $show_text = true, bool $include_css = true ): Element {
		$items        = [];
		$dashicon_map = [
			'share'        => 'dashicons-share',
			'share-alt'    => 'dashicons-share-alt',
			'share-alt2'   => 'dashicons-share-alt2',
			'rss'          => 'dashicons-rss',
			'email'        => 'dashicons-email',
			'email-alt'    => 'dashicons-email-alt',
			'email-alt2'   => 'dashicons-email-alt2',
			'networking'   => 'dashicons-networking',
			'amazon'       => 'dashicons-amazon',
			'facebook'     => 'dashicons-facebook',
			'facebook-alt' => 'dashicons-facebook-alt',
			'google'       => 'dashicons-google',
			'instagram'    => 'dashicons-instagram',
			'linkedin'     => 'dashicons-linkedin',
			'pinterest'    => 'dashicons-pinterest',
			'podio'        => 'dashicons-podio',
			'reddit'       => 'dashicons-reddit',
			'spotify'      => 'dashicons-spotify',
			'twitch'       => 'dashicons-twitch',
			'twitter'      => 'dashicons-twitter',
			'twitter-alt'  => 'dashicons-twitter-alt',
			'whatsapp'     => 'dashicons-whatsapp',
			'xing'         => 'dashicons-xing',
			'youtube'      => 'dashicons-youtube',
		];

		foreach ( $social_profiles as $platform => $url ) {
			$platform_lower = strtolower( $platform );
			$dashicon_class = $dashicon_map[ $platform_lower ] ?? '';

			// Create the link content with icon and optional text
			$link_content = '';

			if ( ! empty( $dashicon_class ) ) {
				$link_content = el_span( null, [ 'class' => "dashicons {$dashicon_class}" ] )->render();
			}

			if ( $show_text ) {
				$link_content .= ' ' . ucfirst( $platform );
			}

			$items[] = el_li(
				el_a( $url, $link_content, [
					'class'      => "social-icon social-icon-{$platform_lower}",
					'aria-label' => "Visit our {$platform} page",
					'target'     => '_blank',
					'rel'        => 'noopener noreferrer'
				] )
			);
		}

		// Make sure Dashicons are enqueued if we're not in admin
		if ( ! is_admin() ) {
			wp_enqueue_style( 'dashicons' );
		}

		// Enqueue our component styles if CSS is enabled
		if ( $include_css ) {
			Assets::enqueue( 'social-links' );
		}

		$classes = [ 'social-links-list' ];

		// Add icon-only class if not showing text
		if ( ! $show_text ) {
			$classes[] = 'social-links-icon-only';
		}

		$merged_attrs = array_merge( [ 'class' => implode( ' ', $classes ) ], $list_attrs );

		return el_ul( $items, $merged_attrs );
	}
}

if ( ! function_exists( 'el_social_links_render' ) ) {
	/**
	 * Create and render a list of social media links with Dashicons.
	 *
	 * @param array $social_profiles Array of social profiles with platform as key and URL as value.
	 * @param array $list_attrs      Attributes for the list element.
	 * @param bool  $show_text       Whether to show the platform name beside the icon.
	 * @param bool  $include_css     Whether to include built-in CSS.
	 */
	function el_social_links_render( array $social_profiles, array $list_attrs = [], bool $show_text = true, bool $include_css = true ): void {
		el_social_links( $social_profiles, $list_attrs, $show_text, $include_css )->output();
	}
}

