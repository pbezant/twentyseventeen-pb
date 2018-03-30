<?php

	function pb_scripts() {

	    $parent_style = 'twentyseventeen-style'; // This is 'twentyseventeen-style' for the Twenty Seventeen theme.

	    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	    wp_enqueue_style( 'child-style',
	        get_stylesheet_directory_uri() . '/style.css',
	        array( $parent_style ),
	        wp_get_theme()->get('Version')
	    );
	    // FontAwesome
	    wp_enqueue_script( 'font-awesome', "https://use.fontawesome.com/0378703fb3.js", array(), '20151215', true );

	    //AOS implementation
	    wp_enqueue_style('aos', "https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.css");
	    wp_enqueue_script( 'aos', "https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.js", array(), '211', true );

	    //Custom code
	    wp_enqueue_script( 'main', get_stylesheet_directory_uri() .'/assets/js/main.js', array(), '001', true );
	}
	add_action( 'wp_enqueue_scripts', 'pb_scripts' );
	
	function pb_customizer_options( $wp_customize ) {
		$wp_customize->add_setting('pb_clip_mask', /*give it an ID*/ array(
			'theme_supports' => 'custom-header',
			'transport'         => 'refresh',
		 ));
		 $wp_customize->add_control(new WP_Customize_Image_Control(
        	$wp_customize,
        	'pb_clip_mask', //give it an ID
		 	array(
			 'label' => __( 'Clipping Mask', 'twentyseventeen-pb' ), //set the label to appear in the Customizer
			 'description' => 'Add a .png with transparent background to create a clipping effect',
			 'section' => 'header_image', //select the section for it to appear under 
			 'settings' => 'pb_clip_mask' //pick the setting it applies to
		 )));

		$wp_customize->add_setting('pb_header_text', /*give it an ID*/ array(
			'theme_supports' => 'custom-header',
			'default' => __( 'default text', 'twentyseventeen-pb' ),
 			//'sanitize_callback' => 'sanitize_text',
			'transport'         => 'refresh',
		 ));

		//$wp_customize->add_control(new Text_Editor_Custom_Control(
		$wp_customize->add_control( new WP_Customize_Control(
        	$wp_customize,'pb_header_text', //give it an ID
		 	array(
			 'label' => __( 'Customize Header', 'twentyseventeen-pb' ), //set the label to appear in the Customizer
			 'description' => 'Use html to create header text',
			 'section' => 'header_image',
			 'priority' => 1,
			 'settings' => 'pb_header_text', //pick the setting it applies to
			 'type' => 'textarea'
		 )));

		$wp_customize->add_setting('pb_toggle_branding', /*give it an ID*/ array(
			'theme_supports' => 'custom-header',
			'default'        => 1,
			'transport'         => 'refresh',
		 ));

		$wp_customize->add_control( 'pb_toggle_branding', array(
			'label'    => __( 'Display Site Branding on Homepage' ),
			'section'  => 'header_image',
			'priority' => 2,
			'settings' => 'pb_toggle_branding',
			'type'     => 'checkbox',
		) );

	}
	add_action('customize_register','pb_customizer_options');


	function pb_clipping_style() {
    	$clip_mask = get_theme_mod( 'pb_clip_mask' );?>
        <style id="clipping_Mask" type="text/css">
        .has-header-image .custom-header-media img, .has-header-video .custom-header-media video, .has-header-video .custom-header-media iframe, .has-header-image:not(.twentyseventeen-front-page):not(.home) .custom-header-media img {
			mask: url(<?php echo $clip_mask ?>);
		    mask-image: url(<?php echo $clip_mask ?>);
		    -webkit-mask: url(<?php echo $clip_mask ?>) center center/cover no-repeat;
		    -webkit-filter: saturate(150%);
		    filter: saturate(150%);
		}
        </style>
	    <?php
	}
	add_action('wp_head', 'pb_clipping_style');

	function pb_toggle_branding(){
		if(FALSE === get_theme_mod('pb_toggle_branding') && ( twentyseventeen_is_frontpage() || ( is_home() && is_front_page() ) ) && ! has_nav_menu( 'top' )):?>
		<style id="hide_branding" type="text/css">
		body .site-branding .custom-logo-link, body .site-branding .site-branding-text{
			display: none;
		}
		</style>
		<?php
		endif;
	}
	add_action('wp_head', 'pb_toggle_branding');

	function pb_heat_map(){ ?>
		<!-- Hotjar Tracking Code for www.prestonbezant.com -->
		<script id="hotjar">
		    (function(h,o,t,j,a,r){
		        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
		        h._hjSettings={hjid:573108,hjsv:5};
		        a=o.getElementsByTagName('head')[0];
		        r=o.createElement('script');r.async=1;
		        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
		        a.appendChild(r);
		    })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
		</script>

	<?php }
	add_action('wp_head', 'pb_heat_map');

	function pb_google_analytics(){?>
		<style id="ga_optimize">.async-hide { opacity: 0 !important} </style>
		<script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;
		h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
		(a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
		})(window,document.documentElement,'async-hide','dataLayer',4000,
		{'GTM-MK5T8JG':true});
		</script>
		<script id="g_analytics">
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
		  ga('create', 'UA-29827719-1', 'auto');
		  ga('require', 'GTM-MK5T8JG');
		  ga('send', 'pageview');
		</script>
	<?php }
	add_action('wp_head', 'pb_google_analytics');

	// Sanitize text
	function sanitize_text( $text ) {
		return sanitize_text_field( $text );
	 }

	function cc_mime_types($mimes) {
	  $mimes['svg'] = 'image/svg+xml';
	  return $mimes;
	}
	add_filter('upload_mimes', 'cc_mime_types');

	// if ( file_exists(get_template_directory() . '/inc/text-editor-custom-control.php')) {
	// 	require get_template_directory() . '/inc/text-editor-custom-control.php';
	// return;
	// }

	if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;
	/**
	 * Class to create a custom tags control
	 */
	class Text_Editor_Custom_Control extends WP_Customize_Control
	{
	      /**
	       * Render the content on the theme customizer page
	       */
	      public function render_content(){?>
	                <label>

	                  <span class="customize-control-title"><?php echo esc_html( $this->label ); ?><br/></span>
	                  <span class="description customize-control-description"><?php echo esc_html( $this->description); ?></span>

	                  <?php
	                    $settings = array(
	                    'textarea_name' => $this->id,
	                    'teeny' => true,
                		'quicktags' => true,
                		'textarea_rows' => 5,
						);
	                    wp_editor($this->value(), $this->id, $settings );
	                  ?>
	                </label>
	            <?php
	       }
	}

?>