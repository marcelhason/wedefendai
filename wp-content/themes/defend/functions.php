<?php
show_admin_bar( false );
// customize login form
add_action('login_head', 'marcel_custom_login');
function marcel_custom_login(){ echo  '<link rel="stylesheet" href="'. get_template_directory_uri().'/custom-login.css">'; }
function my_login_logo_url() { return home_url();}add_filter( 'login_headerurl', 'my_login_logo_url' );

define('CONTENT_FUNCTIONS', get_template_directory().'/functions');
define('CONTENT_TEMPLATES', get_template_directory().'/templates');
define('CONTENT_ASSETS', get_template_directory().'/assets');


//require(CONTENT_ASSETS. '/acf-json/bla.php');
//
//function my_acf_json_save_point( $path ) { return CONTENT_ASSETS . '/acf-json'; }
//add_filter( 'acf/settings/save_json', 'my_acf_json_save_point' );
//
//function my_acf_json_load_point( $paths ) { unset($paths[0]); $paths[] = CONTENT_ASSETS . '/acf-json'; return $paths; }
//add_filter( 'acf/settings/load_json', 'my_acf_json_load_point' );
//

//add_filter( 'wp_handle_upload', 'wpturbo_handle_upload_convert_to_webp' );
//function wpturbo_handle_upload_convert_to_webp( $upload ) {
//	if ( $upload['type'] == 'image/jpeg' || $upload['type'] == 'image/png' || $upload['type'] == 'image/gif' ) {
////		if ( $upload['type'] == 'image/png' || $upload['type'] == 'image/gif' ) {
//		$file_path = $upload['file'];
//		// Check if ImageMagick or GD is available
//		if ( extension_loaded( 'imagick' ) || extension_loaded( 'gd' ) ) {
//			$image_editor = wp_get_image_editor( $file_path );
//			if ( ! is_wp_error( $image_editor ) ) {
//				$file_info = pathinfo( $file_path );
//				$dirname   = $file_info['dirname'];
//				$filename  = $file_info['filename'];
//				// Create a new file path for the WebP image
//				$new_file_path = $dirname . '/' . $filename . '.webp';
//				// Attempt to save the image in WebP format
//				$saved_image = $image_editor->save( $new_file_path, 'image/webp' );
//				if ( ! is_wp_error( $saved_image ) && file_exists( $saved_image['path'] ) ) {
//					// Success: replace the uploaded image with the WebP image
//					$upload['file'] = $saved_image['path'];
//					$upload['url']  = str_replace( basename( $upload['url'] ), basename( $saved_image['path'] ), $upload['url'] );
//					$upload['type'] = 'image/webp';
//					// Optionally remove the original image
//					@unlink( $file_path );
//				}
//			}
//		}
//	}
//	return $upload;
//}




