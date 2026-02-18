<?php
include_once "bd.php";
include "cache.php";

$cache = new FileCache('temp/likes_cache_' . $_SESSION['id'], 10000);
$data = $cache->get('data');

$sql = "SELECT tracks.*, `action` from tracks RIGHT JOIN (SELECT track_id, `action` FROM user_actions WHERE user_id = " . $_SESSION['id'] . " AND `action` = 'Like') as t ON tracks.id = t.track_id";

if ($data!=null) {
	$songs = $data[$_SESSION['id']];
	$track_ids_like_cached=[];
	$track_ids_remove_cached=[];
	foreach ($songs as $song => $action) {
		if ($action === '1') {
			$track_ids_like_cached[] = $song;
		}
		else{
			$track_ids_remove_cached[] = $song;
		}
	}
	
	if (count($track_ids_remove_cached) != 0){
		$sql = $sql . " HAVING tracks.id NOT IN (" . implode(', ', $track_ids_remove_cached) . ")";
	}
	if (count($track_ids_like_cached) != 0){
		$sql = $sql . " UNION SELECT tracks.*, 'Like' from tracks WHERE id IN (" . implode(', ', $track_ids_like_cached) . ")";
	}
}

if($arr = $mysqli->query($sql)){
    echo '<table id="songs_liked">';
	foreach($arr as $row){
		echo "<tr><td> <img class='album' src='img_assets/album_stand_in.png'> </td>
		<td>" . htmlspecialchars($row['title']) . "</td>
		<td> " . htmlspecialchars($row['artist']) . " </td> 
		<td> 
		<audio data-id='" . $row['id'] . "' controls controlslist='nodownload nofullscreen'>
	        <source src=" . htmlspecialchars($row['link']) . " type='audio/mpeg'>
	        Your browser does not support the audio element.
	    </audio> 
	    </td>
	    <td><button type='button' data-id='" . $row['id'] . "' class='like_btn liked'>❤︎</button></td> 
	    </tr>";  
    } 
    echo "</table>";
}
else{
    echo "Ошибка: " . $mysqli->error;
    }

?>
