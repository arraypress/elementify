<?php
/**
 * Elementify Library
 *
 * A fluent interface for generating HTML elements.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Components\Display;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Abstracts\Component;
use Elementify\Create;
use Elementify\Traits\Component\Parts;
use WP_User;

/**
 * User Component
 *
 * Creates a component for displaying user information.
 */
class User extends Component {
	use Parts;

	/**
	 * User options
	 *
	 * @var array
	 */
	protected array $options = [];

	/**
	 * User ID
	 *
	 * @var int
	 */
	protected int $user_id;

	/**
	 * WP_User object
	 *
	 * @var WP_User|null
	 */
	protected $user = null;

	/**
	 * Constructor
	 *
	 * @param int|string|WP_User $user        User ID, username, email, or WP_User object
	 * @param array              $options     Additional options
	 * @param array              $attributes  Element attributes
	 * @param bool               $include_css Whether to include built-in CSS
	 */
	public function __construct( $user, array $options = [], array $attributes = [], bool $include_css = true ) {
		// Get user
		$this->user = $this->get_user_object( $user );

		// Save user ID if user was found
		$this->user_id = $this->user ? $this->user->ID : 0;

		// Merge default options
		$this->options = array_merge( [
			'show_avatar' => true,        // Show user avatar
			'avatar_size' => 32,          // Avatar size in pixels
			'name_type'   => 'display_name', // display_name, user_login, first_name, last_name, full_name
			'link'        => false,       // Link to user profile
			'link_target' => '',          // Link target (_blank, etc.)
			'show_role'   => false,       // Show user role
			'role_format' => '(%s)',      // Format for role display
			'placeholder' => '—',         // Placeholder for when user doesn't exist
		], $options );

		// Set base class
		$this->base_class = 'user-component';

		// Initialize component foundation
		$this->init_component( 'user', $attributes, $include_css );

		// Initialize with a div element
		parent::__construct( 'div', null, $attributes );

		// Build the user component
		$this->build();
	}

	/**
	 * Get WP_User object from user ID, username, email, or WP_User object
	 *
	 * @param int|string|WP_User $user
	 *
	 * @return WP_User|null
	 */
	protected function get_user_object( $user ) {
		// If it's already a WP_User object
		if ( $user instanceof WP_User ) {
			return $user;
		}

		// If it's a user ID
		if ( is_numeric( $user ) ) {
			$user_obj = get_user_by( 'id', $user );
			if ( $user_obj ) {
				return $user_obj;
			}
		}

		// If it's a username or email
		if ( is_string( $user ) ) {
			// Try as username
			$user_obj = get_user_by( 'login', $user );
			if ( $user_obj ) {
				return $user_obj;
			}

			// Try as email
			$user_obj = get_user_by( 'email', $user );
			if ( $user_obj ) {
				return $user_obj;
			}
		}

		// User not found
		return null;
	}

	/**
	 * Build the user component structure
	 */
	protected function build(): void {
		$this->children = []; // Clear children

		// If user doesn't exist, display placeholder
		if ( ! $this->user ) {
			$this->add_child( Create::span( $this->options['placeholder'] )->add_class( 'placeholder' ) );

			return;
		}

		// Create wrapper div with proper classes
		$wrapper = Create::div()->add_class( 'user-wrapper' );

		// Add avatar if needed
		if ( $this->options['show_avatar'] ) {
			$avatar_size = intval( $this->options['avatar_size'] );
			$avatar_html = get_avatar( $this->user_id, $avatar_size );

			if ( $avatar_html ) {
				$avatar = Create::div()->add_class( 'avatar-wrapper' );
				$avatar->add_content( $avatar_html );
				$wrapper->add_child( $avatar );
			}
		}

		// Create content wrapper for name and role
		$content = Create::div()->add_class( 'user-content' );

		// Get user name based on specified type
		$name = $this->get_name_by_type();

		// Create user name element
		$name_element = Create::div( $name )->add_class( 'user-name' );

		// Add link if needed
		if ( $this->options['link'] ) {
			$url          = get_edit_user_link( $this->user_id );
			$name_element = Create::a( $url, $name_element );

			if ( ! empty( $this->options['link_target'] ) ) {
				$name_element->set_attribute( 'target', $this->options['link_target'] );
			}
		}

		// Add name to content
		$content->add_child( $name_element );

		// Add role if needed
		if ( $this->options['show_role'] && ! empty( $this->user->roles ) ) {
			$role       = reset( $this->user->roles );
			$role_names = wp_roles()->get_names();
			$role_name  = isset( $role_names[ $role ] ) ? translate_user_role( $role_names[ $role ] ) : $role;

			// Format role text
			$role_text = sprintf( $this->options['role_format'], $role_name );

			// Add role element
			$content->add_child( Create::div( $role_text )->add_class( 'user-role' ) );
		}

		// Add content to wrapper
		$wrapper->add_child( $content );

		// Add wrapper to component
		$this->add_child( $wrapper );
	}

