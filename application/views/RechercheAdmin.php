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




  <div class="Nouveautes">

    <div class="recherche-box">
      <div class="filter-box">
        <form class="text-box tri" method="post" action="<?=site_url('RechercheAdmin/search')?>">

          <h4>Filtres:</h4>
          <div>
            <input type="checkbox" name="bookMark" value="1">
            <label for="">Marque pages seulement</label>
          </div>
          <div>
            <input type="checkbox" name="aviable" value="2">
            <label for="">En stock</label>
          </div>
          <div>
            <input type="checkbox" name="products" value="3">
            <label for="">Produits</label>
          </div>
          <div>
            <input type="checkbox" name="users" value="4">
            <label for="">Utilisateurs</label>
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

          <input type="text"placeholder=" Rechercher un produit ou un utilisateur..." name="search" id="search" value="<?=$_SESSION['AdminSearch'];?>"></input>

          <div>
            <button type="submit" style="width:190px;"><h4>Appliquer les modifications</h4></button>
          </div>
        </form>
      </div>
      <div style="width:100%;">
        <div class="subtitle">
          <hr>
          <div class="nom"><?= (isset($prods) && isset($users)) ? sizeof($prods)+sizeof($users) : "0"?> résultat(s) pour la recherche: '<?= $_SESSION['AdminSearch'];?>'</div>
          <hr>
        </div>
        <div class="listing-section">
          <div class="CartContainer" style="width:100%;">
            <?php foreach ($prods as  $prod): ?>
              <div class="Cart-Items" style="flex-direction:column;margin-top:25px;">
                <div style="display:flex;flex-direction:row;width:100%;justify-content:space-evenly;align-items:center;">
                  <div class="counter" style="flex-direction:column;">
                    <h3 class="name">id</h3>
                    <h4 class="number"><?= ($prod->getID())?></h4>
                  </div>
                  <div class="image-box">
                    <a href="<?= site_url('PageProduit/produit/').$prod->getId()?>">
                      <img src="<?= base_url('images/')?><?= $prod->getImageLink()?>"/>
                    </a>
                  </div>
                  <div class="counter" style="flex-direction:column;">
                    <h3 class="name"><?= $prod->getName()?></h3>
                    <h4 class="number"><?= ($prod->getType() == 1) ? "Tome ".$prod->getTomeNumber() : "Marque Page" ?></h4>
                  </div>
                  <div class="counter" style="flex-direction:column;">
                    <h3 class="name">quantitée:</h3>
                    <h4 class="number"><?= $prod->getQuantity()?></h4>
                  </div>
                  <div class="prices">
                    <h3 class="name">prix:</h3>
                    <div class="item-price"><?= (($prod->getQuantity() == 0)) ? "<label for='aviable'>rupture de stock</label>" : $prod->getPrice()."€" ?></div>
                  </div>
                  <div class="counter" style="flex-direction:column;">
                    <h3 class="name">ventes:</h3>
                    <h4 class="number"><?= $prod->getSells()?></h4>
                  </div>
                  <form action="#" methode="post">
                    <button type="submit"><img class="remove" src="<?= base_url('images/poubelle.png')?>" alt=""></button>
                  </form>
                </div>
                <div>
                  <h4 class="name">description</h4>
                  <h10 class="number" style="white-space:normal;"><?= ($prod->getDescription())?></h10>
                </div>
              </div>
            <?php endforeach;?>
          </div>

          <?php foreach ($users as  $user): ?>
            <div class="product">
              <div class="text-box">
                <a style="overflow: visible">
                  <h3 class="name" style="overflow: visible; white-space:normal;">Prénom :</h3>
                  <h4 class="number" style="overflow: visible; white-space:normal;"><?= $user->getFirstName()?></h4>
                  <h3 class="name" style="overflow: visible; white-space:normal;">Nom :</h3>
                  <h4 class="number" style="overflow: visible; white-space:normal;"><?= $user->getLastName()?></h4>
                  <h3 class="name" style="overflow: visible; white-space:normal;">Email :</h3>
                  <h4 class="number" style="overflow: visible; white-space:normal;"><?= $user->getEmail()?></h4>
                  <h3 class="name" style="overflow: visible; white-space:normal;">ID :</h3>
                  <h4 class="number" style="overflow: visible; white-space:normal;"><?= $user->getId()?></h4>
                  <h3 class="name" style="overflow: visible; white-space:normal;">Active :</h3>
                  <h4 class="number" style="overflow: visible; white-space:normal;"><?= $user->getActive()?></h4>
                </a>
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