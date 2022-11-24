<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST'); // Méthode POST
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

//Inclusion du fichier Database et Category.php
include_once '../../config/Database.php';
include_once '../../models/Category.php';


// Instancié la BD et connexion
$database = new Database();
$db = $database->connect();


//Instancié l'objet Category
$category = new Category($db);

//Récupérer les data - RAW
$data = json_decode(file_get_contents("php://input"));

$category->name = $data->name;

// Crée la catégorie
if ($category->create()) {
    echo json_encode(
        array('message' => 'La catégorie a bien été crée')
    );
} else {
    echo json_encode(
        array('message' => 'La catégorie n\'a pas été crée')
    );
}
