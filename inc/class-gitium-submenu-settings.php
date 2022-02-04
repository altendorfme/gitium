<?php
/*  Copyright 2014-2016 Presslabs SRL <ping@presslabs.com>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Gitium_Submenu_Settings extends Gitium_Menu {

	public function __construct() {
		parent::__construct( $this->gitium_menu_slug, $this->settings_menu_slug );
		add_action( GITIUM_ADMIN_MENU_ACTION, array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'save' ) );
		add_action( 'admin_init', array( $this, 'regenerate_webhook' ) );
		add_action( 'admin_init', array( $this, 'regenerate_public_key' ) );
	}

	public function admin_menu() {
		$submenu_hook = add_submenu_page(
			$this->menu_slug,
			'Settings',
			__( 'Settings' ),
			GITIUM_MANAGE_OPTIONS_CAPABILITY,
			$this->submenu_slug,
			array( $this, 'page' )
		);
		new Gitium_Help( $submenu_hook, 'settings' );
	}

	public function regenerate_webhook() {
		$gitium_regen_webhook = filter_input(INPUT_POST, 'GitiumSubmitRegenerateWebhook', FILTER_SANITIZE_STRING);
		if ( ! isset( $gitium_regen_webhook ) ) {
			return;
		}
		check_admin_referer( 'gitium-settings' );
		gitium_get_webhook_key( true );
		$this->success_redirect( __( 'Webhook URL regenerates. Please make sure you update any external references.', 'gitium' ), $this->settings_menu_slug );
	}

	public function regenerate_public_key() {
		$submit_regenerate_pub_key = filter_input(INPUT_POST, 'GitiumSubmitRegeneratePublicKey', FILTER_SANITIZE_STRING);
		if ( ! isset( $submit_regenerate_pub_key ) ) {
			return;
		}
		check_admin_referer( 'gitium-settings' );
		gitium_get_keypair( true );
		$this->success_redirect( __( 'Public key successfully regenerated.', 'gitium' ), $this->settings_menu_slug );
	}

	private function show_webhook_table_webhook_url() {
		?>
		<tr>
			<th><label for="webhook-url"><?php _e( 'Webhook URL', 'gitium' ); ?>:</label></th>
			<td>
			  <p><code id="webhook-url"><?php echo esc_url( gitium_get_webhook() ); ?></code>
			  <?php if ( ! defined( 'GIT_WEBHOOK_URL' ) || GIT_WEBHOOK_URL == '' ) : ?>
			  <input type="submit" name="GitiumSubmitRegenerateWebhook" class="button" value="<?php _e( 'Regenerate Webhook', 'gitium' ); ?>" />
                          <a class="button" href="<?php echo esc_url( gitium_get_webhook() ); ?>" target="_blank">Merge changes</a></p>
			  <?php endif; ?>
			  <p class="description"><?php _e( 'Pinging this URL triggers an update from remote repository.', 'gitium' ); ?></p>
			</td>
		</tr>
		<?php
	}

	public function show_webhook_table() {
		?>
		<table class="form-table">
			<?php $this->show_webhook_table_webhook_url() ?>
		</table>
		<?php
	}

	public function save() {
	    $submit_save = filter_input(INPUT_POST, 'GitiumSubmitSave', FILTER_SANITIZE_STRING);
		if ( ! isset( $submit_save ) ) {
			return;
		}
		check_admin_referer( 'gitium-settings' );
	}

	public function page() {
		$this->show_message();
		?>
		<div class="wrap">
		<h2><?php _e( 'Gitium Settings', 'gitium' ); ?></h2>

		<form action="" method="POST">
		<?php wp_nonce_field( 'gitium-settings' ) ?>

		<?php $this->show_webhook_table(); ?>
		<p class="submit">
		<input type="submit" name="GitiumSubmitSave" class="button-primary" value="<?php _e( 'Save', 'gitium' ); ?>" />
		</p>

		</form>
		</div>
		<?php
	}

}
