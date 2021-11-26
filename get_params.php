<?php
$mysqli = new mysqli("db", "umemo_server", "server_umemo", "umemo_database");
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$result = $mysqli->query("SELECT * FROM users_01_01_2019_sing_data WHERE login = '".$_POST['login']."';");

if($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $back_image = "";
    $email = "";
    if ($row['pass'] == $_POST['pass']) {
        if ($row['back_image'] != "") {
            $back_image = "../back_images/".$row['back_image'];
        }
        $email = $row['email'];
        
        echo '{"back_image": "'.$back_image.'", "email": "'.$email.'"}';
    }
}
?>