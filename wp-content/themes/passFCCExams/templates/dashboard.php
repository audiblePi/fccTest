<?php

/*
Template Name: Dashboard
*/

get_header(); ?>

<section id="content-wrapper" class="container my-account-wrapper" role="main">
	<div class="row">
		<!-- <div class="fcc-panel side-bar-collapse">
			<div class="title">Dashboard <div class="section-collapse">collapse <i class="icon-chevron-up"></i></div></div>
			</div>
		</div> -->
		<div class="three columns dashboard-sidebar">
			<div class="sidebar-menu">
				<?php wp_nav_menu( array( 'theme_location' => 'dashboard-menu') ); ?>
			</div>
		</div>
		<div class="nine columns dashboard-main">
			<?php #BEGIN LOOP FOR PAGE ?>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<section class="entry-content">
						<?php the_content(); ?>
					</section>

				</div>

			<?php endwhile; endif; #END LOOP FOR PAGE ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>