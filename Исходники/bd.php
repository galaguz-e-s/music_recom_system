<?php

$mysqli = new mysqli(hostname, username, password, database);    //Вставьте данные о БД
if ($mysqli == false){
    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
}
?>