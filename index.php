<?php

require 'lib/autoload.php';

$db = DBFactory::getMysqlConnexionWithPDO();
$manager = new NewsManagerPDO($db);

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Home page</title>
    <meta charset="utf-8" />
    <LINK href="css/nav.css" rel="stylesheet" type="text/css"> 

  <!--<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>-->
  <link href="http://code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet">
<img src="images/logo-bourbon.png" alt="Bourbon">


  </head>

  <body>
          <ul id="nav">
              <li> <a href="#" id="tile1"><i class="icon ion-ios7-home-outline"></i> Home</a>
                  <ul>
                    <li><a href="#">Board Games</a></li>
                    <li><a href="#">Card Games</a></li>
                    <li><a href="#">Puzzle Games</a></li>
                    <li><a href="#">Skill Games &raquo;</a>
                    <ul>
                        <li><a href="#">Yahoo Pool</a></li>
                        <li><a href="#">Chess</a></li>
                    </ul>
                    </li>
                </ul>
              </li>
              <li> <a href="#" id="tile2"><i class="icon ion-ios7-person-outline"></i> About</a></li>
              <li> <a href="#" id="tile3"><i class="icon ion-ios7-briefcase-outline"></i> Portfolio</a></li>
              <li> <a href="#" id="tile4"><i class="ion-ios7-monitor-outline"></i> Services</a></li>
              <li> <a href="#" id="tile5"><i class="ion-ios7-people-outline"></i> Clients</a></li>
              <li> <a href="#" id="tile6"><i class="ion-bag"></i> Order</a></li>
              <li> <a href="#" id="tile7"><i class="ion-ios7-paper-outline"></i> Blog</a></li>
              <li> <a href="#" id="tile8"><i class="ion-ios7-email-outline"></i> Contact</a></li>
          </ul>
    <!-- <div id="hor-minimalist-a" summary="Employee Pay Sheet"> -->
    <div>
      <table id="background-image">
        <thead>
          <tr>
            <th>Author</th>
            <th>Title</th>
            <th>Date of creation</th>
            <th>Last Update</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
    foreach ($manager->getList() as $news)
    {
      echo '<tr><td>', 
      $news->auteur(), '</td><td>', 
      $news->titre(), '</td><td>', 
      $news->dateAjout()->format('d/m/Y à H\hi'), '</td><td>', ($news->dateAjout() == $news->dateModif() ? '-' : $news->dateModif()->format('d/m/Y à H\hi')), 
      '</td><td><a href="admin.php?modifier=', $news->id(), '"><img src="images/006-pencil.png" alt="Edit" style="float:right;width:16px;height:16px"></a>',
 '<a href="admin.php?supprimer=', $news->id(), '"><img src="images/173-bin.png" alt="Delete" style="float:right;width:16px;height:16px"></a></td></tr>', "\n";
    }
    ?>  
        </tbody>
      </table>
    </div>
    <div>
      <a href="admin.php" class="myButton">Add new</a>
    </div>
  </body>
</html>

