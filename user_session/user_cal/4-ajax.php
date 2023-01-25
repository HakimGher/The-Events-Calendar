<?php
// inclure le code de connexion a la base de donnnes : avec (require)  :
require "2-cal-core.php";

// requette condition :
  switch ($_POST["req"]) {

  case "dis":
  $_CAL->events($_POST["number"]);

 break;

//Enregistrer_un_Evenement : 
  case "save":
    if (!is_numeric($_POST["eid"])) { $_POST["eid"] = null; }
    echo $_CAL->save($_POST["title"],$_POST["place"],
      $_POST["start"], $_POST["end"], $_POST["txt"], $_POST["color"],
      isset($_POST["eid"]) ? $_POST["eid"] : null
    ) ? "OK" : $_CAL->error ;
    break;


// Supprimer_un_Evenement :
  case "del":
    echo $_CAL->delete($_POST["eid"])  ? "OK" : $_CAL->error ;
    break;


// GENERATION DU CALENDRIER  : 
  case "draw":

    // CALCUL NOMBRE DE JOURS PAR MOIS : 
    $Num_days_in_month = cal_days_in_month(CAL_GREGORIAN, $_POST["month"], $_POST["year"]);

    // CALCUL DU PREMIER JOUR DU MOIS :
    $First_date = "{$_POST["year"]}-{$_POST["month"]}-01";

    // CALCUL DU DERNIER JOUR DU MOIS :
    $Last_date = "{$_POST["year"]}-{$_POST["month"]}-{$Num_days_in_month}";

    // JOUR DE SEMAINE (0 => Dimanche) : 
    // DEBUT DE MOIS  QUEL JOUR EXEMPLE ? : { 01 DECEMBRE 2021  C  3=> MRECREDI } : 
    $First_day = (new DateTime($First_date))->format("w");

    // FIN DE MOIS  QUEL JOUR EXEMPLE ? : { 31 DECEMBRE 2021  C  5=> VENDREDI } : 
    $Last_day = (new DateTime($Last_date))->format("w");


    // NOMS DES JOURS : 
    $days = ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam","Dim"];
    // AFFICHER TOUS LES JOURS : 
    foreach ($days as $d) { echo "<div class='space head'>$d</div>"; }
    unset($days);


    // LES ESPACES AVANT LE PREMIER JOUR DU MOIS : 
    $space = $First_day==0 ? 6 : $First_day-1 ;
    for ($i=0; $i<$space; $i++) { 
     echo "<div class='space blank'></div>"; }


    // GENERER LES JOURS DU MOIS : 
    $events = $_CAL->get($_POST["month"], $_POST["year"]);
    $Month_now = date("n");
    $Year_now = date("Y");
    $nowDay = ($Month_now==$_POST["month"] && $Year_now==$_POST["year"]) ? date("j") : 0 ;

      //AFFCIHER LES JOURS : BOUCLE : 
    for ($day = 1; $day <= $Num_days_in_month; $day++) {
    $date = "{$_POST["year"]}-{$_POST["month"]}-$day";
    $weekend_test = (new DateTime($date))->format("w");
    $jF= (new DateTime($date))->format("d");
    $mF= (new DateTime($date))->format("m");
    $an = (new DateTime($date))->format("Y");
    
    $G = ($an%19);
    $C = floor($an/100);
    $H = ($C - floor($C/4) - floor((8*$C+13)/25) + 19*$G + 15)%30;
    $I = $H - floor($H/28)*(1 - floor($H/28)*floor(29/($H + 1))*floor((21 - $G)/11));
    $J = ($an*1 + floor($an/4) + $I + 2 - $C + floor($C/4))%7;
    $L = ($I - $J);
    $MoisPaques = 3 + floor(($L + 40)/44);
    $JoursPaques = $L + 28 - 31*floor($MoisPaques/4);
    
    $dateLp = date_create("$an-$MoisPaques-$JoursPaques");
    $interval1 = new DateInterval('P1D');
    $dateLp->add($interval1);
    $lpJ = strval($dateLp->format('d'));
    $lpM = strval($dateLp->format('m'));

    $dateA = date_create("$an-$MoisPaques-$JoursPaques");
    $interval2 = new DateInterval('P39D');
    $dateA->add($interval2);
    $aJ = strval($dateA->format('d'));
    $aM = strval($dateA->format('m'));

    $dateLpen = date_create("$an-$MoisPaques-$JoursPaques");
    $interval3 = new DateInterval('P50D');
    $dateLpen->add($interval3);
    $lpenJ = strval($dateLpen->format('d'));
    $lpenM = strval($dateLpen->format('m'));

     ?>
    <div class="space day <?=$day==$nowDay?" today":""; ?>
    <?=(($weekend_test=='6')||($weekend_test=='0'))?" weak":""; //weekend?>
    <?=(($jF=='01') and ($mF=='01'))?"ferie":"";//jourAn?>
    <?=((($jF=='01') or ($jF=='08')) and ($mF=='05'))?"ferie":"";//1 et 8 mai?>
    <?=(($jF=='14') and ($mF=='07'))?"ferie":"";//fete national?>
    <?=((($jF=='01') or ($jF=='11')) and ($mF=='11'))?"relg":"";//touissant et armistice?>
    <?=(($jF=='25') and ($mF=='12'))?"relg":"";//noel?>
    <?=(($jF=='15') and ($mF=='08'))?"relg":"";//assomption?>
    <?=(($jF==$lpJ) and ($mF==$lpM))?"relg":"";//lundiPaque?>
    <?=(($jF== $aJ) and ($mF==$aM))?"relg":"";//Ascension?>
    <?=(($jF== $lpenJ) and ($mF==$lpenM))?"relg":"";//LundiPentecote?>

    " data-day="<?=$day?>">
      <div class="calnum"><?=$day?></div>
      <!---AFFICHER TOUS LES EVENEMENTS CORRESPONDANT A CHAQUE JOUR :   --->
        <?php if (isset($events["d"][$day])) { 
          foreach ($events["d"][$day] as $eid) { ?>

        <div class="calevt" data-eid="<?=$eid?>" 
          style="background:<?=$events["e"][$eid]["evt_color"]?>">
          <?=$events["e"][$eid]["evt_title"]?>

        </div>

      <!---AFFICHER LES DONNES D'UN TEL EVENEMENTS : ID,TEXT,COULEUR...    --->
        <?php if ($day == $events["e"][$eid]["first"]) {

          echo "<div id='evt$eid' class='calninja'>".json_encode($events["e"][$eid])."</div>";
        }}
      } 
      ?>
    </div>
          <?php }

    

        


    
    // LES ESPACES APRES LE DERNIER JOUR DU MOIS : 
     $space = $Last_day==0 ? 0 : 6-$Last_day ;
    for ($i=0; $i<$space; $i++) { 
      echo "<div class='space blank'></div>"; }
    








      // FIN DU CODE AJAX !
}

