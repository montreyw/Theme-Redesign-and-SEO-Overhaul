jQuery( document ).ready( function ( $ ) {

	$( '.post-planner-display-comment:odd' ).addClass( 'post-planner-comment-odd' );

	/* Datepicker */
	$( '.post-planner-datepicker' ).datepicker( { dateFormat:postplanner.DATE_FORMAT } );
	$( '#ui-datepicker-div' ).wrap( '<div class="post-planner"></div>' );

	/* Color Picker */
	$( '.post-planner-pickcolor' ).click( function ( e ) {
		var $postplannercolorPicker = $( this ).next( 'div' );
		var $postplannerinput = $( this ).prev( 'input' );

		$.farbtastic( $( $postplannercolorPicker ), function ( a ) {
			$( $postplannerinput ).val( a ).css( 'background', a );
		} );

		$postplannercolorPicker.show();
		e.preventDefault();

		$( document ).mousedown( function () {
			$( $postplannercolorPicker ).hide();
		} );
	} );

	/* Associate Post */
	$( '#_pp_associated_metabox' ).on( 'click', '#post-planner-associate-post', function () {
		var confirmed = confirm( postplanner.CONFIRMATION_MSG );
		if ( confirmed == false ) return;
		var $post_planner_planner_id = $( '#post-planner-id' ).val();
		var $post_planner_post_id = $( '#post-planner-associated-id' ).val();
		var $post_planner_type = $( '#post-planner-type' ).val();

		$.ajax( {
			type:'post',
			url :ajaxurl,
			data:{
				action                :'post_planner_associate_post',
				postplanner_post_id   :$post_planner_post_id,
				postplanner_planner_id:$post_planner_planner_id,
				postplanner_type      :$post_planner_type,
				_ajax_nonce           :postplanner.NONCE
			},
			success:function ( data ) {
				if ( data == 1 ) {
					$( '.post-planner-existing-associations' ).before( '<div class="updated"><p>'+postplanner.ASSOC_SUCCESS_MSG+'</p></div>' );
					$( '.updated' ).delay( 5000 ).fadeOut( 1000 );
					$( '.post-planner-create-post' ).addClass( 'hide' );
					$( '.post-planner-select-post' ).addClass( 'hide' );
					$( '.post-planner-existing-associations' ).show();
					$( '#post-planner-post-id' ).val( $post_planner_post_id );
				} else if ( data == 2 ) {
					$( '.post-planner-existing-associations' ).after( '<div class="error"><p>' + postplanner.ASSOC_DUPLICATE_MSG + '</p></div>' );
					$( '.error' ).delay( 5000 ).fadeOut( 1000 );
				} else if ( data == -1 ) {
					$( '.post-planner-existing-associations' ).after( '<div class="error"><p>' + postplanner.ASSOC_ERROR_MSG + '</p></div>' );
					$( '.error' ).delay( 5000 ).fadeOut( 1000 );
				}
			},
			error  :function ( r ) {
				$( '.post-planner-existing-associations' ).after( '<div class="error"><p>' + postplanner.ASSOC_ERROR_MSG + '</p></div>' );
				$( '.error' ).delay( 5000 ).fadeOut( 1000 );
			}
		} );
	} );
	/* end Associate Post */

	/* Visit Associated Post */
	$( '#_pp_associated_metabox' ).on( 'click', '#post-planner-visit-post', function () {
		var $post_id = $( '#post-planner-post-id' ).val();
		location.href = postplanner.ADMIN_URL+'/post.php?post='+$post_id+'&action=edit';
	} );
	/* end Visit Associated Post */

	/* Create Associated Post */
	$( '#_pp_associated_metabox' ).on( 'click', '#post-planner-create-post', function () {
		var confirmed = confirm( postplanner.CREATE_CONFIRMATION_MSG );
		if ( confirmed == false ) return;
		var $post_planner_planner_id = $( '#post-planner-id' ).val();
		var $post_planner_type = $( '#post-planner-type' ).val();
		var $post_planner_topic = $( '#title' ).val();
		var $post_planner_assigned = $( '.post-planner-assignment' ).val();

		$.ajax( {
			type   :'post',
			url    :ajaxurl,
			dataType:'json',
			data   :{
				action                :'post_planner_create_associated_post',
				postplanner_planner_id:$post_planner_planner_id,
				postplanner_type      :$post_planner_type,
				postplanner_topic     :$post_planner_topic,
				postplanner_assigned  :$post_planner_assigned,
				_ajax_nonce           :postplanner.NONCE
			},
			success:function ( data ) {
				 if ( data['status'] == -2 ) {
					$( '#post-planner-create-post' ).after( '<div class="error"><p>' + postplanner.ASSOC_ALREADY_MSG + '</p></div>' );
					$( '.error' ).delay( 5000 ).fadeOut( 1000 );
				} else if ( data['status'] == -1 ) {
					$( '#post-planner-create-post' ).after( '<div class="error"><p>' + postplanner.ASSOC_NOT_CREATED_MSG + '</p></div>' );
					$( '.error' ).delay( 5000 ).fadeOut( 1000 );
				} else if ( data['status'] == 1 ) {
					$( '.post-planner-existing-associations' ).show();
					$( '.post-planner-existing-associations' ).before( '<div class="updated"><p>' + postplanner.ASSOC_CREATED_MSG + '</p></div>' );
					$( '#post-planner-post-id' ).val( data['post_id'] );
					$( '#post-planner-associated-id' ).append( '<option value="' + data['post_id'] + '">' + $post_planner_topic + '</option>' );
					$( '.post-planner-create-post' ).addClass( 'hide' );
					$( '.post-planner-select-post' ).addClass( 'hide' );
					$( '.updated' ).delay( 5000 ).fadeOut( 1000 );
				}
			},
			error  :function ( r ) {
				$( '#post-planner-create-post' ).after( '<div class="error"><p>' + postplanner.ASSOC_NOT_CREATED_MSG + '</p></div>' );
				$( '.error' ).delay( 5000 ).fadeOut( 1000 );
			}
		} );
	} );
	/* end Create Associated Post */

	/* Delete Association */
	$( '#_pp_associated_metabox' ).on( 'click', '#post-planner-delete-association', function ( e ) {
		var confirmed = confirm( postplanner.REMOVE_CONFIRMATION_MSG );
		e.preventDefault();
		if ( confirmed == false ) return;
		var $post_planner_planner_id = $( '#post-planner-id' ).val();
		var $post_planner_post_id = $( '#post-planner-post-id' ).val();
		var $post_planner_type = $( '#post-planner-type' ).val();

		$.ajax( {
			type   :'post',
			url    :ajaxurl,
			data   :{
				action                :'post_planner_remove_associated_post',
				postplanner_post_id   :$post_planner_post_id,
				postplanner_planner_id:$post_planner_planner_id,
				postplanner_type      :$post_planner_type,
				_ajax_nonce           :postplanner.NONCE
			},
			success:function ( data ) {
				if ( data == 1 ) {
					$( '.post-planner-existing-associations' ).after( '<div class="updated"><p>' + postplanner.ASSOC_REMOVED_MSG + '</p></div>' );
					$( '#post-planner-associated-id' ).prop( 'selectedIndex', 0 );
					$( '.post-planner-existing-associations' ).hide();
					$( '.post-planner-create-post' ).removeClass( 'hide' );
					$( '.post-planner-select-post' ).removeClass( 'hide' );
					$( '.updated' ).delay( 5000 ).fadeOut( 1000 );
				} else if ( data == -1 ) {
					$( '.post-planner-existing-associations' ).after( '<div class="error"><p>' + postplanner.ASSOC_NOT_REMOVED_MSG + '</p></div>' );
					$( '.error' ).delay( 5000 ).fadeOut( 1000 );
				}
			},
			error  :function ( r ) {
				$( '.post-planner-existing-associations' ).after( '<div class="error"><p>' + postplanner.ASSOC_NOT_REMOVED_MSG + '</p></div>' );
				$( '.error' ).delay( 5000 ).fadeOut( 1000 );
			}
		} );
	} );
	/* end Delete Association */

	/* Comments */
	$( '#_pp_comments_metabox' ).on( 'click', '#post-planner-add-comment', function ( e ) {
		e.preventDefault();
		var $post_planner_planner_id = $( '#post-planner-comment-id' ).val();
		var $post_planner_comment_text = $( '#postplannercommenttext' ).val();
		if ( $post_planner_comment_text == '' ) $post_planner_comment_text = $( "#postplannercommenttext_ifr" ).contents().find( 'body' ).html();

		$.ajax( {
			type    :'post',
			url     :ajaxurl,
			dataType:'json',
			data    :{
				action                   :'post_planner_insert_comment',
				post_planner_comment_text:$post_planner_comment_text,
				post_planner_planner_id  :$post_planner_planner_id,
				_ajax_nonce              :postplanner.NONCE
			},
			success:function ( data ) {
				// if successful
				if ( data['status'] == 1 ) {
					var $planner_comment_html = '<div class="post-planner-comment-box">';
					if ( data['comment_avatar'] != '' ) $planner_comment_html += '<div class="post-planner-avatar">'+data['comment_avatar']+'</div>';
					$planner_comment_html += '<div class="post-planner-display-comment post-planner-comment-new';
					if ( data['comment_avatar'] != '' ) $planner_comment_html += ' post-planner-has-avatar';
					$planner_comment_html += '">'+$post_planner_comment_text+'</div>' +
						'<span class="post-planner-comment-details description alignright">'+postplanner.POSTED_BY+' '+data['comment_author'] +
						' - <a href="'+postplanner.ADMIN_URL+'comment.php?action=editcomment&c='+data['comment_id']+'">'+postplanner.EDIT+'</a></span></div>';
					$( '#post-planner-add-comment' ).before( $planner_comment_html );
					$( '#postplannercommenttext' ).val( '' );
					$( "#postplannercommenttext_ifr" ).contents().find( 'body' ).html( '' );
					setTimeout( function () {
						$( '.post-planner-display-comment' ).removeClass( 'post-planner-comment-new' );
					}, 5000 );
				// if error
				} else if ( data['status'] == -1 ) {
					$( '#post-planner-add-comment' ).before( '<div class="error clear"><p>' + postplanner.COMMENT_ERROR_MSG + '</p></div>' );
					$( '.error' ).delay( 5000 ).fadeOut( 1000 );
				}
			},
			error  :function ( r ) {
				$( '#post-planner-add-comment' ).before( '<div class="error clear"><p>' + postplanner.COMMENT_ERROR_MSG + '</p></div>' );
				$( '.error' ).delay( 5000 ).fadeOut( 1000 );
			}
		} );
	} );
	/* end Comments */

	/* Checklist */
	$( '.post-planner-list-item input:checkbox' ).click( function () {
		var $post_planner_planner_id = $( '#post-planner-checklist-id' ).val();
		var $post_planner_checklist = [];
		$( '#post-planner-checklist input:checkbox:checked' ).each( function ( i ) {
			$post_planner_checklist.push( $( this ).val() );
		} );

		$.ajax( {
			type   :'post',
			url    :ajaxurl,
			data   :{
				action                :'post_planner_update_checklist',
				postplanner_checklist :$post_planner_checklist,
				postplanner_planner_id:$post_planner_planner_id,
				_ajax_nonce           :postplanner.NONCE
			},
			success:function ( data ) {
				if ( data == 1 ) {

				} else if ( data == -1 ) {
					$( '#post-planner-checklist' ).before( '<div class="error"><p>' + postplanner.CHECKLIST_ERROR_MSG + '</p></div>' );
					$( '.error' ).delay( 5000 ).fadeOut( 1000 );
				}
			},
			error  :function ( r ) {
				$( '#post-planner-checklist' ).before( '<div class="error"><p>' + postplanner.CHECKLIST_ERROR_MSG + '</p></div>' );
				$( '.error' ).delay( 5000 ).fadeOut( 1000 );
			}
		} );
	} );
	/* end Checklist */

	/* To-Do List */
	$( '.post-planner-todolist-item input:checkbox' ).click( function () {
		var $post_planner_item_id = $( this ).attr( 'id' );
		var $todo_id = '#todo-' + $post_planner_item_id;
		var $todo_status = $( this ).val();
		var _this = $( this );

		$.ajax( {
			type   :'post',
			url    :ajaxurl,
			data   :{
				action                 :'post_planner_update_todolist',
				postplanner_item_id    :$post_planner_item_id,
				postplanner_item_status:$todo_status,
				_ajax_nonce            :postplanner.NONCE
			},
			success:function ( data ) {
				if ( data == 1 ) {
					if ( $( _this ).hasClass( 'show-completed' ) ) {
						_this.prop( 'disabled', 'disabled' );
						$( $todo_id+' div' ).css( 'text-decoration', 'line-through' ).css( 'color', '#666' );
					} else {
						$( $todo_id ).fadeOut();
					}
				} else if ( data == -1 ) {
					$( '#post-planner-todolist' ).before( '<div class="error"><p>' + postplanner.CHECKLIST_ERROR_MSG + '</p></div>' );
					$( '.error' ).delay( 5000 ).fadeOut( 1000 );
				}
			},
			error  :function ( r ) {
				$( '#post-planner-todolist' ).before( '<div class="error"><p>' + postplanner.CHECKLIST_ERROR_MSG + '</p></div>' );
				$( '.error' ).delay( 5000 ).fadeOut( 1000 );
			}
		} );

	} );
	/* end To-Do List */

} );

