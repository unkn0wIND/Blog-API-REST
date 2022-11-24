<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT'); // Méthode PUT
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

//Inclusion du fichier Database et Category.php
include_once '../../config/Database.php';
include_once '../../models/Category.php';


// Instancié la BD et connexion
$database = new Database();
$db = $database->connect();

//Instancié l'objet Category
$category = new Category($db);

// Récupérer les donnée RAW
$data = json_decode(file_get_contents("php://input"));

// ID à UPDATE
$category->id = $data->id;

$category->name = $data->name;

// Update la catégorie
if ($category->update()) {
    echo json_encode(
        array('message' => 'La catégorie a bien été modifié')
    );
} else {
    echo json_encode(
        array('message' => 'La catégorie a bien été modifié')
    );
}
