<?php

function standard_option( $atts )
{
	$atts = shortcode_atts(
	array( 'option_name' => '', 'option_price' => ''), $atts ); ?>

	<div class="option-rows">
		<span class="option-name"><?php echo $atts['option_name'] ?></span>
		<span class="option-price"><?php echo $atts['option_price'] ?></span>
		<span class="cf"></span>
	</div>

	<?php
}