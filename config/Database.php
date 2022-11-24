<?php

class Database
{

    //Paramètre de la base
    private $host = 'localhost';
    private $db_name = 'api';
    private $username = 'root';
    private $password =  '';
    private $connection;

    //Méthode pour la connexion à la base
    public function connect()
    {
        $this->connection = null;

        try {
            //Connexion à la base de donnée via PDO 
            $this->connection = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erreur de connexion: ' . $e->getMessage(); //Message d'erreur si la connexion n'est pas établie
        }

        return $this->connection;
    }
}
