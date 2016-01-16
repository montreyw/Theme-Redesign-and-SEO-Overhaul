jQuery( document ).ready( function ( $ ) {

	$( '#post-planner-dashboard' ).tablesorter();

	/* Create Associated Post */
	$( '#post-planner-dashboard' ).on( 'click', '.post-planner-create-post', function ( e ) {
		e.preventDefault();
		var _this = this;
		var confirmed = confirm( plannerdash.CREATE_CONFIRMATION_MSG );
		if ( confirmed == false ) return;
		var $post_planner_planner_id = $( _this ).attr( 'id' );
		var $post_planner_type = $( this ).prevAll( '.post-planner-post-type' ).text();
		var $post_planner_topic = $( _this ).parent().prevAll( 'td.post-planner-dashboard-topic:first' ).children( 'a' ).html();
		var $post_planner_assigned = $( _this ).parent().prevAll( 'td.post-planner-dashboard-author:first' ).attr( 'id' );

		$.ajax( {
			type    :'post',
			dataType:'json',
			url     :ajaxurl,
			data    :{
				action                :'post_planner_create_associated_post',
				postplanner_planner_id:$post_planner_planner_id,
				postplanner_type      :$post_planner_type,
				postplanner_topic     :$post_planner_topic,
				postplanner_assigned  :$post_planner_assigned,
				_ajax_nonce           :plannerdash.NONCE
			},
			success :function ( data ) {
				if ( data['status'] == -1 ) {
					$( _this ).html( plannerdash.ASSOC_DASHBOARD_ERROR_MSG );
					setTimeout( function () {
						$( _this ).html( plannerdash.CREATE_POST );
					}, 5000 );
				} else if ( data['status'] == 1 ) {
					var $post_url = plannerdash.ADMIN_URL+'post.php?post='+data['post_id']+'&action=edit';
					$( _this ).html( plannerdash.VIEW_POST ).attr( 'href', $post_url ).removeClass( 'post-planner-create-post' );
				}
			},
			error   :function ( r ) {
				$( _this ).html( plannerdash.ASSOC_DASHBOARD_ERROR_MSG );
				setTimeout( function () {
					$( _this ).html( plannerdash.CREATE_POST );
				}, 5000 );
			}
		} );
	} );
	/* end Create Associated Post */

} );
