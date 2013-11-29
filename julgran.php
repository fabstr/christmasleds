<?php
/* LNCP: LED Network Control Protocol:
 * Byte 0 is protocol version
 * Byte 1 is delaytime
 * Byte 2-6 are coefficients for r(t) (see below)
 * Byte 7-11, are coeccicient for g(t) (see below)
 * Byte 12-16 are coeccicient for b(t) (see below)
 * r(t), g(t) and b(t) are functions on the form
 *   f(t)=Asin((B/C)t+D)+E
 * where A,B,C,D,E are real constants and 0 <= A,B,C,D,E <= 255
 * 
 * LNCP operates on port 8467.
 */
//$f = fopen("access.log", "a");
//if (!$f) die("Could not open log file.");
$port = 8467;
$host = "arduino.tallr.se";
$w = $_GET["wait"];
$ba = $_GET["RA"]; $bb = $_GET["RB"]; $bc = $_GET["RC"]; $bd = $_GET["RD"]; $be = $_GET["RE"];
$ga = $_GET["GA"]; $gb = $_GET["GB"]; $gc = $_GET["GC"]; $gd = $_GET["GD"]; $ge = $_GET["GE"];
$ra = $_GET["BA"]; $rb = $_GET["BB"]; $rc = $_GET["BC"]; $rd = $_GET["BD"]; $re = $_GET["BE"];
$r = colFunc($ra, $rb, $rc, $rd, $re);
$g = colFunc($ga, $gb, $gc, $gd, $ge);
$b = colFunc($ba, $bb, $bc, $bd, $be);
$version = 1;
$waittime = ($w < 0 || $w > 255) ? 10 : $w;
$packet = createPacket($version, $waittime, $r, $g, $b);
send($packet, $host, $port);

/* create log file and header */
$page="index.php?wait=$waittime&RA=$ra&RB=$rb&RC=$rc&RD=$rd&RE=$re&GA=$ga&GB=$gb&GC=$gc&GD=$gd&GE=$ge&BA=$ba&BB=$bb&BC=$bc&BD=$bd&BE=$be";
$data = substr($page, 15);
$data = str_replace(array("RA", "RB", "RC", "RD", "RE", "GA", "GB", "GC", "GD", "GE", "BA", "BB", "BC", "BD", "BE", "wait", "&"), "", $data);
$time = date("ymd-His", time());
$rip = $_SERVER['REMOTE_ADDR'];

/* log */
//fwrite($f, "$time $rip $data\n");
//fclose($f);

/* send header */
header("Location: $page");

/**
 * Return a (unsigned char) array of $a, $b, $c, $d and $e.
 * This array is an abstract description of a function on
 * the form f(x):=a*sin((b/c)x+d)+e.
 * Please note that 0 <= a,b,d,e <= 255 and that c != 0.
 * @param $a The a-coeccicient
 * @param $b The b-coeccicient
 * @param $c The c-coeccicient
 * @param $d The d-coeccicient
 * @param $e The e-coeccicient
 * @return The array (or is it a string?)
 */
function colFunc($a, $b, $c, $d, $e) 
{
	if ($a < 0) $a = 0; else if ($a > 255) $a = 255;
	if ($b < 0) $b = 0; else if ($b > 255) $b = 255;
	if ($c < 1) $c = 0; else if ($c > 255) $c = 255; /* c > 0 */
	if ($d < 0) $d = 0; else if ($d > 255) $d = 255;
	if ($e < 0) $e = 0; else if ($e > 255) $e = 255;
	return pack("CCCCC", $a, $b, $c, $d, $e);
}

/**
 * Create a packet on the form
 *   version, waittime, r, b, g
 * where version is the (protocol) version number,
 * waittime is the deyal between each iteration and
 * r, g, b are strings created using colFunc().
 * @param $version The version number
 * @param $r The r string
 * @param $g The g string
 * @param $b The b string
 * @return The packet
 */
function createPacket($version, $waittime, $r, $g, $b)
{
	return pack("CC", $version, $waittime) . $r . $g . $b;
}

/**
 * Send data using TCP to a server at $IP:$PORT.
 * @param $data The data to send.
 */
function send($data, $host, $port) 
{
	$fp = stream_socket_client("tcp://$host:$port", $errno, $errstr, 10);
	if (!$fp) {
		$f = fopen("access.log", "a");
		if (!$f) die("Could not open log file to write error.");
		fwrite($f, "Error: ($errno) $errstr\n");
		fclose($f);
		die("Error during send.");
	}
	fwrite($fp, $data);
	fclose($fp);
}
?>