	/**
	 * Get user name based on the configured name_type
	 *
	 * @return string
	 */
	protected function get_name_by_type(): string {
		if ( ! $this->user ) {
			return $this->options['placeholder'];
		}

		switch ( $this->options['name_type'] ) {
			case 'user_login':
				return $this->user->user_login;

			case 'first_name':
				return ! empty( $this->user->first_name ) ? $this->user->first_name : $this->user->display_name;

			case 'last_name':
				return ! empty( $this->user->last_name ) ? $this->user->last_name : $this->user->display_name;

			case 'full_name':
				$first = $this->user->first_name;
				$last  = $this->user->last_name;
				if ( empty( $first ) && empty( $last ) ) {
					return $this->user->display_name;
				}

				return trim( $first . ' ' . $last );

			case 'display_name':
			default:
				return $this->user->display_name;
		}
	}

	/**
	 * Show/hide avatar
	 *
	 * @param bool $show Whether to show avatar
	 *
	 * @return $this
	 */
	public function show_avatar( bool $show = true ): self {
		$this->options['show_avatar'] = $show;

		// Rebuild the component
		$this->build();

		return $this;
	}

	/**
	 * Set avatar size
	 *
	 * @param int $size Avatar size in pixels
	 *
	 * @return $this
	 */
	public function set_avatar_size( int $size ): self {
		$this->options['avatar_size'] = max( 1, $size );

		// Rebuild the component
		$this->build();

		return $this;
	}

	/**
	 * Set name type
	 *
	 * @param string $type Name type (display_name, user_login, first_name, last_name, full_name)
	 *
	 * @return $this
	 */
	public function set_name_type( string $type ): self {
		$valid_types = [ 'display_name', 'user_login', 'first_name', 'last_name', 'full_name' ];

		if ( in_array( $type, $valid_types, true ) ) {
			$this->options['name_type'] = $type;

			// Rebuild the component
			$this->build();
		}

		return $this;
	}

	/**
	 * Enable/disable user profile link
	 *
	 * @param bool $enable Whether to enable link
	 *
	 * @return $this
	 */
	public function enable_link( bool $enable = true ): self {
		$this->options['link'] = $enable;

		// Rebuild the component
		$this->build();

		return $this;
	}

	/**
	 * Show/hide user role
	 *
	 * @param bool $show Whether to show role
	 *
	 * @return $this
	 */
	public function show_role( bool $show = true ): self {
		$this->options['show_role'] = $show;

		// Rebuild the component
		$this->build();

		return $this;
	}

	/**
	 * Set role format
	 *
	 * @param string $format Format string (use %s for role name)
	 *
	 * @return $this
	 */
	public function set_role_format( string $format ): self {
		$this->options['role_format'] = $format;

		// Rebuild the component
		$this->build();

		return $this;
	}

	/**
	 * Get the user ID
	 *
	 * @return int
	 */
	public function get_user_id(): int {
		return $this->user_id;
	}

	/**
	 * Get the user object
	 *
	 * @return WP_User|null
	 */
	public function get_user() {
		return $this->user;
	}

}