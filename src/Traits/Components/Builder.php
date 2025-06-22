<?php
/**
 * Elementify Library - Date Components Trait
 *
 * A collection of methods for creating date-related HTML components.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Traits\Components;

// Exit if accessed directly
use Elementify\Builders\BreadcrumbBuilder;
use Elementify\Builders\CardBuilder;
use Elementify\Builders\FormBuilder;
use Elementify\Builders\ListBuilder;
use Elementify\Builders\MediaBuilder;
use Elementify\Builders\ModalBuilder;
use Elementify\Builders\NoticeBuilder;
use Elementify\Builders\TableBuilder;

defined( 'ABSPATH' ) || exit;

/**
 * Date Components Trait
 *
 * Provides methods for creating and rendering date-related HTML components.
 */
trait Builder {

	/**
	 * Create a fluent form builder
	 *
	 * @param string $action     Form action URL
	 * @param string $method     Form method (get/post)
	 * @param array  $attributes Element attributes
	 *
	 * @return FormBuilder
	 */
	public static function form_builder( string $action = '', string $method = 'post', array $attributes = [] ): FormBuilder {
		return new FormBuilder( $action, $method, $attributes );
	}

	/**
	 * Create a fluent card builder
	 *
	 * @param array $attributes Element attributes
	 *
	 * @return CardBuilder
	 */
	public static function card_builder( array $attributes = [] ): CardBuilder {
		return new CardBuilder( null, '', null, $attributes );
	}

	/**
	 * Create a fluent table builder
	 *
	 * @param array $attributes Element attributes
	 *
	 * @return TableBuilder
	 */
	public static function table_builder( array $attributes = [] ): TableBuilder {
		return new TableBuilder( $attributes );
	}

	/**
	 * Create a fluent list builder
	 *
	 * @param array $attributes Element attributes
	 *
	 * @return ListBuilder
	 */
	public static function list_builder( array $attributes = [] ): ListBuilder {
		return new ListBuilder( $attributes );
	}

	/**
	 * Create a fluent breadcrumb builder
	 *
	 * @param array $attributes Element attributes
	 *
	 * @return BreadcrumbBuilder
	 */
	public static function breadcrumb_builder( array $attributes = [] ): BreadcrumbBuilder {
		return new BreadcrumbBuilder( [], '/', $attributes );
	}

	/**
	 * Create a fluent notice builder
	 *
	 * @param mixed  $content    Notice content
	 * @param string $type       Notice type
	 * @param array  $attributes Element attributes
	 *
	 * @return NoticeBuilder
	 */
	public static function notice_builder( $content = '', string $type = 'info', array $attributes = [] ): NoticeBuilder {
		return new NoticeBuilder( $content, $type, false, $attributes );
	}

	/**
	 * Create a fluent media builder
	 *
	 * @param array $attributes Element attributes
	 *
	 * @return MediaBuilder
	 */
	public static function media_builder( array $attributes = [] ): MediaBuilder {
		return new MediaBuilder( $attributes );
	}

	/**
	 * Create a fluent modal builder
	 *
	 * @param string $modal_id   Modal ID
	 * @param array  $attributes Element attributes
	 *
	 * @return ModalBuilder
	 */
	public static function modal_builder( string $modal_id, array $attributes = [] ): ModalBuilder {
		return new ModalBuilder( $modal_id, $attributes );
	}

}