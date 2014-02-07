<html>
	<head>
		<title>pipcorona's HabitRPG Character Display</title>
	</head>
	<body>
		<!--Method 1-->
			<?php
				include './inc/habitrpg-api.php';
				echo '<iframe sandbox="allow-popups" src="http://habitrpg.pipcorona.net/get-character.php?api_user='.$api_user.'&api_key='.$api_key.'" style="border: 0; height: 273px;" />';
			?>
		<!--End Method 1-->
		
		<!--Method 2-->
			<iframe sandbox="allow-popups" src="http://habitrpg.pipcorona.net/get-character.php?api_user=PUT_USER_ID_HERE&api_key=PUT_API_KEY_HERE" style="border: 0; height: 273px;" />
		<!--End Method 2-->
	</body>
</html>