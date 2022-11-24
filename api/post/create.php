<?php

//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST'); // Méthode POST
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//Inclusion du fichier Database et Post.php
include_once '../../config/Database.php';
include_once '../../models/Post.php';


// Instancié la BD et connexion
$database = new Database();
$db = $database->connect();

//Instancié l'objet Post
$post = new Post($db);


//Récupérer les data - RAW
$data = json_decode(file_get_contents("php://input"));

$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;

// Crée un article
if ($post->create()) {
    echo json_encode(
        array('message' => 'L\'article a bien été crée')
    );
} else {
    echo json_encode(
        array('message' => 'L\'article n\'a pas été crée')
    );
}
