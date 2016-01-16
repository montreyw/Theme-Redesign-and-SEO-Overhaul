jQuery( document ).ready( function ( $ ) {

	$( '.post-planner-display-comment:odd' ).addClass( 'post-planner-comment-odd' );

	$.ajaxSetup( {
		type:'post',
		url :ajaxurl
	} );

	$( '#post-planner-content' ).addClass( 'post-planner-hide' );

	$( "#post-planner-tabs" ).tabs( {
		collapsible:true,
		selected:-1
	} );
	$( '#post-planner-tabs' ).show();

	$( ".post-planner-sortable" ).sortable( {
		placeholder:"ui-state-highlight"
	} );
	$( ".post-planner-sortable" ).disableSelection();

	$( "#post-planner-sortable-grid" ).sortable( {
		placeholder:"ui-state-highlight"
	} );
	$( "#post-planner-sortable-grid" ).disableSelection();

	/* Create Planner */
	$( '#_pp_planner_metabox' ).on( 'click', '#create-new-planner', function ( e ) {
		e.preventDefault();
		var _this = this;
		var confirmed = confirm( planner.CREATE_PLANNER_CONFIRMATION_MSG );
		if ( confirmed == false ) return;
		var $post_planner_post_id = $( '#post-planner-post-id' ).val();
		var $post_planner_topic = $( '#title' ).val();
		var $post_planner_author = $( '#post_author_override' ).val();
		var $post_type = $( '#post-type' ).val();

		$.ajax( {
			type    :'post',
			url     :ajaxurl,
			dataType:'json',
			data    :{
				action                :'post_planner_create_new_planner',
				postplanner_post_id   :$post_planner_post_id,
				postplanner_topic     :$post_planner_topic,
				postplanner_author    :$post_planner_author,
				postplanner_type      :$post_type,
				_ajax_nonce           :planner.NONCE
			},
			success :function ( data ) {
				if ( data['status'] == -1 ) {
					$( '#create-new-planner' ).before( '<div class="error"><p>' + planner.PLANNER_ERROR_MSG + '</p></div>' );
					$( '.error' ).delay( 5000 ).fadeOut( 1000 );
				} else if ( data['status'] == 1 ) {
					$( '#create-new-planner' ).before( '<div class="updated"><p>' + planner.PLANNER_CREATED_MSG + '</p></div>' ).show();
					$( _this ).removeAttr( 'id' ).attr( 'href', planner.ADMIN_URL+'post.php?post='+data['planner_id']+'&action=edit' ).html( planner.VIEW_PLANNER );
					$( '.updated' ).delay( 5000 ).fadeOut( 1000 );
				}
			},
			error   :function ( r ) {
				$( '#create-new-planner' ).before( '<div class="error"><p>' + planner.PLANNER_ERROR_MSG + '</p></div>' );
				$( '.error' ).delay( 5000 ).fadeOut( 1000 );
			}
		} );
	} );
	/* end Create Planner */

	/* Files */
	$( '.planner-insert-file' ).click( function ( e ) {
		e.preventDefault();
		var $post_planner_li = $( this ).closest( 'li' );
		var $post_planner_post_id = $( '#post-planner-post-id' ).val();
		var $post_planner_planner_id = $( '#post-planner-id' ).val();
		var $post_planner_type = $( '#post-planner-type' ).val();

		$.ajax( {
			data:{
				action                :'post_planner_insert_file',
				post_planner_file_id  :$post_planner_li.attr( 'id' ),
				post_planner_post_id  :$post_planner_post_id,
				post_planner_planner_id:$post_planner_planner_id,
				postplanner_type      :$post_planner_type,
				_ajax_nonce           :planner.NONCE
			},
			success:function ( data ) {
				if ( data == 1 ) {
					$( $post_planner_li ).addClass( 'inserted' );
					$( '.files' ).prepend( '<div class="updated"><p>' + planner.FILES_SUCCESS_MSG + '</p></div>' );
					$( 'div.updated' ).delay( 5000 ).fadeOut( 1000 );

					var $insert_file = '<a href="'+$( $post_planner_li ).find( '.file-info' ).attr( 'href' )+'">'+$( $post_planner_li ).find( '.file-info' ).text()+'</a>' + "\n";

					if ( parent.tinyMCE.activeEditor == null || tinyMCE.activeEditor.isHidden() ) {
						$( '#content' ).insertAtCaret( $insert_file );
					} else {
						parent.tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, $insert_file );
					}
				} else if ( data == -1 ) {
					$( $post_planner_li ).addClass( 'error' );
					$( '.files' ).prepend('<div class="error"><p>'+ planner.FILES_ERROR_MSG +'</p></div>');
					$( 'div.error' ).delay( 5000 ).fadeOut( 1000 );
				}
			},
			error:function ( r ) {
				$( $post_planner_li ).addClass( 'error' );
				$( '.files' ).prepend( '<div class="error"><p>' + planner.FILES_ERROR_MSG + '</p></div>' );
				$( 'div.error' ).delay( 5000 ).fadeOut( 1000 );
			}
		} );
	} );

	$( '#planner-insert-file-list' ).click( function ( e ) {
		e.preventDefault();
		var $post_planner_files = $( '.post-planner-sortable.files li' );
		var $post_planner_post_id = $( '#post-planner-post-id' ).val();
		var $post_planner_planner_id = $( '#post-planner-id' ).val();
		var $post_planner_type = $( '#post-planner-type' ).val();
		var $post_planner_file_ids = new Array();

		$( $post_planner_files ).each( function ( i ) {
			$post_planner_file_ids[i] = $( this ).attr( 'id' );
		});

		$.ajax( {
			data:{
				action               :'post_planner_insert_file_list',
				post_planner_file_ids:$post_planner_file_ids,
				post_planner_post_id :$post_planner_post_id,
				post_planner_planner_id:$post_planner_planner_id,
				postplanner_type     :$post_planner_type,
				_ajax_nonce          :planner.NONCE
			},
			success:function ( data ) {
				if ( data == 1 ) {
					$( '.files' ).prepend( '<div class="updated"><p>' + planner.FILES_LIST_SUCCESS_MSG + '</p></div>' );
					$( 'div.updated' ).delay( 5000 ).fadeOut( 1000 );

					var $files_list = '<ul id="planner-file-list">' + "\n";
					$( $post_planner_files ).each( function ( i ) {
						var $link = $( this ).find( '.file-info' );
						$( this ).addClass( 'inserted' );
						$files_list += '<li><a href="'+$link.attr( 'href' )+'">'+$link.text()+'</a></li>' + "\n";
					});
					$files_list += '</ul>' + "\n";

					if ( parent.tinyMCE.activeEditor == null || tinyMCE.activeEditor.isHidden() ) {
						$( '#content' ).insertAtCaret( $files_list );
					} else {
						parent.tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, $files_list );
					}
			} else if ( data == -1 ) {
					$( '.files' ).prepend( '<div class="error"><p>' + planner.FILES_LIST_ERROR_MSG + '</p></div>' );
					$( 'div.error' ).delay( 5000 ).fadeOut( 1000 );
				}
			},
			error:function ( r ) {
				$( '.files' ).prepend( '<div class="error"><p>' + planner.FILES_LIST_ERROR_MSG + '</p></div>' );
				$( 'div.error' ).delay( 5000 ).fadeOut( 1000 );
			}
		} );
	} );
	/* end Files */

	/* References */
	$( '.planner-insert-reference' ).click( function ( e ) {
		e.preventDefault();
		var $post_planner_li = $( this ).closest( 'li' );

		$( $post_planner_li ).addClass( 'inserted' );
		$( '.references' ).prepend( '<div class="updated"><p>' + planner.REFERENCES_SUCCESS_MSG + '</p></div>' );
		$( 'div.updated' ).delay( 5000 ).fadeOut( 1000 );
		$( this ).addClass( 'inserted' );

		var $reference_index = $( '.post-planner-sortable.references li' ).index( $post_planner_li );
		var $reference_num = $reference_index + 1;
		var $insert_reference = '<sup><a href="#reference-' + $reference_index +'">' + $reference_num + '</a></sup>';

		if ( parent.tinyMCE.activeEditor == null || tinyMCE.activeEditor.isHidden() ) {
			$( '#content' ).insertAtCaret( $insert_reference );
		} else {
			parent.tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, $insert_reference );
		}

	} );

	$( '#planner-insert-references-list' ).click( function ( e ) {
		e.preventDefault();
		var $post_planner_references = $( '.post-planner-sortable.references li ' );

		var $references_list = "\n" + '<p><strong>'+planner.REFERENCES+'</strong></p>' + "\n";
		$references_list += '<ol id="planner-references-list">' + "\n";

		$( $post_planner_references ).each( function ( i ) {
			var $link = $( this ).find( '.reference-info' );
			$( this ).addClass( 'inserted' );
			$references_list += '<li id="reference-'+i+'"><a href="' + $link.attr( 'href' ) + '"';
			if ( $link.attr( 'target' ) ) $references_list += ' target="'+$link.attr( 'target' )+'"';
			if ( $link.attr( 'rel' ) ) $references_list += ' rel="nofollow"';
			$references_list += '>' + $link.text() + '</a></li>' + "\n";
		} );

		$references_list += '</ol>' + "\n";

		if ( parent.tinyMCE.activeEditor == null || tinyMCE.activeEditor.isHidden() ) {
			$( '#content' ).insertAtCaret( $references_list );
		} else {
			parent.tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, $references_list );
		}

		$( '.references' ).prepend( '<div class="updated"><p>' + planner.REFERENCES_LIST_SUCCESS_MSG + '</p></div>' );
		$( 'div.updated' ).delay( 5000 ).fadeOut( 1000 );

	} );
	/* end References */

	/* Images */
	$( '.planner-insert-image' ).click( function ( e ) {
		e.preventDefault();
		var $post_planner_li = $( this ).closest( 'li' );
		var $post_planner_post_id = $( '#post-planner-post-id' ).val();
		var $post_planner_planner_id = $( '#post-planner-id' ).val();
		var $post_planner_type = $( '#post-planner-type' ).val();

		$.ajax( {
			data:{
				action                 :'post_planner_insert_image',
				post_planner_image_id  :$post_planner_li.attr( 'id' ),
				post_planner_post_id   :$post_planner_post_id,
				post_planner_planner_id:$post_planner_planner_id,
				postplanner_type       :$post_planner_type,
				_ajax_nonce            :planner.NONCE
			},
			success:function ( data ) {
				if ( data == 1 ) {
					$( $post_planner_li ).addClass( 'inserted' );
					$( '.images' ).prepend( '<div class="updated"><p>' + planner.IMAGES_SUCCESS_MSG + '</p></div>' );
					$( 'div.updated' ).delay( 5000 ).fadeOut( 1000 );

					var $insert_file = '<img src="' + $( $post_planner_li ).find( '.image-info' ).attr( 'href' ) + '" alt="' + $( $post_planner_li ).find( '.image-info img' ).attr( 'alt' )
							+ '" title="' + $( $post_planner_li ).find( '.image-info img' ).attr( 'title' ) + '" />' + "\n";

					if ( parent.tinyMCE.activeEditor == null || tinyMCE.activeEditor.isHidden() ) {
						$( '#content' ).insertAtCaret( $insert_file );
					} else {
						parent.tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, $insert_file );
					}
				} else if ( data == -1 ) {
					$( $post_planner_li ).addClass( 'error' );
					$( '.images' ).prepend( '<div class="error"><p>' + planner.IMAGES_ERROR_MSG + '</p></div>' );
					$( 'div.error' ).delay( 5000 ).fadeOut( 1000 );
				}
			},
			error:function ( r ) {
				$( $post_planner_li ).addClass( 'error' );
				$( '.images' ).prepend( '<div class="error"><p>' + planner.IMAGES_ERROR_MSG + '</p></div>' );
				$( 'div.error' ).delay( 5000 ).fadeOut( 1000 );
			}
		} );
	} );

	$( '.planner-insert-featured' ).click( function () {
		var $post_planner_li = $( this ).closest( 'li' );
		var $post_planner_post_id = $( '#post-planner-post-id' ).val();
		var $post_planner_type = $( '#post-planner-type' ).val();

		$.ajax( {
			data:{
				action                 :'post_planner_insert_featured_image',
				post_planner_image_id  :$post_planner_li.attr( 'id' ),
				post_planner_post_id   :$post_planner_post_id,
				postplanner_type       :$post_planner_type,
				_ajax_nonce            :planner.NONCE
			},
			success:function ( data ) {
				if ( data == 1) {
					$( $post_planner_li ).addClass( 'inserted' );
					$( '.images' ).prepend( '<div class="updated"><p>' + planner.IMAGES_FEATURED_SUCCESS_MSG + '</p></div>' );
					$( 'div.updated' ).delay( 6000 ).fadeOut( 1000 );
				} else if ( data == -1 ) {
					$( $post_planner_li ).addClass( 'error' );
					$( '.images' ).prepend( '<div class="error"><p>' + planner.IMAGES_FEATURED_ERROR_MSG + '</p></div>' );
					$( 'div.error' ).delay( 5000 ).fadeOut( 1000 );
				}
			},
			error:function ( r ) {
				$( $post_planner_li ).addClass( 'error' );
				$( '.images' ).prepend( '<div class="error"><p>' + planner.IMAGES_FEATURED_ERROR_MSG + '</p></div>' );
				$( 'div.error' ).delay( 5000 ).fadeOut( 1000 );
			}
		} );
	} );

	$( '#planner-insert-all_images' ).click( function ( e ) {
		e.preventDefault();
		var $post_planner_images = $( '#post-planner-sortable-grid.images li' );
		var $post_planner_post_id = $( '#post-planner-post-id' ).val();
		var $post_planner_planner_id = $( '#post-planner-id' ).val();
		var $post_planner_type = $( '#post-planner-type' ).val();
		var $post_planner_image_ids = new Array();

		$( $post_planner_images ).each( function ( i ) {
			$post_planner_image_ids[i] = $( this ).attr( 'id' );
		} );

		$.ajax( {
			data:{
				action                 :'post_planner_insert_all_images',
				post_planner_image_ids :$post_planner_image_ids,
				post_planner_post_id   :$post_planner_post_id,
				post_planner_planner_id:$post_planner_planner_id,
				postplanner_type       :$post_planner_type,
				_ajax_nonce            :planner.NONCE
			},
			success:function ( data ) {
				if ( data == 1 ) {
					$( '.images' ).prepend( '<div class="updated"><p>' + planner.IMAGES_LIST_SUCCESS_MSG + '</p></div>' );
					$( 'div.updated' ).delay( 5000 ).fadeOut( 1000 );

					$( $post_planner_images ).each( function ( i ) {
						$( this ).addClass( 'inserted' );
					} );

					var $images_list = "\n";
					$( $post_planner_images ).each( function ( i ) {
						var $link = $( this ).find( '.image-info' );
						$( this ).addClass( 'inserted' );
						$images_list += '<img src="' + $link.attr( 'href' ) + '" alt="' + $link.find( 'img' ).attr( 'alt' )
								+ '" title="' + $link.find( 'img' ).attr( 'title' ) + '" />';
					} );
					$images_list +=  "\n";

					if ( parent.tinyMCE.activeEditor == null || tinyMCE.activeEditor.isHidden() ) {
						$( '#content' ).insertAtCaret( $images_list );
					} else {
						parent.tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, $images_list );
					}
				} else if ( data == -1 ) {
					$( '.images' ).prepend( '<div class="error"><p>' + planner.IMAGES_LIST_ERROR_MSG + '</p></div>' );
					$( 'div.error' ).delay( 5000 ).fadeOut( 1000 );
				}
			},
			error:function ( r ) {
				$( '.images' ).prepend( '<div class="error"><p>' + planner.IMAGES_LIST_ERROR_MSG + '</p></div>' );
				$( 'div.error' ).delay( 5000 ).fadeOut( 1000 );
			}
		} );
	} );
	/* end Images */

	/* Checklist */
	$( '.post-planner-list-item input:checkbox' ).click( function ( event ) {
		var $post_planner_planner_id = $( '#post-planner-checklist-id' ).val();
		var $post_planner_type = $( '#post-planner-type' ).val();
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
				postplanner_type      :$post_planner_type,
				_ajax_nonce           :planner.NONCE
			},
			success:function ( data ) {
				if ( data == 1 ) {

				} else if ( data == -1 ) {
					$( '#post-planner-checklist' ).before( '<div class="error"><p>' + planner.CHECKLIST_ERROR_MSG + '</p></div>' );
					$( '.error' ).delay( 5000 ).fadeOut( 1000 );
				}
			},
			error  :function ( r ) {
				$( '#post-planner-checklist' ).before( '<div class="error"><p>' + planner.CHECKLIST_ERROR_MSG + '</p></div>' );
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
				postplanner_item_status: $todo_status,
				_ajax_nonce            :planner.NONCE
			},
			success:function ( data ) {
				if ( data == 1 ) {
					if ( $( _this ).hasClass( 'show-completed' ) ) {
						_this.prop( 'disabled', 'disabled' );
						$( $todo_id + ' div' ).css( 'text-decoration', 'line-through' ).css( 'color', '#666' );
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