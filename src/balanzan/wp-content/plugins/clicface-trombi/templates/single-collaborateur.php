<?php

require_once( plugin_dir_path(__FILE__) . '../includes/class-collaborateur.php' );
$collaborateur = new clicface_Collaborateur( get_the_ID() );

$clicface_trombi_settings = get_option('clicface_trombi_settings');
$display_small_name = $clicface_trombi_settings['display_small_name'];

if ($clicface_trombi_settings['trombi_target_window'] != 'thickbox') {
	get_header();
	wp_enqueue_style('clicface-trombi-style');
} else {
	echo '<html>';
	echo '<head>';
	echo '<title></title>';
	echo '<link rel="stylesheet" type="text/css" href="' . plugins_url( 'clicface-trombi/css/clicface-trombi.css') . '">';
	echo '<link rel="stylesheet" type="text/css" href="' . plugins_url( 'clicface-trombi/css/clicface-trombi-thickbox.css') . '">';
	echo '</head>';
	echo '<body>';
}

if ( $clicface_trombi_settings['trombi_profile_width'] == NULL ) {
	$clicface_trombi_settings['trombi_profile_width'] = 720;
}
if ( $clicface_trombi_settings['trombi_profile_height'] == NULL ) {
	$clicface_trombi_settings['trombi_profile_height'] = 440;
}
?>
<div id="content" role="main">
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<a name="ClicfaceTrombi">&nbsp;</a>
			<?php if( $clicface_trombi_settings['trombi_display_return_link'] == 'oui' && $clicface_trombi_settings['trombi_target_window'] == '_self' ): ?>
				<a href="javascript:history.go(-1)">&lt;&lt;&nbsp;<?php _e('Return to the previous page', 'clicface-trombi'); ?></a><br /><br />
			<?php endif; ?>
			<?php if( $clicface_trombi_settings['trombi_display_return_link'] == 'oui' && $clicface_trombi_settings['trombi_target_window'] == '_blank' ): ?>
				<a href="javascript:self.close()"><?php _e('Close this Window', 'clicface-trombi'); ?></a><br /><br />
			<?php endif; ?>
			<header class="entry-header">
				<!--<h1 class="entry-title"><?php echo $collaborateur->Nom; ?></h1>-->
			</header><!-- .entry-header -->

			<link href="https://fonts.googleapis.com/css?family=Arbutus+Slab" rel="stylesheet" type="text/css" />
			<style type="text/css">.clicface-trombi-collaborateur-box {width: <?php echo $clicface_trombi_settings['trombi_profile_width']; ?>px; height: <?php echo $clicface_trombi_settings['trombi_profile_height']; ?>px;}</style>
			<div class="entry-content">
				<div class="clicface-trombi-collaborateur-contenu  clicface-trombi-collaborateur-box">
					<table class="clicface-trombi-collaborateur-contenu-table">
						<tr>
							<td>
								<?php if( $display_small_name == 'oui' ): ?>
									<div class="clicface-trombi-person-name-individual-page"><?php echo $collaborateur->Nom; ?></div>
								<?php endif; ?>
								<div class="clicface-trombi-person-function-individual-page"><?php echo $collaborateur->Fonction; ?></div>
								<div class="clicface-trombi-person-service-individual-page"><?php echo $collaborateur->Service; ?></div><br />
								<?php if( $clicface_trombi_settings['trombi_display_worksite'] == 'oui' ): ?>
									<div class="clicface-trombi-person-worksite-individual-page"><?php echo $collaborateur->Worksite; ?></div><br />
								<?php endif; ?>
								<div class="clicface-trombi-person-details-individual-page">
									<?php if( $collaborateur->TelephoneFixe != NULL ): ?>
										<?php _e('Phone:', 'clicface-trombi'); ?> <?php echo $collaborateur->TelephoneFixe; ?><br />
									<?php endif; ?>
									<?php if( $collaborateur->TelephonePortable != NULL ): ?>
										<?php _e('Cell:', 'clicface-trombi'); ?> <?php echo $collaborateur->TelephonePortable; ?><br />
									<?php endif; ?>
									<?php if( $collaborateur->Mail != NULL ): ?>
										<?php _e('E-mail:', 'clicface-trombi'); ?> <?php echo $collaborateur->Mailto; ?><br />
									<?php endif; ?>
								</div><br />
							</td>
							<td>
								<div style="float: right;">
									<?php echo $collaborateur->PhotoThumbnail; ?><br /><br />
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<?php if( $collaborateur->Commentaires != NULL ): ?>
									<div class="clicface-trombi-person-comments-individual-page"><?php echo nl2br( $collaborateur->Commentaires ); ?></div>
								<?php endif; ?>
								<br />
							</td>
						</tr>
					</table>
				</div>
			</div><!-- .entry-content -->
		</article><!-- #post-<?php the_ID(); ?> -->
		<?php endwhile; // end of the loop. ?>
	</div><!-- #content -->
<?php
if ($clicface_trombi_settings['trombi_target_window'] != 'thickbox') {
	get_footer();
} else {
	echo '</body>';
	echo '</html>';
}
?>