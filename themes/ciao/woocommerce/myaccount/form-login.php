<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
do_action( 'woocommerce_before_customer_login_form' );

$action='login';
if(isset($_GET['action'])){
    $action=$_GET['action'];
}
$wrap_class="wrap-account-form";
if('yes' ===get_option( 'woocommerce_enable_myaccount_registration' )){
    $wrap_class.=' enable-register';
}
?>

<div class="<?php echo esc_attr($wrap_class)?>">
<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

<div class="u-columns col2-set" id="customer_login">

	<div class="u-column1 col-1" <?php if($action=='register'){?>style="display:none" <?php }?>>

<?php endif; ?>

		<h2><?php esc_html_e( 'Login', 'anon' ); ?></h2>

		<form class="woocommerce-form woocommerce-form-login login" method="post">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_attr_e( 'Username or email address', 'anon' ); ?>*" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<input class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_attr_e( 'Password', 'anon' ); ?>*" type="password" name="password" id="password" autocomplete="current-password" />
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>
            <p class="woocommerce-LostPassword lost_password">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline woocommerce-form-login__rememberme">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'anon' ); ?></span>
                </label>
                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'anon' ); ?></a>
            </p>
			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<button type="submit" class="woocommerce-button button" name="login" value="<?php esc_attr_e( 'Log in', 'anon' ); ?>"><?php esc_html_e( 'Log in', 'anon' ); ?></button>
			</p>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

	</div>

	<div class="u-column2 col-2" <?php if($action=='register'){?>style="display:block" <?php }?>>

		<h2><?php esc_html_e( 'Register', 'anon' ); ?></h2>

		<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_attr_e( 'Username', 'anon' ); ?>*" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
				</p>

			<?php endif; ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_attr_e( 'Email address', 'anon' ); ?>*" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_attr_e( 'Password', 'anon' ); ?>*" name="password" id="reg_password" autocomplete="new-password" />
				</p>

			<?php else : ?>

				<p><?php esc_html_e( 'A password will be sent to your email address.', 'anon' ); ?></p>

			<?php endif; ?>

			<?php do_action( 'woocommerce_register_form' ); ?>

			<p class="woocommerce-form-row form-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<button type="submit" class="woocommerce-Button button" name="register" value="<?php esc_attr_e( 'Register', 'anon' ); ?>"><?php esc_html_e( 'Register', 'anon' ); ?></button>
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>

	</div>

</div>
    <div class="wrap-toggle-form-block">
        <div class="toggle-form-block-login" <?php if($action=='register'){?>style="display:block" <?php }?>>
            <h2><?php esc_html_e('Login','anon')?></h2>
            <div class="content-toggle-block">
                <p><?php esc_html_e('Login here by filling you\'re username and password or use your favorite social network account to enter to the site. Site login will simplify the purchase process and allows you to manage your personal account.','anon')?></p>
                <span class="button toggle-form-button toggle-login"><?php esc_html_e('Login','anon')?></span>
            </div>
        </div>
        <div class="toggle-form-block-register" <?php if($action=='register'){?>style="display:none" <?php }?>>
            <h2><?php esc_html_e('Register','anon')?></h2>
            <div class="content-toggle-block">
                <p><?php esc_html_e('Registering for this site allows you to access your order status and history. Just fill in the fields below, and we’ll get a new account set up for you in no time. We will only ask you for information necessary to make the purchase process faster and easier.','anon')?></p>
                <span class="button toggle-form-button toggle-register"><?php esc_html_e('Register','anon')?></span>
				
            </div>
        </div>
    </div>
<?php endif; ?>
</div>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>