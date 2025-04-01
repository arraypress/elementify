<?php
/**
 * Plugin Name: Elementify Loader
 * Plugin URI: https://arraypress.com/plugins/elementify-loader
 * Description: Simple plugin to load and initialize the Elementify HTML element generator.
 * Version: 1.0.0
 * Author: ArrayPress
 * Author URI: https://arraypress.com
 * License: GPL2+
 * Text Domain: elementify-loader
 * Domain Path: /languages
 *
 * @package Elementify_Loader
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Define plugin constants
 */
define( 'ELEMENTIFY_LOADER_VERSION', '1.0.0' );
define( 'ELEMENTIFY_LOADER_FILE', __FILE__ );
define( 'ELEMENTIFY_LOADER_PATH', plugin_dir_path( ELEMENTIFY_LOADER_FILE ) );
define( 'ELEMENTIFY_LOADER_URL', plugin_dir_url( ELEMENTIFY_LOADER_FILE ) );

/**
 * Check if Elementify is already loaded
 */
if ( ! class_exists( 'Elementify\\Element' ) ) {
	/**
	 * Manually include Elementify files
	 *
	 * This is the "without Composer" approach, loading files directly
	 */
	function elementify_loader_include_files() {
		// Traits
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Component/Parts.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Component/SectionContent.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Base.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Common.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Headings.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Layout.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Lists.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Media.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Social.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Separators.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Links.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Location.php';

		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Form/Core.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Form/Buttons.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Form/FieldWrappers.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Form/Inputs.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Form/Selects.php';

		// Updated Components Traits - changed from old structure
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Components/Date.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Components/Display.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Components/Indicators.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Components/Input.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Components/Layout.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Components/Messaging.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Components/Navigation.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Components/Utility.php';

		// Base classes
		require_once ELEMENTIFY_LOADER_PATH . 'src/Element.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Assets.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Create.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Utils.php';

		// Abstracts
		require_once ELEMENTIFY_LOADER_PATH . 'src/Abstracts/Component.php';

		// Elements
		require_once ELEMENTIFY_LOADER_PATH . 'src/Elements/Button.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Elements/Field.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Elements/Form.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Elements/Input.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Elements/Label.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Elements/Select.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Elements/Textarea.php';

		// Components
		// Interactive Components
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Interactive/Accordion.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Interactive/DatePicker.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Interactive/Modal.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Interactive/Tabs.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Interactive/Tooltip.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Interactive/Range.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Interactive/Toggle.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Interactive/Clipboard.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Interactive/Featured.php';

		// Layout Components
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Layout/Breadcrumbs.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Layout/Card.php';

		// Display Components
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Display/BooleanIcon.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Display/ColorSwatch.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Display/FileSize.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Display/ProgressBar.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Display/StatusBadge.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Display/Rating.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Display/TimeAgo.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Display/User.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Display/NumberFormat.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Display/AttachmentImage.php';

		// Notification Components
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Notification/Notice.php';

		// Taxonomy Components
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Taxonomy/Taxonomy.php';

		// Function files
		require_once ELEMENTIFY_LOADER_PATH . 'src/Utilities/Functions.php';
	}

	// Load Elementify files
	elementify_loader_include_files();
}