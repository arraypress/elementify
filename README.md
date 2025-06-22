# Elementify - A Fluent HTML Builder for WordPress

[![PHP Version](https://img.shields.io/badge/php-7.4%2B-blue.svg)](https://php.net)
[![WordPress](https://img.shields.io/badge/wordpress-5.0%2B-blue.svg)](https://wordpress.org)
[![License](https://img.shields.io/badge/license-GPL--2.0%2B-green.svg)](LICENSE)

Elementify is a powerful PHP library that provides a fluent interface for generating HTML elements and components with proper escaping, self-closing tags, and attribute handling. Built specifically for WordPress, it offers both object-oriented and procedural APIs, making it perfect for theme and plugin development.

## 🚀 Key Features

- **Fluent Interface**: Chainable methods for readable, maintainable code
- **Automatic XSS Protection**: Intelligent content escaping based on element context
- **Self-Closing Tags**: Proper HTML5 self-closing tag handling
- **Rich Components**: Pre-built UI components like cards, progress bars, notices, and more
- **WordPress Integration**: Seamless integration with WordPress functions and styles
- **Dual API**: Both object-oriented and procedural approaches
- **Asset Management**: Automatic CSS/JS loading for components
- **Accessibility**: Built-in ARIA attributes and semantic markup
- **Type Safety**: PHP 7.4+ type hints for better code quality

## 📦 Installation

Install via Composer:

```bash
composer require arraypress/elementify
```

## 🎯 Quick Start

### Object-Oriented Approach

```php
use Elementify\Create;

// Create a card component
$card = Create::card(
    'This is the card content with <strong>HTML</strong>.',
    'Card Title',
    'Footer content'
)->add_class('my-card');

echo $card->render();
```

### Procedural Approach

```php
// Create a form with fields
$form = el_create_element('form', null, ['action' => 'process.php', 'method' => 'post']);
// Note: Procedural functions are limited - use Create class for full functionality
```

## 📚 Core Concepts

### Elements vs Components

**Elements** are basic HTML tags with smart escaping:
```php
// Text elements escape content for XSS protection
$p = Create::p('User input: <script>alert("xss")</script>');
// Output: <p>User input: &lt;script&gt;alert("xss")&lt;/script&gt;</p>

// Container elements preserve HTML structure
$div = Create::div();
$div->add_child(Create::p('Safe content'));
$div->add_child('<strong>HTML preserved</strong>');
```

**Components** are advanced UI elements with built-in functionality:
```php
// Components handle complex interactions and styling
$progressBar = Create::progress_bar(75, 100, [
    'show_percentage' => true,
    'size' => 'large'
]);
```

### Automatic Escaping

Elementify intelligently handles content escaping based on context:

- **Text elements** (p, span, h1-h6): Content is escaped
- **Container elements** (div, section, article): Content is preserved
- **Form elements**: Values are escaped, structure is preserved
- **Components**: Handle their own escaping logic

## 🧱 Basic Elements

### Text Elements

```php
// Headings
$h1 = Create::h1('Page Title');
$h2 = Create::h2('Section Title', ['id' => 'section-1']);

// Text content
$p = Create::p('Paragraph with <em>escaped</em> content');
$span = Create::span('Inline text', ['class' => 'highlight']);
$code = Create::code('$variable = "value";');
```

### Layout Elements

```php
// Semantic layout
$page = Create::section(
    Create::article([
        Create::header(Create::h1('Article Title')),
        Create::p('Article content goes here.'),
        Create::footer('Published on ' . date('Y-m-d'))
    ])
);

// Flexible containers
$container = Create::div(['class' => 'container'])
    ->add_child(Create::p('First paragraph'))
    ->add_child(Create::p('Second paragraph'));
```

### Lists

```php
// Simple lists
$ul = Create::ul(['Item 1', 'Item 2', 'Item 3']);

// Complex lists with links
$navList = Create::ul([
    Create::li(Create::a('/home', 'Home')),
    Create::li(Create::a('/about', 'About')),
    Create::li(Create::a('/contact', 'Contact'))
]);

// Definition lists
$dl = Create::dl([
    'HTML' => 'HyperText Markup Language',
    'CSS' => 'Cascading Style Sheets'
]);
```

## 📝 Form Elements

### Basic Form Structure

```php
$form = Create::form('submit.php', 'post', ['class' => 'contact-form']);

// Add fields using the field wrapper
$form->add_child(Create::field('name', 'Full Name', 'Enter your complete name'));
$form->add_child(Create::field(
    Create::email('email', '', ['required' => true]),
    'Email Address',
    'We will never share your email'
));

// Add WordPress nonce
$form->add_nonce('contact_form_action');

// Add submit button
$form->add_child(Create::submit('Send Message', ['class' => 'btn btn-primary']));
```

### Input Types

```php
// Text inputs
$username = Create::text('username', 'john_doe', ['placeholder' => 'Username']);
$email = Create::email('email', '', ['required' => true]);
$password = Create::password('password');
$number = Create::number('age', 25, ['min' => 18, 'max' => 100]);

// Choices
$checkbox = Create::checkbox('newsletter', '1', true);
$radio = Create::radio('size', 'medium', true, ['id' => 'size-medium']);

// Advanced inputs
$range = Create::range('volume', '75', '0', '100', '5', true); // With value display
$color = Create::color('theme_color', '#ff6b6b');
$file = Create::file('upload', ['accept' => 'image/*']);
```

### Select Elements

```php
// Basic dropdown
$select = Create::select('country', [
    'us' => 'United States',
    'ca' => 'Canada',
    'uk' => 'United Kingdom'
], 'us');

// Grouped options
$categorySelect = Create::select('category');
$categorySelect->add_optgroup('Technology', [
    'web' => 'Web Development',
    'mobile' => 'Mobile Apps'
]);
$categorySelect->add_optgroup('Design', [
    'ui' => 'UI Design',
    'graphic' => 'Graphic Design'
]);
```

## 🎨 Available Components

### Layout Components

#### Cards

```php
// Simple card
$card = Create::card(
    'Card content with <strong>HTML</strong> support.',
    'Card Title',
    'Optional footer content'
);

// Advanced card with image
$advancedCard = Create::card_advanced(
    'Product Title',
    'Product description with features and benefits.',
    '/images/product.jpg',
    'Price: $99.99'
);

// Card variants
$compactCard = Create::card('Content', 'Title', null, [], 'compact');
$borderlessCard = Create::card('Content', 'Title', null, [], 'borderless');
$noPaddingCard = Create::card('Content', 'Title', null, [], 'no-padding');
```

### Display Components

#### Progress Bars

```php
// Basic progress bar
$progress = Create::progress_bar(75, 100, [
    'show_percentage' => true,
    'show_current' => true,
    'size' => 'large'
]);

// Customizing progress bar
$customProgress = Create::progress_bar(45, 100)
    ->set_size('small')
    ->show_percentage(true)
    ->show_current(true);
```

#### Status Badges

```php
// Status badges
$successBadge = Create::badge('Active', 'success');
$warningBadge = Create::badge('Pending Review', 'warning');
$errorBadge = Create::badge('Failed', 'error');
$infoBadge = Create::badge('Processing', 'info');

// Custom badge with icon
$customBadge = Create::badge('Custom Status', 'default', ['icon' => 'yes']);
```

#### Rating Display

```php
// Star rating
$rating = Create::rating(4.5, [
    'max' => 5,
    'style' => 'stars',
    'show_value' => true,
    'precision' => 1
]);

// Different rating styles
$heartRating = Create::rating(3, ['style' => 'hearts', 'max' => 5]);
$thumbsRating = Create::rating(1, ['style' => 'thumbs', 'max' => 1]);

// Using dashicons
$dashiconRating = Create::rating(4, [
    'dashicons' => true,
    'style' => 'stars'
]);
```

#### Boolean Icons

```php
// Boolean indicator
$checkIcon = Create::boolean_icon(true, [
    'true_icon' => 'yes-alt',
    'false_icon' => 'no-alt'
]);

// Custom boolean display
$customBoolean = Create::boolean_icon($user_active, [
    'true_label' => 'Active User',
    'false_label' => 'Inactive User'
]);
```

#### Data Display

```php
// Number formatting
$revenue = Create::number_format(1234567.89, [
    'decimals' => 2,
    'prefix' => '$',
    'short_format' => true // Shows as $1.23M
]);

// File sizes
$fileSize = Create::filesize(1234567890, ['decimals' => 1]); // Shows as 1.1 GB

// Color swatches
$colorSwatch = Create::color_swatch('#ff6b6b', [
    'size' => 24,
    'shape' => 'circle',
    'show_value' => true
]);

// Time ago display
$timeAgo = Create::timeago('2024-01-15 10:30:00', [
    'show_tooltip' => true,
    'cutoff' => 7 * 24 * 3600 // Show absolute date after 1 week
]);

// User display with avatar
$userDisplay = Create::user(123, [
    'show_avatar' => true,
    'avatar_size' => 48,
    'name_type' => 'display_name',
    'show_role' => true
]);
```

### Navigation Components

#### Breadcrumbs

```php
// From array
$breadcrumbs = Create::breadcrumbs([
    ['text' => 'Home', 'url' => '/'],
    ['text' => 'Products', 'url' => '/products'],
    'Current Product'
]);

// From URL path
$pathBreadcrumbs = Create::breadcrumbs_from_path(
    'products/electronics/smartphones', 
    'https://example.com/'
);

// From URL map
$mapBreadcrumbs = Create::breadcrumbs_map([
    '/' => 'Home',
    '/products' => 'Products',
    '/products/electronics' => 'Electronics',
    'Smartphones' // Current page
]);
```

### Interactive Components

#### Toggle Switch

```php
// Basic toggle
$toggle = Create::toggle('notifications', true, '1', 'Enable Notifications');

// Disabled toggle
$disabledToggle = Create::toggle('feature', false, '1', 'Feature Toggle', [], true);
```

#### Featured Star

```php
// Featured indicator
$featured = Create::featured('is_featured', true, 'Mark as Featured');

// Disabled featured control
$disabledFeatured = Create::featured('featured', false, 'Featured', [], true);
```

#### Range Slider

```php
// Range with value display
$rangeSlider = Create::range('volume', '75', '0', '100', '5', true);

// Customized range
$customRange = Create::range('price', '50', '0', '200', '10', true)
    ->set_value('75')
    ->set_display_value(true);
```

#### Clipboard

```php
// Simple clipboard component
$clipboard = Create::clipboard('https://example.com/share/abc123', [
    'display_text' => 'Share Link',
    'max_length' => 20,
    'tooltip' => 'Click to copy share link'
]);
```

### Notification Components

#### Notices

```php
// Different notice types
$successNotice = Create::success_notice('Settings saved successfully!', true); // Dismissible
$warningNotice = Create::warning_notice('Please review your settings before continuing.');
$errorNotice = Create::error_notice('An error occurred while processing your request.');
$infoNotice = Create::info_notice('This feature is currently in beta.');

// Generic notice
$customNotice = Create::notice('Custom message', 'info', false);
```

## ⚙️ Advanced Usage

### Method Chaining

All elements support extensive method chaining for clean, readable code:

```php
$complexElement = Create::div()
    ->set_id('main-container')
    ->add_class(['container', 'fluid'])
    ->set_data('role', 'main')
    ->set_aria('label', 'Main content area')
    ->set_styles(['margin' => '20px', 'padding' => '10px'])
    ->add_child(Create::h1('Welcome')->add_class('hero-title'))
    ->add_child(Create::p('This is the main content area.'))
    ->toggle_class('active', $is_active)
    ->toggle_attribute('hidden', true, $is_hidden);

echo $complexElement->render();
```

### Conditional Rendering

```php
// Render only if condition is met
$element = Create::div('Content');
echo $element->render_if($user_is_logged_in);

// Toggle classes and attributes based on conditions
$button = Create::button('Submit')
    ->toggle_class('disabled', !$form_is_valid)
    ->toggle_attribute('disabled', true, !$form_is_valid);
```

### Working with Collections

```php
// Create multiple similar elements
$listItems = [];
foreach ($menuItems as $item) {
    $listItems[] = Create::li(
        Create::a($item['url'], $item['title'])
            ->toggle_class('active', $item['is_current'])
    );
}

$menu = Create::ul($listItems, ['class' => 'main-nav']);
```

### Custom Attributes and Data

```php
$element = Create::div('Content')
    ->set_data('component', 'modal')
    ->set_data('config', json_encode(['autoClose' => true]))
    ->set_aria('hidden', 'true')
    ->set_aria('labelledby', 'modal-title')
    ->add_tooltip('Click to interact');
```

### Asset Management

Components automatically load their required CSS and JavaScript:

```php
// These components will automatically enqueue their assets
$progressBar = Create::progress_bar(50); // Loads progress-bar.css
$rangeSlider = Create::range('volume', '50'); // Loads range.css and range.js
$clipboard = Create::clipboard('text'); // Loads clipboard.css and clipboard.js

// Manual asset loading
\Elementify\Assets::enqueue(['card', 'notice', 'progress-bar']);
\Elementify\Assets::enqueue('all'); // Load all component assets
```

## 🔒 Security

Elementify provides automatic XSS protection through intelligent content escaping:

- **User-generated content** is automatically escaped
- **Trusted HTML structures** are preserved
- **Component content** is handled contextually
- **WordPress integration** uses `wp_kses_post()` for content filtering

```php
// Safe - content is escaped
Create::p($_POST['user_input']);

// Safe - HTML structure preserved, content escaped appropriately
Create::div([
    Create::h2('Safe Title'),
    Create::p('User content: ' . $_POST['content'])
]);
```

## 🧪 Element Inspection

```php
// Element inspection methods
$element = Create::div('Content')->add_class('container');

// Check properties
$hasClass = $element->has_class('container'); // true
$id = $element->get_attribute('id', 'default'); // 'default'
$children = $element->get_children(); // array of child elements
$tag = $element->get_tag(); // 'div'

// Content extraction
$content = $element->get_content_string();
```

## 📚 WordPress Integration

### Theme Development

```php
// In template files
echo Create::card(
    get_the_content(),
    get_the_title(),
    'Posted on ' . get_the_date()
);

// User display in author bio
echo Create::user(get_the_author_meta('ID'), [
    'show_avatar' => true,
    'show_role' => true
]);
```

### Plugin Development

```php
// Admin notices
add_action('admin_notices', function() {
    Create::success_notice('Plugin activated successfully!', true)->output();
});

// Settings forms with nonce
function render_settings_form() {
    $form = Create::form('options.php', 'post');
    $form->add_nonce('my_plugin_settings', '_wpnonce');
    
    $form->add_child(Create::field('api_key', 'API Key', 'Enter your API key'));
    $form->add_child(Create::submit('Save Settings'));
    
    return $form->render();
}
```

## 🔗 Links & Media

### Link Types

```php
// Basic links
$link = Create::a('https://example.com', 'Visit Example');
$external = Create::external_link('https://google.com', 'Google', ['class' => 'external']);

// Communication links
$email = Create::mailto('contact@example.com', 'Email Us');
$phone = Create::tel('+1-555-123-4567', 'Call Now');

// Download links
$download = Create::download('/files/document.pdf', 'document.pdf', 'Download PDF');
```

### Media Elements

```php
// Images
$image = Create::img('/images/photo.jpg', 'Beautiful landscape');

// Responsive images
$picture = Create::picture([
    ['src' => '/images/small.jpg', 'media' => '(max-width: 600px)'],
    ['src' => '/images/medium.jpg', 'media' => '(max-width: 1200px)']
], '/images/large.jpg', 'Responsive image');

// Audio/Video
$audio = Create::audio('/media/podcast.mp3', true); // With controls
$video = Create::video(['/video/demo.mp4', '/video/demo.webm'], true);
```

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

1. Fork the repository
2. Create a feature branch
3. Add tests for new functionality
4. Ensure all tests pass
5. Submit a pull request

## 📄 License

This project is licensed under the GPL-2.0+ License. See the [LICENSE](LICENSE) file for details.

## 🆘 Support

- **Documentation**: [Full documentation](https://github.com/arraypress/elementify/wiki)
- **Issues**: [Issue tracker](https://github.com/arraypress/elementify/issues)
- **Discussions**: [GitHub Discussions](https://github.com/arraypress/elementify/discussions)

---

**Built with ❤️ by [ArrayPress](https://arraypress.com)**