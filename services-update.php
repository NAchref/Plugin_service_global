<?php

function services_update() {

    global $wpdb;
    $table_name = $wpdb->prefix . "services";

    $id = $_GET["ID"];
    $titre = $_POST["titre"];
	  $description = $_POST["description"];
	  $icone = $_POST["icone"];
	  $image_gallerie = $_POST["image_gallerie"];


//update
    if (isset($_POST['update'])) {
  
			if(!empty($titre) /*&& !empty($type) && !empty($price)*/){
				$wpdb->update(
						$table_name, //table
						array('TITRE' => $titre, 'DESCRIPTION' => $description, 'ICONE' => $icone, 'GALLERIE' => $image_gallerie), //data
						array('ID' => $id), //where
						array('%s', '%s', '%s', '%s'), //data format
						array('%s') //where format
				);
			
			} else {
				
				if(empty($titre)){
					$error .= "S il vous plait saisir titre<br>";
				}	
			}
    }
    //delete services 
    else if (isset($_POST['delete'])) {
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %s", $id));
    } else {//selecting value to update	
        $services = $wpdb->get_results($wpdb->prepare("SELECT ID, TITRE, DESCRIPTION, ICONE, GALLERIE from $table_name where ID=%s", $id));

      foreach ($services as $s) {
      $titre = $s->titre;
			$description = $s->description;
			$icone = (($s->icone) > 0 ? $s->icone : '' );
			$image_gallerie = (($s->image_gallerie) > 0 ? $s->image_gallerie : '' );
        }
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>./service-global/assets/css/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Services</h2>
					<?php if ($_POST['delete'] && !isset($error)) { ?>
									<div class="updated"><p>Services deleted</p></div>
									<a href="<?php echo admin_url('admin.php?page=services_list') ?>">&laquo; Retour à la liste des services</a>
					<?php } else if ($_POST['update'] && !isset($error)) { ?>
							<div class="updated"><p>Services updated</p></div>
							<a href="<?php echo admin_url('admin.php?page=services_list') ?>">&laquo; Retour à la liste des services</a>

        <?php } else { ?>
			<?php if (isset($error)): ?><div class="error"><p><?php echo $error; ?></p></div><?php endif; ?>
			
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <table class='wp-list-table widefat fixed'>
                    <tr><th>Titre</th><td><input type="text" name="titre" value="<?php echo $titre; ?>"/></td></tr>
										<tr>
											<th class="ss-th-width">Service icone</th>
											<td><input type="text" name="icone"  value="<?php echo $icone; ?>" class="required ss-field-width" /></td>
									</tr>				
									<tr>
										<th class="ss-th-width">Service gallerie</th>
										<td><input type="text" name="image_gallerie" value="<?php echo $image_gallerie; ?>" class="required ss-field-width" /></td>
									</tr>
									<tr>
										<th class="ss-th-width">Service Description</th>
										<td><textarea name="description" rows="5" cols="60"><?php echo $description; ?></textarea></td>
									</tr>
								</table>
                <input type='submit' name="update" value='Save' class='button'> &nbsp;&nbsp;
                <input type='submit' name="delete" value='Delete' class='button' onclick="return confirm('service supprimer')">
            </form>
        <?php } ?>

    </div>
    <?php
}