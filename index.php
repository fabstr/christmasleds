<?php
$wait=(isset($_GET['wait'])) ? $_GET['wait'] : '10'; 
$ra=(isset($_GET['RA'])) ? $_GET['RA'] : '125'; 
$rb=(isset($_GET['RB'])) ? $_GET['RB'] : '1'; 
$rc=(isset($_GET['RC'])) ? $_GET['RC'] : '0'; 
$rd=(isset($_GET['RD'])) ? $_GET['RD'] : '125'; 
$re=(isset($_GET['RE'])) ? $_GET['RE'] : '125'; 
$ga=(isset($_GET['GA'])) ? $_GET['GA'] : '125'; 
$gb=(isset($_GET['GB'])) ? $_GET['GB'] : '1'; 
$gc=(isset($_GET['GC'])) ? $_GET['GC'] : '0'; 
$gd=(isset($_GET['GD'])) ? $_GET['GD'] : '125'; 
$ge=(isset($_GET['GE'])) ? $_GET['GE'] : '125'; 
$ba=(isset($_GET['BA'])) ? $_GET['BA'] : '125'; 
$bb=(isset($_GET['BB'])) ? $_GET['BB'] : '1'; 
$bc=(isset($_GET['BC'])) ? $_GET['BC'] : '0'; 
$bd=(isset($_GET['BD'])) ? $_GET['BD'] : '125'; 
$be=(isset($_GET['BE'])) ? $_GET['BE'] : '125'; 
?>
<!DOCTYPE html>
<html lang="sv">
	<head>
		<title>Julgran 2.0</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<style type="text/css">
			body {
				font-family: Verdana, Geneva, sans-serif;
				font-size: 14px;
				color: #333333;
			} h1 {
				font-size: 32px;
				color: #EE0000;
			} h2 {
				color: #00BB00;
				font-size: 24px;
			} h3 {
				color: #0000EE;
				font-size: 16px;
			} table, th, td {
				border-style: none;
			} pre {
				font-size: 16px;
			} div#box {
				width: 600px;
				margin: 0px auto;
				border: 1px solid black;
				padding: 20px;
			} a:link {
				color: #AAAA00;
			} a:visited {
				color: #AAAA00;
			} a:hover {
				color: #444444;
			} a:active {
				color: #444444;
			} .red {
				background-color: #EE8888;
				border: none;
			} .green {
				background-color: #88BB88;
				border: none;
			} .blue {
				background-color: #8888EE;
				border: none;
			} .colour {
				width: 70px;
			} .fraction {
				border-bottom: 3px solid #444444;
			} .copy {
				font-size: 10px;
				text-align: center;
				border-top: 1px solid black;
				padding-top: 10px;
			}
		</style>
	</head>
	<body>
		<div id="box">
		<h1>Julgran 2.0</h1>
		<form action="eth.php" method="get">
		<h2>Färdiga program</h2>
			<h3>Röd</h3>
				<p>Gör lysdioderna röda, tryck <a href="eth.php?wait=255&RA=0&RB=1&RC=1&RD=0&RE=255&GA=0&GB=1&GC=1&GD=0&GE=0&BA=0&BB=1&BC=1&BD=0&BE=0">här</a> för att aktivera.</p>
			<h3>Grön</h3>
				<p>Gör lysdioderna gröna, tryck <a href="eth.php?wait=255&RA=0&RB=1&RC=1&RD=0&RE=0&GA=0&GB=1&GC=1&GD=0&GE=255&BA=0&BB=1&BC=1&BD=0&BE=0">här</a> för att aktivera.</p>
			<h3>Blå</h3>
				<p>Gör lysdioderna blåa, tryck <a href="eth.php?wait=255&RA=0&RB=1&RC=1&RD=0&RE=0&GA=0&GB=1&GC=1&GD=0&GE=0&BA=0&BB=1&BC=1&BD=0&BE=255">här</a> för att aktivera.</p>
			<h3>Program 2</h3>
				<p>Tonar lysdioderna mellan olika färger, tryck <a href="eth.php?wait=255&RA=75&RB=6&RC=180&RD=0&RE=75&GA=125&GB=6&GC=90&GD=0&GE=125&BA=50&BB=6&BC=255&BD=0&BE=200">här</a> för att aktivera.</p>
			<h3>Program 3</h3>
				<p>Som program 2, fast med andra parametrar. Tryck <a href="eth.php? wait=255&RA=50&RB=3&RC=32&RD=0&RE=50&GA=125&GB=3&GC=128&GD=0&GE=125&BA=125&BB=3&BC=255&BD=0&BE=125">här</a> för att aktivera.</p>
			<h3>Alla på</h3>
				<p>Alla färgkanaler sätts till max, effekten av detta blir att många olika färger lyser samtidigt. Tryck 
				<a href="eth.php?wait=255&RA=0&RB=1&RC=1&RD=0&RE=255&GA=0&GB=1&GC=1&GD=0&GE=255&BA=0&BB=1&BC=1&BD=0&BE=255">här</a> för att aktivera.</p>
			<h3>Pulsera, röd</h3>
				<p>Pulsera med färgen röd. Tryck <a href="eth.php?wait=10&RA=125&RB=22&RC=255&RD=0&RE=125&GA=0&GB=1&GC=1&GD=0&GE=0&BA=0&BB=1&BC=1&BD=0&BE=0">här</a> för att aktivera.</p>
			<h3>Pulsera, grön</h3>
				<p>Pulsera med färgen grön. <a href="eth.php?wait=10&RA=0&RB=1&RC=1&RD=0&RE=0&GA=125&GB=22&GC=255&GD=0&GE=125&BA=0&BB=1&BC=1&BD=0&BE=0">här</a> för att aktivera.</p>
			<h3>Pulsera, blå</h3>
				<p>Pulsera med färgen blå. Tryck <a href="eth.php?wait=10&RA=0&RB=1&RC=1&RD=0&RE=0&GA=0&GB=1&GC=1&GD=0&GE=0&BA=125&BB=22&BC=255&BD=0&BE=125">här</a> för att aktivera.</p>
			<h3>Pulsera, gul</h3>
				<p>Pulsera med en gul(aktig) färg. Tryck <a href="eth.php?wait=10&RA=100&RB=22&RC=255&RD=0&RE=100&GA=125&GB=22&GC=255&GD=0&GE=125&BA=0&BB=1&BC=1&BD=0&BE=0">här</a> för att aktivera.</p>
			<h3>Pulsera, cerise</h3>
				<p>Pulsera med en cerise(aktig) färg. Tryck <a href="eth.php?wait=10&RA=113&RB=22&RC=255&RD=0&RE=113&GA=0&GB=1&GC=1&GD=0&GE=0&BA=64&BB=22&BC=225&BD=0&BE=64">här</a> för att aktivera.</p>
			<h3>Snabbt färgbyte</h3>
				<p>Byt snabbt mellan olika färger. Tryck <a href="eth.php?wait=255&RA=125&RB=22&RC=14&RD=0&RE=125&GA=125&GB=22&GC=14&GD=2&GE=125&BA=125&BB=22&BC=14&BD=4&BE=125">här</a> för att aktivera.</p>
			<h3>Långsamt färgbyte</h3>
				<p>Byt långsamt mellan olika färger. Tryck <a href="eth.php?wait=255&RA=125&RB=22&RC=255&RD=0&RE=125&GA=125&GB=22&GC=255&GD=2&GE=125&BA=125&BB=22&BC=255&BD=4&BE=125">här</a> för att aktivera.</p>
			<h3>Stäng av</h3>
				<p>Stäng av lysdioderna Tryck <a href="eth.php?wait=255&RA=0&RB=1&RC=1&RD=0&RE=0&GA=0&GB=1&GC=1&GD=0&GE=0&BA=0&BB=1&BC=1&BD=0&BE=0">här</a> för att aktivera.</p>
		<h2>Hur du skapar ett eget program</h2>
		<p>
			<ol>
				<li>Välj tre funktioner på formen <pre>y(t)=A·sin((B/C)t+D)+E</pre>(det vill säga välj konstanterna A, B, C, D och E).</li>
				<li>Skriv in funktionerna i formuläret nedan.</li>
				<li>Tryck på "Ändra funktioner"</li>
			</ol>
		</p>
		<p> När funktionerna körs kommer t att ökas med ett (1) varje iteration.  </p>
		<p> Väntintervall (millisekunder, hur lång tid som väntas mellan en uppdatering): &nbsp; <input type="text" size="4" name="wait" value="<?php echo $wait ?>"> </p>
		<p> <b>Observera att inga värden får vara minde än noll eller större än 255. Nämnaren C får inte vara noll.</b> Ett tips är att låta täljaren i bråket vara ett närmevärde till en multipel av pi, till exempel sex eller 22. </p>
		<p>En färg lyser som starkast när y(t)=255 och som svagast då y(t)=0. Om en färg alltid ska vara påslagen kan man skriva 0·sin(...)+255.
