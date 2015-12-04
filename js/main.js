/**
 * Main.js
 */

/** global Router */
( function( $, _, undefined ) {
	var apiUrl = 'http://wpapi.dev/wp-json',
		$el = $( '#js-data' ),
		$logo = $( '#logo' );

	/**
	 * Event handler for visitors that click the logo image.
	 *
	 * Routes visitors to the homepage when they click the logo.
	 *
	 * @param  {object} event    Event object.
	 */
	$logo.click( function( event ) {
		event.preventDefault();

		/**
		 * Route to the homepage view.
		 *
		 * This is the same as calling:
		 * listPostswithPagination( '1' );
		 * history.pushState( null, null, 'http://wpapi.dev/' );
		 */
		router.setRoute( '/' );
	});

	/**
	 * Single Post route callback.
	 *
	 * @param  {string} postName - The post slug.
	 */
	var viewPost = function( postName ) {
		$.get( apiUrl + '/wp/v2/posts/?filter[name]=' + postName + '&_embed', function( data ) {
			var output = data[0],
				template = _.template( $( '#post-tmpl' ).html(), output );

			$el.html( template );
		});
	};

	/**
	 * Homepage and Post list pagination routes callback.
	 *
	 * @param  {string} page - Pagination location.
	 */
	var listPostswithPagination = function( page ) {
		page = typeof page !== 'undefined' ? page : '1';

		$.get( apiUrl + '/wp/v2/posts?page=' + page, function( data, textStatus, jqxhr ) {
			var output = { data: data },
				currentPage = parseInt( page, 10 ),
				maxPages = parseInt( jqxhr.getResponseHeader( 'X-WP-TotalPages' ), 10 ),
				template;

			if ( currentPage > 1 ) {
				output.previous = currentPage - 1;
			}

			if ( currentPage < maxPages ) {
				output.next = currentPage + 1;
			}

    		template = _.template( $( '#posts-tmpl' ).html(), output );

			$el.html( template );

			/**
			 * Click event handler for a single view of a listed Post.
			 *
			 * @param  {Object} event - Event object.
			 */
			$( '.js-single-post' ).click( function( event ) {
				event.preventDefault();
				var slug = $( this ).data( 'name' );

				router.setRoute( '/news/' + slug );

				// Scroll to the top of the page.
				$( 'html, body' ).animate( { scrollTop: 0 }, 'slow' );
			});
		});
	};

	/**
	 * Define our routing paths and their accompanying callbacks.
	 *
	 * @type {Object}
	 */
	var routes = {
		'/': listPostswithPagination,
		'/:page': listPostswithPagination,
		'/news/:postName': viewPost
	};

	/**
	 * The Router object for our routes.
	 */
	var router = new window.Router( routes );

	router.configure( { html5history: true } );

	router.init();


})( jQuery, _ );
