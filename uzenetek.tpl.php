
 <link rel="stylesheet" href="./styles/style.css">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body text-center">
				
<table id="tabli" class="table table-bordered" >
<thead>
<tr><th>Sorszám</th><th>Feladó</th><th>Tárgy</th><th>Üzenet</th></tr></thead>
<?php

try{
$pdo = new PDO('mysql:host=mysql.omega:3306;dbname=azeiel', 'azeiel', 'vk4ug8',
array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
$pdo->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
$utasitas = "Select * From email Order By datum DESC";
$eredm = $pdo->query($utasitas);

foreach ($eredm as $sor)
print "<tr><td>".$sor['sorszam'] . "</td>"."<td> " .$sor['felado']. "</td>"."<td> " .$sor['targy']."</td>"."<td> ".$sor['uzenet'] . "</td>"."</tr> ";
}

catch(PDOException $e) {
echo "Hiba: ".$e->getMessage();
}


?>
</table>

 </div>
             
            </div>
        </div>
    </div>
</div>

