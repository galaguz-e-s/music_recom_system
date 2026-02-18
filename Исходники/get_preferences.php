<?php
session_start();

require "bd.php";
include "llm_query.php";
include "cache.php";

if (isset($_SESSION["id"])) {

	$sql = "SELECT * FROM (SELECT tracks.*, `action`, `time` from tracks RIGHT JOIN (SELECT track_id, `action`, `time` FROM user_actions WHERE user_id = " . $_SESSION['id'] . " AND `action` = 'Like') as t ON tracks.id = t.track_id ORDER BY `time` LIMIT 5) as t1
	UNION
	SELECT * FROM (SELECT tracks.*, `action`, `time`  from tracks RIGHT JOIN (SELECT track_id, `action`, `time` FROM user_actions WHERE user_id = " . $_SESSION['id'] . " AND `action` = 'Listen') as t ON tracks.id = t.track_id ORDER BY `time` LIMIT 10) as t2;";

	$cache = new FileCache('temp/preferences_cache_' . $_SESSION['id'] . isset($_GET['mood']) ? 'mood' : '', 300);
	$faves = $cache->get('favorites');
	$final = $cache->get('preferences_playlist');
	$mood = $cache->get('mood');

	if ($faves === null or $faves != $preferences or ($_GET['mood'] and $mood===null)) {

		$stmt = $mysqli->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
		$response = array('preferences'=>$data);
		$stmt->free_result();
		$stmt->close();
		$preferences = json_encode($response);

		$sql = "SELECT * FROM tracks";
		$stmt = $mysqli->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
	    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
	    $response = array('tracks'=>$data);
	    $stmt->free_result();
		$stmt->close();
		$tracks = json_encode($response);

		if (isset($_GET['mood'])) {
			$new_track_IDs = getTop10TracksByMood($apiKey, $agentAccessId, $preferences, $tracks, $_GET['mood']);
		}
		else {
			$new_track_IDs = getTop10TracksByMood($apiKey, $agentAccessId, $preferences, $tracks);
		}
		
		if ($new_track_IDs['success'] === false) {
			$response = ['success' => false, 'error' => $new_track_IDs['error']];
		}
		else {
			$track_id_string = implode(", ", $new_track_IDs['track_ids']);
			$sql = "SELECT * FROM tracks where tracks.ID IN (" . $track_id_string .");";
			$stmt = $mysqli->prepare($sql);
			$stmt->execute();
			$result = $stmt->get_result();
		    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
		    $response = ['success' => true, 'tracks'=>$data];
		    $stmt->free_result();
			$stmt->close();	
		}
		$final = json_encode($response);

	$cache->set('preferences_playlist', $final);
	$cache->set('favorites', $preferences);
	if ( isset($_GET['mood'])){
		$cache->set('mood', $_GET['mood']);
	}
	}

	echo $final;
}

$mysqli->close();
?>