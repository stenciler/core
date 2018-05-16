jQuery( function ( $ ) {
	'use strict';

	function update() {

		
		var $this = $( this ),
			$wrapper = $this.closest( '.wp-editor-wrap' ),
			id = $this.attr( 'id' );

	
		var $content = $wrapper.find('.wp-editor-tools hide-if-no-js').attr('id');

		console.log($content);

	}

	
	$('.field-wysiwyg').each(update);
});
