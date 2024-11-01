<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
    <style>
        input.ss { width: 50px; }
        th {text-align: left;}
    </style>
<?php
$on = array('home page','pages','posts','custom post' );
$po = array('--','top','right','bottom','left' );
if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'],'update_ysi_basic' )) {
    // var_dump($_POST);
    $a = get_option(('ysi-option'));
    for($i=0;$i <= 5; $i++) {
        if (isset($_POST['sl'.$i])) { $a['sl'.$i] = true; } else { $a['sl' . $i] = false; }
        if (isset($_POST['no'.$i])) { $a['no'.$i] = (int)$_POST['no'.$i]; } else { $a['no'.$i] = 1; }
        if (isset($_POST['nt'.$i])) { $a['nt'.$i] = (int)$_POST['nt'.$i]; } else { $a['nt'.$i] = 0; }
        if (isset($_POST['po'.$i])) { $a['po'.$i] = (int)$_POST['po'.$i]; } else { $a['po'.$i] = 5; }
        if (isset($_POST['dv'.$i])) { $a['dv'.$i] = (int)$_POST['dv'.$i]; } else { $a['dv'.$i] = 0; }
        if (isset($_POST['sm'.$i])) { $a['sm'.$i] = (int)$_POST['sm'.$i]; } else { $a['sm'.$i] = 0; }
        if (isset($_POST['pc'.$i])) { $a['pc'.$i] = (int)$_POST['pc'.$i]; } else { $a['pc'.$i] = 0; }
        if (isset($_POST['of'.$i])) { $a['of'.$i] = (int)$_POST['of'.$i]; } else { $a['of'.$i] = 0; }
        if (isset($_POST['om'.$i])) { $a['om'.$i] = (int)$_POST['om'.$i]; } else { $a['om'.$i] = 0; }
        if (isset($_POST['iz'.$i])) { $a['iz'.$i] = (int)$_POST['iz'.$i]; } else { $a['iz'.$i] = 100; }
        if (isset($_POST['io'.$i])) { $a['io'.$i] = (int)$_POST['io'.$i]; } else { $a['io'.$i] = 100; }
    }
    if (isset($_POST['he'])) {$a['he'] = (int)$_POST['he']; } else {$a['he'] = 2; }
    if (get_option(('ysi-option'))) {
        update_option(('ysi-option'), $a);
    } else {
        add_option(('ysi-option'), $a);
    }
}
echo "";
$a = get_option(('ysi-option'));
echo "<div>";
echo '<h1>Your social icons</h1>';
echo "<form method='post'>";
wp_nonce_field('update_ysi_basic');
echo "<input name='options' type='hidden' value='1'>";
echo "<div  style='display: inline-block;margin-right: 30px;'>";
echo "<h2>Select Networks</h2>";
echo "<table><tr><th>icon</th><th>show</th><th>rank</th><th>network</th></tr>";
for($i=0;$i <= 5; $i++){
    if ($a['sl'.$i]){$ch = 'checked';} else {$ch = '';}
    echo "<tr><td>";
    echo "<p style='width:".$a['cs']."px;height:".$a['cs']."px;zoom:.5;background: url(".$a['ci'].") ".($i*$a['cs'])."px 0; margin:0;'></p></td><td>";
    echo "<input type='checkbox' $ch name='sl".$i."'></td><td>";
    echo "<input type='number' min=1 max=6 value=".$a['no'.$i]." name='no".$i."' class='ss'></td><td>";
    echo "<select name='nt".$i."'>";
    for($j=0;$j <= 9; $j++) {
        if ($a['nt'.$i]  == $j )  { $sel = 'selected';
        } else  { $sel = '';
        }
        $net = str_getcsv( $a['nu'.$j], '|');
        echo "<option value='".$j."' ". $sel . ">" . $net[0] . "</option>";
    }
    echo "</td></tr>";
}
echo "</table>";
submit_button( 'save', 'primary', 'save' );
echo "</div>";
echo "<div style='display: inline-block;vertical-align: top;'>";
echo "<h2>Bar settings</h2>";
echo "<table><tr><th></th><th>position</th><th>divider</th><th>offset</th><th>if % = 0</th><th>outer</th>
        <th>zoom</th><th>opality</th></tr>";
for($i=0;$i <= 3; $i++){
    echo "<tr><td>".$on[$i]."</td><td>";
    echo "<select name='po".$i."'>";
    for($j=0;$j <= 4; $j++){
        if ($a['po'.$i] == $j )  { $sel = 'selected';
        } else  { $sel = '';
        }
        echo "<option value='".$j."' ". $sel . ">" . $po[$j] . "</option>";
    }
    echo "<td><input type='number' min=0 max=30 value= ".$a['dv'.$i]." name='dv".$i."' class='ss'>px</td>";
    echo "<td><input type='number' min=0 max=70 step=2 value=".$a['pc'.$i]." name='pc".$i."' class='ss'>%</td>";
    echo "<td><input type='number' min=0 max=600 step=10 value= ".$a['of'.$i]." name='of".$i."' class='ss'>px</td>";
    echo "<td><input type='number' min=0 max=40 step=1 value= ".$a['om'.$i]." name='om".$i."' class='ss'>px</td>";
    echo "<td><input type='number' min=30 max=110 step=5 value= ".$a['iz'.$i]." name='iz".$i."' class='ss'>%</td>";
    echo "<td><input type='number' min=30 max=100 step=5 value= ".$a['io'.$i]." name='io".$i."' class='ss'>%</td></tr>";
}
echo "<tr><td>shortcode [ysi1]</td><td></td><td><input type='number' min=0 max=30 value= ".$a['dv4']." name='dv4' class='ss'>px</td>";
echo "<td></td><td><input type='number' min=0 max=600 step=10 value= ".$a['of4']." name='of4' class='ss'>px</td><td></td>";
echo "<td><input type='number' min=30 max=110 step=5 value= ".$a['iz4']." name='iz4' class='ss'>%</td>";
echo "<td><input type='number' min=30 max=100 step=5 value= ".$a['io4']." name='io4' class='ss'>%</td></tr>";
echo "<tr><td>shortcode [ysi2]</td><td></td><td><input type='number' min=0 max=30 value= ".$a['dv5']." name='dv5' class='ss'>px</td>";
echo "<td></td><td><input type='number' min=0 max=600 step=10 value= ".$a['of5']." name='of5' class='ss'>px</td><td></td>";
echo "<td><input type='number' min=30 max=110 step=5 value= ".$a['iz5']." name='iz5' class='ss'>%</td>";
echo "<td><input type='number' min=30 max=100 step=5 value= ".$a['io5']." name='io5' class='ss'>%</td></tr>";
echo "<tr><td>Hoover effect </td><td><select name='he'>";// hoover effect
for($j=0;$j <= 4; $j++) {
    if ($a['he']  == $j ) {
        $sel = 'selected';
    } else {
        $sel = '';
    }
    echo "<option value='".$j."' ". $sel . ">" . $a['ho'.$j] . "</option>";
}
echo "</td></tr></table>";

echo "</div>";
echo "</form>";
echo '</div>';
