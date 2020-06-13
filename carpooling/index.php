<?php
    session_start();

    if(isset($_POST["utente"])){
        if($_POST["utente"]=="passeggero") header('location: loginPasseggero.php');
        else header('location: loginAutista.php');
    }
?>
<html>
    <head>
        <h1>Che utente sei?</h1>
    </head>
    <body>
        <form action="" method="POST">
            Scegli il tipo di utente:
            <select name="utente">
                <option value="utista">autista</option>
                <option value="passeggero">passeggero</option>
            </select>
            <br><button type="submit">Next</button>
        </form>
    </body>
</html>