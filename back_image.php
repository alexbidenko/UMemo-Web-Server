<?php

function can_upload($file){
	// если имя пустое, значит файл не выбран
    if($file['name'] == '')
		return 'Вы не выбрали файл.';
	
	/* если размер файла 0, значит его не пропустили настройки 
	сервера из-за того, что он слишком большой */
	if($file['size'] == 0)
		return 'Файл слишком большой.';
	
	// разбиваем имя файла по точке и получаем массив
	$getMime = explode('.', $file['name']);
	// нас интересует последний элемент массива - расширение
	$mime = strtolower(end($getMime));
	// объявим массив допустимых расширений
	$types = array('jpg', 'png', 'bmp', 'jpeg');
	
	// если расширение не входит в список допустимых - return
	if(!in_array($mime, $types))
		return 'Недопустимый тип файла.';
	
	return true;
  }
  
function make_upload($file, $login, $pass){
	
	$mysqli = new mysqli("db", "umemo_server", "server_umemo", "umemo_database");
    if ($mysqli->connect_errno) {
        echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

	$array = explode('.', $file['name']);
    $extension = end($array);

	$name = mt_rand(0, 9999) . mt_rand(0, 9999) . mt_rand(0, 9999) . '.' . $extension;
	copy($file['tmp_name'], 'back_images/'.$name);
	echo '../back_images/'.$name;
	
	$mysqli->query("UPDATE users_01_01_2019_sing_data SET back_image = '".$name."' WHERE login = '".$login."' AND pass = '".$pass."';");
}
	
$mysqli = new mysqli("db", "umemo_server", "server_umemo", "umemo_database");
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$result = $mysqli->query("SELECT * FROM users_01_01_2019_sing_data WHERE login = '".$_POST['login']."' AND pass = '".$_POST['pass']."';");

if($result->num_rows > 0)
{
    $row = $result->fetch_assoc();
    if(isset($_POST['comand']) && $_POST['comand'] == "delete") {
        if (file_exists('back_images/'.$row['back_image'])) unlink('back_images/'.$row['back_image']);
      	
        $mysqli->query("UPDATE users_01_01_2019_sing_data SET back_image = null WHERE login = '".$_POST['login']."' AND pass = '".$_POST['pass']."';");
    } else {
      	// проверяем, можно ли загружать изображение
      	$check = can_upload($_FILES['files']);
      	
      	if (file_exists('back_images/'.$row['back_image'])) unlink('back_images/'.$row['back_image']);
    
      	if($check === true){
            // загружаем изображение на сервер
        	make_upload($_FILES['files'], $_POST['login'], $_POST['pass']);
      	}
    }
}
?>