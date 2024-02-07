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
          <input type="text"placeholder=" Rechercher  ..." name="search" id="search">
          <button type="submit" id="lancerRecherhce" style="border: none; background-color:unset;"><img src="<?= base_url('images/search.png')?>" alt="" style="height: 15px;"></button>
        </form>
      </div>

      <script type="text/javascript">
        function OtherVolumes(){
          var txt = '<?php echo $items[0]->getName() ?>';
          document.getElementById("search").value = txt;
          recherche();
        }
        function recherche(){
          document.getElementById("lancerRecherhce").click();
        }
      </script>

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


  <?php foreach ($items as $item): ?>
    <div class="Produit">
      <div class="image-box">
        <img src="<?= base_url('images/')?><?= $item->getImageLink()?>" alt="">
        <?= (($item->getQuantity() == 0)) ? "
          <form action='#' methode='post' style='margin-top: 20px; opacity: 70%;'>
            <button type='submit' name='item-1-button' id='item-1-button'><h2>Ajouter au panier</h2>
              <img src=". base_url('images/cadis.png')." alt='' style='height: 30px;'>
            </button>
          </form>
        " : "
          <form action=".site_url('Panier/addToCart/'.$item->getId())." methode='post' style='margin-top: 20px;'>
            <button type='submit' name='item-1-button' id='item-1-button'><h2>Ajouter au panier</h2>
              <img src=". base_url('images/cadis.png')." alt='' style='height: 30px;'>
            </button>
          </form>
        "?>
      </div>
      <div class="text-box">
        <div><h2>Nom:</h2><h3 class="name" style="text-align:left; color: #444"><?= $item->getName()?></h2></div>
        <div><?= ($item->getType() == 1) ? "<h2>Numéro de tome:</h2><h3 class='number' style='text-align:left;'>Tome ".$item->getTomeNumber() : "<h2>Type:</h2><h3 class='number' style='text-align:left;'>Marque Page</h3>" ?></div>
        <div><h2>Prix:</h2><h3 class="item-price"><?= $item->getPrice()?>€</h3></div>
        <div><h2>Disponibilité:</h2><div class="stock"><?= (($item->getQuantity() == 0)) ? "<h3 for='aviable' style='color:#FF5555'>Rupture de stock</h3>" : "<h3 for='aviable' style='color:#1e5816'>Article disponible</h3>" ?></div></div>
        <div><h2>Résumé:</h2> <div class="description"><?= $item->getDescription()?></div></div>
      </div>
    </div>
  <?php endforeach;?>



  <div class="Nouveautes">

    <div class="subtitle">
      <hr>
      <h3 class="more-products" id="autresTommes" onclick="OtherVolumes()">D'autres tommes</h3>
      <hr>
    </div>
    <div class="listing-section">
      <table>
        <tr>
          <?php for($i=0;$i<5;$i++): ?>
            <td class="product">
              <div class="image-boxes">
                <div class="images">
                  <a href="<?= site_url('PageProduit/produit').'/'.$volumes[$i]->getId()?>">
                    <?= (($volumes[$i]->getQuantity() == 0)) ? "<img src=".base_url('images/').$volumes[$i]->getImageLink()." style='opacity: 80%; position:absolute; z-index: index 1;'><img src=".base_url('images/soldout.png')." style='opacity: 40%; z-index: index 2;'>" : "<img src=".base_url('images/').$volumes[$i]->getImageLink()." class='hoverable'"?>
                  </a>
                </div>
              </div>
              <div class="text-box">
                <a href="<?= site_url('PageProduit/produit').'/'.$volumes[$i]->getId()?>">
                  <h2 class="name"><?= $volumes[$i]->getName()?></h2>
                  <h4 class="number"><?= ($volumes[$i]->getType() == 1) ? "Tome ".$volumes[$i]->getTomeNumber() : "Marque Page" ?></h4>
                </a>
                <h3 class="item-price"><?= (($volumes[$i]->getQuantity() == 0)) ? "<label for='aviable'>rupture de stock</label>" : $volumes[$i]->getPrice()."€" ?></h3>
                <?= (($volumes[$i]->getQuantity() == 0)) ? "" : "
                  <form action=".site_url('Panier/addToCart/'.$volumes[$i]->getId())." methode='post'>
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
  <div class="Nouveautes">

    <div class="subtitle">
      <hr>
      <h3 class="more-products" id="autresTommes" onclick="recherche()">Les articles les plus recents</h3>
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
      </table>
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