<?php
require_once "baza.php";
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if($conn->connect_errno!=0) {
    exit("Błąd serwera :/ Przepraszamy za utrudnienia.");
}
function wypiszNaprawy($id_user) {
    $sql = "SELECT * FROM repairs WHERE id_user=? ORDER BY data DESC, id DESC";
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    return $stmt->get_result();
}
function zapiszNaprawe($tytul, $data, $przebieg, $id_user) { 
    $sql = "INSERT INTO repairs VALUES (NULL, ?, ?, ?, ?)";
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $tytul, $data, $przebieg, $id_user);
    $stmt->execute();
    return $stmt->get_result();
}
function pobierzNaprawe($id) {
    $sql = "SELECT * FROM repairs WHERE id=?";
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $wynik = $stmt->get_result();
    return $wynik->fetch_assoc();
}
function edytujNaprawe($id,$tytul,$data,$przebieg) {
    $sql = "UPDATE repairs SET tytul=?, data=?, przebieg=? WHERE id=?";
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $tytul, $data, $przebieg, $id);
    $stmt->execute();
}
function usunNaprawe($id) {
    $sql = "DELETE FROM repairs WHERE id=?";
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}