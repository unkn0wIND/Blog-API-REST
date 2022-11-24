<?php

//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//Inclusion du fichier Database et Post.php
include_once '../../config/Database.php';
include_once '../../models/Post.php';


// Instancié la BD et connexion
$database = new Database();
$db = $database->connect();

//Instancié l'objet Post
$post = new Post($db);

//Appel à la méthode read
$result = $post->read();

// row count
$num = $result->rowCount();

//Vérifier si il y a un article
if ($num > 0) {
    //Tableau post
    $posts_arr = array();
    $posts_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        );

        // PUSH dans "data"
        array_push($posts_arr['data'], $post_item);
    }

    //Output en JSON
    echo json_encode($posts_arr);
} else {
    // Pas d'article
    echo json_encode(['message' => 'Pas d\'article dans la base']);
}
