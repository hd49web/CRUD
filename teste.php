<?php
try
{
      $pdo = new PDO("mysql:dbname=crud;host=localhost","root","");	
} catch (PDOException $e) {
	echo "erro no bando de dados".$e->getMessage();
} catch (PDOException $e) {
	echo "erro normal";
}





?>
