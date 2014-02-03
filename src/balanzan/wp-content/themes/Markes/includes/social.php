<?php

    global $options;
    $options = get_option( 'swt_theme_options' );
    
    if ( $options['swt_social'] == 'Display' ) {
        $facebook = $options['swt_facebook'];
        $twitter = $options['swt_twitter'];
        $rss = $options['swt_rss'];
        $youtube = $options['swt_youtube'];
        $linkedin = $options['swt_linkedin'];
        $pinterest = $options['swt_pinterest'];
        
        if ( $twitter || $facebook || $youtube || $rss || $linkedin || $pinterest || $google_plus ) {
        
                echo '<div class="widget">
                        <div class="widget-wrap widget-inside">
                            <h3 class="widget-title">' . __( 'Follow Us', hybrid_get_parent_textdomain() ) .'</h3>
                                <ul id="social">';
                            
                                    if ( $facebook )
                                            echo '<li><a id="facebook" href="'. $facebook .'" title="'. __( 'Facebook', hybrid_get_parent_textdomain() ) .'"></a></li>';                                                                                   

                                    if ( $twitter )
                                            echo '<li><a id="twitter" href="'. $twitter .'" title="'. __( 'Twitter', hybrid_get_parent_textdomain() ) .'"></a></li>';
                
                                    if ( $youtube )
                                            echo '<li><a id="youtube" href="'. $youtube .'" title="'. __( 'Youtube Channel', hybrid_get_parent_textdomain() ) .'"></a></li>';

                                    if ( $rss )
                                            echo '<li><a id="rss" href="'. $rss .'" title="'. __( 'RSS', hybrid_get_parent_textdomain() ) .'"></a></li>';                

                                    if ( $pinterest )
                                            echo '<li><a id="pinterest" href="'. $pinterest .'" title="'. __( 'Pinterest', hybrid_get_parent_textdomain() ) .'"></a></li>';                                                                                
                                                                                           
                                    if ( $linkedin )
                                            echo '<li><a id="linkedin" href="'. $linkedin .'" title="'. __( 'Linkedin', hybrid_get_parent_textdomain() ) .'"></a></li>';                
                                                                                                                                                                                                                                                                       
                echo '</ul></div></div>';
    
        }
    }        
?>