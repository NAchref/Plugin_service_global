<?php
function category_insertion() {
  $id = $_POST["id"];
  $name = $_POST["name"];
  $description = $_POST["description"];
    
	//insert
    if (isset($_POST['insert'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . "categories";
		
		if(!empty($name)){
			
			$wpdb->insert(
					$table_name, //table
					array('NOM' => $name, 'DESCRIPTION' => $description), //data
					array('%s','%s') //data format			
			);
			$message.="La catégorie a bien été ajoutée.";
		
		} else {
			
			
			if(empty($name)){
				$error .= "Veuillez indiquer le nom de la catégorie.<br>";
			}
			
			
		}

    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>./service-global/assets/css/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Ajouter Nouveau Service</h2>
        <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
		<?php if (isset($error)): ?><div class="error"><p><?php echo $error; ?></p></div><?php endif; ?>

        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <table class='wp-list-table widefat fixed'>
                <!--<tr>
                    <th class="ss-th-width">ID</th>
                    <td><input type="text" name="id" value="<?php echo $id; ?>" class="required ss-field-width" /></td>
                </tr>-->
                <tr>
                    <th class="ss-th-width">Saisi le nom de catégorie.</th>
                    <td><input type="text" name="name" value="<?php echo $name; ?>" class="required ss-field-width" /></td>
                </tr>							
				<tr>
                    <th class="ss-th-width">Catégorie description</th>
                    <td><textarea name="description" rows="5" cols="74"><?php echo $description; ?></textarea></td>
                </tr>
            </table>
            <input type='submit' name="insert" value='Enregistre' class='button'>
        </form>
    </div>
    <?php
}