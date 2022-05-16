<html>
<?php
function service_collection_table_html(){
  ob_start();
  global $wpdb;
  $table_name = $wpdb->prefix . "services";

//insert commands
if (isset($_POST['insert'])) {
global $wpdb;
$table_commandes = $wpdb->prefix . "commandes";
$commandes = $_POST['commandes'];
foreach($commandes as $key=>$values){
$listofcommandes .= $values.", ";
}



  $wpdb->insert(
      $table_commandes, //table
      array('COMMANDS' => $listofcommandes, 'REF' => ''), //data
      array('%s', '%s') //data format			
  );

  $message.="Commands inserted";

}
$rows = $wpdb->get_results("SELECT ID, TITRE, DESCRIPTION, ICONE, GALLERIE from $table_name");
?>
<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>./service-global/assets/css/custom.css" rel="stylesheet" />
<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/service-global/assets/css/custom_singel.css" rel="stylesheet" />
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

<div class="section" id="section"> 
  <div>
    <p>filter par categorie: 
      <button class="btn">Immobilier</button>
      <button class="btn">Bureautique</button>
      <button class="btn">Informatique</button>
      <button class="btn">Telecom</button>
    </p>  
  </div>
  <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <div class="grids">
      <?php 
      foreach ($rows as $row) {
        ?>
          <div class="grid">
            <span><input type="checkbox" name="commandes[]" class="checkbox" value="<?php echo $row->TITRE; ?>"/><i class="fas fa-unlink"></i>&nbsp;&nbsp;<?php echo $row->TITRE; ?></span>
            <small><?php echo $row->DESCRIPTION; ?></small>
            <a href="javascript:popUp(<?php echo $row->ID; ?>,'<?php echo $row->TITRE; ?>','<?php echo $row->DESCRIPTION; ?>');">En savoir plus</a>
          </div>
      <?php
      }?>
    </div>
    <input type='submit' name="insert" value='Valider la sélection' class='btn-selection'/>
  </form>
</div>

<?php 


        global $wpdb;
        $table_name = $wpdb->prefix . "services";
        $rows = $wpdb->get_results("SELECT ID, TITRE,DESCRIPTION,ICONE,GALLERIE from $table_name");

     ?>
 
<div class="float-container" style="display: none;" id="container"> 
<div class="float-child grid-gallerie">
    <div class="">
    <img class="img-icon" src="<?php echo WP_PLUGIN_URL; ?>/service-global/media/city-solid.svg" alt="">
    <h2 id="titreModal"></h2>
    <div class="bg-image-wrapper">
    <div class="table">
        <div class="row">
            <div class="cell"><img src="<?php echo WP_PLUGIN_URL; ?>/service-global/media/service-media/col1.jpg" alt="" /></div>
            <div class="cell"><img src="<?php echo WP_PLUGIN_URL; ?>/service-global/media/service-media/col2.jpg" alt="" /></div>
        </div>
        <div class="row">
            <div class="cell"><img src="<?php echo WP_PLUGIN_URL; ?>/service-global/media/service-media/col3.jpg" alt="" /></div>
            <div class="cell"><img src="<?php echo WP_PLUGIN_URL; ?>/service-global/media/service-media/col4.jpg" alt="" /></div>
        </div>
    </div>
</div>
    </div>
  </div>
  <div class="float-child grid-details">
    <div class="">
    <span>Détails</span>
    <p id="descriptionModal"></p>
    <label>Options</label><br>
    <select name="option" id="option-select">
        <option value="">100m2 - 2000£/mois </option>
        <option value="">150m2 - 2500£/mois</option>
        <option value="">200m2 - 3000£/mois</option>
    </select><br>
    <label for="story">Besoins supplémentaire</label><br>
    <textarea id="" name=""
          rows="5" cols="33">
    </textarea>
    <button class="btn-ss">Ajouter à la sélection</button>
    </div>
  </div>
</div>
 
<?php
      ?>


<?php
return ob_get_clean();
}
//create shortcode!
add_shortcode('service_collection_table', 'service_collection_table_html');
define('ROOTDIR', plugin_dir_path(__FILE__));

?>
<script>

document.addEventListener('DOMContentLoaded', () => {  
document.getElementById("addCommande").addEventListener("click",function(){

  <?php 
  global $wpdb;
  $table_commandes = $wpdb->prefix . "commandes";
  $wpdb->insert(
      $table_commandes, //table
      array('COMMAND' => "test", 'NUM_COMMAND' => "123", 'DATE_COMMAND' => '', 'TOTAL' => ''), //data
      array('%s', '%s', '%s', '%s') //data format			
  ); ?>
  var markedCheckbox = document.querySelectorAll('.checkbox:checked');
for (var checkbox of markedCheckbox) {
console.log(checkbox.getAttribute('value'))
}
});
});

function popUp(id,titre,description){
  console.log(id,titre,description)
  var container = document.getElementById('container');
  var section = document.getElementById('section');
  container.setAttribute('style', 'display: block');
  section.setAttribute('style','opacity: 1;');
  document.getElementById('titreModal').innerHTML = titre;
  document.getElementById('descriptionModal').innerHTML= description;
}



</script>

