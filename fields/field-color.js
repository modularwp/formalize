jQuery(document).ready(function($){

	// Calls formalizeColorPicker() on page load.
	formalizeColorPicker();

	// Calls formalizeColorPicker() when widgets are added/updated.
    $(document).on( 'widget-added widget-updated', formalizeColorPicker );

    // Initializes the color pickers.
	function formalizeColorPicker() {
    	$('.formalize-color').wpColorPicker();
	}
});