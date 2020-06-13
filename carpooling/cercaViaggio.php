<?php
session_start();
include("connection.php");

if(!isset($_SESSION["id"])) header("Location: index.html");

if (isset($_POST["visited"]) && $_POST["visited"] == "yes") {
    $viaggi = "";
    $i = 1;
    $sql = "SELECT * FROM viaggio WHERE CittàP='" . $_POST["cittàP"] . "' AND CittàA='" . $_POST["cittàA"] . "' AND Stato='aperto'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $sql2="SELECT * FROM feedback WHERE IdAutista='".$row["IdAutista"]."' AND Type='PA'";
        $stmt2=$db->prepare($sql2);
        $stmt2->execute();
        $viaggi .= 'Viaggio' . $i . ':<br>
                        Data:' . $row["Data"] . '<br>
                        Ora:' . $row["Ora"] . '<br>
                        Tempo stimato:' . $row["TempoStimato"] . '<br>
                        Prezzo:' . $row["Prezzo"] . '<br>
                        Capienaza:' . $row["CapienzaMax"] .'<br>
                        Voti:';
        while($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
            $viaggi.=$row2["Voto"].' / ';
        }
        $viaggi.='<br><button type="submit" value="' . $row["IdViaggio"] . '" name="prenotazione">Prenota</button>';
        $viaggi.='<input type="hidden" name="idAutista" value="'.$row["IdAutista"].'">';
        $i+=1;
    }
}
?>

<html>

<head>
    <h1>Cerca viaggio:</h1>
</head>

<body>
    <form action="" method="POST">
        Città di partenza:<input type="text" name="cittàP" required><br><br>
        Città di arrivo:<input type="text" name="cittàA" required>
        <input type="hidden" name="visited" value="yes">

        <button type="submit" name="">Cerca</button>
    </form>

    <form action="inviaRichiesta.php" method="POST">
        <h2>Viaggi disponibili:</h2>
        <?php if (isset($viaggi)) echo $viaggi; ?>
    </form>

</body>

</html>