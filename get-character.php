<?php
	if ($_GET['method']==="session"){ session_start(); }
	include_once("./inc/analyticstracking.php");
?>

<link rel="stylesheet" type="text/css" href="./inc/habitrpg.css">
<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>

<?php
	//Set your image directory. This makes it easier for people who deploy this on their own server and don't want to follow the same file structure
	//Set this to the folder that will contain the spritesmith and backer-only folders
	$imagedir = './img/sprites';

	//Checks to see if the user id and api key are set in the url, if not, uses the onse in the included file
	//Make sure to set the included files permissions to read and write only for the user (600)
	if (isset($_GET['api_user']) && isset($_GET['api_key'])){
		$api_user = $_GET['api_user'];
		$api_key = $_GET['api_key'];
	} elseif (isset($_SESSION['api_user']) && isset($_SESSION['api_key'])) {
		$api_user = $_SESSION['api_user'];
		$api_key = $_SESSION['api_key'];
		unset($_SESSION['api_user'], $_SESSION['api_key']);
	} else {
		include './inc/habitrpg-api.php';
	}
	
	//Set $ch to the curl request required by the api
	$ch = curl_init('https://beta.habitrpg.com/api/v2/user/');
	curl_setopt($ch,CURLOPT_HTTPHEADER,array(
		'Content-Type:application/json',
		'x-api-user: '.$api_user.'',
		'x-api-key: '.$api_key.''
	));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	//Execute the request and then close the connection
	$result = curl_exec($ch);
	curl_close($ch);
	
	//Use json_decode to turn the result into an array so PHP can work with it
	$dump = json_decode($result, true);
	
	//Grab the characters profile name and store it in $user
	$user = $dump["profile"];
	$user = $user["name"];
	
	//Grab the characters statistics and store the array in $stats
	$stats = $dump["stats"];
	
	//Grab the characters preferences and store the array in $preferences
	$preferences = $dump["preferences"];
	$preferences = array_merge($preferences, $preferences["hair"]);

	//Grab the characters items and store the array in $items, the gear is an array in the array so it is stored in $gear
	$items = $dump["items"];
	$gear = $items["gear"];
	
	//Check to see if the user has a costume instead of equipped gear, if so, store that in the $items array
	if ($preferences["costume"] == 1){
		$items = array_merge($items, $gear["costume"]);
	} else {
		$items = array_merge($items, $gear["equipped"]);
	}
	
	//$result and $dump are no longer necessary, so unset the variables
	unset($result, $dump);

	?>
	
