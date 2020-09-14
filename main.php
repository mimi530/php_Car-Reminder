<?php
    session_start();
    require_once("php/functions.php");
    if(!$_SESSION['zalogowany']) {
        header("Location: index.php");
    }
    $repairs = wypiszNaprawy($_SESSION['id']);
    if(isset($_POST['naprawa'])) {
        $tytul = $_POST['naprawa'];
        $data = $_POST['data_naprawy'];
        $przebieg = $_POST['przebieg'];
        if(!$tytul) $tytul = 'Bez tytułu';
        if(!$data) $data = date('Y-m-d');
        if(!$przebieg) $przebieg = 0;
        if($_POST['id']) edytujNaprawe($_POST['id'],$tytul, $data, $przebieg);
        else zapiszNaprawe($tytul, $data, $przebieg, $_SESSION['id']);
        header("Location: main.php");
    }
    if(isset($_GET['id_usun']))
    {
        usunNaprawe($_GET['id_usun']);
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
        $obecnaNaprawa = pobierzNaprawe($_GET['id']);
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Michał Domżalski, Paweł Graboś">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Car Service History</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link href="fontello/css/fontello.css" rel="stylesheet" type="text/css">
    <!--"Talk is cheap, show me the code."-->
</head>
<body class="bg-main">
    <div class="container-fluid blackFog pb-5">
        <header>
            <div class="row text-center">
                <div class="col py-3 d-flex">
                    <a class="btn btn-warning ml-auto" href="php/logout.php">Wyloguj się</a>
                </div>
                <div class="col-12">
                    <h1 class="ml-auto">Historia napraw samochodu</h1>
                </div>
            </div>
        </header>
        <article>
            </section>
                <div class="row mt-5">
                    <div class="col text-center">
                        <form class="" method="POST">
                            <div class="row justify-content-center">
                                <div class="col-12 col-sm-10 col-md-8 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label>Jaka naprawa</label>
                                        <input type="hidden" name="id" value="<?= $obecnaNaprawa['id'] ?>">
                                        <input type="text" class="form-control" name="naprawa" 
                                            placeholder="np. Wymiana oleju" value="<?= $obecnaNaprawa['tytul'] ?>">
                                        <small class="form-text">Domyślnie "Bez tytułu"</small>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-10 col-md-8 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label>Data naprawy</label>
                                        <input type="date" class="form-control" name="data_naprawy" value="<?= $obecnaNaprawa['data'] ?>">
                                        <small class="form-text">Domyślnie data bieżąca</small>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-10 col-md-8 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label>Przegieg w km</label>
                                        <input type="number" class="form-control" name="przebieg" value="<?= $obecnaNaprawa['przebieg'] ?>">
                                        <small class="form-text">Domyślnie 0</small>
                                    </div>
                                </div>
                                <div class="col-12 py-4">
                                    <button class="btn btn-primary">
                                        <?php if($obecnaNaprawa['id']): ?>
                                            Zmień
                                        <?php else: ?>
                                            Dodaj naprawę
                                        <?php endif; ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <section>
                <div class="row bg-dark">
                    <div class="col table-responsive mx-auto p-0 py-5 text-center">
                        <table class="table table-dark m-0">
                            <thead>
                                <tr><th colspan="5"> Łącznie napraw: <?= $repairs->num_rows ?></th></tr>
                                <tr>
                                    <th class="tCol1" scope="col">Naprawa</th>
                                    <th class="tCol2" scope="col">Przebieg</th>
                                    <th class="tCol3" scope="col">Data</th>
                                    <th class="buttonsCol" scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($repairs as $naprawa): ?>
                                    <tr>
                                        <td class="px-0"><?= $naprawa['tytul'] ?></td>
                                        <td class="px-0"><?= $naprawa['przebieg'] ?></td>
                                        <td class="px-0"><?= $naprawa['data'] ?></td>
                                        <td class="px-0">
                                            <a href="?id=<?= $naprawa['id'] ?>"><i class="icon-edit"></i></a>
                                            <form onSubmit="return confirm('Czy na pewno chcesz usunąć?')" method="GET">
                                                <button class="removeButton" name="id_usun" value="<?= $naprawa['id'] ?>"><i class="icon-trash-empty"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </article>
    </div>
</body>
<!--<body>
    <main>
    </main>
</body>-->
</html>
