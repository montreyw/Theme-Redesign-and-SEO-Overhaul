jQuery( document ).ready( function ( $ ) {

	$( "label:contains(Slug)" ).remove();
	$( "label:contains(Password)" ).remove();
	$( ".inline-edit-group em" ).remove();

	// we create a copy of the WP inline edit post function
	var $wp_inline_edit = inlineEditPost.edit;
	// and then we overwrite the function with our own code
	inlineEditPost.edit = function ( id ) {

		// "call" the original WP edit function
		// we don't want to leave WordPress hanging
		$wp_inline_edit.apply( this, arguments );

		// get the post ID
		var $post_id = 0;
		if ( typeof( id ) == 'object' )
			$post_id = parseInt( this.getId( id ) );

		if ( $post_id > 0 ) {

			var $edit_row = $( '#edit-' + $post_id );
			var $status = $( '#post-planner-status-' + $post_id + ' span' ).text();
			var $assignment = $( '#post-planner-assignment-' + $post_id + ' span' ).text();

			$edit_row.find( 'select[name="_pp_status"]' ).val( $status );
			$edit_row.find( 'select[name="_pp_assignment"]' ).val( $assignment );
		}

	};

} );
