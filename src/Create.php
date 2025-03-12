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

namespace Elementify;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Factory class for creating HTML elements
 */
class Create {
	use Traits\Core;
	use Traits\Components;
	use Traits\Forms;
	use Traits\Headings;
	use Traits\Layout;
	use Traits\Lists;
	use Traits\Media;
}