<?php
/**
 * Footer Template
 *
 * The footer template is generally used on every page of your site. Nearly all other
 * templates call it somewhere near the bottom of the file. It is used mostly as a closing
 * wrapper, which is opened with the header.php file. It also executes key functions needed
 * by the theme, child themes, and plugins. 
 *
 * @package swt
 * @subpackage Template
 */
?>
				<?php get_sidebar( 'primary' ); // Loads the sidebar-primary.php template. ?>

			</div><!-- .wrap -->

		</div><!-- #main -->

		<?php get_sidebar( 'subsidiary' ); // Loads the sidebar-subsidiary.php template. ?>

		<div id="footer">

			<div class="wrap">
			
				<p>Copyright &copy; <?php echo date('Y'); ?>. All Rights Reserved. Designed by <a href="http://www.simplewpthemes.com">Mande Soft Engineering</a></p>
					
			</div><!-- .wrap -->

		</div><!-- #footer -->

	</div><!-- #container -->

	<?php wp_footer(); // wp_footer ?>

</body>
</html>