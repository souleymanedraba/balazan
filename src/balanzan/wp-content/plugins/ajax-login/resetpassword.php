<?php

require("constants.php");
require('../../../wp-config.php' );

$errors = array();
nocache_headers();

$key = preg_replace('/[^a-z0-9]/i', '', $_GET['key']);
if ( empty( $key ) ) {
	exit();
}

$user = $wpdb->get_row("SELECT * FROM $wpdb->users WHERE user_activation_key = '$key'");
if ( empty( $user ) ) {
	exit();
}

do_action('password_reset');

// Generate something random for a password... md5'ing current time with a rand salt
$new_pass = substr( md5( uniqid( microtime() ) ), 0, 7);
$wpdb->query("UPDATE $wpdb->users SET user_pass = MD5('$new_pass'), user_activation_key = '' WHERE user_login = '$user->user_login'");
wp_cache_delete($user->ID, 'users');
wp_cache_delete($user->user_login, 'userlogins');
$message  = sprintf(__('Username: %s'), $user->user_login) . "\r\n";
$message .= sprintf(__('Password: %s'), $new_pass) . "\r\n";
$message .= get_option('siteurl') . "\r\n";

if (FALSE == wp_mail($user->user_email, sprintf(__('[%s] Your new password'), get_option('blogname')), $message)) {
	die('<p>' . __('Le message ne pouvait pas �tre envoyé.') . "<br />\n" . __(' raison possible : désactivation du mail serait en cause...') . '</p>');
} else {
	// send a copy of password change notification to the admin
	// but check to see if it's the admin whose password we're changing, and skip this
	if ($user->user_email != get_option('admin_email')) {
		$message = sprintf(__('Mot de pass perdu/Changé de l utilisateur: %s'), $user->user_login) . "\r\n";
		wp_mail(get_option('admin_email'), sprintf(__('[%s] Mot de pass perdu/Changé'), get_option('blogname')), $message);
	}

}
?>
<html>
<head>
<title>Password is reset. Check your mail.</title>
<script type="text/javascript">
function alertuser() {
	alert("Votre nouveau mot de pass nous a été envoyé. Merci de vérifié notre mail!");
	window.location.href="<?=get_option('siteurl')?>";
}
</script>
</head>
<body onload="alertuser();"></body>
</html>