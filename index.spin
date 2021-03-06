<!--
	HTML5 Canvas + JavaScript winning wheel
	Created by Douglas McKechie @ http://www.dougtesting.net as an example.
	Last updated 14 July 2013.

	Code to render and spin the wheel is in winwheel_1.2.js.
-->
<html>
	<head>
		<meta charset="utf-8"/>
		<title>HTML5 Canvas Winning Wheel</title>
		<link rel="stylesheet" href="./main.css" type="text/css" />
		<script type='text/javascript' src='winwheel_1.2.js'></script>
	</head>
	<body>
		<div align="center">
			<h1>HTML5 Canvas Winning Wheel</h1>
			<p>Choose a power setting then press the Spin button. The wheel will spin for a few moments then slow to a stop.</p>
			<p>In this example the Prize Detection feature is turned on so you will be alerted to the prize won when the wheel stops.</p>
			<br />
			<hr />
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
						<div class="power_controls">
							<br />
							<br />
							<table class="power" cellpadding="10" cellspacing="0">
								<tr>
									<th align="center">Power</th>
								</tr>
								<tr>
									<td width="78" align="center" id="pw3" onClick="powerSelected(3);">High</td>
								</tr>
								<tr>
									<td align="center" id="pw2" onClick="powerSelected(2);">Med</td>
								</tr>
								<tr>
									<td align="center" id="pw1" onClick="powerSelected(1);">Low</td>
								</tr>
							</table>
							<br />
							<img id="spin_button" src="./spin_off.png" alt="Spin" onClick="startSpin();" />
							<!-- <br /><br />
							&nbsp;&nbsp;<a href="#" onClick="resetWheel(); return false;">Play Again</a><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(reset) -->
						</div>
					</td>
					<td width="438" height="582" class="the_wheel" align="center" valign="center">
						<canvas class="the_canvas" id="myDrawingCanvas" width="434" height="434">
							<p class="noCanvasMsg" align="center">Sorry, your browser doesn't support canvas.<br />Please try another.</p>
						</canvas>
					</td>
				</tr>
			</table>
			<br />
			<hr />
			<br />
			<p>Created by Douglas McKechie @ <a href="http://www.dougtesting.net" target="_blank">www.dougtesting.net</a></p>
		</div>
		<br />
		<script>

			// Call function to draw the wheel face at it's initial position.
			begin();

		</script>
	</body>
</html>
