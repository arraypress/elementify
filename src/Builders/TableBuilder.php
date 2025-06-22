<?php
/**
 * Elementify Library - Table Builder
 *
 * Provides a fluent interface for building HTML tables with advanced features.
 *
 * @package     ArrayPress\Elementify\Builders
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Builders;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Element;
use Elementify\Create;

/**
 * Table Builder Class
 *
 * Provides a fluent interface for building complex HTML tables with headers,
 * rows, sorting, pagination, and other advanced table features.
 */
class TableBuilder extends Element {

	/**
	 * Table headers
	 *
	 * @var array
	 */
	protected array $headers = [];

	/**
	 * Table rows
	 *
	 * @var array
	 */
	protected array $rows = [];

	/**
	 * Table caption
	 *
	 * @var string
	 */
	protected string $caption = '';

	/**
	 * Whether table should be striped
	 *
	 * @var bool
	 */
	protected bool $striped = false;

	/**
	 * Whether table is sortable
	 *
	 * @var bool
	 */
	protected bool $sortable = false;

	/**
	 * Action column configuration
	 *
	 * @var array
	 */
	protected array $actions = [];

	/**
	 * Constructor
	 *
	 * @param array $attributes Element attributes
	 */
	public function __construct( array $attributes = [] ) {
		parent::__construct( 'table', null, $attributes );
	}

	/**
	 * Set table headers
	 *
	 * @param array $headers Array of header texts or header configurations
	 *
	 * @return $this For method chaining
	 */
	public function headers( array $headers ): self {
		$this->headers = $headers;

		return $this;
	}

	/**
	 * Add a single header
	 *
	 * @param string $text       Header text
	 * @param array  $attributes Header cell attributes
	 *
	 * @return $this For method chaining
	 */
	public function header( string $text, array $attributes = [] ): self {
		$this->headers[] = [
			'text'       => $text,
			'attributes' => $attributes
		];

		return $this;
	}

	/**
	 * Add a table row
	 *
	 * @param array $cells      Array of cell contents
	 * @param array $attributes Row attributes
	 *
	 * @return $this For method chaining
	 */
	public function row( array $cells, array $attributes = [] ): self {
		$this->rows[] = [
			'cells'      => $cells,
			'attributes' => $attributes
		];

		return $this;
	}

	/**
	 * Add multiple rows from data array
	 *
	 * @param array $data    Array of data rows
	 * @param array $columns Optional column mapping (for object/associative arrays)
	 *
	 * @return $this For method chaining
	 */
	public function data( array $data, array $columns = [] ): self {
		foreach ( $data as $item ) {
			if ( is_array( $item ) ) {
				// Handle associative arrays
				if ( ! empty( $columns ) ) {
					$cells = [];
					foreach ( $columns as $column ) {
						$cells[] = $item[ $column ] ?? '';
					}
					$this->row( $cells );
				} else {
					// Use array values directly
					$this->row( array_values( $item ) );
				}
			} elseif ( is_object( $item ) ) {
				// Handle objects
				if ( ! empty( $columns ) ) {
					$cells = [];
					foreach ( $columns as $column ) {
						$cells[] = $item->$column ?? '';
					}
					$this->row( $cells );
				}
			} else {
				// Handle scalar values
				$this->row( [ $item ] );
			}
		}

		return $this;
	}

	/**
	 * Set table caption
	 *
	 * @param string $caption Table caption text
	 *
	 * @return $this For method chaining
	 */
	public function caption( string $caption ): self {
		$this->caption = $caption;

		return $this;
	}

	/**
	 * Enable striped rows
	 *
	 * @param bool $striped Whether to enable striped rows
	 *
	 * @return $this For method chaining
	 */
	public function striped( bool $striped = true ): self {
		$this->striped = $striped;

		if ( $striped ) {
			$this->add_class( 'striped' );
		} else {
			$this->remove_class( 'striped' );
		}

		return $this;
	}

	/**
	 * Make table sortable
	 *
	 * @param bool $sortable Whether table should be sortable
	 *
	 * @return $this For method chaining
	 */
	public function sortable( bool $sortable = true ): self {
		$this->sortable = $sortable;

		if ( $sortable ) {
			$this->add_class( 'sortable' );
		} else {
			$this->remove_class( 'sortable' );
		}

		return $this;
	}

