<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
<div class="login profile" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php $template->the_action_template_message( 'profile' ); ?>
	<?php $template->the_errors(); ?>
	<form id="your-profile" action="<?php $template->the_action_url( 'profile' ); ?>" method="post">
		<?php wp_nonce_field( 'update-user_' . $current_user->ID ); ?>
			<input type="hidden" name="from" value="profile" />
			<input type="hidden" name="checkuser_id" value="<?php echo $current_user->ID; ?>" />
		<?php do_action( 'profile_personal_options', $profileuser ); ?>
		<table class="form-table">
			<tr >	
				<th ><label for="user_login"><?php _e( 'Username', 'theme-my-login' ); ?></label></th>
				<td ><input type="text" name="user_login" id="user_login" value="<?php echo esc_attr( $profileuser->user_login ); ?>" disabled="disabled" class="regular-text" /> <span class="description"><?php _e( 'Your username cannot be changed.', 'theme-my-login' ); ?></span></td>
			</tr>
			<tr >	
				<th ><label for="first_name"><?php _e( 'First Name', 'theme-my-login' ); ?></label></th>
				<td ><input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $profileuser->first_name ); ?>" class="regular-text" /></td>
			</tr>
			<tr >	
				<th ><label for="last_name"><?php _e( 'Last Name', 'theme-my-login' ); ?></label></th>
				<td ><input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $profileuser->last_name ); ?>" class="regular-text" /></td>
			</tr>
			<tr >	
				<th ><label for="nickname"><?php _e( 'Nickname', 'theme-my-login' ); ?> <span class="description"><?php _e( '(required)', 'theme-my-login' ); ?></span></label></td>
				<td ><input type="text" name="nickname" id="nickname" value="<?php echo esc_attr( $profileuser->nickname ); ?>" class="regular-text" /></td>
			</tr>
			<tr >	
				<th ><label for="display_name"><?php _e( 'Display name publicly as', 'theme-my-login' ); ?></label></th>
				<td >
					<select name="display_name" id="display_name">
					<?php
						$public_display = array();
						$public_display['display_nickname']  = $profileuser->nickname;
						$public_display['display_username']  = $profileuser->user_login;

						if ( ! empty( $profileuser->first_name ) )
							$public_display['display_firstname'] = $profileuser->first_name;

						if ( ! empty( $profileuser->last_name ) )
							$public_display['display_lastname'] = $profileuser->last_name;

						if ( ! empty( $profileuser->first_name ) && ! empty( $profileuser->last_name ) ) {
							$public_display['display_firstlast'] = $profileuser->first_name . ' ' . $profileuser->last_name;
							$public_display['display_lastfirst'] = $profileuser->last_name . ' ' . $profileuser->first_name;
						}

						if ( ! in_array( $profileuser->display_name, $public_display ) )// Only add this if it isn't duplicated elsewhere
							$public_display = array( 'display_displayname' => $profileuser->display_name ) + $public_display;

						$public_display = array_map( 'trim', $public_display );
						$public_display = array_unique( $public_display );

						foreach ( $public_display as $id => $item ) {
					?>
						<option <?php selected( $profileuser->display_name, $item ); ?>><?php echo $item; ?></option>
					<?php
						}
					?>
					</select>
				</td>
			</tr>
			<tr>	
				<th ><label for="email"><?php _e( 'E-mail', 'theme-my-login' ); ?> <span class="description"><?php _e( '(required)', 'theme-my-login' ); ?></span></label></th>
				<td ><input type="text" name="email" id="email" value="<?php echo esc_attr( $profileuser->user_email ); ?>" class="regular-text" /></td>
			</tr>
			<?php
				foreach ( wp_get_user_contact_methods() as $name => $desc ) {
			?>
			<tr>	
				<th ><label for="<?php echo $name; ?>"><?php echo apply_filters( 'user_'.$name.'_label', $desc ); ?></label></th>
				<td ><input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo esc_attr( $profileuser->$name ); ?>" class="regular-text" /></td>
			</tr>
			<?php
				}
			?>
		</table>

		<?php do_action( 'show_user_profile', $profileuser ); ?>

		<p class="submit">
			<input type="hidden" name="action" value="profile" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $current_user->ID ); ?>" />
			<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Update Profile', 'theme-my-login' ); ?>" name="submit" />
		</p>
	</form>
</div>
