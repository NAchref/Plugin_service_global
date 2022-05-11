<?php
/**
 * @package service-global
 */
?>

<?php
function service_collection_table_html(){
  ob_start();
  global $wpdb;
  $table_name = $wpdb->prefix . "services";

//insert commands
if (isset($_POST['insert'])) {
global $wpdb;
$table_commandes = $wpdb->prefix . "commandes";
$command = $_POST["titre"];
$NUM_COMMAND = rand();

if(!empty($titre)){
  $wpdb->insert(
      $table_commandes, //table
      array('COMMAND' => $command, 'NUM_COMMAND' => $NUM_COMMAND, 'DATE_COMMAND' => '', 'TOTAL' => ''), //data
      array('%s', '%s', '%s', '%s') //data format			
  );
  $message.="Commands inserted";
} else {
  if(empty($titre)){
    $error .= "S'il vous plait insérer au moins un service<br>";
  }
}
}
$rows = $wpdb->get_results("SELECT ID, TITRE, DESCRIPTION, ICONE, GALLERIE from $table_name");
?>
<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>./service-global/assets/css/custom.css" rel="stylesheet" />
<div class="section"> 
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
            <span><input type="checkbox" name="titre" class="checkbox" value="<?php echo $row->titre; ?>"/><i class="fas fa-unlink"></i>&nbsp;&nbsp;<?php echo $row->TITRE; ?></span>
            <small><?php echo $row->DESCRIPTION; ?></small>
            <a href="<?php echo ''; ?>">En savoir plus</a>
          </div>
      <?php
      }?>
    </div>
    <input type='submit' name="insert" value='Valider la sélection' class='btn-selection'>
  </form>
</div>
<?php
return ob_get_clean();
}
//create shortcode!
add_shortcode('service_collection_table', 'service_collection_table_html');
define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'template/singel_page_service.php');

?>