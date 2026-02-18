<?php
session_start();

require "bd.php";
include "cache.php";

if (isset($_GET['query'])) {
	$cache = new FileCache('temp/likes_cache_' . $_SESSION['id'], 10000);
	$data = $cache->get('data');

	if($_GET['query'] === 'input'){
		$songID = $_GET['songID'];
		$is_added = $_GET['isAdded'];
		$action = $is_added == 'false' ? "0" : "1";

		if ($data === null){
			$data = [$_SESSION['id'] => [$songID => $action]];
		}
		else {
			$data[$_SESSION['id']][$songID] = $action;
		}
		$cache->set('data', $data);
	}
	else { //'call'
		if ($data != null){
			foreach ($data as $user_id => $songs) {
				foreach ($songs as $track_id => $action) {
					$sql = "CALL `likes_management`(" . htmlspecialchars($user_id) . ", " . htmlspecialchars($track_id) . ", " . $action . ");";

					//var_dump($data);
					//echo $sql;
					$cache->set('data', null);
					$stmt = $mysqli->prepare($sql);
					$stmt->execute();
					$stmt->close();
				} 
			} 
		}
	}
}



?>
