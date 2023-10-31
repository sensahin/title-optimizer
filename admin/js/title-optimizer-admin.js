(function( $ ) {
	'use strict';

	$(document).ready(function($) {
		$('.improve-title-action').click(function(e) {
			e.preventDefault();
			var postId = $(this).data('post-id');
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
					action: 'improve_title_action',
					post_id: postId
				},
				success: function(response) {
					alert(response);
					location.reload();
				}
			});
		});
	});
	

})( jQuery );
