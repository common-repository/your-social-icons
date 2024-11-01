<?php
// Plugin Name: Your social icons
// Plugin URI: http://eduk.nl/ysi
// Description: Use your social icons and configure them perfect in your pages. Share content or link to your social media page
// Version: 1.2.0
// Author: Erik Dukker, Eduk.nl
// Requires at least: 3.5
// Tested up to: 4.7
// Stable tag: 4.7
// License: GPLv2 or later
// License URI: http://www.gnu.org/licenses/gpl-2.0.html
if ( ! defined( 'ABSPATH' ) ) exit;
register_activation_hook( __FILE__, 'ysi_on_activation' );
register_deactivation_hook( __FILE__, 'ysi_on_deactivation' );
register_uninstall_hook( __FILE__ , 'ysi_on_uninstall' );
/* Activation hook. */
function ysi_on_activation() { }
/* Deactivation hook. */
function ysi_on_deactivation(){ }
function ysi_on_uninstall() {
    delete_option(('ysi-option'), $a);
}
add_action( 'admin_bar_menu', 'ysi_menu_top', 90 );
function ysi_menu_top( ) {
    global $wp_admin_bar;
    if ( !is_user_logged_in() ) return;
    if ( !is_super_admin() || !is_admin_bar_showing() )return;
    $wp_admin_bar->add_menu( array(
            'id' => ('ysi'),
            'title' => __( 'Your social icons' , 'ysi' )));
    $wp_admin_bar->add_menu( array(
        'parent' => ('ysi'),
        'id'     => 'ysi_basic',
        'title' => __( 'Basic', 'ysi'),
        'href'   => admin_url( 'admin.php?page=ysi_basic' )));
   $wp_admin_bar->add_menu( array(
        'parent' => ('ysi'),
        'id'     => 'ysi_expert',
        'title' => __( 'Expert', 'ysi'),
       'href'   => admin_url( 'admin.php?page=ysi_expert' )));
}
add_action( 'admin_menu', 'ysi_menu_side' );
function ysi_menu_side(  ) {
    add_menu_page( '', 'Your social icons', 'manage_options', ('ysi'), 'ysi_basic');
    add_submenu_page (('ysi'), __( 'Basic', 'ysi'), __( 'Basic', 'ysi'), 'manage_options', 'ysi_basic', 'ysi_basic' );
    add_submenu_page (('ysi'), __( 'Expert', 'ysi'), __( 'Expert', 'ysi'), 'manage_options', 'ysi_expert', 'ysi_expert' );
    if (!get_option(('ysi-option'))) {
        $a = array();
        $a['ho0'] = "none";
        $a['ho1'] = "shrink";
        $a['ho2'] = "grow";
        $a['ho3'] = "turn";
        $a['ho4'] = "skew";
        $a['nu0'] = "facebook share|http://www.facebook.com/sharer.php?u=%share_url%";
        $a['nu1'] = "linkedin share|http://www.linkedin.com/shareArticle?mini=true&url=%share_url%";
        $a['nu2'] = "google plus share|https://plus.google.com/share?url=%share_url%";
        $a['nu3'] = "twitter share|http://twitter.com/intent/tweet?text=%title% - %share_url%";
        $a['nu4'] = "pinterest share|http://pinterest.com/pin/create/bookmarklet/?is_video=false&url=%share_url%&media=%img%&description=%title%";
        $a['nu5'] = "instagram page|http://www.instagram.com/YOURPAGE/";
        $a['nu6'] = "facebook page|http://www.facebook.com/YOURPAGE";
        $a['nu7'] = "linkedin page|http://www.linkedin.com/in/YOURPAGE/";
        $a['nu8'] = "free 1|http://eduk.nl/sharer.php?u=%share_url%";
        $a['nu9'] = "free 2|http://eduk.nl/sharer.php?u=%share_url%";
        for($i=0;$i <= 5; $i++){ $a['sl'.$i] = true; $a['no'.$i] = $i+1; $a['nt'.$i] = $i;
            $a['po'.$i] = 2; $a['dv'.$i] = 0; $a['sm'.$i] = 0; $a['pc'.$i] = 20; $a['of'.$i] = 0; $a['om'.$i] = 5; $a['iz'.$i] = 50; $a['io'.$i] = 100;
        }
        $a['nt0'] = 0;$a['nt1'] = 5;$a['nt2'] = 1;$a['nt3'] = 2;$a['nt4'] = 4;$a['nt5'] = 3;$a['cr'] = 0;$a['he'] = 1;
        $a['ci'] = plugins_url( '/defaulticonssprite.png' , __FILE__ ); $a['cs']=100;$a['rc']=0;$a['cc']='';
        add_option(('ysi-option'), $a);
    }
}
function ysi_basic( ) { include_once("ysi_basic.php"); }
function ysi_expert( ) { include_once("ysi_expert.php"); }
add_action('wp_head','ysi_front_end');
function ysi_front_end() { /* home page, pages, posts, custom post */
    echo "<script>
    jQuery(document).ready( function() {
        jQuery('#ysi a').click(function(e) {
            event.preventDefault(e);
            share_url = jQuery(this).attr('href');
            popUp=window.open(share_url, 'popupwindow', 'scrollbars=yes,width=800,height=400');
            popUp.focus();
            return false;
        })
    })
    jQuery(document).ready( function() {
        jQuery('#ysis a').click(function(e) {
            event.preventDefault(e);
            share_url = jQuery(this).attr('href');
            popUp=window.open(share_url, 'popupwindow', 'scrollbars=yes,width=800,height=400');
            popUp.focus();
            return false;
        })
    })
    </script>";
    $a=get_option(('ysi-option'));
    if (is_home() || is_front_page()) {
        if ($a['po0'] != 0 ) { echo ysi_share_buttons($a,0); }
    }  elseif ( is_singular() && !is_singular('post') && !is_singular('page')) {
        if ($a['po3'] != 0) { echo ysi_share_buttons($a,3); }
    }  elseif (is_singular('page')) {
        if ($a['po1'] != 0) { echo ysi_share_buttons($a,1); }
    }  elseif ( is_singular('post')) {
        if ($a['po2'] != 0) { echo ysi_share_buttons($a, 2); }
    }
}
add_shortcode( 'ysi1', 'ysi1' );
function ysi1( ) {
    $a=get_option(('ysi-option'));
    return ysi_share_buttons($a,4);
}
add_shortcode( 'ysi2', 'ysi2' );
function ysi2( ) {
    $a=get_option(('ysi-option'));
    return ysi_share_buttons($a,5);
}
function ysi_share_buttons($pars,$pag) {
    global $version;
    //var_dump($pars);
    $output= '';
    $share_url = get_permalink();
    $title = get_the_title();
    if (has_post_thumbnail( get_the_ID() ) ):
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
        $img = $image[0];
    endif;
    if ($pars['cr'] != 0 ){$radius= 'border-radius: '.$pars['cr'].'px';} else {$radius='';}

    $output .=  '<style>';
    switch ($pars['he']) {
        case 0:
            break;
        case 1:
            $output .= '#ysi a:hover, #ysis a:hover { transform: scalex(0.9); transition: .5s;}';
            break;
        case 2:
            $output .= '#ysi a:hover, #ysis a:hover { transform: scalex(1.1); transition: .5s;}';
            break;
        case 3:
            $output .= '#ysi a:hover, #ysis a:hover { transform: rotate(2deg);; transition: .5s;}';
            break;
        case 4:
            $output .= '#ysi a:hover, #ysis a:hover { transform: skew(2deg,2deg); transition: .5s;}';
            break;
    }
    if ($pag <= 3) {
        $output .=  '#ysi { position: fixed; display: block; z-index	: 10000000; border-style: none; box-shadow: none !important;'.
             'zoom:'.($pars['iz'.$pag]/100).'; opacity:'.($pars['io'.$pag]/100).';} ';
        $output .=  '#ysi a { display: block;	overflow: hidden; position: relative; }';
        if ($pars['pc'.$pag] != 0) {$sh = $pars['pc'.$pag].'%';} else {$sh = $pars['of'.$pag].'px';}
        switch ($pars['po'.$pag]) { /* --, top, right, bottom, left */
            case 1: //top
                $output .=  '#ysi div {  display: inline-block; margin-right:'.$pars['dv'.$pag].'px;'.$radius.'}';
                $output .=  '#ysi { top: '.$pars['om'.$pag].'px; left:'.$sh.'}'; break;
            case 2: //right
                $output .=  '#ysi div {  display: block; margin-bottom:'.$pars['dv'.$pag].'px;'.$radius.'}';
                $output .=  '#ysi { right: '.$pars['om'.$pag].'px;  top:'.$sh.'}'; break;
            case 3: //bottom
                $output .=  '#ysi div {  display: inline-block;  margin-right:'.$pars['dv'.$pag].'px;'.$radius.'}';
                $output .=  '#ysi { bottom: '.$pars['om'.$pag].'px; left:'.$sh.'}'; break;
            case 4: //left
                $output .=  '#ysi div {  display: block; margin-bottom:'.$pars['dv'.$pag].'px;'.$radius.'}';
                $output .=  '#ysi { left: '.$pars['om'.$pag].'px; top:'.$sh.'}'; break;
        }
        $output .=  ' '.$pars['cc'].' </style>';
        $output .=  '<div id="ysi" class="ysipg'.$pag.'">';
    } else {
        switch ($pag) {
            case 4: //shortcode 1
            case 5: //shortcode 2
                $output .=  '#ysis { display: block; z-index	: 10000000; border-style: none; box-shadow: none !important;'.
                    'zoom:'.($pars['iz'.$pag]/100).'; opacity:'.($pars['io'.$pag]/100).' position: relative; left:'.$pars['of'.$pag].'px'.'}';
                $output .=  '#ysis a { display: block;	overflow: hidden; position: relative; }';
                $output .=  '#ysis div {  display: inline-block; margin-right:'.$pars['dv'.$pag].'px;'.$radius.'}';  break;
        }
        $output .=  ' '.$pars['cc'].' </style>';
        $output .=  '<div id="ysis" class="ysipg'.$pag.'">';
    }
     for($i=0;$i <= 5; $i++){
        if ($pars['sl'.$i]) {
            $sr[$pars['no' . $i]] = $pars['nt' . $i];
            $ii[$pars['no' . $i]] = $i;
        }
    }
    for($i=1;$i <=6; $i++){
        if ( isset($sr[$i])) {
            $output .=  "<div>";
            $title= 'test';
            $urtmp = str_getcsv( $pars['nu'.$sr[$i]], '|');
            $ur = str_replace('%share_url%', $share_url, $urtmp[1]);
            $ur = str_replace('%title%', $title, $ur);
            $ur = str_replace('%title%', $title, $ur);
            $output .=  "<a style='width:".$pars['cs']."px;height:".$pars['cs']."px;background: url(".esc_url($pars['ci']).") ".(($ii[$i])*$pars['cs'])."px 0';
            href='".esc_html($ur)   ."'></a>";
            $output .=  "</div>";
        }
    }
    $output .=  '</div>';
    Return $output;
}
