# Display SVGs in the Media Library

As of WordPress 4.7 the media library does not display Scalable Vector Graphics (SVG) correctly. We aim to fix that.

## Originally a plugin

The [Scalable Vector Graphics plugin](http://www.sterlinghamilton.com/projects/scalable-vector-graphics/) solves this 
nicely, but what if you want to include this functionality in your own theme or plugin?

## Now a package

Ah, the same good stuff as a [Composer](https://getcomposer.com) dependency!

### Installation

Run 

	composer require press-bits/media-library-svg-display

or add 

	"press-bits/media-library-svg-display": "^0.1.0"

to the requirements in your `composer.json`.

### Usage

In your bootstrap code, after including `vendor/autoload.php`:

	PressBits\MediaLibrary\ScalarVectorGraphicsDisplay::enable();

## No Uploads

The original plugin also enables uploads of SVGs, but this package does not. One reason is to limit 
the responsbilitiy of the package, another is the 
[security risk of SVG uploads](http://wordpress.stackexchange.com/questions/247189/understanding-svg-vulnerabilities-in-wordpress-related-to-a-specific-fix).

A separate package based on the [Safe SVG plugin](https://wordpress.org/plugins/safe-svg/developers/) may be in order.
