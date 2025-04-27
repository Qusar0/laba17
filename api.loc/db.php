<?php
# Не дам я свой пароль
$conn = pg_connect("host=127.0.0.1 dbname=postgres user=postgres password=password")
   or die("Connection error: " . pg_last_error());
?>