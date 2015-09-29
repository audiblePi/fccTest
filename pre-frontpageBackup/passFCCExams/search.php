<?php get_header(); ?>

<div class="header-image bgimage" style="background:url('<?php echo get_default_header_image(); ?>') no-repeat #003366; background-position: top center; background-size: 100%;">

	<div class="row">
		<div class="twelve columns">
			<h1>Search Results for:</h1>

			<h2>&quot;<?php echo get_search_query(); ?>&quot;</h2>

		</div>

	</div>
</div>

<div class="subheader">
	<div class="row">
		<div class="twelve columns ph">
			<?php get_search_form( ); ?>

		</div>
	</div>
</div>


<section id="content-wrapper" class="container" role="main">
	<div class="row">
		<div class="eight columns">
			<?php #BEGIN LOOP FOR PAGE ?>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'entry' ); ?>
				<?php endwhile; ?>
				<?php get_template_part( 'nav', 'below' ); ?>
			<?php else : ?>
				<article id="post-0" class="post no-results not-found">
					<header class="header">
						<h2 class="entry-title"><?php _e( 'Nothing Found', 'conure' ); ?></h2>
					</header>
					<section class="entry-content">
						<p><?php _e( 'Sorry, nothing matched your search. Please try again.', 'conure' ); ?></p>
						<?php get_search_form(); ?>
					</section>
				</article>
			<?php endif; ?>

		</div>
		<div class="four columns">
			<div class="sidebar">
				<?php
				$sidebarOption = get_field('sidebar_option');
				switch ($sidebarOption){
					case "sidebar1":
					dynamic_sidebar( "Sidebar 1" );
					break;
					case "sidebar2":
					dynamic_sidebar( "Sidebar 2" );
					break;
					case "sidebar3":
					dynamic_sidebar( "Sidebar 3" );
					break;
					case "sidebar4":
					dynamic_sidebar( "Sidebar 4" );
					break;
					default:
					dynamic_sidebar( "Sidebar 1" );
					break;
				}
				?>
			</div>


		</div>
	</div>

</section>

<?php get_footer(); ?>


<?php get_footer(); ?>