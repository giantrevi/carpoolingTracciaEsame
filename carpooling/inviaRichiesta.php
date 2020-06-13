<?php
session_start();
include("connection.php");

if(!isset($_SESSION["id"])) header("Location: index.html");

if(isset($_POST["prenotazione"]) && isset($_POST["idAutista"])){
    $_SESSION["idViaggio"]=$_POST["prenotazione"];
    $_SESSION["idAutista"]=$_POST["idAutista"];
}


if(isset($_SESSION["idViaggio"]) && isset($_POST["nPersone"])){
    
    $sql = "INSERT INTO carpooling.prenotazione (IdPrenotazione,NumPersone,IdPasseggero,IdViaggio,Stato) VALUES (?, ?, ?, ?, ? )";
    $stmt = $db->prepare($sql);
    $stmt->execute([NULL, $_POST["nPersone"], $_SESSION["id"], $_SESSION["idViaggio"], "non accettata"]);

    $sql2="SELECT * FROM autista WHERE IdAutista='".$_SESSION["idAutista"]."'";
    $stmt2=$db->prepare($sql2);
    $stmt2->execute();
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

    $sql3="SELECT * FROM passeggero WHERE IdPasseggero='".$_SESSION["id"]."'";
    $stmt3=$db->prepare($sql3);
    $stmt3->execute();
    $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);

    $messaggio="
    <html>
        <head>
            <h1>Profilo del passeggero:</h1>
        </head>
        <body>
            Nome:".$row3["Nome"]."
            Cognome:".$row3["Cognome"]."
            Telefono:".$row3["Telefono"]."
            Mail:".$row3["Mail"]."
            http://carpooling/feedback?idPasseggero=".$_SESSION["id"]."
        </body>
    </html>";
    $destinatario=$row2["Mail"];
    $oggetto="Richiesta di partecipazione al viaggio da parte di:".$row3["Nome"].$row3["Cognome"];

    mail($destinatario, $oggetto, $messaggio);
    
}

//nella mail invi le informazioni del passeffero e nella mail inserisco il link per andare a vedere i feedback che il passeggero ha ricevuto,passando in get l'id del passeggero.
?>
<html>
    <head>
        <h1>Richiedi conferma prenotazione:</h1>
    </head>

    <body>
        <form action="" method="POST">
            Numero di persone:<input type="number" name="nPersone"><br><br>
            <button type="submit">invia richiesta</button>
        </form>
    </body>
</html>

