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
          <input type="text"placeholder=" Rechercher  ..." name="search" id="search"></input>
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




  <div class="Nouveautes">

    <div class="recherche-box">
      <div class="filter-box">
        <form class="text-box tri" method="post" action="<?=site_url('Recherche/search')?>">

          <h4>Filtres:</h4>
          <div>
            <input type="checkbox" name="bookMark" value="1">
            <label for="">Marque pages seulement</label>
          </div>
          <div>
            <input type="checkbox" name="aviable" value="2">
            <label for="">En stock</label>
          </div>

          <h4>Option de tri:</h4>
          <div>
            <input type="radio" name="radio" value="1">
            <label for="">Meilleures ventes</label>
          </div>
          <div>
            <input type="radio" name="radio" value="2">
            <label for="">Alphabetique(de A à Z)</label>
          </div>
          <div>
            <input type="radio" name="radio" value="3">
            <label for="">Alphabetique(de Z à A)</label>
          </div>          
          <div>
            <input type="radio" name="radio" value="4">
            <label for="">Prix croissant</label>            
          </div>
          <div>
            <input type="radio" name="radio" value="5">
            <label for="">Prix décroissant</label>  
          </div>
          <div>
            <input type="radio" name="radio" value="6" checked>
            <label for="">Les derniers ajouts d'abord</label>  
          </div>

          <input type="text"placeholder=" Rechercher  ..." name="search" id="search" value="<?=$_SESSION['lastSearch'];?>"></input>

          <div>
            <button type="submit"><h4>Appliquer les modifications</h4></button>
          </div>
        </form>
      </div>
      <div style="width:80%;">
        <div class="subtitle">
          <hr>
          <div class="nom"><?= sizeof($prods)?> résultat(s) pour la recherche: '<?= $_SESSION['lastSearch'];?>'</div>
          <hr>
        </div>
        <div class="listing-section">
          <?php foreach ($prods as  $prod): ?>
            <div class="product">
              <div class="image-boxes">
                <div class="images">
                  <a href="<?= site_url('PageProduit/produit').'/'.$prod->getId()?>">
                    <?= (($prod->getQuantity() == 0)) ? "<img src=".base_url('images/').$prod->getImageLink()." style='opacity: 80%; position:absolute; z-index: index 1;'><img src=".base_url('images/soldout.png')." style='opacity: 40%; z-index: index 2;'>" : "<img src=".base_url('images/').$prod->getImageLink()." class='hoverable'"?>
                  </a>
                </div>
              </div>
              <div class="text-box">
                <a href="<?= site_url('PageProduit/produit').'/'.$prod->getId()?>" style="overflow: hidden;text-overflow: ellipsis;">
                  <h3 class="name"><?= $prod->getName()?></h3>
                  <h4 class="number"><?= ($prod->getType() == 1) ? "Tome ".$prod->getTomeNumber() : "Marque Page" ?></h4>
                </a>
                <h3 class="item-price"><?= (($prod->getQuantity() == 0)) ? "<label for='aviable'>rupture de stock</label>" : $prod->getPrice()."€" ?></h3>
                <?= (($prod->getQuantity() == 0)) ? "" : "
                  <form action=".site_url('Panier/addToCart/'.$prod->getId())." methode='post'>
                    <button type='submit' name='item-1-button' id='item-1-button'>Ajouter au panier
                      <img src=". base_url('images/cadis.png')." alt='' style='height: 15px;'>
                    </button>
                  </form>
                "?>
              </div>  
            </div>
          <?php endforeach;?>
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