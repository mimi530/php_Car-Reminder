<?php
if(isset($_POST['llogin'])) {
    session_start();
    require_once("baza.php");
    mysqli_report(MYSQLI_REPORT_STRICT);
    try {
        $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if($conn->connect_errno==0) {
            $login = $_POST['llogin'];
            $_SESSION['llogin'] = $login;
            $haslo = $_POST['lhaslo'];
            #sprawdzanie loginu w bazie
            $sql = "SELECT * FROM users WHERE login=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $login);
            $stmt->execute();
            if($wynik = $stmt->get_result())
            {
                if($wynik->num_rows) {
                    $wiersz = $wynik->fetch_assoc();
                    #sprawdzanie hasla w bazie
                    if(password_verify($haslo, $wiersz['haslo'])) {
                        $_SESSION['zalogowany'] = true;
                        $_SESSION['id'] = $wiersz['id'];
                        $_SESSION['login'] = $wiersz['login'];
                        $_SESSION['email'] = $wiersz['email'];
                        unset($_SESSION['llogin']);
                        header("Location: ../main.php");
                    }
                    else {
                        $_SESSION['blad_log'] = "Nieprawidłowy login lub hasło!";
                        header("Location: ../index.php");
                    }
                }
                else {
                    $_SESSION['blad_log'] = "Nieprawidłowy login lub hasło!";
                    header("Location: ../index.php");
                }
            } else {
                throw new Exception($conn->error);
            }
            $conn->close();
        }
        else {
            throw new Exception($conn->error);
        }
    }
    catch(Exception $error) {
        echo 'Błąd serwera :/ Przepraszamy za niedogoności.';
    }
}
else header("Location: ../index.php");