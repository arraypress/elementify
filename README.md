# Elementify - A Fluent HTML Element Generator for WordPress

Elementify is a comprehensive PHP library that allows developers to easily create HTML elements and components with proper escaping, self-closing tags, and attribute handling. It offers both an object-oriented and procedural API, making it versatile for different coding preferences.

## Installation

```bash
composer require arraypress/elementify
```

## Basic Usage

Elementify provides two distinct ways to create HTML elements:

### 1. Object-Oriented Approach (using the `Create` class)

```php
use Elementify\Create;

/// Create a div with classes and content
$div = Create::div( 'Content here' )
             ->add_class( 'container' )
             ->set_id( 'main-content' );

/// Render the element
echo $div->render();
```

### 2. Procedural Approach (using utility functions)

```php
// Create a div with classes and content 
$div = el_div( 'Content here', [ 'class' => 'container', 'id' => 'main-content' ] );

// Render the element
echo $div->render();

// Or render directly
el_div_render( 'Content here', [ 'class' => 'container', 'id' => 'main-content' ] );
```

## Creating Basic Elements

### Text and Container Elements

```php
// Creating a paragraph
el_p_render( 'This is a paragraph with <b>bold</b> text', [ 'class' => 'intro' ] );

// Creating a div
$container = el_div( null, [ 'class' => 'container' ] );
$container->add_content( 'First paragraph' );
$container->add_content( el_p( 'Second paragraph in a p element' ) );
echo $container->render();

// Creating a span
el_span_render( 'Inline text', [ 'class' => 'highlight' ] );

// Creating headings
el_h_render( 1, 'Page Title' );
el_h_render( 2, 'Section Title', [ 'id' => 'section-1' ] );
```

### Links and Anchors

```php
// Simple link
el_a_render( 'https://example.com', 'Visit Example' );

// Link with attributes
echo el_a( 'https://example.com', 'Visit Example', [
	'class'  => 'button',
	'target' => '_blank',
	'rel'    => 'noopener'
] )->render();
```

### Lists

```php
// Unordered list
el_ul_render( [
	'Item 1',
	'Item 2',
	el_li( 'Item 3 with <b>bold</b> text' )
] );

// Ordered list
el_ol_render( [
	'First item',
	'Second item',
	'Third item'
], [ 'class' => 'numbered-list' ] );

// Definition list
el_dl_render( [
	'HTML' => 'HyperText Markup Language',
	'CSS'  => 'Cascading Style Sheets',
	'PHP'  => 'PHP: Hypertext Preprocessor'
] );
```

### Media Elements

```php
// Image
el_img_render( 'path/to/image.jpg', 'Alt text description' );

// Picture with responsive sources
el_picture_render( [
	[ 'src' => 'small.jpg', 'media' => '(max-width: 600px)' ],
	[ 'src' => 'medium.jpg', 'media' => '(max-width: 1200px)' ]
], 'large.jpg', 'Image description' );

// Audio
el_audio_render( 'path/to/audio.mp3' );

// Video
el_video_render( 'path/to/video.mp4' );

// Iframe
el_iframe_render( 'https://www.youtube.com/embed/VIDEO_ID', 'Video title' );
```

## Form Elements

### Basic Form Structure

```php
// Create a form
$form = el_form( 'process.php', 'post', [ 'class' => 'contact-form' ] );

// Add form fields
$form->add_child( el_field( 'name', 'Your Name', 'Please enter your full name' ) );
$form->add_child( el_field( el_email( 'email' ), 'Email Address', 'We will not share your email' ) );
$form->add_child( el_field( el_textarea( 'message', '' ), 'Your Message' ) );
$form->add_child( el_submit( 'Send Message', [ 'class' => 'button button-primary' ] ) );

// Add WordPress nonce field
$form->add_nonce( 'contact_form_nonce' );

// Render the form
echo $form->render();
```

### Input Fields

