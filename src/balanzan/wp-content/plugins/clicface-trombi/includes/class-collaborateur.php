<?php
class clicface_Collaborateur {
	function __construct( $id ) {
		try {
			// Nom
			$this->Nom = get_the_title($id);
			
			// Lien vers la fiche
			$this->Link = get_permalink($id);
			
			// Fonction
			$this->Fonction = get_post_meta($id , 'fonction', true);
			
			// Service
			$collaborateur_service = wp_get_post_terms( $id, 'collaborateur_service' );
			if ( isset($collaborateur_service[0]->name) ) {
				$this->Service = $collaborateur_service[0]->name;
			} else {
				$this->Service = NULL;
			}
			
			// Worksite
			$collaborateur_worksite = wp_get_post_terms( $id, 'collaborateur_worksite' );
			if ( isset($collaborateur_worksite[0]->name) ) {
				$this->Worksite = $collaborateur_worksite[0]->name;
			} else {
				$this->Worksite = NULL;
			}
			
			// Mail
			if( !function_exists('convert_email_adr') ){
				function convert_email_adr($email) {
					$pieces = str_split(trim($email));
					$new_mail = '';
					foreach ($pieces as $val) {
						$new_mail .= '&#'.ord($val).';';
					}
					return $new_mail;
				}
			}
			$this->Mail = get_post_meta($id , 'mail', true);
			$this->Mailto = '<a href="mailto:' . convert_email_adr( get_post_meta($id , 'mail', true) ) . '">' . convert_email_adr( get_post_meta($id , 'mail', true) ) . '</a>';
			
			// Téléphone fixe
			$this->TelephoneFixe = get_post_meta($id , 'telephone_fixe', true);
			
			// Téléphone portable
			$this->TelephonePortable = get_post_meta($id , 'telephone_portable', true);
			
			// Commentaires
			$this->Commentaires = get_post_meta($id , 'commentaires', true);
			
			// Photo
			$args = array(
				'post_type' => 'attachment'
				,'numberposts' => 1
				,'post_parent' => $id
				,'post_status' => 'all'
			);
			$attachments = get_posts( $args );
			if ($attachments) {
				global $wp_post_statuses;
				remove_all_filters('get_the_excerpt'); // Since we're using the_excerpt for notes, we need to keep it clean.
				foreach ( $attachments as $post ) {
					setup_postdata($post);
					$this->PhotoThumbnail = wp_get_attachment_image( $post->ID, 'thumbnail', false );
					
					$this->PhotoLarge = '<div id="pik_post_attachment_' . $post->ID . '" class="piklist-field-container">';
					$this->PhotoLarge .= '<div class="piklist-label-container">' . wp_get_attachment_image( $post->ID, 'large', false ) . '</div>';
					$this->PhotoLarge .= '</div>';
				}
			} else {
				$this->PhotoThumbnail = '-';
				$this->PhotoLarge = NULL;
			}
			
			$this->Erreur = false;
			return true;
		}
		
		catch (Exception $e) {
			$this->Erreur = __('An error occurred:', 'clicface-trombi') . " $this->Nom : " . $e->getMessage() . "\r";
			return false;
		}
	}
}