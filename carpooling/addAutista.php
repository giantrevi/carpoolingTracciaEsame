<?php
session_start();
include('connection.php');


if (isset($_POST["visited"]) && $_POST["visited"] == "yes") {

    $sql = "INSERT INTO carpooling.autista (IdAutista,Cognome,Nome,CartaId,Telefono,Mail,Password,NumeroPatente,ScadenzaPatente,FotoProfilo) VALUES (?, ?, ?, ?, ?, ?,?,?,?,? )";
    $stmt = $db->prepare($sql);
    $stmt->execute([NULL, $_POST["cognome"], $_POST["nome"], $_POST["nCarta"], $_POST["telefono"], $_POST["mail"], $_POST["password"], $_POST["nPatente"], $_POST["scadenzaP"], $_POST["fotoP"]]);

    
    $sql = "SELECT * FROM autista WHERE Mail = '" . $_POST['mail'] . "' AND Password = '" . $_POST['password'] . "'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $total = $stmt->rowCount();
    if ($total == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION["id"] = $row["IdAutista"];
    }

    $_SESSION["nome"]=$_POST["nome"];

    $i = 1;
    while (isset($_POST["targa" . $i])) {

        $sql = "INSERT INTO carpooling.auto (TargaAuto,Modello,Marca,FotoAuto) VALUES (?, ?, ?, ? )";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_POST["targa" . $i], $_POST["modello" . $i], $_POST["marca" . $i], $_POST["fotoA" . $i]]);

        $sql = "INSERT INTO carpooling.tblautoautista (IdAutoAutista,IdAutista,TargaAuto) VALUES (?, ?, ? )";
        $stmt = $db->prepare($sql);
        $stmt->execute([NULL, $_SESSION["idAutista"], $_POST["targa" . $i]]);

        $i += 1;
    }

    header("Location: profiloAutista.php");
}

?>
<html>

<head>
    <h1>Registrazione nuovo autista:</h1>
    <script>
        function addAuto() {

            var nAuto = document.getElementById("content").childElementCount + 1;
            const div = document.createElement('div');

            var targa = "targa" + nAuto;
            var modello = "modello" + nAuto;
            var marca = "marca" + nAuto;
            var fotoA = "fotoA" + nAuto;

            div.innerHTML = `
    			<br>Auto` + nAuto + `:<br>
    	  		Targa:<input type="text" name="` + targa + `" required ><br><br>
                Modello:<input type="text" name="` + modello + `" required ><br><br>
                Marca:<input type="text" name="` + marca + `" required ><br><br>
                Foto auto:<input type="file" name="` + fotoA + `"><br><br>
            `;

            document.getElementById('content').appendChild(div);
        }
    </script>
</head>

<body>
    <form action="" method="POST">
        <h2>Generalità:</h2><br>
        Nome:<input type="text" name="nome" required><br><br>
        Cognome:<input type="text" name="cognome" required><br><br>
        Mail:<input type="text" name="mail" required><br><br>
        Password:<input type="password" name="password" required><br><br>
        Numero carta identità:<input type="text" name="nCarta" required><br><br>
        Telefono:<input type="text" name="telefono" required><br><br>
        Numero patente:<input type="text" name="nPatente" required><br><br>
        Scedenza patente:<input type="date" name="scadenzaP" required><br><br>
        Foto profilo:<input type="file" name="fotoP"><br><br>

        <p>
            <h2>
                Auto
            </h2>
            <button type="button" onclick="addAuto()">+</button>
        </p>
        <div id="content">
        </div>

        <br><button type="submit">Add</button>

        <input type="hidden" name="visited" value="yes">
    </form>
</body>

</html>