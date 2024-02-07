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
    <script>
      window.addEventListener("beforeunload", function (e) {
        var confirmationMessage = "Voulez-vous vraiement quitter la page? Cette action annullera votre commande";
        if (!confirm(confirmationMessage)) {
            e.preventDefault();
            e.returnValue = "";
        } else {
          annulerCommande();
        }
        return confirmationMessage;
      });
    </script>

  </head>



<body>

  <div class="form_container">
    <img src="<?= base_url('images/tree.png')?>" alt="" class="formBorderImage">

    <div class="row">
      <div class="col-75">
        <div class="container">
          <div class="PayingForm">
            <div class="row">
              <div class="col-50">
                <h3>Adresse de facturation</h3></br>
                <label for="fname"><i class="fa fa-user"></i> Nom complet</label>
                <input type="text" id="fname" name="firstname" placeholder="John Doe">
                <label for="email"><i class="fa fa-envelope"></i> Email</label>
                <input type="text" id="email" name="email" placeholder="john@example.com">
                <label for="adr"><i class="fa fa-address-card-o"></i> Adresse</label>
                <input type="text" id="adr" name="address" placeholder="3 Rue Marechal Joffre">
                <label for="city"><i class="fa fa-institution"></i> Ville</label>
                <input type="text" id="city" name="city" placeholder="Nantes">
                <label for="zip">Code postale</label>
                <input type="text" id="zip" name="zip" placeholder="44000">
              </div>

              <div class="col-50">
                <h3>Paiement</h3></br>
                <label for="fname" style="margin-bottom: 4px;">Cartes prises en charge</label>
                <div class="icon-container" style="margin-bottom: 0px;">
                  <img src="<?=base_url('images/visa.png')?>" alt="">
                  <img src="<?=base_url('images/amex.png')?>" alt="">
                  <img src="<?=base_url('images/mastercard.png')?>" alt="">
                </div>
                <label for="cname">Nom sur la carte</label>
                <input type="text" id="cname" name="cardname" placeholder="John More Doe">
                <label for="ccnum">Numéro de carte</label>
                <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">
                <label for="expmonth">Date d'expiration:</label>
                <div class="row" style="margin-top:-10px;">
                  <div class="col-50" style="margin:0;">
                    <input type="text" id="expmonth" name="expmonth" placeholder="Mois">
                  </div>
                  <div class="col-50" style="margin:0;">
                    <input type="text" id="expyear" name="expyear" placeholder="Année">
                  </div>
                </div>
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" placeholder="352">


              </div>

            </div>
            <form action="<?=site_url('Paiement/ValiderPaiement')?>">
              <div>
                <button type="submit" class="send">Continuer le paiement</button>
              </div>
            </form>
          </div>
          <form class="PayingForm" action="<?=site_url('Paiement/AnnulerPaiement')?>" style="background:none;">
            <div>
              <button type="submit" class="reset">Annuler</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <img src="<?= base_url('images/tree2.png')?>" alt="" class="formBorderImage">
  </div>
  

</body>

</html>