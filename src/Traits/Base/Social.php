<?php
/**
 * Elementify Library - Social Elements Trait
 *
 * A collection of methods for creating social media HTML elements.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Traits\Base;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Assets;
use Elementify\Element;
use Elementify\Utils;

/**
 * Social Elements Trait
 *
 * Provides methods for creating social media elements including sharing links,
 * social profile lists, and platform-specific integrations.
 */
trait Social {

	/**
	 * Create a list of social media links with Dashicons
	 *
	 * @param array $social_profiles Array of social profiles with platform as key and URL as value
	 * @param array $list_attrs      Attributes for the list element
	 * @param bool  $show_text       Whether to show the platform name beside the icon
	 * @param bool  $include_css     Whether to include built-in CSS (default: true)
	 *
	 * @return Element
	 */
	public static function social_links( array $social_profiles, array $list_attrs = [], bool $show_text = true, bool $include_css = true ): Element {
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
				$link_content = self::span( null, [ 'class' => "dashicons {$dashicon_class}" ] )->render();
			}

			if ( $show_text ) {
				$link_content .= ' ' . ucfirst( $platform );
			}

			$items[] = self::li(
				self::a( $url, $link_content, [
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

		return self::ul( $items, $merged_attrs );
	}

	/**
	 * Create and render a list of social media links with Dashicons
	 *
	 * @param array $social_profiles Array of social profiles with platform as key and URL as value
	 * @param array $list_attrs      Attributes for the list element
	 * @param bool  $show_text       Whether to show the platform name beside the icon
	 * @param bool  $include_css     Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function social_links_render( array $social_profiles, array $list_attrs = [], bool $show_text = true, bool $include_css = true ): void {
		self::social_links( $social_profiles, $list_attrs, $show_text, $include_css )->output();
	}

	/**
	 * Create a WhatsApp link
	 *
	 * @param string $phone      Phone number (with country code)
	 * @param string $message    Optional message to pre-fill
	 * @param mixed  $content    Link content (defaults to phone if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function whatsapp( string $phone, string $message = '', $content = null, array $attributes = [] ): Element {
		// Use phone as content if none provided
		if ( $content === null ) {
			$content = $phone;
		}

		// Clean phone number (keep only digits and plus sign)
		$clean_phone = Helpers::clean_phone_number( $phone );

		$url = 'https://wa.me/' . $clean_phone;

		// Add message if provided
		if ( ! empty( $message ) ) {
			$url .= '?text=' . rawurlencode( $message );
		}

		return self::a( $url, $content, $attributes );
	}

	/**
	 * Create and render a WhatsApp link
	 *
	 * @param string $phone      Phone number (with country code)
	 * @param string $message    Optional message to pre-fill
	 * @param mixed  $content    Link content (defaults to phone if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function whatsapp_render( string $phone, string $message = '', $content = null, array $attributes = [] ): void {
		self::whatsapp( $phone, $message, $content, $attributes )->output();
	}

	/**
	 * Create a social media sharing link for Twitter/X
	 *
	 * @param string $text       Text to share
	 * @param string $url        URL to share (optional)
	 * @param string $hashtags   Comma-separated hashtags without # symbol (optional)
	 * @param mixed  $content    Link content
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function twitter_share( string $text, string $url = '', string $hashtags = '', $content = 'Share on Twitter', array $attributes = [] ): Element {
		$share_url = 'https://twitter.com/intent/tweet?text=' . rawurlencode( $text );

		if ( ! empty( $url ) ) {
			$share_url .= '&url=' . rawurlencode( $url );
		}

		if ( ! empty( $hashtags ) ) {
			$share_url .= '&hashtags=' . rawurlencode( $hashtags );
		}

		return self::external_link( $share_url, $content, $attributes );
	}

	/**
	 * Create and render a Twitter/X sharing link
	 *
	 * @param string $text       Text to share
	 * @param string $url        URL to share (optional)
	 * @param string $hashtags   Comma-separated hashtags without # symbol (optional)
	 * @param mixed  $content    Link content
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function twitter_share_render( string $text, string $url = '', string $hashtags = '', $content = 'Share on Twitter', array $attributes = [] ): void {
		self::twitter_share( $text, $url, $hashtags, $content, $attributes )->output();
	}

	/**
	 * Create a social media sharing link for Facebook
	 *
	 * @param string $url        URL to share
	 * @param mixed  $content    Link content
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function facebook_share( string $url, $content = 'Share on Facebook', array $attributes = [] ): Element {
		$share_url = 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( $url );

		return self::external_link( $share_url, $content, $attributes );
	}

	/**
	 * Create and render a Facebook sharing link
	 *
	 * @param string $url        URL to share
	 * @param mixed  $content    Link content
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function facebook_share_render( string $url, $content = 'Share on Facebook', array $attributes = [] ): void {
		self::facebook_share( $url, $content, $attributes )->output();
	}

	/**
	 * Create a social media sharing link for LinkedIn
	 *
	 * @param string $url        URL to share
	 * @param string $title      Title of content to share (optional)
	 * @param mixed  $content    Link content
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function linkedin_share( string $url, string $title = '', $content = 'Share on LinkedIn', array $attributes = [] ): Element {
		$share_url = 'https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode( $url );

		if ( ! empty( $title ) ) {
			$share_url .= '&title=' . rawurlencode( $title );
		}

		return self::external_link( $share_url, $content, $attributes );
	}

	/**
	 * Create and render a LinkedIn sharing link
	 *
	 * @param string $url        URL to share
	 * @param string $title      Title of content to share (optional)
	 * @param mixed  $content    Link content
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function linkedin_share_render( string $url, string $title = '', $content = 'Share on LinkedIn', array $attributes = [] ): void {
		self::linkedin_share( $url, $title, $content, $attributes )->output();
	}

	/**
	 * Create a generic social media sharing link
	 *
	 * @param string $platform   Social media platform
	 * @param string $url        URL to share
	 * @param array  $params     Additional parameters for the sharing URL
	 * @param mixed  $content    Link content
	 * @param array  $attributes Element attributes
	 *
	 * @return Element|null      Returns null if platform is not supported
	 */
	public static function social_share( string $platform, string $url, array $params = [], $content = null, array $attributes = [] ): ?Element {
		$platform = strtolower( $platform );

		// Default content if not provided
		if ( $content === null ) {
			$content = 'Share on ' . ucfirst( $platform );
		}

		switch ( $platform ) {
			case 'twitter':
			case 'x':
				$text     = $params['text'] ?? '';
				$hashtags = $params['hashtags'] ?? '';

				return self::twitter_share( $text, $url, $hashtags, $content, $attributes );

			case 'facebook':
				return self::facebook_share( $url, $content, $attributes );

			case 'linkedin':
				$title = $params['title'] ?? '';

				return self::linkedin_share( $url, $title, $content, $attributes );

			case 'pinterest':
				$description = $params['description'] ?? '';
				$media       = $params['media'] ?? '';
				$share_url   = 'https://pinterest.com/pin/create/button/?url=' . rawurlencode( $url );

				if ( ! empty( $description ) ) {
					$share_url .= '&description=' . rawurlencode( $description );
				}

				if ( ! empty( $media ) ) {
					$share_url .= '&media=' . rawurlencode( $media );
				}

				return self::external_link( $share_url, $content, $attributes );

			case 'reddit':
				$title     = $params['title'] ?? '';
				$share_url = 'https://www.reddit.com/submit?url=' . rawurlencode( $url );

				if ( ! empty( $title ) ) {
					$share_url .= '&title=' . rawurlencode( $title );
				}

				return self::external_link( $share_url, $content, $attributes );

			default:
				return null;
		}
	}

	/**
	 * Create and render a generic social media sharing link
	 *
	 * @param string $platform   Social media platform
	 * @param string $url        URL to share
	 * @param array  $params     Additional parameters for the sharing URL
	 * @param mixed  $content    Link content
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function social_share_render( string $platform, string $url, array $params = [], $content = null, array $attributes = [] ): void {
		$element = self::social_share( $platform, $url, $params, $content, $attributes );

		if ( $element !== null ) {
			$element->output();
		}
	}

}