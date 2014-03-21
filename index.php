<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 20.03.14
 * Time: 23:06
 * Project: how_much_long
 * @author: Evgeny Pynykh bpteam22@gmail.com
 */
?>
<?if(!isset($_POST['steam_link'])){?>
	<form action="" method="POST">
	Your steam link: <input type="text" name="steam_link">
	<input type="submit" value="count"><br/>
	Ex: http://steamcommunity.com/id/xxxKNxxx/games?tab=all<br/>
	<img src="demo.png">
</form>
<?} elseif(preg_match('%^\s*(?<url>(http://)?(?<link>steamcommunity.com/(id|profiles)/(?<nic>[^/]+)/games\?tab=all))\s*$%ims', $_POST['steam_link'], $match)) {
	$data = file_get_contents('http://'.$match['link']);
	if(preg_match('%var\s*rgGames\s*=\s*(?<json>\[\{.*\}\]);%ims',$data,$match) && $json = json_decode($match['json'],true)){
		$hours = 0;
		foreach($json as $data){
			if(isset($data['hours_forever'])){

				$hours += str_replace(',','',$data['hours_forever']);
			}
		}
		echo $hours;
	} else {
		echo 'Error parsing data';
	}
	?>
<?
} else {
	echo 'WRONG LINK';
}