```php
// Text input
el_text_render( 'username', 'Current value', [ 'placeholder' => 'Enter username' ] );

// Email input
el_email_render( 'user_email', '', [ 'required' => true ] );

// Password input
el_password_render( 'password', [ 'autocomplete' => 'new-password' ] );

// Number input
el_input_render( 'number', 'quantity', 1, [
	'min'  => 1,
	'max'  => 10,
	'step' => 1
] );

// Checkbox
el_checkbox_render( 'subscribe', '1', true, [ 'id' => 'subscribe-checkbox' ] );

// Radio buttons
el_radio_render( 'size', 'small', false, [ 'id' => 'size-small' ] );
el_radio_render( 'size', 'medium', true, [ 'id' => 'size-medium' ] );
el_radio_render( 'size', 'large', false, [ 'id' => 'size-large' ] );
```

### Select Dropdowns

```php
// Basic select dropdown
el_select_render(
	'country',
	[
		'us' => 'United States',
		'ca' => 'Canada',
		'uk' => 'United Kingdom',
		'au' => 'Australia'
	],
	'us'
);

// Select with option groups
$options = [
	'Fruits'     => [
		'apple'  => 'Apple',
		'banana' => 'Banana',
		'orange' => 'Orange'
	],
	'Vegetables' => [
		'carrot'  => 'Carrot',
		'celery'  => 'Celery',
		'spinach' => 'Spinach'
	]
];

$select = el_select( 'food_category', [], 'apple' );

foreach ( $options as $group_label => $group_options ) {
	$select->add_optgroup( $group_label, $group_options );
}

echo $select->render();
```

### Textarea

```php
// Simple textarea
el_textarea_render( 'description', 'Current content', [
	'rows'        => 5,
	'placeholder' => 'Enter description here'
] );

// Textarea with additional attributes
echo el_textarea( 'comments', '', [
	'rows'     => 4,
	'cols'     => 50,
	'required' => true,
	'class'    => 'comment-field'
] )->render();
```

### Buttons

```php
// Submit button
el_submit_render( 'Save Changes' );

// Button with custom type
el_button_render( 'Cancel', 'button', [ 'class' => 'button-secondary' ] );

// Button with data attributes
echo el_button( 'Delete', 'button', [
	'class'        => 'button button-danger',
	'data-confirm' => 'Are you sure?'
] )->render();
```

## UI Components

### Tabs

```php
// Basic tabs
Create::tabs_render( [
	[
		'id'      => 'tab1',
		'title'   => 'General',
		'content' => 'General settings content here.'
	],
	[
		'id'      => 'tab2',
		'title'   => 'Advanced',
		'content' => 'Advanced settings content here.'
	]
], 'tab1' );

// Alternative format with ID as key
el_tabs_flexible_render( [
	'general'  => [
		'title'   => 'General',
		'content' => 'General content'
	],
	'advanced' => [
		'title'   => 'Advanced',
		'content' => 'Advanced content'
	]
], 'general' );
```

### Accordion

```php
// Basic accordion
Create::accordion_render( [
	[
		'title'   => 'Section 1',
		'content' => 'Content for section 1',
		'active'  => true
	],
	[
		'title'   => 'Section 2',
		'content' => 'Content for section 2'
	]
] );

// Accordion with multiple sections open
$accordion = Create::accordion( [
	[
		'title'   => 'FAQ Item 1',
		'content' => 'Answer 1',
		'active'  => true
	],
	[
		'title'   => 'FAQ Item 2',
		'content' => 'Answer 2',
		'active'  => true
	]
], true ); /// Allow multiple sections to be open

echo $accordion->render();
```

### Cards

```php
// Basic card
Create::card_render(
	'This is the card body content.',
	'Card Title',
	'Card Footer'
);

// Card with image and variant
echo Create::card(
	'This is a product with high quality materials.',
	'Product Card',
	'Price: $99.99',
	[ 'class' => 'product-card' ],
	true,
	'compact'
)->render();
```

### Modal Dialogs

```php
// Basic modal
$modal = Create::modal(
	'Confirmation',
	'Are you sure you want to delete this item?',
	[
		[ 'text' => 'Cancel', 'type' => 'button', 'class' => 'button' ],
		[ 'text' => 'Delete', 'type' => 'button', 'class' => 'button button-danger' ]
	]
);

// Create a button to trigger the modal
echo $modal->create_trigger( 'Delete Item', [ 'class' => 'button button-danger' ] )->render();

// Output the modal
echo $modal->render();
```

### Notices