	/**
	 * Add WordPress list table classes
	 *
	 * @return $this For method chaining
	 */
	public function wp_list_table(): self {
		$this->add_class( 'wp-list-table widefat fixed' );

		return $this;
	}

	/**
	 * Add action buttons column
	 *
	 * @param array  $actions     Array of action configurations
	 * @param string $header_text Header text for actions column
	 *
	 * @return $this For method chaining
	 */
	public function actions( array $actions, string $header_text = 'Actions' ): self {
		$this->actions = $actions;

		// Add actions header if not already present
		if ( ! empty( $actions ) ) {
			$this->header( $header_text, [ 'class' => 'actions-column' ] );
		}

		return $this;
	}

	/**
	 * Make table responsive
	 *
	 * @return $this For method chaining
	 */
	public function responsive(): self {
		$this->add_class( 'responsive' );

		return $this;
	}

	/**
	 * Set table to full width
	 *
	 * @return $this For method chaining
	 */
	public function full_width(): self {
		$this->set_styles( [ 'width' => '100%' ] );

		return $this;
	}

	/**
	 * Build the table structure
	 *
	 * @return void
	 */
	protected function build(): void {
		$this->children = []; // Clear existing content

		// Add caption if set
		if ( ! empty( $this->caption ) ) {
			$this->add_child( Create::element( 'caption', $this->caption ) );
		}

		// Build header
		if ( ! empty( $this->headers ) ) {
			$thead      = Create::element( 'thead' );
			$header_row = Create::element( 'tr' );

			foreach ( $this->headers as $header ) {
				if ( is_string( $header ) ) {
					$th = Create::element( 'th', $header );
				} else {
					$th = Create::element( 'th', $header['text'] ?? '', $header['attributes'] ?? [] );
				}

				if ( $this->sortable ) {
					$th->add_class( 'sortable' );
				}

				$header_row->add_child( $th );
			}

			$thead->add_child( $header_row );
			$this->add_child( $thead );
		}

		// Build body
		if ( ! empty( $this->rows ) ) {
			$tbody = Create::element( 'tbody' );

			foreach ( $this->rows as $row_data ) {
				$tr = Create::element( 'tr', null, $row_data['attributes'] ?? [] );

				foreach ( $row_data['cells'] as $cell ) {
					if ( $cell instanceof Element ) {
						$td = Create::element( 'td' );
						$td->add_child( $cell );
					} else {
						$td = Create::element( 'td', $cell );
					}
					$tr->add_child( $td );
				}

				// Add actions column if configured
				if ( ! empty( $this->actions ) ) {
					$actions_cell = Create::element( 'td', null, [ 'class' => 'actions' ] );

					foreach ( $this->actions as $index => $action ) {
						if ( is_string( $action ) ) {
							$classes = [ 'button' ];

							// Add WordPress button classes based on action type
							if ( $action === 'edit' ) {
								$classes[] = 'button-secondary';
							} elseif ( $action === 'delete' ) {
								$classes[] = 'button-secondary';
								$classes[] = 'button-link-delete';
							} else {
								$classes[] = 'button-secondary';
							}

							$button = Create::button( ucfirst( $action ), 'button', [
								'class' => implode( ' ', $classes ) . " action-{$action}"
							] );
							$actions_cell->add_child( $button );

							// Add spacing between buttons
							if ( $index < count( $this->actions ) - 1 ) {
								$actions_cell->add_child( ' ' );
							}
						} elseif ( is_array( $action ) && isset( $action['text'], $action['url'] ) ) {
							$classes    = $action['classes'] ?? [ 'button', 'button-secondary' ];
							$attributes = array_merge(
								[ 'class' => is_array( $classes ) ? implode( ' ', $classes ) : $classes ],
								$action['attributes'] ?? []
							);
							$link       = Create::a( $action['url'], $action['text'], $attributes );
							$actions_cell->add_child( $link );
						}
					}

					$tr->add_child( $actions_cell );
				}

				$tbody->add_child( $tr );
			}

			$this->add_child( $tbody );
		}
	}

	/**
	 * Render the table
	 *
	 * @return string
	 */
	public function render(): string {
		$this->build();

		return parent::render();
	}

}