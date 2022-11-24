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

// Récupérer l'ID via l'URL
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

// Récupérer l'article
$post->read_single();

//Création d'un tableau
$post_arr = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name
);

// Output JSON
print_r(json_encode($post_arr));
