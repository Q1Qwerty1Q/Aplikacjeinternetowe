<?php
$connection = mysqli_connect('localhost','root','','kupauto');
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komis aut</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <header>
        <h1><strong><i>KupAuto!</i></strong> Internetowy komis samochodowy</h1>
    </header>

    <main id="blok1">
    <?php 
        $query = "SELECT zdjecie, model, rocznik, przebieg, paliwo, cena FROM samochody WHERE zdjecie='ToyotaYaris.jpg'";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);

        echo "<img src='" . $row['zdjecie'] . "' alt='oferta dnia'>";
        echo "<h4>Oferta Dnia: Toyota " . $row['model'] . "</h4>";   
        echo "<p>Rocznik: " . $row['rocznik'] . ", przebieg: " . $row['przebieg'] . ", rodzaj paliwa: " . $row['paliwo'] . "</p>";
        echo "<h4>Cena: " . $row['cena'] . "</h4>";
    ?>
    </main>

    <main>
    <h2>Oferty Wyróżnione</h2>
    <?php 
        $query = "SELECT zdjecie, nazwa, model, rocznik, cena FROM samochody JOIN marki ON samochody.marki_id=marki.id LIMIT 4";
        $result = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='oferta'>";
            echo "<img src='" . $row['zdjecie'] . "' alt='" . $row['model'] . "'>";
            echo "<h4>" . $row['nazwa'] . " " . $row['model'] . "</h4>";
            echo "<p>Rocznik: " . $row['rocznik'] . "</p>";
            echo "<h4>Cena: " . $row['cena'] . " </h4>";
            echo "</div>";
        }
    ?>
    </main>

    <main>
        <h2>Wybierz markę</h2>
        <?php 
            $query = "SELECT DISTINCT nazwa FROM marki";
            $result = mysqli_query($connection, $query);

            echo "<form method='POST'>";
            echo "<select name='marka'>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['nazwa'] . "'>" . $row['nazwa'] . "</option>";
            }

            echo "</select>";
            echo "<input type='submit' value='Wyszukaj'>";
            echo "</form>";
        ?>    

        <?php 
        if (isset($_POST['marka'])) {

            $wybranaMarka = mysqli_real_escape_string($connection, $_POST['marka']);

            $query = "SELECT zdjecie, nazwa, model, cena FROM samochody JOIN marki ON samochody.marki_id=marki.id WHERE nazwa = '$wybranaMarka'";

            $result = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='oferta'>";
                echo "<img src='" . $row['zdjecie'] . "' alt='" . $row['model'] . "'>";
                echo "<h4>" . $row['nazwa'] . " " . $row['model'] . "</h4>";
                echo "<h4>Cena: " . $row['cena'] . " </h4>";
                echo "</div>";
            }
        }

        mysqli_close($connection);
        ?>
    </main>
    
    <footer>
        <p>Stronę wykonała: </p>
        <p><a href="https://firmy.pl/komis">Znajdź nas także</a></p>
    </footer>
</body>
</html>