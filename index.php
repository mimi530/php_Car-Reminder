<?php
    #code ^^
    
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta author="Michał Domżalski">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
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
    </style>
    <!--"Talk is cheap, show me the code."-->
</head>
<body>
    <h1>Car-Reminder!</h1>
    <h4>Strona stworzona w celu przećwiczenia umiejętności PHP. Żeby nie była bezużyteczna to symuluje 
        "przypominacz samochodowy" aby pamiętać kiedy przeprowadzaliśmy okresowe naprawy :)</h4></br>
    <h2>Rejestracja</h2>
    <form action="rejestracja.php" method="post">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Login</label>
                    <input class="form-control" type="text" name="username">
                    <small class="form-text text-muted">3-20 znaków.</small>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>E-mail</label>
                    <input class="form-control" type="text" name="email">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Hasło</label>
                    <input class="form-control" name="haslo" type="password">
                    <small class="form-text text-muted">Min. 8 znaków</small>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Powtórz hasło</label>
                    <input class="form-control" name="haslo2" type="password" >
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Zarejestruj!</button>
        </div>
    </form>
    </br>
    <h2>Logowanie</h2>
    <form action="logowanie.php" method="post">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Login</label>
                    <input class="form-control" name="login" type="text">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Hasło</label>
                    <input class="form-control" type="password" name="haslo">
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Zaloguj</button>
        </div>
    </form> 
</body>
</html>