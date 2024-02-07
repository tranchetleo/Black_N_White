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
      <div class="link">
        <a href="<?= site_url('Admin')?>">
          <img src="<?= base_url('images/pers.png')?>" class="pers" alt="">
          <h2><?= (isset($_SESSION['login'])) ? $_SESSION['login'] : "connexion" ?></h2>
        </a>
      </div>
    </nav>    

  </header>

  <div class="form_container">
    <img src="<?= base_url('images/right.png')?>" alt="" style="height: 700px; opacity:90%;">
    <form class="PageConnexion" action="<?=site_url('Admin/login')?>" method="post">           
      <h1>Se connecter</h1>

      <div class="inputs">
        <p>
          Votre identifiant :<br />
          <input type="text" name="login" placeholder="Login" style="padding:15px; border-radius:5px; border:none;outline:none;"required />
        </p>

        <p>
          Votre mot de passe :<br />
          <input type="password" name="pass" id="password" placeholder="Password" title="Password min 8 characters. At least one UPPERCASE and one lowercase letter" required/>
        </p>
      </div>

      <div>
        <button type="submit" class="send" value="Sign Up">Se connecter</button>
      </div>
      <p class="inscription">Je n'ai pas de compte? Je m'en <span><a href="<?= site_url('InscriptionAdmin')?>">crée un.</a></span></p>
    </form>
    <img src="<?= base_url('images/left.png')?>" alt="" style="height: 700px; opacity:90%;">
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