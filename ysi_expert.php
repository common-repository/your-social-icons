<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
    <style>
        input.ss { width: 50px; }
        th {text-align: left;}
    </style>
<?php
/* $iz = 100; */
if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'],'update_ysi_expert' )) {
    //  var_dump($_POST);
    $a = get_option(('ysi-option'));
    for($i=0;$i <= 9; $i++){
        $net = str_getcsv( $a['nu'.$i], '|');
        if (isset($_POST['nu'.$i])) {$a['nu'.$i] = $net[0].'|'.sanitize_text_field($_POST['nu'.$i]); } else {$a['nu'.$i] = $net[0].'|'; }
    }
    if (isset($_POST['ci'])) {$a['ci'] = sanitize_text_field($_POST['ci']); } else {$a['ci'] = ''; }
    if (isset($_POST['cs'])) { $a['cs'] = (int)$_POST['cs']; } else { $a['cs'] = 0; }
    if (isset($_POST['rc'])) { $a['rc'] = (int)$_POST['rc']; } else { $a['rc'] = 0; }
    if (isset($_POST['cc'])) {$a['cc'] = sanitize_text_field($_POST['cc']); } else {$a['cc'] = ''; }
    if (get_option(('ysi-option'))) {
        update_option(('ysi-option'), $a);
    } else {
        add_option(('ysi-option'), $a);
    }
}
echo "";
$a = get_option(('ysi-option'));
echo "<div>";
echo '<h1>Your social icons (expert)</h1>';
if (isset($_POST['reset'])) {
    delete_option(('ysi-option'), $a);
    echo "setting are reseted";
} else {
    echo "<form method='post'>";
    wp_nonce_field('update_ysi_expert');
    echo "<input name='options' type='hidden' value='1'>";
    echo "<div  style='display: inline-block;margin-right: 30px;'>";
    echo "<h2>Network URL</h2>";
    echo "<table><tr><th>description</th><th>URL</th></tr>";
    for ($i = 0; $i <= 9; $i++) {
        $net = str_getcsv($a['nu' . $i], '|');
        echo "<tr><td>" . $net[0] . "</td><td><input type='url' size=60 value=" . esc_html($net[1]) . " su name='nu" . $i . "'></td></tr>";
        echo "</td></tr>";
    }
    echo "</table>";
    echo "available params: %share_url% %title% %img% don't forget tot replace YOURPAGE";
    submit_button('save', 'primary', 'save');
    echo "</div>";
    echo "<div style='display: inline-block;vertical-align: top;'>";
    echo "<h3>Custom icons</h3>";
    echo "<table>";
    echo "<tr><td>Custom icon stripe url</td><td><input type='url' size=60 value='" . $a['ci'] . "' name='ci'></td></tr>";
    echo "<tr><td></td><td>Use the url of your icon strip in the media lib, please check the plugin website</td></tr>";
    echo "<tr><td></td><td>Scale the strip to the needed size: zoom doesn't work in Firefox, Opera</td></tr>";
    echo "<tr><td>Custom icon size</td><td><input type='number' min=30 max=150 step=1 value='" . $a['cs'] . "' name='cs' class='ss'>px</td></tr>";
    echo "<tr><td>Rounded corners</td><td><input type='number' min=0 max=50 step=1 value= '" . $a['rc'] . "' name='rc' class='ss'>px</td></tr>";
    echo "</table>";
    echo "<h3>Custom CSS</h3>";
    echo "<textarea rows='10' cols='85' name='cc'> " . esc_textarea($a['cc']) . "</textarea>";
    submit_button('reset all settings', 'primary', 'reset');
    echo "</div>";
    echo "</form>";
}
echo '</div>';
