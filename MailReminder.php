<?php
mail($_POST['email'], $_POST['title'], $_POST['text'], "From: umemo@umemo.h1n.ru \r\n");
?>