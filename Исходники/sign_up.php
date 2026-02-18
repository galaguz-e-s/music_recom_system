
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
<body style="background-image: url('img_assets/notes_darken.jpg'); background-repeat: repeat; font-family: 'Inter'; font-weight: bold;">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

	<div id="main_container auth" style=" display: flex; align-items: center; justify-content: center; height: 50em;" >
		<div id="inside_container" style="border-radius: 1.5em">
				<form action="save_user.php" method="POST">
				<h3 style="text-align: center;">Регистрация</h3>
				<h3>Логин: <input type="text" name="login" style="margin-bottom: 0.5em" /></h3>
				<h3>Пароль: <input type="text" name="password" style="margin-bottom: 1em" /></h3>
				<button type="submit"  style="font-size: 2em; border: solid black; width: 100%; margin-bottom: 1em " class = "btn">Зарегистрироваться</button>
				<a href="sign_in.php" style="width: 100%; text-align: center" class="text-decoration-none"><h3>Есть аккаунт? Войти</h3></a>
				</form>
				<h3></h3>
		</div>
	</div>

		</body>
</html>
