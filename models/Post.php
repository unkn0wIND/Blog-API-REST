<?php

class Post
{
    //Etablir la connexion à la db
    private $connection;
    private $table = 'posts';

    //Propriété de la table posts
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    //Constructeur avec la BD
    public function __construct($db)
    {
        $this->connection = $db;
    }

    // Méthode pour lire les articles
    public function read()
    {
        //Création de la requête pour récupérer les articles
        $query = 'SELECT 
            c.name as category_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.created_at
            FROM ' . $this->table . ' p
            LEFT JOIN
              categories c ON p.category_id = c.id
            ORDER By
              p.created_at DESC';

        //Préparation statement
        $stmt = $this->connection->prepare($query);

        //Execution de la requête
        $stmt->execute();

        return $stmt;
    }

    //Méthode pour lire un seul article via son ID
    public function read_single()
    {
        //Création de la requête pour récupérer 1 article
        $query = 'SELECT 
            c.name as category_name,
            p.id,
            p.category_id,
            p.title,
            p.body,
            p.author,
            p.created_at
            FROM ' . $this->table . ' p
            LEFT JOIN
              categories c ON p.category_id = c.id
            WHERE
            p.id = ?
            LIMIT 0,1';

        //Préparation statement
        $stmt = $this->connection->prepare($query);

        //BIND ID
        $stmt->bindParam(1, $this->id);

        //Execution de la requête
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Appliquer les propriétés
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }


    //Méthode pour crée un article dans la DB
    public function create()
    {
        //Création de la requête pour crée un article
        $query = 'INSERT INTO ' . $this->table . '
                SET
                    title = :title,
                    body = :body,
                    author = :author,
                    category_id = :category_id';

        //Préparation statement
        $stmt = $this->connection->prepare($query);

        //Sécurité
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //BindParam
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);

        //Execute la requête
        if ($stmt->execute()) {
            return true;
        }

        //Afficher une erreur si il y a un problème
        printf("Erreur: %s.\n", $stmt->error);
        return false;
    }


    //Méthode pour mettre à jour un article dans la DB
    public function update()
    {
        //Création de la requête pour crée un article
        $query = 'UPDATE ' . $this->table . '
                SET
                    title = :title,
                    body = :body,
                    author = :author,
                    category_id = :category_id
                    WHERE
                    id = :id';

        //Préparation statement
        $stmt = $this->connection->prepare($query);

        //Sécurité
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //BindParam
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        //Execute la requête
        if ($stmt->execute()) {
            return true;
        }

        //Afficher une erreur si il y a un problème
        printf("Erreur: %s.\n", $stmt->error);
        return false;
    }


    //Méthode pour supprimer un article
    public function delete()
    {

        //Requête pour supprimer un article
        $query = 'DELETE FROM ' . $this->table .  ' WHERE id = :id';

        //Préparation statement
        $stmt = $this->connection->prepare($query);

        //Sécurité
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind
        $stmt->bindParam(':id', $this->id);

        //Execute la requête
        if ($stmt->execute()) {
            return true;
        }

        //Afficher une erreur si il y a un problème
        printf("Erreur: %s.\n", $stmt->error);
        return false;
    }
}
