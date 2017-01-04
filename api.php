<?php

require_once 'vendor/autoload.php';

$app = new \Slim\Slim();

$db = new mysqli("localhost","root","","armonic");

$app->get("/categorias",function() use($db,$app){
	$query = $db->query("SELECT * FROM categorias;");
	$categorias = array();
	while($fila=$query->fetch_assoc()){
		$categorias[]=$fila;
	}
	
	echo json_encode($categorias);
});

$app->post("/categorias",function() use($db,$app){
	
	$query="INSERT INTO categorias VALUES(NULL,"
			. "'{$app->request->post("nombre")}'"
			. ")";
	$insert = $db->query($query);
	
	if($insert){
		$result = array("STATUS" => "true", "message" => "Producto creado correctamente!!!");
	}else{
		$result = array("STATUS" => "false", "message" => "Producto NO SE HA creado!!!");
	}
	
	echo json_encode($result);
	
});

$app->put("/categorias/:id",function($id) use($db,$app){
	$query="UPDATE categorias SET " 
			. "nombre = '{$app->request->post("nombre")}', "
			. " WHERE idCategoria={$id}";
	$update=$db->query($query);
	if($update){
		$result = array("STATUS" => "true", "message" => "Producto se ha actualizado correctamente!!!");
	}else{
		$result = array("STATUS" => "false", "message" => "Producto NO SE HA actualizado!!!");
	}
	
	echo json_encode($result);
});

$app->delete("/categorias/:id",function($id) use($db,$app){
	$query="DELETE FROM categorias WHERE idCategoria = {$id}";
	$delete=$db->query($query);
	
	if($delete){
		$result = array("STATUS" => "true", "message" => "Producto se ha borrado correctamente!!!");
	}else{
		$result = array("STATUS" => "false", "message" => "Producto NO SE HA borrado!!!");
	}
	
	echo json_encode($result);
});

$app->run();
