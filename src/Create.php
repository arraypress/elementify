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
	use Traits\Common;
	use Traits\Headings;
	use Traits\Layout;
	use Traits\Lists;
	use Traits\Media;
	use Traits\Separators;
	use Traits\Social;
	use Traits\Utils;

	use Traits\Form\Core;
	use Traits\Form\Buttons;
	use Traits\Form\FieldWrappers;
	use Traits\Form\Inputs;
	use Traits\Form\Selects;

	use Traits\Components\Date;
	use Traits\Components\Interactive;
	use Traits\Components\Layout;
	use Traits\Components\Message;
	use Traits\Components\Navigation;

}