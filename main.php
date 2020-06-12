<?php
    session_start();
    if(!$_SESSION['zalogowany'])
    {
        header("Location: index.php");
    }
    $polaczenie = require_once 'Connection.php';
    $naprawy = $polaczenie->wypisz($_SESSION['id']);
    if(isset($_POST['guzik']))
    {
        $tytul = dane_post('naprawa');
        $data = dane_post('data_naprawy');
        $przebieg = dane_post('przebieg');
        $polaczenie->zapisz($tytul, $data, $przebieg, $_SESSION['id']);
        header("Location: main.php");
    }
    function dane_post($pole)
    {
        return htmlspecialchars(stripslashes($_POST[$pole]));
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta author="Michał Domżalski">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" 
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Ćwiczenia PHP</title>
    <style>
        body
        {
            padding: 100px;
        }
        h1
        {
            font-size: 50px;
            text-align: center;
        }
        h4
        {
            margin-bottom: 50px;
            text-align: center;
        }
        article
        {
            margin-left: auto;
            margin-right: auto;
            width: 200px;
            text-align: center;
        }
        table
        {
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            margin-top: 20px;
        }
        td
        {
            border: 1px solid black;
            width: 200px;
        }
        th
        {
            border: 1px solid black;
        }
    </style>
    <!--"Talk is cheap, show me the code."-->
</head>
<body>
    <header>
        <h1>Historia napraw samochodu</h1>
    </header>
    <main>
        <article>
        <a href="logout.php">[ Wyloguj się ]</a></br></br>
            <form method="POST">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Jaka naprawa</label>
                            <input type="text" class="form-control" name="naprawa" placeholder="np. Wymiana oleju">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Data naprawy</label>
                            <input type="date" class="form-control" name="data_naprawy">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Przegieg w km</label>
                            <input type="number" class="form-control" name="przebieg">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="submit" name="guzik" class="btn btn-primary" value="Dodaj naprawę">
                        </div>
                    </div>
                </div>
            </form>
        </article>
        <section>
            <table>
                <thead>
                    <tr><th colspan="5"> Łącznie napraw: <?= $naprawy->rowCount() ?></th></tr>
                    <tr>
                        <th>Naprawa</th>
                        <th>Przebieg</th>
                        <th>Data</th>
                        <th>Modyfikacja</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $naprawy = $naprawy->fetchAll(PDO::FETCH_ASSOC);
                        foreach($naprawy as $naprawa){
                            echo "<tr><td>{$naprawa['tytul']}</td><td>{$naprawa['przebieg']}</td><td>{$naprawa['data']}</td><td>Edytuj</td><td>X</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>