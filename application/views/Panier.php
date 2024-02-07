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
          <?= (isset($cartItems[0])) ? "<img src=".base_url('images/cadis2.png')." class='cart' alt=''>" : "<img src=".base_url('images/cadis.png')." class='cart' alt=''>" ?>
          <h2>panier</h2>
        </a>
      </div>
    </nav>    

  </header>

  <div class="Title">
    <h1>Panier</h1>
  </div>

  <div class="CartContainer">
    <div class="Header">
      <h2 class="Heading">Vos produits</h3>
      <form action="<?=site_url('Panier/removeAllFromCart/')?>">
        <button type="submit" class="Action" style="border: none; background-color: unset;">
          Supprimer tout
        </input>
      </form>
      
    </div>

    <?= (isset($_SESSION['name'])) ? "" : 
    "<div class='Cart-Items' style='justify-content: space-evenly;'>
      <img src=".base_url('images/detective.png')." style='height:100px;'>
      <h3>Oups!!! Veuillez vous connecter pour avoir accès à votre panier</h3>
      <a href=".site_url('Connexion')." style='text-decoration: none; color: #845de0;'
        <h2>Connexion</h2>
      </a>
    </div>"
    ?>
    <?php $total = 0; $nbArticles = 0?>
    <?php foreach ($cartItems as  $cart): ?>
      <div class="Cart-Items">
        <div class="image-box">
          <a href="<?= site_url('PageProduit/produit/').$cart->getId()?>">
            <img src="<?= base_url('images/')?><?= $cart->getImageLink()?>"/>
          </a>
        </div>
        <div class="about">
          <a href="<?= site_url('PageProduit/produit/').$cart->getId()?>">
            <h2 class="name"><?= $cart->getName()?></h2>
            <h3 class="number"><?= ($cart->getType() == 1) ? "Tome ".$cart->getTomeNumber() : "Marque Page" ?></h3>
          </a>
        </div>
        <div class="counter">
          <form action="<?=site_url('Panier/reduceQuantity/'.$cart->getId())?>">
            <button type="submit" class="btn">-</button>
          </form>
          <div class="count"><?= $cart->getQuantity()?></div>
          <form action="<?=site_url('Panier/increaseQuantity/'.$cart->getId())?>">
            <button type="submit" class="btn">+</button>
          </form>
        </div>
        <div class="prices">
          <div class="item-price"><?= (($cart->getQuantity() == 0)) ? "<label for='aviable'>rupture de stock</label>" : $cart->getPrice()."€" ?></div>
        </div>
        <form action="<?=site_url('Panier/removeFromCart/'.$cart->getId())?>" methode="post">
          <button type="submit"><img class="remove" src="<?= base_url('images/poubelle.png')?>" alt=""></button>
        </form>
      </div>
      <?php $total += $cart->getQuantity() * $cart->getPrice(); $nbArticles += $cart->getQuantity()?>
    <?php endforeach;?>
    <?= (!(isset($cartItems[0])) && (isset($_SESSION['email']))) ?
      "<div class='Cart-Items' style='justify-content: space-evenly;'>
        <img src=".base_url('images/chibi_yuji.png')." style='height:100px;'>
        <h3>Oups!!! Votre panier est vide.</h3>
        <a href=".site_url('Home')." style='text-decoration: none; color: #845de0;'
          <h2>Continuer vos achats</h2>
        </a>
      </div>"
      : ""
    ?>
    <div class="number">
      Veuillez verifier le nombre d'articles en stock, certains produits sont victimes de leurs succès
      <?php
        if(isset($_SESSION['erreurPanier'])){
          if ($_SESSION['erreurPanier'] == "1") {
            echo "<div class='item-price'>Attention 1 ou plusieurs articles ont été retirés de votre panier car ils étaient indisponibles!</div>";
            $this->session->unset_userdata('erreurPanier');
            $_SESSION['erreurPanier'] = "0";
          }
        }
      ?>
      <?php
        if(isset($_SESSION['erreurPaiement'])){
          if ($_SESSION['erreurPaiement'] == "1") {
            echo "<div class='item-price'>Votre commande viens d'être annulée avec succes.</div>";
            $this->session->unset_userdata('erreurPaiement');
            $_SESSION['erreurPaiement'] = "0";
          }
        }
      ?>
    </div>
  </div>  

  <div class="checkout">
    <div class="total">
      <div>
        <div class="Subtotal">Total :</div>
        <div class="items"><?= $nbArticles?> produit(s)</div>
      </div>
      <div class="total-amount"><?= $total?>€</div>
    </div>
    <form action="<?=site_url('Panier/checkCartToPay')?>">
      <button type="submit" class="button">Passer au paiement</button>
    </form>
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