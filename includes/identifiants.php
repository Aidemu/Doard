<?php
try
{
$db = new PDO('mysql:host=localhost;dbname=doard', 'root', '');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}