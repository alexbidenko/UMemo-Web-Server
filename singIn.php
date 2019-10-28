<?php
$mysqli = new mysqli("81.90.180.128", "umemo_server", "server_umemo", "umemo_database");
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

if ($_POST['comand'] == "enter") {
    $result = $mysqli->query("SELECT * FROM users_01_01_2019_sing_data WHERE login = '".$_POST['login']."';");
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['pass'] == $_POST['pass']) echo "well";
        else echo "not_pass";
    } else echo "not_pass";
} else if ($_POST['comand'] == "regist") {
    $result = $mysqli->query("SELECT * FROM users_01_01_2019_sing_data WHERE login = '".$_POST['login']."';");
    
    if($result->num_rows > 0) {
        echo "no";
    } else if (//Данные обо всех пользователях - добавлям туда нового пользователя
        !$mysqli->query("INSERT INTO users_01_01_2019_sing_data 
            (
                login, 
                pass, 
                email
            ) 
            VALUES 
            (
                '".$_POST['login']."', 
                '".$_POST['pass']."', 
                '".$_POST['email']."'
            );") || 
        //Создаем таблицу параметров всех заметок (цвета, шрифты...)
        !$mysqli->query("CREATE TABLE keeps_table_".$_POST['login']."_".$_POST['pass']." 
            (
                id_keep INT AUTO_INCREMENT PRIMARY KEY,
                keep_name VARCHAR(20), 
                color_keep INT, 
                font_family_number_keep INT, 
                font_family_path_keep VARCHAR(20), 
                text_size_keep INT, 
                date_redact VARCHAR(16),
                keep_next_event VARCHAR(16)
            );") || 
        //Создаем таблицу с текстами всех заметок
        !$mysqli->query("CREATE TABLE keeps_text_".$_POST['login']."_".$_POST['pass']." 
            (
                id_data INT AUTO_INCREMENT PRIMARY KEY,
                keep_name VARCHAR(20), 
                keep_type_of_data VARCHAR(20), 
                keep_value_of_data VARCHAR(160)
            );")) {
        echo "Не удалось создать таблицу: (" . $mysqli->errno . ") " . $mysqli->error."\n";
    } else {
        echo "created";
    }
}
?>