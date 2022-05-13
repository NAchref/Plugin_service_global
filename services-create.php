<?php

function services_create() {
  $id = $_POST["id"];
  $titre = $_POST["titre"];
  $description = $_POST["description"];
  $image_gallerie = $_POST["image_gallerie"];


  $icone = $_FILES["icone"]["name"];
  $tmp_icone_img = $_FILES["icone"]["tmp_name"];
  $path = "\wp-content\plugins\service-global\upload\ ";


  
 

  global $wpdb;
  $table_categories = $wpdb->prefix . "categories";
         

  $rows = $wpdb->get_results("SELECT ID, NOM from $table_categories");
    //insert services
    if (isset($_POST['insert'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . "services";
        

        
		
		if(!empty($titre)){

            move_uploaded_file($tmp_icone_img,ABSPATH.$path.$icone);
			$wpdb->insert(
					$table_name, //table
					array('TITRE' => $titre, 'DESCRIPTION' => $description,'ICONE' => $icone ,'GALLERIE' => $image_gallerie), //data
					array('%s', '%s', '%s', '%s', '%s') //data format

                    			
			);
			$message.="Service inserted";
		
		} else {
			if(empty($titre)){
				$error .= "S il vous plait insere nom<br>";
			}
		}

    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>./service-global/assets/css/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Ajouter Nouveau Service</h2>
        <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
		<?php if (isset($error)): ?><div class="error"><p><?php echo $error; ?></p></div><?php endif; ?>

        <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <table class='wp-list-table widefat fixed'>
                <!--<tr>
                    <th class="ss-th-width">ID</th>
                    <td><input type="text" name="id" value="<?php echo $id; ?>" class="required ss-field-width" /></td>
                </tr>-->
				        <tr>
                    <th class="ss-th-width">Service</th>
                    <td><input type="text" name="titre"  value="<?php echo $titre; ?>" class="required ss-field-width" /></td>
                </tr>
				
				<tr>
                    <th class="ss-th-width">Service icone</th>
                    <td><input type="file" name="icone"  value="<?php echo $icone; ?>" class="required ss-field-width" /></td>
                </tr>
				
			         	<tr>

                    <th class="ss-th-width">Service gallerie</th>
                    <td><input type="text" name="image_gallerie"  value="<?php echo $image_gallerie; ?>" class="required ss-field-width" /></td>
                </tr>											
				        <tr>
                    <th class="ss-th-width">Service description</th>
                    <td><textarea name="description" rows="5" cols="74"><?php echo $description; ?></textarea></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Choisissez la catégorie de votre service</th>
                    <td>
                        <?php foreach ($rows as $row) { ?>
                        <!--<td class="manage-column ss-list-width"><?php echo $row->ID; ?></td>-->
                            <label class="lab-wid"><?php echo $row->NOM; ?></label>
                            <input type="checkbox" name="categorie" value="<?php echo $row->NOM; ?>"><br><br>
                        <?php } ?>

                </tr>
            </table>
            <input type='submit' name="insert" value='Enregistre' class='button'>
        </form>
    </div>
    <?php
}