<?php
if(isset($_POST['login'])) {
    session_start();
    $login = $_POST['login'];
    $email = $_POST['email'];
    $haslo = $_POST['haslo'];
    $haslo2 = $_POST['haslo2'];
    #walidacja danych
    $walidacja = true;
    define('WYMAGANE','To pole jest wymagane!');
    #sprawdzanie loginu
    if(!$login) {
        $walidacja = false;
        $_SESSION['e_login'] = WYMAGANE;
    } elseif (strlen($login)<3 || strlen($login)>20) {
        $walidacja = false;
        $_SESSION['e_login'] = 'Login musi posiadać od 3-20 znaków!';
    } elseif (!ctype_alnum($login)) {
        $walidacja = false;
        $_SESSION['e_login'] = 'Login może składać się tylko z liter i cyfr (bez polskich znaków)!';
    }
    #sprawdzanie maila
    $email2 = filter_var($email, FILTER_SANITIZE_EMAIL);
    if(!$email) {
        $walidacja = false;
        $_SESSION['e_email'] = WYMAGANE;
    } elseif (!filter_var($email2, FILTER_VALIDATE_EMAIL) || $email!=$email2) {
        $walidacja = false;
        $_SESSION['e_email'] = 'E-mail musi być poprawny!';
    }
    #sprawdzanie hasła
    if(!$haslo) {
        $walidacja = false;
        $_SESSION['e_haslo'] = WYMAGANE;
    } elseif(strlen($haslo)<8) {
        $walidacja = false;
        $_SESSION['e_haslo'] = "Hasło za krótkie!";
    }
    if(!$haslo2) {
        $walidacja = false;
        $_SESSION['e_haslo2'] = WYMAGANE;
    }
    if($haslo !== $haslo2) {
        $walidacja = false;
        $_SESSION['e_haslo2'] = 'Hasła muszą się zgadzać!';
    }
	$_SESSION['fr_login'] = $login;
    $_SESSION['fr_email'] = $email;
    $_SESSION['fr_haslo'] = $haslo;
    $_SESSION['fr_haslo2'] = $haslo2;
    #walidacja udana
    if($walidacja) {
        require_once("baza.php");
        mysqli_report(MYSQLI_REPORT_STRICT);
        try {
            $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
            if($conn->connect_errno==0) {
                #czy email istnieje juz w bazie
                $sql = "SELECT id FROM users WHERE email=?";
                $stmt = $conn->prepare($sql);
                if(!$stmt) throw new Exception($conn->error);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $wynik = $stmt->get_result();
                if($wynik->num_rows) {
                    $walidacja = false;
                    $_SESSION['e_email'] = 'Taki email istnieje już w bazie danych!';
                }
                #czy login istnieje juz w bazie
                $sql = "SELECT id FROM users WHERE login=?";
                $stmt = $conn->prepare($sql);
                if(!$stmt) throw new Exception($conn->error);
                $stmt->bind_param("s", $login);
                $stmt->execute();
                $wynik = $stmt->get_result();
                if($wynik->num_rows) {
                    $walidacja = false;
                    $_SESSION['e_login'] = 'Taki login istnieje już w bazie danych!';
                }
                #rejestracja nowego uzytkownika
                if($walidacja) {
                    $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO users VALUES (NULL, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    if(!$stmt) throw new Exception($conn->error);
                    $stmt->bind_param("sss", $login, $haslo_hash, $email);
                    if($stmt->execute()) {
                        $_SESSION['udana'] = ' udana!';
                        unset($_SESSION['fr_login']);
                        unset($_SESSION['fr_email']);
                        unset($_SESSION['fr_haslo']);
                        unset($_SESSION['fr_haslo2']);
                        header('Location: ../index.php');
                    }
                    else throw new Exception($conn->error);
                } else {
                    header("Location: ../index.php");
                }
                $conn->close();
            } else {
                throw new Exception($conn->error);
            }
        } catch(Exception $error) {
            echo 'Błąd serwera :/ Przepraszamy za niedogoności.';
        }
    } else {
        header("Location: ../index.php");
    }
} else header("Location: ../index.php");