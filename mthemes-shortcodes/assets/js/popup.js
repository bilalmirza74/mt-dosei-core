function mtscInsertShortcode() {
	// Grab input content, build the shortcodes, and insert them
	// into the content editor
	var select = jQuery('#select-mtsc-shortcode').val(),
		type = select.replace('mtsc-', '').replace('-shortcode', ''),
		template = jQuery('#' + select).data('shortcode-template'),
		childTemplate = jQuery('#' + select).data('shortcode-child-template'),
		tables = jQuery('#' + select).find('table').not('.mtsc-clone-template'),
		attributes = '',
		content = '',
		contentToEditor = '';

	// go over each table, build the shortcode content
	for (var i = 0; i < tables.length; i++) {
		var elems = jQuery(tables[i]).find('input[type=text], input[type=text]:not(.mtsc-fixed-value), input[type=checkbox], input[type=number], select, textarea');

		// Build an attributes string by mapping over the input
		// fields in a given table.
		attributes = jQuery.map(elems, function(el, index) {
			var $el = jQuery(el);

			console.log(el);

			if( $el.attr('id') === 'content' ) {
				content = $el.val();
				return '';
			} else if( $el.attr('id') === 'last' ) {
				if( $el.is(':checked') ) {
					return $el.attr('id') + '="true"';
				} else {
					return '';
				}
			} else {
				return $el.attr('id') + '="' + $el.val() + '"';
			}
		});
		attributes = attributes.join(' ').trim();

		// Place the attributes and content within the provided
		// shortcode template
		if( childTemplate ) {
			// Run the replace on attributes for columns because the
			// attributes are really the shortcodes
			contentToEditor += childTemplate.replace('{{attributes}}', attributes).replace('{{attributes}}', attributes).replace('{{content}}', content);
		} else {
			// Run the replace on attributes for columns because the
			// attributes are really the shortcodes
			contentToEditor += template.replace('{{attributes}}', attributes).replace('{{attributes}}', attributes).replace('{{content}}', content);
		}
	};

	// Insert built content into the parent template
	if( childTemplate ) {
		contentToEditor = template.replace('{{child_shortcode}}', contentToEditor);
	}

	// Send the shortcode to the content editor and reset the fields
	window.send_to_editor( contentToEditor );
	mtscResetFields();
}

// Set the inputs to empty state
function mtscResetFields() {

	// Get text and textareas
	var elementsToReset = jQuery('#mtsc-shortcode-wrap').find( 'input[type=text], textarea, input[type=number]' );
	
	// Reset the select, titles and clones
	jQuery('#mtsc-shortcode-title').text('Choose a shortcode');
	jQuery('#mtsc-shortcode-wrap').find('select').val('');
	jQuery('.mtsc-was-cloned').remove();
	jQuery('.mtsc-shortcode-type').hide();

	// Reset texts and texareas
	elementsToReset.each( function () {
		this.value = this.defaultValue;
	} );
}

// Simple function to clone an included template
function mtscCloneContent(el) {
	var clone = jQuery(el).find('.mtsc-clone-template').clone().removeClass('hidden mtsc-clone-template').removeAttr('id').addClass('mtsc-was-cloned');

	jQuery(el).append(clone);
}

jQuery(document).ready(function($) {
	// Popup window
	$('.mtsc-popup').magnificPopup({
		type: 'inline',
		preloader: false
	});
	$(document).on('click', '.mtsc-popup-dismiss', function (e) {
		e.preventDefault();
		$.magnificPopup.close();
	});

	var $shortcodes = $('.mtsc-shortcode-type').hide(),
		$title = $('#mtsc-shortcode-title');

	// Show the selected shortcode input fields
	$('#select-mtsc-shortcode').change(function () {
		var text = $(this).find('option:selected').text();

		$shortcodes.hide();
		$title.text(text);
		$('#' + $(this).val()).show();
	});

	// Clone a set of input fields
	$('.clone-content').on('click', function() {
		var el = $(this).siblings('.mtsc-sortable');

		mtscCloneContent(el);
		$('.mtsc-sortable').sortable('refresh');
	});

	// Remove a set of input fields
	$('.mtsc-shortcode-type').on('click', '.mtsc-remove' ,function() {
		$(this).closest('table').remove();
	});

	// Make content sortable using the jQuery UI Sortable method
	$('.mtsc-sortable').sortable({
		items: 'table:not(".hidden")',
		placeholder: 'mtsc-sortable-placeholder'
	});

	// WordPress Colorpicker
	$('.wp-color-picker-field').wpColorPicker();

	// Iconpicker
	$( document ).on('click', '.mtsc-iconpicker span', function(e) {
		e.preventDefault();

		var iconWithPrefix = $(this).attr('class');
		var fontName = $(this).attr('data-name');

		if($(this).hasClass('active')) {
			$(this).parent().find('.active').removeClass('active');

			$(this).parent().parent().find('input').attr('value', '');
		} else {
			$(this).parent().find('.active').removeClass('active');
			$(this).addClass('active');

			$(this).parent().parent().find('input').attr('value', fontName);
		}
	});
});