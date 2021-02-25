<?php
    session_start();
    if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']) header("Location: main.php");
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
    <!--"Talk is cheap, show me the code."-->
</head>
<body class="bg-index">
    <div class="container-fluid">
        <div class="mt-5 blackFog">
            <header>
                <div class="row no-gutters">
                    <div class="col d-flex align-items-center flex-column text-center">
                        <h1 class="mt-5">Car Service History</h1>
                        <p class="w-75">
                            Strona stworzona w dwuosobowym zespole w celu przećwiczenia umiejętności. Symuluje 
                            "książeczkę serwisową" aby pamiętać kiedy przeprowadzaliśmy naprawy :)
                        </p>
                    </div>
                </div>
            </header>
            <main>
                <article>
                    <section>
                        <header>
                            <div class="row mt-2 no-gutters">
                                <div class="col text-center">
                                    <h2>Logowanie</h2>
                                </div>
                            </div>
                        </header>
                        <form action="php/logowanie.php" method="post">
                            <div class="row no-gutters justify-content-center">
                                <div class="col-8 col-md-4 col-lg-3 mb-3 mx-2">
                                    <div class="form-group">
                                        <label>Login</label>
                                        <input class="form-control <?= isset($_SESSION['blad_log']) ? 'is-invalid' : ''?>" name="llogin" type="text" value="<?= $_SESSION['llogin'] ?? ''; unset($_SESSION['llogin'])?>">
                                        <div class="invalid-feedback">
                                            <?= $_SESSION['blad_log'] ?? ''; unset($_SESSION['blad_log'])?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8 col-md-4 col-lg-3 mb-3 mx-2">
                                    <div class="form-group">
                                        <label>Hasło</label>
                                        <input class="form-control <?= isset($_SESSION['blad_log']) ? 'is-invalid' : ''?>" type="password" name="lhaslo" <?= isset($_SESSION['llogin']) ? 'autofocus' : ''; ?>>
                                    </div>
                                </div>
                                <div class="col-12 mb-5">
                                    <div class="form-group text-center">
                                        <button class="btn btn-primary">Zaloguj</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                    <section>
                        <header>
                            <div class="row no-gutters">
                                <div class="col text-center">
                                    <h2>Rejestracja <?= $_SESSION['udana'] ?? ''; unset($_SESSION['udana']);?></h2>
                                </div>
                            </div>
                        </header>
                        <form action="php/signup.php" method="post">
                            <div class="row justify-content-center no-gutters">
                                <div class="col-8 col-md-4 col-lg-3 mx-2">
                                    <div class="form-group">
                                        <label>Login</label>
                                        <input class="form-control <?= isset($_SESSION['e_login']) ? 'is-invalid' : ''?>" type="text" name="login" value="<?= $_SESSION['fr_login'] ?? ''; unset($_SESSION['fr_login']) ?>">
                                        <small class="form-text text-muted">3-20 znaków.</small>
                                        <div class="invalid-feedback">
                                            <?= $_SESSION['e_login']; unset($_SESSION['e_login']) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8 col-md-4 col-lg-3 mx-2">
                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <input class="form-control <?= isset($_SESSION['e_email']) ? 'is-invalid' : ''?>" type="text" name="email" value="<?= $_SESSION['fr_email'] ?? ''; unset($_SESSION['fr_email']) ?>">
                                        <div class="invalid-feedback">
                                            <?= $_SESSION['e_email']; unset($_SESSION['e_email']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center no-gutters">
                                <div class="col-8 col-md-4 col-lg-3 mx-2">
                                    <div class="form-group">
                                        <label>Hasło</label>
                                        <input class="form-control <?= isset($_SESSION['e_haslo']) ? 'is-invalid' : ''?>" name="haslo" type="password" value="<?= $_SESSION['fr_haslo'] ?? ''; unset($_SESSION['fr_haslo']) ?>">
                                        <small class="form-text text-muted">Min. 8 znaków</small>
                                        <div class="invalid-feedback">
                                            <?= $_SESSION['e_haslo']; unset($_SESSION['e_haslo']) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8 col-md-4 col-lg-3 mx-2">
                                    <div class="form-group">
                                        <label>Powtórz hasło</label>
                                        <input class="form-control <?= isset($_SESSION['e_haslo2']) ? 'is-invalid' : ''?>" name="haslo2" type="password" value="<?= $_SESSION['fr_haslo2'] ?? ''; unset($_SESSION['fr_haslo2']) ?>">
                                        <div class="invalid-feedback">
                                            <?= $_SESSION['e_haslo2']; unset($_SESSION['e_haslo2']) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12"></div>
                                <div class="form-group text-center">
                                    <input type="submit" class="btn btn-primary" value="Zarejestruj!">
                                </div>
                            </div>
                        </form>
                    </section>
                </article>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>