<?php
function _rrze_setup() {
    
    load_theme_textdomain( '_rrze', get_template_directory() . '/languages' );
    
    define('HEADER_TEXTCOLOR', '');
    define('HEADER_IMAGE', '%s/grafiken/header/default.png');
    define('LOGO_IMAGE', '%s/grafiken/logo/default.png');
    define('HEADER_IMAGE_WIDTH', apply_filters('d7_blogs_header_image_width', 1387));
    define('HEADER_IMAGE_HEIGHT', apply_filters('d7_blogs_header_image_height', 118));
    define('LOGO_IMAGE_WIDTH', apply_filters('d7_blogs_logo_image_width', 124));
    define('LOGO_IMAGE_HEIGHT', apply_filters('d7_blogs_logo_image_height', 113));
    set_post_thumbnail_size(HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true);

    define('NO_HEADER_TEXT', true);
    define('NO_LOGIN_TEXT', true);

    add_theme_support('custom-header', array( 'd7_blogs_admin_header_style' ) );
    
	add_theme_support( 'automatic-feed-links' );
    
    add_theme_support( 'post-formats', array( 'gallery' ) );
    
    add_theme_support( 'post-thumbnails' );
        
}

add_action( 'after_setup_theme', '_rrze_setup' );

if (!function_exists('d7_blogs_admin_header_style')) :

    function d7_blogs_admin_header_style() {
    ?>
        <style type="text/css">
            #headimg {
                height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
                width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
            }
            #headimg h1, #headimg #desc {
                display: none;
            }
        </style>
    <?php
    }

endif;

function _rrze_widgets_init() {
    // sidebar-1
    register_sidebar( array(
        'name' => __( 'Bereichsmenü', '_rrze' ),
        'description'   => __( 'Dieser Bereich ist für der Bereichsmenü (linke Spalte) vorgesehen.', '_rrze' ),
        'before_widget' => '<li>',
        'after_widget' => '</ul></li>',
        'before_title' => '<span class="aktiv">',
        'after_title' => '</span><ul>',
    ));

    // sidebar-2
    register_sidebar( array(
        'name' => __( 'Zielgruppennavigation', '_rrze' ),
        'description' => __( 'Dieser Bereich ist für die Zielgruppennavigation (im Kopfteil) vorgesehen.', '_rrze' ),
        'before_widget' => '<div class="space">',
        'after_widget' => '</div>',
        'before_title' => '<!--',
        'after_title' => '-->',
    ));

    // sidebar-3
    register_sidebar( array(
        'name' => __( 'Kurzinfo', '_rrze' ),
        'description' => __( 'Dieser Bereich ist für die Kurzinformationen (unter Bereichsmenü) vorgesehen.', '_rrze' ),
        'before_widget' => '<div class="blog">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));

    // sidebar-4
    register_sidebar( array(
        'name' => __( 'Zusatzinfo', '_rrze' ),
        'description' => __( 'Dieser Bereich ist für die Zusatzinformationen (rechte Spalte) vorgesehen.', '_rrze' ),
        'before_widget' => '<div class="blog">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));

    // sidebar-5
    register_sidebar( array(
        'name' => __( 'Inhaltsinfo', '_rrze' ),
        'description' => __( 'Dieser Bereich ist für die Zusatzinformationen (im Fußteil) vorgesehen. Hier könnten hilfreiche Links oder sonstige Informationen stehen, welche auf jeder Seite eingeblendet werden sollen. Diese Angaben werden bei der Ausgabe auf dem Drucker nicht mit ausgegeben!', '_rrze' ),
        'before_widget' => '<div class="blog">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));
}

add_action( 'widgets_init', '_rrze_widgets_init' );

function _rrze_list_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">sagt:</span>', '_rrze' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Ihr Kommentar muss noch moderiert werden.', '_rrze' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php printf( __( '%1$s um %2$s', '_rrze' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(bearbeiten)', '_rrze' ), ' ' ); ?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', '_rrze' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(bearbeiten)', '_rrze' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
