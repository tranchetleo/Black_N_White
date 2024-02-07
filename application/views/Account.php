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

  <div class="form_container">
    <div style="display: flex; flex-direction: column;margin:auto;">
      <div>
        <div class="Inscription" style="padding: 10%; align-content: space-around;">
          <form class="Inscription" action="<?=site_url('Account/updateUserInfo')?>" style="background:none;" method="post">
            <h2>Informations Personelles</h2>
            <p>
                Votre prénom :<br />
                <input type="text" name="prenom" id="firstname" value=<?=$_SESSION['name']?> required/>
            </p>
            <p>
                Votre nom :<br />
                <input type="text" name="nom" id="lastname" value=<?=$_SESSION['lastname']?> required/>
            </p>
            <p>
              Votre adresse mail :<br />
              <input type="mail" name="mail" id="email" value=<?=$_SESSION['email']?> required/>
            </p>
            <p class="inscription">Attention en modifiant votre adresse mail il faudra la valider de nouveau!</p>
            <?php
              if(isset($_SESSION['infoUpdated'])){
                if ($_SESSION['infoUpdated'] == "1") {
                  echo "<div class='item-price'>Vos Modifications ont bien été prises en compte.</div>";
                  $this->session->unset_userdata('infoUpdated');
                  $_SESSION['infoUpdated'] = "0";
                }
              }
            ?>
            <div>
              <button type="submit" class="send">Soumettre les modifications</button>
            </div>
          </form>
          <hr style="background-color:#FFFFFF;">
          <form class="Inscription" action="<?=site_url('Account/changePassword')?>" style="background:none;" method="post">
            <h2>Sécurité</h2>
            <p>Vous désirez changer votre mot de passe?</p>
            <p>
              Mot de passe actuel:<br />
              <input type="password" name="pass" id="password" placeholder="Password" />
            </p>
            <p>
              Nouveau mot de passe:<br />
              <input type="password" name="new_pass" id="password1" placeholder="New Password" />
            </p>
            <p>
              Confirmation:<br />
              <input type="password" name="pass_confirmation" id="password2" placeholder="Password Confirmation" />
            </p>
            <div>
              <button type="submit" class="send">Soumettre les modifications</button>
            </div>
          </form>
          <hr style="background-color:#FFFFFF;">
          <form class="Inscription" action="<?=site_url('Connexion/deleteUser')?>" style="background:none;" method="post">
            <div>
              <button type="submit" class="send">Supprimer le compte</button>
            </div>
          </form>
          <hr style="background-color:#FFFFFF;">
          <form class="Inscription" action="<?=site_url('Connexion/logout')?>" style="background:none;" method="post">
            <div>
              <button type="submit" class="send">Se déconnecter</button>
            </div>
          </form>
        </div>
      </div>
    </div>
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