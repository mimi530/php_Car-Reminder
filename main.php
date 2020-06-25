<?php
    session_start();
    if(!$_SESSION['zalogowany']) {
        header("Location: index.php");
    }
    $polaczenie = require_once 'Connection.php';
    $naprawy = $polaczenie->wypiszNaprawy($_SESSION['id']);
    if(isset($_POST['naprawa'])) {
        $tytul = dane_post('naprawa');
        $data = dane_post('data_naprawy');
        $przebieg = dane_post('przebieg');
        if(!$tytul) $tytul = 'Bez tytułu';
        if(!$data) $data = date('Y-m-d');
        if(!$przebieg) $przebieg = 0;
        if($_POST['id']) $polaczenie->edytujNaprawe($_POST['id'],$tytul, $data, $przebieg);
        else $polaczenie->zapiszNaprawe($tytul, $data, $przebieg, $_SESSION['id']);
        header("Location: main.php");
    }
    if(isset($_GET['id_usun']))
    {
        $polaczenie->usunNaprawe($_GET['id_usun']);
        header("Location: main.php");
        exit();
    }
    $obecnaNaprawa = [
        'id' => '',
        'tytul' => '',
        'przebieg' => '',
        'data' => ''
    ];
    if(isset($_GET['id'])){
        $obecnaNaprawa = $polaczenie->pobierzNaprawe($_GET['id']);
    }
    function dane_post($pole) {
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
    <link href="style.css" rel="stylesheet">
    <title>Car Reminder</title>
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
                            <input type="hidden" name="id" value="<?= $obecnaNaprawa['id'] ?>">
                            <input type="text" class="form-control" name="naprawa" 
                                placeholder="np. Wymiana oleju" value="<?= $obecnaNaprawa['tytul'] ?>">
                            <small class="form-text text-muted">Domyślnie "Bez tytułu"</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Data naprawy</label>
                            <input type="date" class="form-control" name="data_naprawy" value="<?= $obecnaNaprawa['data'] ?>">
                            <small class="form-text text-muted">Domyślnie data bieżąca</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Przegieg w km</label>
                            <input type="number" class="form-control" name="przebieg" value="<?= $obecnaNaprawa['przebieg'] ?>">
                            <small class="form-text text-muted">Domyślnie 0</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <button class="btn btn-primary">
                                <?php if($obecnaNaprawa['id']): ?>
                                    Zmień
                                <?php else: ?>
                                    Dodaj naprawę
                                <?php endif; ?>
                            </button>
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
                        foreach($naprawy as $naprawa): ?>
                            <tr>
                                <td><?= $naprawa['tytul'] ?></td>
                                <td><?= $naprawa['przebieg'] ?></td>
                                <td><?= $naprawa['data'] ?></td>
                                <td><a class= "btn btn-info" href="?id=<?= $naprawa['id'] ?>">Edytuj</a></td>
                                <td>
                                    <form onSubmit="return confirm('Czy na pewno chcesz usunąć?')" method="GET">
                                        <button class= "btn btn-danger" name="id_usun" value="<?= $naprawa['id'] ?>">Usuń</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>