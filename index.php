<?php
/**
 * Index.php
 *
 * The main theme file template.
 *
 * @package wcus
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>
	<body>
		<header>
			<a href="<?php echo esc_url( home_url() ); ?>"><img id="logo" height="80" src="<?php echo esc_url( get_template_directory_uri() . '/img/logo.png' ); ?>"></a>
		</header>
		<div id="wrapper">
			<div id="js-data" class="container" aria-live="assertive">
				<!-- Our collection and single view data will be appended here -->
			</div>
		</div>
		<footer>
			<p class="credit">Powered by the <a href="https://github.com/WP-API/WP-API">WP REST API</a></p>
		</footer>
		<?php wp_footer(); ?>
	</body>

	<script id="posts-tmpl" type="text/template">
		<% _.each( data, function( post ) { %>
			<div id="post-<%= post.id %>">
				<h1><a class="js-single-post" data-name="<%= post.slug %>" href="http://wpapi.dev/news/<%= post.slug %>">
					<%= post.title.rendered %>
				</a></h1>
				<%= post.excerpt.rendered %>
			</div>
		<% }); %>
		<div id="pagination">
			<% if ( typeof previous !== 'undefined' ) { %>
				<a class="page-prev" href="http://wpapi.dev/<%= previous %>"><< Previous</a>
			<% } %>

			<% if ( typeof next !== 'undefined' ) { %>
				<a class="page-next" href="http://wpapi.dev/<%= next %>">Next >></a>
			<% } %>
		</div>
	</script>

	<script id="post-tmpl" type="text/template">
		<% if ( typeof _embedded["https://api.w.org/featuredmedia"] !== 'undefined' ) { %>
			<div class="featured" id="attachment-<%= _embedded["https://api.w.org/featuredmedia"][0].id %>">
				<img class="aligncenter" src="<%= _embedded["https://api.w.org/featuredmedia"][0].source_url %>">
			</div>
		<% } %>
		<div id="post-<%= id %>">
			<h1><%= title.rendered %></h1>

			<p class="author-info">Written by: <img src="<%= _embedded.author[0].avatar_urls[24] %>"> <%= _embedded.author[0].name %></p>

			<%= content.rendered %>
		</div>
	</script>
</html>
