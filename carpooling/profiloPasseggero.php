<?php
session_start();

if(!isset($_SESSION["id"])) header("Location: index.html");
?>

<html>

<head>
    <h1>Profilo autista di <?= $_SESSION["nome"] ?>:</h1>
</head>

<body>
    <div>
        <?php
        include("connection.php");
        $sql = "SELECT * from passeggero WHERE IdPasseggero='" . $_SESSION["id"] . "'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "Cognome:" . $row["Cognome"] . "<br>";
        echo "Numero carta d'identità:" . $row["CartaId"] . "<br>";
        echo "Numero di telefono:" . $row["Telefono"] . "<br>";
        echo "Mail:" . $row["Mail"] . "<br>";
        ?>
    </div>
    <form action="cercaViaggio.php" method="POST">

        <button type="submit">Cerca viaggio</button>
    </form>


    <form action="logout.php" method="POST">

        <br><br><button type="submit">Logout</button>
    </form>
</body>

</html>