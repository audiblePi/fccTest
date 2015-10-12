<?php

/*
Template Name: Login
*/

get_header(); ?>
<section id="content-wrapper" class="container" role="main">
	<div class="row">
		<div class="logo" >
			<a href="<?php echo site_url(); ?>"><img src="/wp-content/themes/passFCCExams/assets/images/logo.png"></a>
		</div>
		<div class="panel-wrapper">
			<div class="login-wrapper">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<section class="entry-content">
							<div class="login-title">
								User Login
							</div>
							<?php the_content(); ?>
						</section>
					</div>
				<?php endwhile; endif; #END LOOP FOR PAGE ?>
			</div>
			<div class="shadow"></div>
		</div>
		<div class="login-links">
			<ul>
				<li>
					<a href="<?php echo site_url() ?>/lostpassword/">Forgot your password?</a>
				</li>
				<li>
					<a href="<?php echo site_url() ?>">← Back to PassFCCExams.com</a>
				</li>
			</ul>
		</div>
	</div>
</section>
<?php get_footer(); ?>