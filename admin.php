<?php
require 'lib/autoload.php';
$db = DBFactory::getMysqlConnexionWithPDO();
$manager = new NewsManagerPDO($db);

if (isset($_GET['modifier']))
{
  $news = $manager->getUnique((int) $_GET['modifier']);
}

if (isset($_GET['supprimer']))
{
  $manager->delete((int) $_GET['supprimer']);
  $message = 'La news a bien été supprimée !';
  unset($news);
  header('Location: index.php');
}

if ($_POST['quit']=='Cancel')
{
      unset($news);
      header('Location: index.php');
}  
else
{
      if (isset($_POST['auteur']))
      {
        $news = new News([
          'auteur' => $_POST['auteur'],
          'titre' => $_POST['titre'],
          'contenu' => $_POST['contenu']
          ]);

        if (isset($_POST['id']))
        {
          $news->setId($_POST['id']);
        }
        
        if ($news->isValid())
        {
          $manager->save($news);
          $message = $news->isNew() ? 'La news a bien été ajoutée !' : 'La news a bien été modifiée !';
          unset($news);
          header('Location: index.php');
        }
        else
        {
          $erreurs = $news->erreurs();
        }
      }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Administration</title>
    <meta charset="utf-8" />
    <LINK href="css/nav.css" rel="stylesheet" type="text/css">

  </head>

  <body>
    <!-- <p><a href=".">Accéder à l'accueil du site</a></p>  -->
    <div class="tab-content">
      <div class="form-style-10">
        <form action="admin.php" method="post">
        <h1>Entry Form<span>Enter what you want here !</span></h1>
  <?php

  if (isset($message))
  {
    echo $message, '<br />';
  }

  ?>
      <div class="section"><span>1</span>Author &amp; Title</div>
      <div class="inner-wrap">
          <?php if (isset($erreurs) && in_array(News::AUTEUR_INVALIDE, $erreurs)) echo 'L\'auteur est invalide.<br />'; ?>
          <label>Author <input type="text" name="auteur" value="<?php if (isset($news)) echo $news->auteur(); ?>" /></label>
          
          <?php if (isset($erreurs) && in_array(News::TITRE_INVALIDE, $erreurs)) echo 'Le titre est invalide.<br />'; ?>
          <label>Title <input type="text" name="titre" value="<?php if (isset($news)) echo $news->titre(); ?>" /></label>
      </div>
          
      <div class="section"><span>2</span>Content</div>
      <div class="inner-wrap">
          <?php if (isset($erreurs) && in_array(News::CONTENU_INVALIDE, $erreurs)) echo 'Le contenu est invalide.<br />'; ?>
          <label>Text Content <textarea rows="8" cols="60" name="contenu"><?php if (isset($news)) echo $news->contenu(); ?></textarea></label>
      </div>

      <div class="button-section">     
  <?php

  if(isset($news) && !$news->isNew())
  {

  ?>
          <input type="hidden" name="id" value="<?= $news->id() ?>" />
          <!-- <input type="submit" value="Modifier" name="modifier" /> -->
          <input type="submit" class="myButton" value="Save" name="quit" />
          <input type="submit" class="myButton" value="Cancel" name="quit"/>
  <?php

  }
  else
  {

  ?>
           <!-- <input type="submit" value="Ajouter" /> -->
          <input type="submit" class="myButton" value="Save" name="quit" />
          <input type="submit" class="myButton" value="Cancel" name="quit"/>
  <?php

  }

  ?>
            <span class="privacy-policy">
              <input type="checkbox" name="field7">You agree to our Terms and Policy.
            </span>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>