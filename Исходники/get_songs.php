<?php
include_once "bd.php";
include "cache.php";

$sql = "SELECT tracks.*, `action` from tracks LEFT JOIN (SELECT track_id, `action` FROM user_actions WHERE user_id = " . $_SESSION['id'] . " AND `action` = 'Like') as t ON tracks.id = t.track_id;";

$track_ids_like_cached=['default'=>'-1'];
$track_ids_remove_cached=['default'=>'-1'];

$cache = new FileCache('temp/likes_cache_' . $_SESSION['id'], 10000);
$data = $cache->get('data');
if ($data!=null) {
	$songs = $data[$_SESSION['id']];
	foreach ($songs as $song => $action) {
		if ($action === '1') {
			$track_ids_like_cached[] = $song;
		}
		else{
			$track_ids_remove_cached[] = $song;
		}
	}
}

if($arr = $mysqli->query($sql)){

    echo '<table id="songs">';

	foreach($arr as $row){
		if (in_array($row['id'], $track_ids_remove_cached)) {
			$row['action'] = 'NULL';
		}
		if (in_array($row['id'], $track_ids_like_cached)) {
			$row['action'] = 'Like';
		}

		$is_liked = (htmlspecialchars($row['action']) == 'Like');
		echo "<tr><td> <img class='album' src='img_assets/album_stand_in.png'> </td>
		<td>" . htmlspecialchars($row['title']) . "</td>
		<td> " . htmlspecialchars($row['artist']) . " </td> 
		<td> 
		<audio data-id='" . $row['id'] . "' controls controlslist='nodownload nofullscreen'>
	        <source src=" . htmlspecialchars($row['link']) . " type='audio/mpeg'>
	        Your browser does not support the audio element.
	    </audio> 
	    </td>
	    <td><button type='button' data-id='" . $row['id'] . "' class='like_btn " . ($is_liked ? 'liked' : '') . "'>❤︎</button></td> 
	    </tr>";  
    } 
    echo "</table>";
}
else{
    echo "Ошибка: " . $mysqli->error;
    }

?>
