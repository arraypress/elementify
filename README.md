# Elementify - A Fluent HTML Generator for WordPress

[![PHP Version](https://img.shields.io/badge/php-8.0%2B-blue.svg)](https://php.net)
[![WordPress](https://img.shields.io/badge/wordpress-5.0%2B-blue.svg)](https://wordpress.org)
[![License](https://img.shields.io/badge/license-GPL--2.0%2B-green.svg)](LICENSE)

Elementify is a powerful PHP library that provides a fluent interface for generating HTML elements and components with proper escaping, self-closing tags, and attribute handling. It offers both object-oriented and procedural APIs, making it perfect for WordPress theme and plugin development.

## 🚀 Features

- **Fluent Interface**: Chainable methods for readable, maintainable code
- **Automatic XSS Protection**: Smart content escaping based on element context
- **Self-Closing Tags**: Proper HTML5 self-closing tag handling
- **Rich Components**: Pre-built UI components like modals, tabs, accordions, and more
- **WordPress Integration**: Seamless integration with WordPress functions and styles
- **Dual API**: Both object-oriented and procedural approaches
- **Asset Management**: Automatic CSS/JS loading for components
- **Accessibility**: Built-in ARIA attributes and semantic markup

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
$form = el_form('process.php', 'post', ['class' => 'contact-form']);
$form->add_child(el_field('name', 'Your Name', 'Enter your full name'));
$form->add_child(el_field(el_email('email'), 'Email', 'We will not share your email'));
$form->add_child(el_submit('Send Message'));

echo $form->render();
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
// Components handle complex interactions
$tabs = Create::tabs([
    ['id' => 'tab1', 'title' => 'General', 'content' => 'Settings content'],
    ['id' => 'tab2', 'title' => 'Advanced', 'content' => 'Advanced options']
], 'tab1');
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
Create::h1('Page Title');
Create::h2('Section Title', ['id' => 'section-1']);

// Text content
Create::p('Paragraph with <em>escaped</em> content');
Create::span('Inline text', ['class' => 'highlight']);
Create::code('$variable = "value";');
```

### Layout Elements

```php
// Semantic layout
Create::section(
    Create::article([
        Create::header(Create::h1('Article Title')),
        Create::p('Article content goes here.'),
        Create::footer('Published on ' . date('Y-m-d'))
    ])
);

// Flexible containers
Create::div(['class' => 'container'])
    ->add_child(Create::p('First paragraph'))
    ->add_child(Create::p('Second paragraph'));
```

### Lists

```php
// Simple lists
Create::ul(['Item 1', 'Item 2', 'Item 3']);

// Complex lists with links
Create::ul([
    Create::li(Create::a('/home', 'Home')),
    Create::li(Create::a('/about', 'About')),
    Create::li(Create::a('/contact', 'Contact'))
]);

// Definition lists
Create::dl([
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
Create::text('username', 'john_doe', ['placeholder' => 'Username']);
Create::email('email', '', ['required' => true]);
Create::password('password');
Create::number('age', 25, ['min' => 18, 'max' => 100]);

// Choices
Create::checkbox('newsletter', '1', true);
Create::radio('size', 'medium', true, ['id' => 'size-medium']);

// Advanced inputs
Create::range('volume', '75', '0', '100', '5', true); // With value display
Create::color('theme_color', '#ff6b6b');
Create::file('upload', ['accept' => 'image/*']);
```

### Select Elements

```php
// Basic dropdown
Create::select('country', [
    'us' => 'United States',
    'ca' => 'Canada',
    'uk' => 'United Kingdom'
], 'us');

// Grouped options
$select = Create::select('category');
$select->add_optgroup('Technology', [
    'web' => 'Web Development',
    'mobile' => 'Mobile Apps'
]);
$select->add_optgroup('Design', [
    'ui' => 'UI Design',
    'graphic' => 'Graphic Design'
]);
```

## 🎨 UI Components

### Cards

```php
// Simple card
Create::card(
    'Card content with <strong>HTML</strong> support.',
    'Card Title',
    'Optional footer content'
);

// Card with image
Create::card_advanced(
    'Product Title',
    'Product description with features and benefits.',
    '/images/product.jpg',
    'Price: $99.99'
);
```

### Modal Dialogs

```php
$modal = Create::modal(
    'Confirmation Required',
    'Are you sure you want to delete this item? This action cannot be undone.',
    [
        ['text' => 'Cancel', 'type' => 'button', 'class' => 'btn btn-secondary'],
        ['text' => 'Delete', 'type' => 'button', 'class' => 'btn btn-danger', 'action' => 'delete']
    ]
);

// Create trigger button and output modal
echo $modal->create_trigger('Delete Item', ['class' => 'btn btn-danger']);
echo $modal->render();
```

### Tabs

```php
// Standard tabs
Create::tabs([
    ['id' => 'general', 'title' => 'General Settings', 'content' => $general_content],
    ['id' => 'advanced', 'title' => 'Advanced Options', 'content' => $advanced_content],
    ['id' => 'help', 'title' => 'Help & Support', 'content' => $help_content]
], 'general');

// Flexible format
Create::tabs_flexible([
    'settings' => ['title' => 'Settings', 'content' => 'Settings panel'],
    'tools' => ['title' => 'Tools', 'content' => 'Tools panel']
], 'settings');
```

### Accordion

```php
Create::accordion([
    ['title' => 'Getting Started', 'content' => 'Welcome guide content', 'active' => true],
    ['title' => 'Advanced Features', 'content' => 'Advanced documentation'],
    ['title' => 'Troubleshooting', 'content' => 'Common issues and solutions']
], true); // Allow multiple sections open
```

## 📊 Display Components

### Progress & Status

```php
// Progress bar
Create::progress_bar(75, 100, [
    'show_percentage' => true,
    'show_current' => true,
    'size' => 'large'
]);

// Status badges
Create::badge('Active', 'success');
Create::badge('Pending Review', 'warning');
Create::badge('Failed', 'error');

// Boolean indicators
Create::boolean_icon(true, ['true_icon' => 'yes-alt', 'false_icon' => 'no-alt']);
```

### Data Display

```php
// Numbers with formatting
Create::number_format(1234567.89, [
    'decimals' => 2,
    'prefix' => '$',
    'short_format' => true // Shows as $1.23M
]);

// File sizes
Create::filesize(1234567890, ['decimals' => 1]); // Shows as 1.1 GB

// Color swatches
Create::color_swatch('#ff6b6b', [
    'size' => 24,
    'shape' => 'circle',
    'show_value' => true
]);

// Ratings
Create::rating(4.5, [
    'max' => 5,
    'style' => 'stars',
    'show_value' => true
]);
```

### User & Content

```php
// User display with avatar
Create::user(123, [
    'show_avatar' => true,
    'avatar_size' => 48,
    'name_type' => 'display_name',
    'show_role' => true
]);

// Taxonomy terms
Create::taxonomy(get_the_ID(), 'category', [
    'link' => true,
    'separator' => ', ',
    'limit' => 3,
    'show_more' => true
]);

// Time ago
Create::timeago('2024-01-15 10:30:00', [
    'show_tooltip' => true,
    'cutoff' => 7 * 24 * 3600 // Show absolute date after 1 week
]);
```

## 🧭 Navigation Components

### Breadcrumbs

```php
// From array
Create::breadcrumbs([
    ['text' => 'Home', 'url' => '/'],
    ['text' => 'Products', 'url' => '/products'],
    'Current Product'
]);

// From URL path
Create::breadcrumbs_from_path('products/electronics/smartphones', 'https://example.com/');

// From URL map
Create::breadcrumbs_map([
    '/' => 'Home',
    '/products' => 'Products',
    '/products/electronics' => 'Electronics',
    'Smartphones' // Current page
]);
```

## 🔗 Links & Media

### Link Types

```php
// Basic links
Create::a('https://example.com', 'Visit Example');
Create::external_link('https://google.com', 'Google', ['class' => 'external']);

// Communication links
Create::mailto('contact@example.com', 'Email Us');
Create::tel('+1-555-123-4567', 'Call Now');
Create::whatsapp('+1-555-123-4567', 'Hello!', 'WhatsApp Us');

// Social links
Create::telegram('username', '@username');
Create::twitter_share('Check this out!', 'https://example.com', 'awesome,cool');
```

### Media Elements

```php
// Images
Create::img('/images/photo.jpg', 'Beautiful landscape');

// Responsive images
Create::picture([
    ['src' => '/images/small.jpg', 'media' => '(max-width: 600px)'],
    ['src' => '/images/medium.jpg', 'media' => '(max-width: 1200px)']
], '/images/large.jpg', 'Responsive image');

// Audio/Video
Create::audio('/media/podcast.mp3', true); // With controls
Create::video(['/video/demo.mp4', '/video/demo.webm'], true);
```

## 🛠️ Interactive Components

### Form Enhancements

```php
// Toggle switches
Create::toggle('notifications', true, '1', 'Enable Notifications');

// Range sliders with display
Create::range('volume', '75', '0', '100', '5', true);

// Date pickers
Create::datepicker('event_date', '2024-12-25', [
    'format' => 'Y-m-d',
    'min_date' => '2024-01-01',
    'max_date' => '2024-12-31'
]);

// Featured star toggle
Create::featured('is_featured', true, 'Mark as Featured');
```

### Utility Components

```php
// Copy to clipboard
Create::clipboard('https://example.com/share/abc123', [
    'display_text' => 'Share Link',
    'max_length' => 20,
    'tooltip' => 'Click to copy share link'
]);

// Tooltips
Create::tooltip('Hover for info', 'This provides additional context', [
    'position' => 'top',
    'theme' => 'dark'
]);
```

## 🎭 Social Media Integration

```php
// Social media links with icons
Create::social_links([
    'facebook' => 'https://facebook.com/yourpage',
    'twitter' => 'https://twitter.com/youraccount',
    'instagram' => 'https://instagram.com/youraccount',
    'linkedin' => 'https://linkedin.com/company/yourcompany'
], ['class' => 'social-footer'], true); // Show text with icons

// Sharing buttons
Create::facebook_share('https://example.com/article');
Create::twitter_share('Great article!', 'https://example.com/article', 'tech,web');
Create::linkedin_share('https://example.com/article', 'Professional Article');
```

## 🗺️ Location & Maps

```php
// Map links for different platforms
Create::google_map('123 Main St, City, State', 'Visit Our Office');
Create::apple_map('Central Park, New York', 'Meet at Central Park');
Create::device_map('Times Square, NYC'); // Uses device default map app

// Coordinate-based maps
Create::coordinates_map(40.7128, -74.0060, 'google', 'New York City');
```

## 🔔 Notifications

```php
// Notice types (WordPress compatible)
Create::notice('Settings saved successfully!', 'success', true); // Dismissible
Create::warning_notice('Please review your settings before continuing.');
Create::error_notice('An error occurred while processing your request.');
Create::info_notice('This feature is currently in beta.');
```

## ⚙️ Advanced Usage

### Chaining Methods

```php
$element = Create::div()
    ->set_id('main-container')
    ->add_class(['container', 'fluid'])
    ->set_data('role', 'main')
    ->set_styles(['margin' => '20px', 'padding' => '10px'])
    ->add_child(Create::h1('Welcome'))
    ->add_child(Create::p('This is the main content area.'));
```

### Custom Components

```php
// Extend base classes for custom components
class CustomCard extends \Elementify\Abstracts\Component {
    protected function build(): void {
        // Custom component logic
        $this->add_child(Create::div('Custom content'));
    }
}
```

### Conditional Rendering

```php
// Render only if condition is met
$element = Create::div('Content');
echo $element->render_if($user_is_logged_in);

// Toggle classes based on conditions
Create::button('Submit')
    ->toggle_class('disabled', !$form_is_valid)
    ->toggle_attribute('disabled', true, !$form_is_valid);
```

### Asset Management

```php
// Components automatically load their CSS/JS
Create::datepicker('date'); // Loads datepicker.css and datepicker.js

// Manual asset loading
\Elementify\Assets::enqueue(['modal', 'tabs', 'tooltip']);
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

## 🧪 Testing

```php
// Element inspection
$element = Create::div('Content');
$element->has_class('container'); // false
$element->get_attribute('id', 'default'); // 'default'
$element->get_children(); // array of child elements

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

// Navigation menus
$menu_items = wp_get_nav_menu_items('primary');
echo Create::menu($menu_items);
```

### Plugin Development

```php
// Admin notices
add_action('admin_notices', function() {
    Create::success_notice('Plugin activated successfully!', true)->output();
});

// Settings forms
function render_settings_form() {
    $form = Create::form('options.php', 'post');
    settings_fields('my_plugin_settings');
    
    $form->add_child(Create::field('api_key', 'API Key', 'Enter your API key'));
    $form->add_child(Create::submit('Save Settings'));
    
    return $form->render();
}
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