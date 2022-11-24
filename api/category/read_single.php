<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//Inclusion du fichier Database et Category.php
include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instancié la BD et connexion
$database = new Database();
$db = $database->connect();


//Instancié l'objet Category
$category = new Category($db);

// Récupérer l'ID
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

// Récupérer la catégorie
$category->read_single();

//Création d'un tableau
$category_arr = array(
    'id' => $category->id,
    'name' => $category->name
);

// L'Output Json
print_r(json_encode($category_arr));
