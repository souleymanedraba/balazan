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
			$photo_array = array_filter( get_post_meta( $id, 'upload_photo', false ) );
			$photo_id = array_shift(array_slice($photo_array, 0, 1));
			if ( $photo_id != NULL ) {
				$this->PhotoThumbnail = wp_get_attachment_image( $photo_id, 'thumbnail', false );
				$this->PhotoLarge = '<div id="pik_post_attachment_' . $id . '" class="piklist-field-container">';
				$this->PhotoLarge .= '<div class="piklist-label-container">' . wp_get_attachment_image( $id, 'large', false ) . '</div>';
				$this->PhotoLarge .= '</div>';
			} else {
				$this->PhotoThumbnail = NULL;
				$this->PhotoLarge = NULL;
			}
			if ( $this->PhotoThumbnail == NULL ) {
				$clicface_trombi_settings = get_option('clicface_trombi_settings');
				if ( !empty( $clicface_trombi_settings['trombi_default_picture'] ) ) {
					$default_picture_array = array_filter( $clicface_trombi_settings['trombi_default_picture'] );
					$default_picture_id = array_shift(array_slice($default_picture_array, 0, 1));
					$this->PhotoThumbnail = wp_get_attachment_image( $default_picture_id, 'thumbnail', false );
				} else {
					$this->PhotoThumbnail = '<img src="' . plugins_url( 'img/default_picture.png' , dirname(__FILE__) ) . '" alt="" />';
				} 
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