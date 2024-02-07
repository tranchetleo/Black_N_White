<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Black N White</title>

    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href="<?= base_url('assets/style/style.css')?>" rel="stylesheet">
    <link href="<?= base_url('assets/style/reset.css')?>" rel="stylesheet">
    <link rel="icon" href="<?= base_url('images/Logo.png')?>">
    
    <script src="<?= base_url('assets/style/main.js')?>"></script>
  </head>



<body class="hasBackground-image" style="background-image: url('<?= base_url('images/Background.png')?>');">
  <header class="page header">
    
    <nav class="header-navbar">
      <a href="<?= site_url('Home')?>">
        <img src="<?= base_url('images/Logo.png')?>">
      </a>
      <a class="nom" href="<?= site_url('Home')?>">
        <h2>Accueil</h2>
      </a>

      <div class="search">
        <form action="<?=site_url('Recherche/search')?>" method="post">
          <input type="text"placeholder=" Rechercher  ..." name="search">
          <button type="submit" style="border: none; background-color:unset;"><img src="<?= base_url('images/search.png')?>" alt="" style="height: 15px;"></button>
        </form>
      </div>

      <div class="link">
        <a href="<?= site_url('Connexion')?>">
          <img src="<?= base_url('images/pers.png')?>" class="pers" alt="">
          <h2><?= (isset($_SESSION['name'])) ? $_SESSION['name'] : "connexion" ?></h2>
        </a>
      </div>

      <div class="link">
        <a href="<?= site_url('Panier')?>">
          <?= (isset($cartItems[0])) ? "<img src=".base_url('images/cadis2.png')." class='cart' alt=''>" : "<img src=".base_url('images/cadis.png')." class='cart' alt=''>" ?>
          <h2>panier</h2>
        </a>
      </div>
    </nav>    

  </header>

  <div>
    <div class="PageConnexion" style="margin-top: 5%;">
      <?php
        if(isset($_SESSION['confirmationPaiement'])){
          if ($_SESSION['confirmationPaiement'] == "1") {
            echo "<div class='item-price'>Votre commandea été passée avec succes.</div>";
            $this->session->unset_userdata('confirmationPaiement');
            $_SESSION['confirmationPaiement'] = "0";
          }
        }
      ?>
      <img src="<?= base_url('images/validation.png')?>" alt="" style="height: 300px;">
      <h3 style="color: #FFFFFF;">Un mail vous a été envoyé, veuillez y jeter un oeil pour terminer la procédure.</h3>
    </div>
  </div>

</body>


<div class="footer-all-conteneur absolute">

  <div class="bigline"></div>

  <div class="footer-conteneur-adresse">

    <div class="footer-adress-assoce-conteneur">
      <h3 class="footer-adresse-title">Contactez-nous</h3>
      <div class="footer-adresse-conteneur">
        <a href="">
          <img src="<?= base_url('images/insta.png')?>" alt="">
        </a>
        <a href="">
          <img src="<?= base_url('images/mail.png')?>" alt="">
        </a>
        <a href="">
          <img src="<?= base_url('images/facebook.png')?>" alt="">
        </a>
      </div>
    </div>

    <div class="footer-copiright-conteneur">
      <span class="footer-terme">@copy-right</span>
      <a href="<?= site_url('CGU')?>" class="footer-div">
        <span class="footer-terme">terme et condition</span>
      </a>
      <span class="footer-terme">Confidentialité</span>
    </div>

  </div>
</div>
</html>