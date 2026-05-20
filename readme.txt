=== Posts by Taxonomy ===
Author URI: https://brightbridgeweb.com
Plugin URI: https://brightbridgeweb.com
Donate link: 
Contributors: @benjerminp
Tags: custom post display, custom taxonomy, order by taxonomy
Requires at least: 6.0.0
Tested up to: 6.7.1
Requires PHP: 7.4
Stable tag: 1.0.1
License: GPLv2  
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Display a list separated by any taxonomy via shortcode.

== Description ==

Display a posts or custom post types in a list seperated by tags, categories or a custom taxonomy via a simple shortcode. Enable test mode to allow a visualization of how many posts are currently being displayed. Future updates will also include a default pageniation along with alternative paginations such as infinate scroll.

EXAMPLES:
  
  Simple display using default settings:
  [bbwd-post-display post-type='your-Post-Type-Slug']
  
  Simple display in "Test Mode":
  [bbwd-post-display post-type='your-Post-Type-Slug' testing='true']
  
  Select a specific post type:
  [bbwd-post-display post-type='your-Post-Type-Slug']
  
  Select a specific post type and use a custom taxonomy:
  [bbwd-post-display post-type='your-Post-Type-Slug' taxonomy='your-Tax-Slug']
  
  Select a specific post type, custom taxonomy and add quantity to disply per taxonomy:
  [bbwd-post-display post-type='your-Post-Type-Slug' taxonomy='your-Tax-Slug' post-per-section=5]
  
  Select a specific post type, custom taxonomy, add quantity to disply per taxonomy and add a fallback url:
  [bbwd-post-display post-type='your-Post-Type-Slug' taxonomy='your-Tax-Slug' post-per-section=5 fallback-image='https://yourURL.com/wp-content/uploads/2023/06/your-image.jpg']
  
  Select a specific post type, custom taxonomy, add quantity to disply per taxonomy, add a fallback url, and display with Search and Filter:
  [bbwd-post-display post-type='your-Post-Type-Slug' taxonomy='your-Tax-Slug' post-per-section=5 fallback-image='https://yourURL.com/wp-content/uploads/2023/06/your-image.jpg' s-and-f=123]
  
  Select a specific post type, custom taxonomy, add quantity to disply per taxonomy, add a fallback url, display with Search and Filter, and exclude tags:
  [bbwd-post-display post-type='your-Post-Type-Slug' taxonomy='your-Tax-Slug' post-per-section=5 fallback-image='https://yourURL.com/wp-content/uploads/2023/06/your-image.jpg' s-and-f=123 exclude='123, 222']


== Frequently Asked Questions ==

= How do I include Search and Filter =
Create your seach and filter form. Copy the ID and add it to your shortcode as an attribute (s-and-f=123)

= What does your company do =
Bright Bridge Web is a web development company that specializes in React, Django, and WordPress. We build websites to best fit your needs and work with you to stay within your budget.


== Installation ==

1. Go to `Plugins` in the Admin menu
2. Click on the button `Add new`
3. Search for `Posts by Taxonomy` and click 'Install Now' or click on the `upload` link to upload `posts-by-taxonomy.zip`
4. Click on `Activate plugin`

== Changelog ==

= 1.0.0: October 16, 2024 =
* Birthday of Posts by Taxonomy

= 1.0.2: May 21, 2026 =
* Resolving custom post type error

= 1.0.3: May 21, 2026 =
* Resolving missing attribute errors
* Verify WP 7.0 release