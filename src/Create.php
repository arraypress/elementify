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
	use Traits\Base\Base;
	use Traits\Base\Common;
	use Traits\Base\Headings;
	use Traits\Base\Layout;
	use Traits\Base\Links;
	use Traits\Base\Lists;
	use Traits\Base\Media;
	use Traits\Base\Separators;

	use Traits\Form\Core;
	use Traits\Form\Buttons;
	use Traits\Form\FieldWrappers;
	use Traits\Form\Inputs;
	use Traits\Form\Selects;

	use Traits\Components\Date;
	use Traits\Components\Display;
	use Traits\Components\Indicators;
	use Traits\Components\Input;
	use Traits\Components\Layout;
	use Traits\Components\Messaging;
	use Traits\Components\Navigation;
	use Traits\Components\Utility;
}