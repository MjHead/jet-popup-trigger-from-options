# Config example

Add this code into **functions.php** file of your active theme

```php
add_filter( 'jet-ptfo/config', function( $config ) {

	$config[] = array(
		'page' => 'option-page-slug',
		'option' => 'option-name',
		'popup' => 123,
	);

	return $config;
} );
```

where:
- _option-page-slug_ - you need to replace with your actual option page slug;
- _option-name_ - you need to replace with option field name/ID which will control popup visibility. The field should return true or false (like a Switcher field, for example);
- _123_ - its a popup ID you need to launch. It can be found in the address bar on the popup edit page.

**Please note** - this plugin replaces only popup conditions logic, open event still need to be set in the popup settings section
