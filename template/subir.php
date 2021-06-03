<?php 
	$route = 'template/images/';
    
    $foto = $route . basename($_FILES['test']['name']);
    move_uploaded_file($_FILES['test']['tmp_name'], $foto);
 ?>