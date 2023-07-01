<?php
require("includes/conn.inc.php");
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Filter</title>
</head>

<body>
    <form action="filter.php" method="post">
        <label>Filter nach E-Mail: </label>
        <input type="email" name="Email">
        <button>suchen</button>

        <?php
        if (count($_POST) > 0) {
            $Email = $_POST["Email"];
            $sql = "
            SELECT 
                tbl_eintraege.Eintrag, tbl_eintraege.Eintragezeitpunkt, tbl_user.Emailadresse
                FROM 
                    tbl_eintraege
                INNER JOIN 
                    tbl_user
                ON 
                    tbl_eintraege.FIDUser = tbl_user.IDUser
                WHERE 
                    tbl_user.Emailadresse = '$Email';
            
            ";
            $result = $conn->query($sql);
            if ($result != false) {
                while ($row = $result->fetch_assoc()) {
                    $zeit = new DateTime($row["Eintragezeitpunkt"]);
                    $eintrag = $row["Eintrag"];
                    $date = $zeit->format('m/d/Y');
                    $time = $zeit->format('H:i:s');
                    echo "<ul><li>$date um $time Uhr: <br>$eintrag</li></ul>";
                }
            }
        } else {
            echo "<br>Give in something to search!";
        }
        ?>
    </form>
</body>

</html>