<div id="container">
	<div id="wrapper">
		<a class="habitrpg" style="display:inline" href="https://habitrpg.com" target="_blank">
			<div id="character">

	<?php
	//Displays the user name at above the character if there is no mount
	if($items["currentMount"]==NULL){echo '<div class="text">'.$user.'</div>';}
	
	//The Following display all the sprite pictures. Some require special positions that don't match with the rest so case statements are used
	
	//Shirt
	echo '<div class="base'.(($items["currentMount"]!=NULL)?'-mount':'').'"><img src="'.$imagedir.'/spritesmith/shirts/'.$preferences["size"].'_shirt_'.$preferences["shirt"].'.png" /></div>';
	
	//Skin
	echo '<div class="base'.(($items["currentMount"]!=NULL)?'-mount':'').'"><img src="'.$imagedir.'/spritesmith/skin/skin_'.$preferences["skin"].'.png" /></div>';
	
	//Mustache
	if($preferences["mustache"]!=0){echo '<div class="hair'.(($items["currentMount"]!=NULL)?'-mount':'').'"><img src="'.$imagedir.'/spritesmith/beards/hair_mustache_'.$preferences["mustache"].'_'.$preferences["color"].'.png" /></div>';}
	
	//Beard
	if($preferences["beard"]!=0){echo '<div class="hair'.(($items["currentMount"]!=NULL)?'-mount':'').'"><img src="'.$imagedir.'/spritesmith/beards/hair_beard_'.$preferences["beard"].'_'.$preferences["color"].'.png" /></div>';}
	
	//Hair
	if($preferences["base"]!=0){echo '<div class="hair'.(($items["currentMount"]!=NULL)?'-mount':'').'"><img src="'.$imagedir.'/spritesmith/hair/hair_base_'.$preferences["base"].'_'.$preferences["color"].'.png" /></div>';}
	
	//Bangs
	if($preferences["bangs"]!=0){echo '<div class="hair'.(($items["currentMount"]!=NULL)?'-mount':'').'"><img src="'.$imagedir.'/spritesmith/hair/hair_bangs_'.$preferences["bangs"].'_'.$preferences["color"].'.png" /></div>';}
	
	//Mount
	if($items["currentMount"]!=NULL){
		echo '<div class="mounthead"><img src="'.$imagedir.'/spritesmith/mounts/Mount_Head_'.$items["currentMount"].'.png" /></div>';
		echo '<div class="mountbody"><img src="'.$imagedir.'/spritesmith/mounts/Mount_Body_'.$items["currentMount"].'.png" /></div>';
	}
	
	//Pet
	switch ($items["currentPet"]){
		case NULL:
			break;
		case "Wolf-Cerberus":
			echo '<div class="pet" style="top: 63px;"><img src="'.$imagedir.'/backer-only/BackerOnly-Pet-CerberusPup.gif" /></div>';
			break;
		default:
			echo '<div class="pet"><img src="'.$imagedir.'/spritesmith/pets/Pet-'.$items["currentPet"].'.png" /></div>';
	}
	
	//Shield
	switch ($items["shield"]){
		case "shield_base_0":
			break;
		case "shield_special_0":
			echo '<div class="item'.(($items["currentMount"]!=NULL)?'-mount':'').'"><img src="'.$imagedir.'/backer-only/BackerOnly-Shield-TormentedSkull.gif" /></div>';
			break;
		default:
			echo '<div class="item'.(($items["currentMount"]!=NULL)?'-mount':'').'"><img src="'.$imagedir.'/spritesmith/shield/'.$items["shield"].'.png" /></div>';
	}

	//Helmet
	switch ($items["head"]){
		case "head_base_0";
			echo '<div class="base'.(($items["currentMount"]!=NULL)?'-mount':'').'"><img src="'.$imagedir.'/spritesmith/head/head_0.png" /></div>';
			break;
		case "head_special_0":
			echo '<div class="gear'.(($items["currentMount"]!=NULL)?'-mount" style="top: -24; left: 22;"':'" style="top: 1; left:22;"').'><img src="'.$imagedir.'/backer-only/BackerOnly-Equip-ShadeHelmet.gif" /></div>';
			break;
		case "head_special_1":
			echo '<div class="gear'.(($items["currentMount"]!=NULL)?'-mount" style="top: -3; left: 25;"':'" style="top: 22; left:25;"').'><img src="'.$imagedir.'/backer-only/ContributorOnly-Equip-CrystalHelmet.gif" /></div>';
			break;
		default:
			echo '<div class="gear'.(($items["currentMount"]!=NULL)?'-mount':'').'"><img src="'.$imagedir.'/spritesmith/head/'.$items["head"].'.png" /></div>';
	}
	
	//Armor
	switch ($items["armor"]){
		case "armor_base_0":
			break;
		case "armor_special_0":
			echo '<div class="gear'.(($items["currentMount"]!=NULL)?'-mount':'').'"><img src="'.$imagedir.'/backer-only/BackerOnly-Equip-ShadeArmor.gif" /></div>';
			break;
		case "armor_special_1":
			echo '<div class="gear'.(($items["currentMount"]!=NULL)?'-mount" style="top:-3;"':'" style="top:22;"').'><img src="'.$imagedir.'/backer-only/ContributorOnly-Equip-CrystalArmor.gif" /></div>';
			break;
		default:
			echo '<div class="gear'.(($items["currentMount"]!=NULL)?'-mount':'').'"><img src="'.$imagedir.'/spritesmith/armor/'.$preferences["size"].'_'.$items["armor"].'.png" /></div>';

	}
				
	//Weapon
	switch ($items["weapon"]){
		case "weapon_base_0":
			break;
		case "weapon_special_0":
			echo '<div class="item'.(($items["currentMount"]!=NULL)?'-mount" style="top: -30; left: 22;"':'" style="top: -5; left: 22;"').'><img src="'.$imagedir.'/backer-only/BackerOnly-Weapon-DarkSoulsBlade.gif" /></div>';
			break;
		case "weapon_special_1":
			echo '<div class="item'.(($items["currentMount"]!=NULL)?'-mount" style="left:7;"':'" style="left:7;"').'"><img src="'.$imagedir.'/spritesmith/weapon/'.$items["weapon"].'.png" /></div>';
			break;
		case "weapon_special_critical":
			echo '<div class="item'.(($items["currentMount"]!=NULL)?'-mount" style="left: 13; top: 6;"':'" style="left: 13; top: 31;"').'"><img src="'.$imagedir.'/backer-only/weapon_special_critical.gif" /></div>';
			break;
		default:
			echo '<div class="item'.(($items["currentMount"]!=NULL)?'-mount':'').'"><img src="'.$imagedir.'/spritesmith/weapon/'.$items["weapon"].'.png" /></div>';
	}
	
	//Sleep
	if($preferences["sleep"]==1){echo '<div class="base'.(($items["currentMount"]!=NULL)?'-mount':'').'"><img src="'.$imagedir.'/spritesmith/shop/zzz.png" /></div>';}

?>
			</div>
			<div class="text">
				<!-- Displays the user name below the character if there is a mount-->
				<?php if($items["currentMount"]!=NULL){echo '<div class="text">'.$user.'</div>';} ?>
				<!-- Displays the characters level and class-->
				Level <?php echo $stats["lvl"].' '.ucfirst($stats["class"]); ?>
			</div>
			<!--Display progress bars for hp, experience and mana-->
			<div id="meters">
				<div class="meter-wrap">
					<div class="hp" style="width:<?php echo($stats["hp"]/$stats["maxHealth"])*100; ?>%;">
						<div class="meter-text"><i class="icon-heart"></i><?php echo round($stats["hp"]).' / '.$stats["maxHealth"]; ?></div>
					</div>
				</div>
				<div class="meter-wrap">
					<div class="exp" style="width:<?php echo($stats["exp"]/$stats["toNextLevel"])*100; ?>%;">
						<div class="meter-text"><i class="icon-star"></i><?php echo round($stats["exp"]).' / '.$stats["toNextLevel"]; ?></div>
					</div>
				</div>
				<div class="meter-wrap">
					<div class="mana" style="width:<?php echo($stats["mp"]/$stats["maxMP"])*100; ?>%;">
						<div class="meter-text"><i class="icon-fire"></i><?php echo round($stats["mp"]).' / '.$stats["maxMP"]; ?></div>
					</div>
				</div>
			</div>
		</a>
	</div>
	<div style="clear: both; width: 100%;"></div>
</div>
<?php
	//Unset the arrays				
	unset($preferences, $stats, $items, $user, $api_user, $api_key);
?>