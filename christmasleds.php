<html>
<head>
<title>Skickar data</title>
</head>
<body>
<?php
$port = 8467;
$host = "arduino.tallr.se";

if (!isset($_GET["premade"])) {
	$anRed = array($_POST["ra1"], $_POST["ra2"], $_POST["ra3"], $_POST["ra4"],
		$_POST["ra5"], $_POST["ra6"], $_POST["ra7"], $_POST["ra8"],
		$_POST["ra9"], $_POST["ra10"]);
	$bnRed = array($_POST["rb1"], $_POST["rb2"], $_POST["rb3"], $_POST["rb4"],
		$_POST["rb5"], $_POST["rb6"], $_POST["rb7"], $_POST["rb8"],
		$_POST["rb9"], $_POST["rb10"]);
	$anGreen = array($_POST["ga1"], $_POST["ga2"], $_POST["ga3"], $_POST["ga4"],
		$_POST["ga5"], $_POST["ga6"], $_POST["ga7"], $_POST["ga8"],
		$_POST["ga9"], $_POST["ga10"]);
	$bnGreen = array($_POST["gb1"], $_POST["gb2"], $_POST["gb3"], $_POST["gb4"],
		$_POST["gb5"], $_POST["gb6"], $_POST["gb7"], $_POST["gb8"],
		$_POST["gb9"], $_POST["gb10"]);
	$anBlue = array($_POST["ba1"], $_POST["ba2"], $_POST["ba3"], $_POST["ba4"],
		$_POST["ba5"], $_POST["ba6"], $_POST["ba7"], $_POST["ba8"],
		$_POST["ba9"], $_POST["ba10"]);
	$bnBlue = array($_POST["bb1"], $_POST["bb2"], $_POST["bb3"], $_POST["bb4"],
		$_POST["bb5"], $_POST["bb6"], $_POST["bb7"], $_POST["bb8"],
		$_POST["bb9"], $_POST["bb10"]);

	$waittime = $_POST["waittime"];
	$xstep = $_POST["xstep"];
	$period = $_POST["period"];

	$a0R = $_POST["ra0"];
	$a0G = $_POST["ga0"];
	$a0B = $_POST["ba0"];
	$pR = $_POST["rperiod"];
	$pG = $_POST["gperiod"];
	$pB = $_POST["bperiod"];
} else {
	$anRed = array(); 
	$bnRed = array();
	$anGreen = array(); 
	$bnGreen = array();
	$anBlue = array(); 
	$bnBlue = array();
	$waittime = 10;
	$xstep = 0.1;
	$pR = $pG = $pB = 6.28;
	$a0R = $a0G = $a0B = 0;

	$var = $_GET["premade"];
	echo $var;
	switch ($_GET["premade"]) {
	case "red":
		$a0R = 255;
		break;
	case "green": 
		$a0G = 255; 
		break;
	case "blue":
		$a0B = 255;
		break;
	case "pulsered":
		$anRed = array(1); 
		$bnRed = array(0);
		$a0R = 128; 
		break;
	case "pulsegreen":
		$anGreen = array(1); 
		$bnGreen = array(0);
		$a0G = 128; 
		break;
	case "pulseblue":
		$anBlue = array(1); 
		$bnBlue = array(0);
		$a0B = 128;
		break;
	case "pulseyellow":
		$anRed = array(1); 
		$bnRed = array(0);
		$anGreen = array(1); 
		$bnGreen = array(0);
		$a0R = $a0G = 128; 
		break;
	case "off":
		break;
	}
}

//$an = array(0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0);
//$bn = array(1.2732, 0.0, 0.4244, 0.0, 0.2546, 0.0, 0.1819, 0.0, 0.1415, 0.0, 0.1157, 0.0, 0.0979, 0.0, 0.0849, 0.0, 0.0749, 0.0, 0.067, 0.0, 0.0606, 0.0, 0.0554, 0.0, 0.0509, 0.0, 0.0472, 0.0, 0.0439, 0.0, 0.0411, 0.0, 0.0386);
//$waittime = 100;
//$xstep = 0.005;
//$period = 6.28;

function arrayToString($arr) {
	$str = "";
	foreach ($arr as $a) {
		$str .= sprintf("%2.2f ", $a);
	}

	return $str;
}


$nR = sizeof($anRed);
$nG = sizeof($anGreen);
$nB = sizeof($anBlue);

$red = sprintf("%d %d %1.2f %s%s", $a0R, $nR, $pR, arrayToString($anRed), arrayToString($bnRed));
$green = sprintf("%d %d %1.2f %s%s", $a0G, $nG, $pG, arrayToString($anGreen), arrayToString($bnGreen));
$blue = sprintf("%d %d %1.2f %s%s", $a0B, $nB, $pB, arrayToString($anBlue), arrayToString($bnBlue));

$data = trim(sprintf("2 %d %1.2f\n%s\n%s\n%s", $waittime, $xstep, $red, $green, $blue));

$fp = stream_socket_client("tcp://$host:$port", $errno, $errstr, 10);
if (!$fp) {
	die("Error during send.");
}
echo "Packing data...<br>";
$data = pack("a*x", $data);
echo "Sending data: <pre>\n$data</pre><br>";
fwrite($fp, $data);
echo "Closing connection...<br>";
fclose($fp);
echo "Done!";
?>
<p><a href="index.php">Tillbaka</a></p>
</body>
</html>
