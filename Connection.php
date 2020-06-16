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
        public function wypiszNaprawy($id_user)
        {
            $zapytanie = $this->pdo->prepare("SELECT * FROM repairs WHERE id_user=$id_user ORDER BY data DESC");
            $zapytanie->execute();
            return $zapytanie;
        }
        public function zapiszNaprawe($tytul, $data, $przebieg, $id_user)
        {
            $zapytanie = $this->pdo->prepare('INSERT INTO repairs VALUES (NULL, :tytul, :data, :przebieg, :id_user)');
            $zapytanie->bindValue(':tytul', $tytul, PDO::PARAM_STR);
            $zapytanie->bindValue(':data', $data);
            $zapytanie->bindValue(':przebieg', $przebieg, PDO::PARAM_INT);
            $zapytanie->bindValue(':id_user', $id_user, PDO::PARAM_INT);
            $zapytanie->execute();
        }
        public function pobierzNaprawe($id)
        {
            $zapytanie = $this->pdo->prepare('SELECT * FROM repairs WHERE id=:id');
            $zapytanie->bindValue(':id', $id, PDO::PARAM_INT);
            $zapytanie->execute();
            return $zapytanie->fetch(PDO::FETCH_ASSOC);
        }
        public function edytujNaprawe($id,$tytul,$data,$przebieg)
        {
            $zapytanie = $this->pdo->prepare('UPDATE repairs SET tytul=:tytul, data=:data, przebieg=:przebieg WHERE id=:id');
            $zapytanie->bindValue(':tytul', $tytul, PDO::PARAM_STR);
            $zapytanie->bindValue(':data', $data);
            $zapytanie->bindValue(':przebieg', $przebieg, PDO::PARAM_INT);
            $zapytanie->bindValue(':id', $id, PDO::PARAM_INT);
            $zapytanie->execute();
        }
        public function usunNaprawe($id)
        {
            $zapytanie = $this->pdo->prepare('DELETE FROM repairs WHERE id=:id');
            $zapytanie->bindValue(':id', $id, PDO::PARAM_INT);
            $zapytanie->execute();
        }
    }
    return new Connection();
?>