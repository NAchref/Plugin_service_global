<?php

function singel_page_service_html(){
  ob_start();

  global $wpdb;
  $table_name = $wpdb->prefix . "service";
  $id = $_GET["id"];
  
  $row = $wpdb->get_results("SELECT id,titre,description,categorie,icone,image_gallerie from $table_name WHERE id = %s", $id);

?>
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/service-global/assets/css/custom_singel.css" rel="stylesheet" />


<div class="float-container"> 
<div class="float-child grid-gallerie">
    <div class="">
    <img class="img-icon" src="<?php echo WP_PLUGIN_URL; ?>/service-global/media/city-solid.svg" alt="">
    <h2>Location de bureau</h2>
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
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita quasi nulla eum delectus adipisci. Totam molestias saepe, quidem dolorum accusantium optio, sequi explicabo possimus odio nulla odit sed vero ipsumectus adipisci saepe, quidem dolorum accusantium optio, sequi explicabo possimus odio nulla odit sed vero ipsum.</p>
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
return ob_get_clean();
}

//create shortcode!
add_shortcode('service_singel_page', 'singel_page_service_html');

?>