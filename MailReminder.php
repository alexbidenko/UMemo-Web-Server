<?php
mail($_POST['email'], $_POST['title'], $_POST['text'], "From: umemo@umemo.ru \r\n");
?>