function cc_mime_types( $mimes ) {
	$mimes['json'] = 'text/plain';
	$mimes['svg'] = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	$mimes['webp'] = 'image/webp';
	$mimes['heic'] = 'image/heic';
	$mimes['heif'] = 'image/heif';
	$mimes['heics'] = 'image/heic-sequence';
	$mimes['heifs'] = 'image/heif-sequence';
	$mimes['avif'] = 'image/avif';
	$mimes['avis'] = 'image/avif-sequence';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types');

function custom_excerpt( $text, $count = 150 ) {
	if ( empty( $text ) ) {
		return false;
	}
	$temp = wp_html_excerpt( $text, $count );
	$words_count = explode( ' ', $temp );
	return wp_trim_words( $temp, count( $words_count ) - 1 );
}


//add_filter( 'jpeg_quality', function($arg) { return 100; });
//add_filter( 'wp_editor_set_quality', function($arg) { return 100; });

function vd($result, $var_dump = false, $die = false) {
	echo '<pre>';
	if ( ! $var_dump ) {print_r( $result );
	} else {var_dump( $result );}
	echo '</pre>';
	if ( $die ) {die();}
}




add_theme_support( 'post-thumbnails' );

add_image_size( 'full' );
add_image_size( 'inspacia-left', 607);
add_image_size( 'inspacia-rih', 333);
//
add_theme_support( 'menus' );
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automativ-feed-links' );
add_theme_support( 'html5', array(
	'search-form',
	'comment-form',
	'comment-list',
	'gallery',
	'caption',
	'widgets',
) );

register_nav_menus( array(
	'primary' => 'Top Menu',
	'secondary' => 'Bottom menu',
));

function show_post($path) {
	$post = get_page_by_path($path);
	$content = apply_filters('the_content', $post->post_content);
	echo $content;
}



add_shortcode( 'video', 'wpdocs_video_func' );
function wpdocs_video_func( $atts, $content = "" ) {
	return "content = $content";
}




//marcel pridal  send cf7 start
add_filter('wpcf7_editor_panels', 'add_html_message');
function add_html_message($panels) {
	if ( current_user_can( 'wpcf7_edit_contact_form' ) ) {
		$panels['wpcf7cf-html-message'] = array(
			'title'    => __( 'Html Messages', 'wpcf7cf' ),
			'callback' => 'wpcf7cf_editor_html_messages'
		);
	}
	return $panels;
}
function wpcf7cf_editor_html_messages($form) {
	$form_id = $_GET['post'];
	$wpcf7cm_entries = get_post_meta($form_id,'wpcf7cm_options',true);

	?>
    <div class="wpcf7cm-inner-container">
        <h3><?php echo esc_html( __( 'Html Success Messages', 'wpcf7cm' ) ); ?></h3>
        <p><?php echo esc_html( __( 'Enter your message once saved the form.', 'wpcf7cm' ) ); ?></p>
        <div id="wpcf7cm-text-entries">
            <div id="wpcf7cm-settings-text-wrap">
                <textarea id="wpcf7cm-settings-text" name="wpcf7cm_options" class="large-text" cols="100" rows="8"><?= $wpcf7cm_entries; ?></textarea>
            </div>
        </div>
    </div>
	<?php
}
// wpcf7_save_contact_form callback
add_action( 'wpcf7_save_contact_form', 'wpcf7cm_save_contact_form', 10, 1 );
function wpcf7cm_save_contact_form( $contact_form )
{
	if ( ! isset( $_POST ) || empty( $_POST ) || ! isset( $_POST['wpcf7cm_options'] )) {
		return;
	}
	$post_id = $contact_form->id();

	if ( ! $post_id )
		return;

	$options = $_POST['wpcf7cm_options'];
	update_post_meta( $post_id, 'wpcf7cm_options', $options );
	return;
};
add_action( 'rest_api_init', 'wpcf7cm_rest_api_init', 1, 1 );

function wpcf7cm_rest_api_init() {
	register_rest_route( 'contact-form-7/v1',
		'/contact-forms/(?P<id>\d+)/feedback',
		array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => 'wpcf7cm_rest_create_feedback',
			),
		)
	);
}
function wpcf7cm_rest_create_feedback( WP_REST_Request $request ) {
	$id = (int) $request->get_param( 'id' );
	$item = wpcf7_contact_form( $id );
	if ( ! $item ) {
		return new WP_Error( 'wpcf7_not_found',
			__( "The requested contact form was not found.", 'contact-form-7' ),
			array( 'status' => 404 ) );
	}
	$result = $item->submit();
	$unit_tag = $request->get_param( '_wpcf7_unit_tag' );

	$wpcf7cm_entries = get_post_meta($id,'wpcf7cm_options',true);
	$response = array(
		'into' => '#' . wpcf7_sanitize_unit_tag( $unit_tag ),
		'status' => $result['status'],
		'message' => $result['message'],
		'posted_data_hash' => $result['posted_data_hash'],
		'custom_msg' => $wpcf7cm_entries,
		'result' => $request->get_params()
	);
	if ( 'validation_failed' == $result['status'] ) {
		$invalid_fields = array();
		foreach ( (array) $result['invalid_fields'] as $name => $field ) {
			$invalid_fields[] = array(
				'into' => 'span.wpcf7-form-control-wrap.'
				          . sanitize_html_class( $name ),
				'message' => $field['reason'],
				'idref' => $field['idref'],
			);
		}
		$response['invalidFields'] = $invalid_fields;
	}
	$response = apply_filters( 'wpcf7_ajax_json_echo', $response, $result );
	return rest_ensure_response( $response );
}

add_action( 'wp_footer', 'c7_footer_scripts' );
function c7_footer_scripts(){
	?>
    <!--    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>-->
    <script>
        document.addEventListener( 'wpcf7mailsent', function( event ) {
            if(event.detail.apiResponse.hasOwnProperty('custom_msg')){
                var message = event.detail.apiResponse.custom_msg;
                var ta = event.detail.apiResponse.into;
                $(ta).find('form').remove();
                $(ta).append(message);
            }
        });
    </script>
	<?php
}
//marcel pridal send cf7 end


















//require_once(__DIR__.'/templates/bloks/buttonko.php');


function butontest($buns)
{

	$button_text   = $buns['tlacitko_text'];
	$button_link   = $buns['tlacitko_link'];
	?>
	<div class="text_center mgt-40">
		<a href="<?php echo $button_link ?>" title="" class="btn_basic wmin190" style="color: #d55779">
			<?php echo $button_text ?>
		</a>
	</div>
<?php }

function tlacitko_typ_1()
{
	if( have_rows('butons_typ_1') ):
		while ( have_rows('butons_typ_1') ) : the_row();
			$button_showhde = get_sub_field( 'showhide' );
			$button_text = get_sub_field( 'text' );
			$button_link = get_sub_field( 'link' );
			$button_color = get_sub_field( 'color' );
			$button_text_color = get_sub_field( 'text_color' );
			?>
			<?php if($button_showhde == true ){ ?>
				<div class="text_center mgt-40">
					<a href="<?php echo $button_link ?>" title="" class="btn_basic wmin190" style="background-color: <?php echo $button_color ?>; color: <?php echo $button_text_color ?>">
						<?php echo $button_text ?>
					</a>
				</div>
			<?php } ?>
		<?php endwhile; endif; ?>
<?php }

function tlacitko_typ_2($watashi)
{
	if( have_rows($watashi.'_buttons_typ_2') ):
		while ( have_rows($watashi.'_buttons_typ_2') ) : the_row();
			$button_text = get_sub_field( 'text' );
			$button_link = get_sub_field( 'link' );
			$button_color = get_sub_field( 'color' );
			$button_color_text = get_sub_field( 'color_text' );
			$button_background_color = get_sub_field( 'background_color' );
			?>
			<div class="text_center mgt-30" style="background-color: <?php echo $button_background_color ?>">
				<a href="<?php echo $button_link . $button_background_color ?>" title="" class="btn_basic wmin190" style="color: <?php echo $button_color_text ?>; background-color: <?php echo $button_color ?>">
					<?php echo $button_text ?>
				</a>
			</div>
		<?php endwhile; endif; ?>
<?php }



