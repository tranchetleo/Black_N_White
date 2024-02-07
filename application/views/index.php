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

    <div class="slider" id="main-slider">
      <img src="<?= base_url('images/Logo.png')?>" alt="">
      <div class="slider-wrapper">
        <img src="<?= base_url('images/slide.jpg')?>" alt="First" class="slide" />
        <img src="<?= base_url('images/slide2.jpg')?>" alt="Second" class="slide" />
        <img src="<?= base_url('images/slide3.jpg')?>" alt="Third" class="slide" />
        <img src="<?= base_url('images/slide4.jpg')?>" alt="Fourth" class="slide" />
        <img src="<?= base_url('images/slide5.jpg')?>" alt="Fifth" class="slide" />
      </div>
    </div>

    <div class="Title">
      <h1>PRODUITS</h1>
    </div>

    <div class="Nouveautes">

      <div class="subtitle">
        <hr>
        <div class="nom">NOUVEAUTES</div>
        <hr>
      </div>
      <div class="listing-section">
        <table>
          <tr>
            <?php for($i=0;$i<5;$i++): ?>
                <td class="product">
                  <div class="image-boxes">
                    <div class="images">
                      <a href="<?= site_url('PageProduit/produit').'/'.$prods[$i]->getId()?>">
                        <?= (($prods[$i]->getQuantity() == 0)) ? "<img src=".base_url('images/').$prods[$i]->getImageLink()." style='opacity: 80%; position:absolute; z-index: index 1;'><img src=".base_url('images/soldout.png')." style='opacity: 40%; z-index: index 2;'>" : "<img src=".base_url('images/').$prods[$i]->getImageLink()." class='hoverable'"?>
                      </a>
                    </div>
                  </div>
                  <div class="text-box">
                    <a href="<?= site_url('PageProduit/produit').'/'.$prods[$i]->getId()?>">
                      <h2 class="name"><?= $prods[$i]->getName()?></h2>
                      <h4 class="number"><?= ($prods[$i]->getType() == 1) ? "Tome ".$prods[$i]->getTomeNumber() : "Marque Page" ?></h4>
                    </a>
                    <h3 class="item-price"><?= (($prods[$i]->getQuantity() == 0)) ? "<label for='aviable'>rupture de stock</label>" : $prods[$i]->getPrice()."€" ?></h3>
                    <?= (($prods[$i]->getQuantity() == 0)) ? "" : "
                      <form action=".site_url('Panier/addToCart/'.$prods[$i]->getId())." methode='post'>
                        <button type='submit' name='item-1-button' id='item-1-button'>Ajouter au panier
                          <img src=". base_url('images/cadis.png')." alt='' style='height: 15px;'>
                        </button>
                      </form>
                    "?>
                  </div>
                </td>
            <?php endfor;?>
          </tr>
          <tr>
            <?php for($i=5;$i<10;$i++): ?>
              <td class="product">
                <div class="image-boxes">
                  <div class="images">
                    <a href="<?= site_url('PageProduit/produit').'/'.$prods[$i]->getId()?>">
                      <?= (($prods[$i]->getQuantity() == 0)) ? "<img src=".base_url('images/').$prods[$i]->getImageLink()." style='opacity: 80%; position:absolute; z-index: index 1;'><img src=".base_url('images/soldout.png')." style='opacity: 40%; z-index: index 2;'>" : "<img src=".base_url('images/').$prods[$i]->getImageLink()." class='hoverable'"?>
                    </a>
                  </div>
                </div>
                <div class="text-box">
                  <a href="<?= site_url('PageProduit/produit').'/'.$prods[$i]->getId()?>">
                    <h2 class="name"><?= $prods[$i]->getName()?></h2>
                    <h4 class="number"><?= ($prods[$i]->getType() == 1) ? "Tome ".$prods[$i]->getTomeNumber() : "Marque Page" ?></h4>
                  </a>
                  <h3 class="item-price"><?= (($prods[$i]->getQuantity() == 0)) ? "<label for='aviable'>rupture de stock</label>" : $prods[$i]->getPrice()."€" ?></h3>
                  <?= (($prods[$i]->getQuantity() == 0)) ? "" : "
                    <form action=".site_url('Panier/addToCart/'.$prods[$i]->getId())." methode='post'>
                      <button type='submit' name='item-1-button' id='item-1-button'>Ajouter au panier
                        <img src=". base_url('images/cadis.png')." alt='' style='height: 15px;'>
                      </button>
                    </form>
                  "?>
                </div>
              </td>
            <?php endfor;?>
          </tr>
        </table>
      </div>
    </div>

    <div class="Populaires">
      <table>
        <div class="subtitle">
          <hr>
          <div class="nom">LES PLUS POPULAIRES</div>
          <hr>
        </div>
        <tr>
          <?php for($i=0;$i<3;$i++): ?>
            <td class="product">
              <div class="image-boxes">
                <div class="images">
                  <a href="<?= site_url('PageProduit/produit').'/'.$best[$i]->getId()?>">
                    <?= (($best[$i]->getQuantity() == 0)) ? "<img src=".base_url('images/').$best[$i]->getImageLink()." style='opacity: 80%; position:absolute; z-index: index 1;'><img src=".base_url('images/soldout.png')." style='opacity: 40%; z-index: index 2;'>" : "<img src=".base_url('images/').$best[$i]->getImageLink()." class='hoverable'"?>
                  </a>
                </div>
              </div>
              <div class="text-box">
                <a href="<?= site_url('PageProduit/produit').'/'.$best[$i]->getId()?>">
                  <h2 class="name"><?= $best[$i]->getName()?></h2>
                  <h4 class="number"><?= ($best[$i]->getType() == 1) ? "Tome ".$best[$i]->getTomeNumber() : "Marque Page" ?></h4>
                </a>
                <h3 class="item-price"><?= (($best[$i]->getQuantity() == 0)) ? "<label for='aviable'>rupture de stock</label>" : $best[$i]->getPrice()."€" ?></h3>
                <label for="aviable"><?= $best[$i]->getSells()?> ventes</label>
                <?= (($best[$i]->getQuantity() == 0)) ? "" : "
                  <form action=".site_url('Panier/addToCart/'.$best[$i]->getId())." methode='post'>
                    <button type='submit' name='item-1-button' id='item-1-button'>Ajouter au panier
                      <img src=". base_url('images/cadis.png')." alt='' style='height: 15px;'>
                    </button>
                  </form>
                "?>
              </div>
            </td>
          <?php endfor;?>
        </tr>
      </table>
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