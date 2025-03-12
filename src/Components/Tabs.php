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

namespace Elementify\Components;

use Elementify\Abstracts\Component;
use Elementify\Create;
use Elementify\Element;
use Elementify\Traits\Component\Parts;
use Elementify\Traits\Component\SectionContent;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Tabs Component
 *
 * Creates a tabbed interface with navigation and content panels.
 */
class Tabs extends Component {
	use Parts;
	use SectionContent;

	/**
	 * Navigation element
	 *
	 * @var Element
	 */
	protected Element $nav;

	/**
	 * Content container element
	 *
	 * @var Element
	 */
	protected Element $content_container;

	/**
	 * Constructor
	 *
	 * @param array  $tabs        Array of tabs with 'id', 'title', and 'content' keys
	 * @param string $active_tab  ID of the active tab
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS
	 */
	public function __construct( array $tabs = [], string $active_tab = '', array $attributes = [], bool $include_css = true ) {
		// Set base class
		$this->base_class = 'tabs-container';

		// Initialize component foundation
		$this->init_component( 'tabs', $attributes, $include_css );

		// Initialize with a div element
		parent::__construct( 'div', null, $attributes );

		// Create navigation and content container
		$this->nav               = Create::ul()->add_class( 'tabs-nav' );
		$this->content_container = Create::div()->add_class( 'tabs-content' );

		// Set active tab
		$this->active_section = $active_tab;

		// Add tabs if provided
		if ( ! empty( $tabs ) ) {
			$this->add_sections( $tabs );
		}

		// Build the tabs component
		$this->build();
	}

	/**
	 * Build the tabs component
	 */
	protected function build(): void {
		$this->children = []; // Clear children

		// Rebuild navigation
		$this->nav->children = [];

		// If no active tab is set but we have tabs, set the first one as active
		if ( empty( $this->active_section ) && ! empty( $this->sections ) ) {
			reset( $this->sections );
			$this->active_section = key( $this->sections );
		}

		// Build navigation tabs
		foreach ( $this->sections as $tab_id => $tab ) {
			$is_active = $tab_id === $this->active_section;

			$tab_link = Create::a( '#' . $tab_id, $tab['title'] )
			                  ->set_attribute( 'data-tab', $tab_id )
			                  ->add_class( $is_active ? 'active' : '' );

			$this->nav->add_child( Create::li( $tab_link ) );
		}

		// Rebuild content panels
		$this->content_container->children = [];

		// Build content panels
		foreach ( $this->sections as $tab_id => $tab ) {
			$is_active = $tab_id === $this->active_section;

			$content_panel = Create::div( $tab['content'] )
			                       ->set_id( $tab_id )
			                       ->add_class( 'tab-content' . ( $is_active ? ' active' : '' ) );

			$this->content_container->add_child( $content_panel );
		}

		// Add navigation and content to the component
		$this->add_child( $this->nav );
		$this->add_child( $this->content_container );
	}

	/**
	 * Set the active tab
	 *
	 * @param string $id Tab ID to make active
	 *
	 * @return $this
	 */
	public function set_active_tab( string $id ): self {
		return $this->set_section_active( $id );
	}

	/**
	 * Get the active tab ID
	 *
	 * @return string
	 */
	public function get_active_tab(): string {
		return $this->get_active_section();
	}

	/**
	 * Get all tabs
	 *
	 * @return array
	 */
	public function get_tabs(): array {
		return $this->get_sections();
	}

	/**
	 * Get a specific tab
	 *
	 * @param string $id Tab ID
	 *
	 * @return array|null
	 */
	public function get_tab( string $id ): ?array {
		return $this->get_section( $id );
	}

	/**
	 * Add a single tab
	 *
	 * @param string $id      Tab ID
	 * @param string $title   Tab title
	 * @param mixed  $content Tab content
	 *
	 * @return $this
	 */
	public function add_tab( string $id, string $title, $content ): self {
		return $this->add_section( $id, $title, $content );
	}

	/**
	 * Remove a tab
	 *
	 * @param string $id Tab ID to remove
	 *
	 * @return $this
	 */
	public function remove_tab( string $id ): self {
		return $this->remove_section( $id );
	}

	/**
	 * Get the navigation element
	 *
	 * @return Element
	 */
	public function get_nav(): Element {
		return $this->nav;
	}

	/**
	 * Get the content container element
	 *
	 * @return Element
	 */
	public function get_content_container(): Element {
		return $this->content_container;
	}
}