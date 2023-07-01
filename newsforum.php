<?php
require("includes/conn.inc.php");

show_post();

// everything inside function is scoped
function show_post($post_id = null)
{
    global $conn;

    if ($post_id == null) {
        $sql = "
        SELECT 
            tbl_user.Vorname, tbl_user.Nachname, 
            tbl_eintraege.Eintrag, tbl_eintraege.IDEintrag, 
            tbl_eintraege.FIDEintrag, tbl_eintraege.Eintragezeitpunkt
        FROM tbl_eintraege
        INNER JOIN tbl_user
        ON tbl_eintraege.FIDUser = tbl_user.IDUser
        WHERE tbl_eintraege.FIDEintrag IS null;";
    } else {
        $sql = "
        SELECT 
            tbl_user.Vorname, tbl_user.Nachname, 
            tbl_eintraege.Eintrag, tbl_eintraege.IDEintrag, 
            tbl_eintraege.FIDEintrag, tbl_eintraege.Eintragezeitpunkt
        FROM tbl_eintraege
        INNER JOIN tbl_user
        ON tbl_eintraege.FIDUser = tbl_user.IDUser
        WHERE tbl_eintraege.FIDEintrag =" . $post_id . ";";
    }
    $result = $conn->query($sql);
    if ($result != false) {
        while ($row = $result->fetch_assoc()) {
            $name = $row["Vorname"];
            $lastname = $row["Nachname"];
            $eintrag = $row["Eintrag"];
            $id = $row["IDEintrag"];
            $fid = $row["FIDEintrag"];
            $zeit = new DateTime($row["Eintragezeitpunkt"]);
            $date = $zeit->format('m/d/Y');
            $time = $zeit->format('H:i:s');
            echo "<ul>";
            echo "<li>$name $lastname wrote on $date at $time <br> $eintrag </li>";
            // recursion
            show_post($id);
            echo "</ul>";
            // echo "<ul><li>" . $name . " " . $lastname . " wrote on " . $date . " at " . $time . "</li></ul></ul>";
        }
    }
}
