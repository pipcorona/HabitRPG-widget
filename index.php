<html>
	<head>
		<title>pipcorona's HabitRPG Character Display</title>
	</head>
	<body>
		<!--Method 1-->
			<?php
				//Place this at the very top of your web page before anything else, even the <html> tag
				include './inc/habitrpg-api.php';
			?>
				<!--Place this where you want the widget to show up-->
				<iframe sandbox="allow-popups allow-scripts" src="http://habitrpg.pipcorona.net/get-character.php" style="border: 0; height: 273px;" />';
		<!--End Method 1-->
		
		<!--Method 2-->
			<iframe sandbox="allow-popups allow-scripts" src="http://habitrpg.pipcorona.net/get-character.php?api_user=PUT_USER_ID_HERE&api_key=PUT_API_KEY_HERE" style="border: 0; height: 273px;" />
		<!--End Method 2-->
	</body>
</html>