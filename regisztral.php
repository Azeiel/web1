<?php
if(isset($_POST['felhasznalo']) && isset($_POST['jelszo']) && isset($_POST['vezeteknev']) && isset($_POST['keresztnev'])) {
    try {
        // Kapcsolódás
        $dbh = new PDO('mysql:host=mysql.omega:3306;dbname=azeiel', 'azeiel', 'vk4ug8',
                        array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
        
        // Létezik már a felhasználói név?
        $sqlSelect = "select id from regisztracio where bejelentkezes = :bejelentkezes";
        $sth = $dbh->prepare($sqlSelect);
        $sth->execute(array(':bejelentkezes' => $_POST['felhasznalo']));
        if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $uzenet = "A felhasználó név foglalt!";
            $ujra = "true";
        }
        else {
            // Ha nem létezik, akkor regisztráljuk
            $sqlInsert = "insert into regisztracio(id, vezetek_nev, kereszt_nev, bejelentkezes, jelszo)
                          values(0, :vezeteknev, :keresztnev, :bejelentkezes, :jelszo)";
            $stmt = $dbh->prepare($sqlInsert); 
            $stmt->execute(array(':vezeteknev' => $_POST['vezeteknev'], ':keresztnev' => $_POST['keresztnev'],
                                 ':bejelentkezes' => $_POST['felhasznalo'], ':jelszo' => sha1($_POST['jelszo']))); 
            if($count = $stmt->rowCount()) {
                $newid = $dbh->lastInsertId();
                $uzenet = "A regisztráció sikeres.<br>Azonosító: {$newid}";                     
                $ujra = false;
            }
            else {
                $uzenet = "A regisztráció nem sikerült.";
                $ujra = true;
            }
        }
    }
    catch (PDOException $e) {
        $uzenet = "Hiba: ".$e->getMessage();
        $ujra = true;
    }      
}
else {
    header("Location: .");
}
?>