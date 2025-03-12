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
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Core.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Components.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Forms.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Headings.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Layout.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Lists.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Traits/Media.php';

		// Base classes
		require_once ELEMENTIFY_LOADER_PATH . 'src/Element.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Assets.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Create.php';

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
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Accordion.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Breadcrumbs.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Card.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/DatePicker.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Modal.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Notice.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/ProgressBar.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/StatusBadge.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Tabs.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Components/Tooltip.php';

		// Function files
		require_once ELEMENTIFY_LOADER_PATH . 'src/Functions/Core.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Functions/Common.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Functions/Accordion.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Functions/Badges.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Functions/Breadcrumbs.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Functions/Brevity.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Functions/Card.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Functions/DatePicker.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Functions/Form.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Functions/Layout.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Functions/List.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Functions/Media.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Functions/Modal.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Functions/Notices.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Functions/ProgressBar.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Functions/Seperators.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Functions/Social.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Functions/Tabs.php';
		require_once ELEMENTIFY_LOADER_PATH . 'src/Functions/Tooltip.php';
	}

	// Load Elementify files
	elementify_loader_include_files();
}