
<?php
session_start();

if(!isset($_SESSION["login"]) or !isset($_SESSION["id"])) {
		header("Location: sign_in.php");
		exit();
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    </head>
<body style="background-image: url('img_assets/notes.jpg'); background-repeat: repeat; font-family: 'Inter'; font-weight: bold;">
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

	<header class="header"> 
		     <div class="container_header">
		     	<div class="header__inner">
		       <div class="header__inner">
		       	<h1 style="font-size: 2.5em; font-weight: 600; padding: 0.2em 1em">Музыка</h1>
		        <nav class="menu">
		           <ul class="menu__list">
		             <li class="header__list-item"> <a class="menu__list-link text-decoration-none" >Каталог</a> </li>
		             <li class="header__list-item"> <a class="menu__list-link text-decoration-none" href="playlists.php">Плейлисты</a> </li>
		           	</ul>
		         </nav>
		       	</div>
		       	<div class="header__inner">
		       		<h3> <?php echo $_SESSION["login"] ?> </h3>
		       		<figure class="icon"><button class="icon-button" data-bs-toggle="modal" data-bs-target="#modalAccount"></figure>
		       	</div>
		     	</div>
		     </div>
		</header>

	<div class="modal" id="modalAccount" tabindex="-1">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Аккаунт</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <span>
	        	<p>Логин: <?php echo $_SESSION["login"] ?> </p>
	        </span>
	      </div>
	      <div class="modal-footer">
	      <form method="post">
		    <button type="submit" name ="sign_out" class="btn btn-secondary">Выйти из аккаунта</button>
		  </form>

		  <?php
		    if (isset($_POST['sign_out'])) {
		    	session_unset();
		        header("Location: ".$_SERVER['PHP_SELF']);
		        exit;
		    }
		    ?>

	      </div>
	    </div>
	  </div>

 
</div>
	<div id="main_container">
			<div id="inside_container">
				<h1 style="margin: font-size: 2.5em; font-weight: 600; 0.5em 0em; padding: 0em 0.1em">Каталог песен</h1>
				<?php
            	include 'get_songs.php';
            	?> 
			</div>
	</div>
	<script src="music_manager.js"></script>
		</body>
</html>
