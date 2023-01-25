<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['current_session'])) header('Location: ../../index.php');
?>
<html>
  <head>
    <title>Calendar Demo</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="event.css">

    <link rel="stylesheet" href="6-calendar.css">

    <script src="5-calendar.js" defer></script>
    <script src="eventScript.js" defer ></script>

 <body>

<!--button pour afficher les prochain events de l'utilsateur  -->
 <div class="topnav">

        <div class="login-container" >
    <div  style="margin-left:65%;margin-top: 20px;">

       <button onclick="showEvents();called()" class="mod">mes prochaines événements
     </button>

       <button 
       type="submit" class="del"  name="submit" class="mod"><a class="del" href="../logout.php" >
        Se déconnecter</a>
      </button>

    </div>
            </div>
      </div>





    <!-- (A) PERIOD SELECTOR -->

    <div id="calPeriod"><?php
      // (A1) MONTH SELECTOR
      // NOTE: DEFAULT TO CURRENT SERVER MONTH YEAR
      $months = [
        1 => "Janvier", 2 => "Février", 3 => "Mars", 4 => "Avril",
        5 => "Mai", 6 => "Juin", 7 => "Juillet", 8 => "Aout",
        9 => "Septembre", 10 => "Octobre", 11 => "Novembre", 12 => "Decembre"
      ];
      $monthNow = date("m");
      echo "<select id='calmonth'>";
      foreach ($months as $m=>$mth) {
        printf("<option value='%s'%s>%s</option>",
          $m, $m==$monthNow?" selected":"", $mth
        );
      }
      echo "</select>";

      // (A2) YEAR SELECTOR
      echo "<input type='number' id='calyear' value='".date("Y")."'/>";
    ?></div>
    <!--prochains events div -->
<div  class='popup'>
  <div class='popcont'>
            <span class="close">&times;</span>
            <ul id="event-list">
  <li>
  <input type='number' onchange='call()'  id='days_input' value='7'>
  <li>
    <div  class ='champ' id='fork'>
    </div>
    </ul>
                 </div>
  </div>
      <!-- (B) CALENDAR WRAPPER -->

    <div id="calwrap"></div>

    <!-- (C) EVENT FORM -->
    <div id="calblock"><form id="calform">
      <input type="hidden" name="req" value="save"/>
      <input type="hidden" id="evtid" name="eid"/>
      <label for="title">Titre</label>
      <textarea id="evttitle" name="title" required></textarea>
      <label for="place">Lieu</label>
      <textarea id="evtplace" name="place" required></textarea>
      <label for="start">Date Start</label>
      <input type="datetime-local" id="evtstart" name="start" required/>
      <label for="end">Date End</label>
      <input type="datetime-local" placeholder="dd/mm/yyyy" id="evtend" name="end" required/>
      <label for="txt">Description</label>
      <textarea id="evttxt" name="txt" required></textarea>
      <label for="color">Color</label>
      <input type="color" id="evtcolor" name="color" value="#e4edff" required/>
      <input type="submit" id="calformsave" value="save"/>
      <input type="button" id="calformdel" value="Delete"/>
      <input type="button" id="calformcx" value="Cancel"/>
    </form></div>
    
  </body>
</html>
