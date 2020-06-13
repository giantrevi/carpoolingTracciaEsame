<?php
    include("connection.php");
    session_start();

    if(!isset($_SESSION["id"])) header("Location: index.html");

    if(isset($_POST["visited"]) && $_POST["visited"]=="yes"){

        $sql = "INSERT INTO carpooling.viaggio (IdViaggio,CittàP,CittàA,Data,Ora,TempoStimato,Prezzo,CapienzaMax,Stato,TargaAuto,IdAutista) VALUES (?, ?, ?, ?, ?, ?,?,?,?,?,? )";
        $stmt = $db->prepare($sql);
        $stmt->execute([NULL, $_POST["cittàP"], $_POST["cittàA"], $_POST["data"], $_POST["oraP"], $_POST["tempo"], $_POST["prezzo"], $_POST["capienza"],"Aperto", $_POST["auto"], $_SESSION["id"]]);

        header("Location: profiloAutista.php");
    }
?>
<html>

<head>
    <h1>Creazione di un viaggio:</h1>
</head>

<body>
    <form action="" method="POST">
        Città di partenza:<input name="cittàP" type="text" class="form-control" placeholder="Città di partenza" required><br><br>
        Città di arrivo:<input name="cittàA" type="text" class="form-control" placeholder="Città di arrivo" required><br><br>
        Data:<input name="data" type="date" class="form-control" required><br><br>
        Ora della partenza:<input name="oraP" type="time" class="form-control" required><br><br>
        Tempo stimato:<input name="tempo" type="time" class="form-control" required><br><br>
        Contributo di ogni passeggero:<input name="prezzo" type="number" class="form-control" required><br><br>
        Capienza della vettura:<input name="capienza" type="number" class="form-control" required><br><br>
        Auto:<select name="auto">
            <?php
                include("connection.php");
                $sql = "SELECT * FROM auto JOIN (SELECT TargaAuto FROM tblautoautista WHERE IdAutista='" . $_SESSION["id"] . "')as tbl1 ON auto.TargaAuto= tbl1.TargaAuto";
                $stmt = $db->prepare($sql);
                $stmt->execute();

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    echo '<option value="'.$row["TargaAuto"].'">'.$row["Modello"].'</option>';
                }
            ?>
        </select>
        <br><br><button type="submit">Crea</button>
        <input type="hidden" name="visited" value="yes">
    </form>
</body>

</html>