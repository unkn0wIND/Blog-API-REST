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

//Appel à la méthode read
$result = $category->read();

// row count
$num = $result->rowCount();

//Vérifier si il y a un article
if ($num > 0) {
    //Tableau catégorie, cat
    $cat_arr = array();
    $cat_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $cat_item = array(
            'id' => $id,
            'name' => $name
        );

        // PUSH dans "data"
        array_push($cat_arr['data'], $cat_item);
    }

    //Output en JSON
    echo json_encode($cat_arr);
} else {
    // Pas de catégorie
    echo json_encode(
        array('message' => 'Pas de catégorie trouvée')
    );
}