```php
// Basic notice types
Create::notice_render( 'This is a general information notice.', 'info' );
Create::notice_render( 'Operation completed successfully!', 'success' );
Create::notice_render( 'Please check your input before proceeding.', 'warning' );
Create::notice_render( 'An error occurred during the operation.', 'error' );
```

### Progress Bar

```php
// Basic progress bar
Create::progress_bar_render( 75, 100 );

// Progress bar with options
echo Create::progress_bar( 65, 100, [
	'show_percentage' => true,
	'show_current'    => true,
	'show_total'      => true,
	'size'            => 'large'
] )->render();
```

### Status Badges

```php
// Basic badges
Create::badge_render( 'Active', 'success' );
Create::badge_render( 'Pending', 'warning' );
Create::badge_render( 'Failed', 'error' );
Create::badge_render( 'Processing', 'info' );
```

### Breadcrumbs

```php
// Basic breadcrumbs
Create::breadcrumbs_render( [
	[ 'text' => 'Home', 'url' => '/' ],
	[ 'text' => 'Products', 'url' => '/products' ],
	'Current Product'
] );

// Breadcrumbs from path
Create::breadcrumbs_from_path_render(
	'products/electronics/phones',
	'https://example.com/'
);
```

### Tooltip

```php
// Basic tooltip
echo Create::tooltip( 'Hover me', 'This is a tooltip', [ 'position' => 'top' ] )->render();

// Tooltip with different position
echo Create::tooltip( 'Right tooltip', 'Appears to the right', [ 'position' => 'right' ] )->render();
```

### DatePicker

```php
// Basic date picker
echo Create::datepicker( 'birthdate', '1990-01-15' )->render();

// Date picker with options
echo Create::datepicker( 'event_date', '2023-12-25', [
	'format'      => 'Y-m-d',
	'min_date'    => '2023-01-01',
	'max_date'    => '2023-12-31',
	'placeholder' => 'Select event date'
] )->render();
```

## Advanced Usage

### Chaining Methods

```php
// Create an element with chained methods
$div = el_div()
	->set_id( 'container' )
	->add_class( 'wrapper' )
	->set_data( 'role', 'main' )
	->add_content( 'First paragraph' )
	->add_content( el_p( 'Second paragraph' ) )
	->set_attribute( 'aria-label', 'Main content' );

echo $div->render();
```

### Working with Element Escape Logic

```php
// Content in text elements is escaped by default
echo el_p( 'This contains <b>HTML</b> that will be escaped' )->render();

// Container elements don't escape their content
$div = el_div();
$div->add_content( '<b>Bold text</b> preserved' );
$div->add_content( el_p( 'Paragraph with <b>escaped</b> content' ) );
echo $div->render();

// Explicit control over escaping
$element = el_element( 'div', 'Content with <b>HTML</b>' )
	->set_escape_content( true ); /// Force escaping
echo $element->render();
```

## Field Wrappers for Forms

```php
// Create a complete field with label and description
echo el_field( 'username', 'Username', 'Enter a unique username' )->render();

// Field with a specific input type
echo el_field(
	el_email( 'email_address', '', [ 'required' => true ] ),
	'Email Address',
	'We will send confirmation to this address'
)->render();

// Field with a textarea
echo el_field(
	el_textarea( 'bio', '', [ 'rows' => 4 ] ),
	'Biography',
	'Tell us about yourself'
)->render();

// Field with a select dropdown
echo el_field(
	el_select( 'country', [ 'us' => 'United States', 'ca' => 'Canada' ] ),
	'Country',
	'Select your country of residence'
)->render();
```

## Benefits Over Manual HTML

* **Proper Escaping**: Elements handle content escaping appropriately based on context
* **Self-Closing Tags**: Automatically manages self-closing tags like `<img>`, `<br>`, etc.
* **Attribute Handling**: Properly formats attributes, including boolean attributes
* **Fluent Interface**: Makes code more readable and maintainable
* **Type Safety**: Uses PHP type hints for better code quality
* **Built-in Components**: Ready-to-use UI components save development time

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request. For major changes, please open an issue first to discuss what you would like to change.

## License

This project is licensed under the GPL2+ License. See the LICENSE file for details.

## Support

For support, please use the [issue tracker](https://github.com/arraypress/elementify/issues).