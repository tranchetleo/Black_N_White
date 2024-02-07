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



<body>
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
          <img src="<?= base_url('images/cadis.png')?>" class="cart" alt="">
          <h2>panier</h2>
        </a>
      </div>
    </nav>    

  </header>

  <div class="form_container">
    <img src="<?= base_url('images/tree.png')?>" alt="" class="back-images-plus undisplay" style="left:0; height:100vw;">
    <form name="sign_in" class="Inscription" action="<?=site_url('Inscription/create_account')?>" method="post" id="form">
      <h1>Inscription</h1>
      <?php
        if(isset($_SESSION['erreurInscription'])){
          if ($_SESSION['erreurInscription'] == "1") {
            echo "<div class='item-price'>Attention certaines informations sont invalides!</div>";
            $this->session->unset_userdata('erreurInscription');
            $_SESSION['erreurInscription'] = "0";
          }
        }
      ?>
      <p>
          Votre prénom :<br />
          <input type="text" name="prenom" id="firstname" placeholder="First name" required/>
      </p>
      <p>
          Votre nom :<br />
          <input type="text" name="nom" id="lastname" placeholder="Last name" required/>
      </p>
      <p>
        Votre adresse mail :<br />
        <input type="mail" name="mail" id="email" placeholder="Email" required/>
      </p>
      <p>
          Votre mot de passe :<br />
          <input type="password" name="pass" id="password" placeholder="Password" pattern="(?=^.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" required/>
      </p>
      <p>
        Confirmation mot de passe :<br />
        <input type="password" name="pass_confirmation" id="password2" placeholder="Password Confirmation" pattern="(?=^.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" required/>
      </p>
      <h6 style="display: flex; flex-direction: row;">
        <input type="checkbox" name="check" id="check" required />
        <p class="inscription" style="font-size:10px; margin:auto;">En vous inscrivant vous confirmé avoir lu et accepté les <span><a href="<?= site_url('CGU')?>">CGU.</a></span></p>
      </h6>
      <div>
          <button type="submit" class="send">Envoyer</button>
      </div>
      <div>
        <button type="reset" class="reset">Annuler</button>
      </div>
      <p class="inscription">Vous avez déjà un compte? Je me <span><a href="<?= site_url('Connexion')?>">connecte.</a></span></p>
    </form>
    <img src="<?= base_url('images/tree2.png')?>" alt="" class="back-images-plus undisplay" style="right:0; height:100vw;">
  </div>
  

</body>

<div class="footer-all-conteneur">
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