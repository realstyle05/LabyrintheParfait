<?php
$directory = 'img_Tiles';
$files = array_diff(scandir($directory), array('..', '.'));

header('Content-Type: application/json');
echo json_encode($files);
?>