<!--		<p>De värden som redan är ifyllda kan beskriva de funktioner som körs nu.</p> -->
		<p>
			<table class="red">
				<tr>
					<td class="colour"><pre>Röd(t)</pre></td>
					<td><pre>=</pre></td>
					<td><input type="text" size="3" name="RA" value="<?php echo $ra ?>"></td>
					<td><pre>·sin(</pre></td>
					<td>
						<table>
						<tr><td class="fraction"><input type="text" size="3" name="RB" value="<?php echo $rb ?>"</td></tr>
						<tr><td><input type="text" size="3" name="RC" value="<?php echo $rc ?>"</td></tr>
						</table>
					</td>
					<td><pre>·t+</pre></td>
					<td><input type="text" size="3" name="RD" value="<?php echo $rd ?>"></td>
					<td><pre>)+</pre></td>
					<td><input type="text" size="3" name="RE" value="<?php echo $re ?>"></td>
				</tr>
			</table>
			<table class="green">
				<tr>
					<td class="colour"><pre>Grön(t)</pre></td>
					<td><pre>=</pre></td>
					<td><input type="text" size="3" name="GA" value="<?php echo $ga ?>"></td>
					<td><pre>·sin(</pre></td>
					<td>
						<table>
						<tr><td class="fraction"><input type="text" size="3" name="GB" value="<?php echo $gb ?>"</td></tr>
						<tr><td><input type="text" size="3" name="GC" value="<?php echo $gc ?>"</td></tr>
						</table>
					</td>
					<td><pre>·t+</pre></td>
					<td><input type="text" size="3" name="GD" value="<?php echo $gd ?>"></td>
					<td><pre>)+</pre></td>
					<td><input type="text" size="3" name="GE" value="<?php echo $ge ?>"></td>
				</tr>
			</table>
			<table class="blue">
				<tr>
					<td class="colour"><pre>Blå(t)</pre></td>
					<td><pre>=</pre></td>
					<td><input type="text" size="3" name="BA" value="<?php echo $ba ?>"></td>
					<td><pre>·sin(</pre></td>
					<td>
						<table>
						<tr><td class="fraction"><input type="text" size="3" name="BB" value="<?php echo $bb ?>"</td></tr>
						<tr><td><input type="text" size="3" name="BC" value="<?php echo $bc ?>"</td></tr>
						</table>
					</td>
					<td><pre>·t+</pre></td>
					<td><input type="text" size="3" name="BD" value="<?php echo $bd ?>"></td>
					<td><pre>)+</pre></td>
					<td><input type="text" size="3" name="BE" value="<?php echo $be ?>"></td>
				</tr>
			</table>
			<table>
				<tr>
					<td colspan="6"><input type="submit" value="Ändra funktioner"></td>
				</tr>
			</table>
		</form>
		</p>
		<p class="copy">Fabian Ström 2012 - 2013, <a href="mailto:fs@fabianstrom.se">kontakt</a></p>
		</div> <!-- box -->
	</body>
</html>
