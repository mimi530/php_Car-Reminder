<?php
    
    class Connection
    {
        public PDO $pdo;
        public function __construct()
        {
            try {
                require_once "baza.php";
                $this->pdo = new PDO("mysql:server={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOExcetion $error) {
                exit("Błąd bazy danych");
            }
        }
        public function wypisz($id_user)
        {
            $zapytanie = $this->pdo->prepare("SELECT * FROM repairs WHERE id_user=$id_user ORDER BY data ASC");
            $zapytanie->execute();
            return $zapytanie;
        }
        public function zapisz($tytul, $data, $przebieg, $id_user)
        {
            $zapytanie = $this->pdo->prepare('INSERT INTO repairs VALUES (NULL, :tytul, :data, :przebieg, :id_user)');
            $zapytanie->bindValue(':tytul', $tytul, PDO::PARAM_STR);
            $zapytanie->bindValue(':data', $data);
            $zapytanie->bindValue(':przebieg', $przebieg, PDO::PARAM_INT);
            $zapytanie->bindValue(':id_user', $id_user, PDO::PARAM_INT);
            $zapytanie->execute();
        }
    }
    return new Connection();
?>