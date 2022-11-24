<?php


//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE'); // Méthode DELETE
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//Inclusion du fichier Database et Post.php
include_once '../../config/Database.php';
include_once '../../models/Post.php';


// Instancié la BD et connexion
$database = new Database();
$db = $database->connect();

//Instancié l'objet Post
$post = new Post($db);


//Récupérer les data 
$data = json_decode(file_get_contents("php://input"));

// ID à supprimer
$post->id = $data->id;


// Supprimer un article
if ($post->delete()) {
    echo json_encode(
        array('message' => 'L\'article a bien été supprimer')
    );
} else {
    echo json_encode(
        array('message' => 'L\'article n\'a pas été supprimer')
    );
}
