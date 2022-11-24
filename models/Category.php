<?php
class Category
{
  //Etablir la connexion à la db
  private $connection;
  private $table = 'categories';

  // Properties
  public $id;
  public $name;
  public $created_at;

  //Constructeur avec la BD
  public function __construct($db)
  {
    $this->connection = $db;
  }

  // Méthode pour récupérer tous les catégories
  public function read()
  {
    // Requête pour récupérer
    $query = 'SELECT
        id,
        name,
        created_at
      FROM
        ' . $this->table . '
      ORDER BY
        created_at DESC';

    // Préparation statement
    $stmt = $this->connection->prepare($query);

    // Execution de la requête
    $stmt->execute();

    return $stmt;
  }

  // Méthode pour récupérer 1 seul catégorie
  public function read_single()
  {
    // Requête pour récupérer 1 catégorie par ID
    $query = 'SELECT
          id,
          name
        FROM
          ' . $this->table . '
      WHERE id = ?
      LIMIT 0,1';

    //Préparation statement
    $stmt = $this->connection->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->id);

    // Executer la requête
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Appliquer les propriétés
    $this->id = $row['id'];
    $this->name = $row['name'];
  }

  // Méthode pour crée une catégorie
  public function create()
  {
    // Requête pour crée une catégorie
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
      name = :name';

    // Préparation statement
    $stmt = $this->connection->prepare($query);

    // Sécurité
    $this->name = htmlspecialchars(strip_tags($this->name));

    // Bind donnée
    $stmt->bindParam(':name', $this->name);

    // Requête exécuté
    if ($stmt->execute()) {
      return true;
    }

    // En cas d'erreur
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // Méthode pour mettre à jour une catégorie
  public function update()
  {
    // Requête pour mettre à jour
    $query = 'UPDATE ' .
      $this->table . '
    SET
      name = :name
      WHERE
      id = :id';

    // Préparation statement
    $stmt = $this->connection->prepare($query);

    // Sécurité
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind donnée
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':id', $this->id);

    // Requête exécuté
    if ($stmt->execute()) {
      return true;
    }

    // En cas d'erreur
    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  // Méthode pour supprimer une catégorie
  public function delete()
  {
    // Requête pour supprimer
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    // Préparation statement
    $stmt = $this->connection->prepare($query);

    // Sécurité
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind donnée
    $stmt->bindParam(':id', $this->id);

    // Exécuté la requête
    if ($stmt->execute()) {
      return true;
    }

    // En cas d'erreur
    printf("Error: %s.\n", $stmt->error);

    return false;
  }
}
