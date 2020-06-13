<?php
session_start();
include('connection.php');

$errMsg = false;
if (isset($_POST["visited"]) && $_POST["visited"] == "yes") {
    $sql = "SELECT * FROM passeggero WHERE Mail = '" . $_POST['email'] . "' AND Password = '" . $_POST['password'] . "'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $total = $stmt->rowCount();
    if ($total == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION["nome"] = $row["Nome"];
        $_SESSION["id"] = $row["IdPasseggero"];
        header("Location: profiloPasseggero.php");
    } else {
        $errMsg = true;
    }
}
?>
<html>

<head>
    <h1>Login autista</h1>
</head>

<body>
    <form action="" method="POST">
        <div class="form-label-group">
            <input name="email" type="text" id="inputEmail" class="form-control" placeholder="Nome utente" required><br><br>
            <input name="password" type="text" id="inputPassword" class="form-control" placeholder="Password" required>
            <input type="hidden" name="visited" value="yes">
        </div>
        <?php
        if (isset($_POST["visited"]) && $_POST["visited"] == "yes" && $errMsg) {
            echo "<script> alert('Hai sbagliato la password'); </script>";
        }
        ?>
        <br><br><button type="submit">Login</button>
    </form>
</body>

</html>