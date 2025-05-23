<?php
session_start();
$_SESSION['test'] = 'Ceci est un test';
echo "Session test créée. <a href='compte.php'>Aller au compte</a>";
?>