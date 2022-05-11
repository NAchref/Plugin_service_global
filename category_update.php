<?php

function category_update() {
    global $wpdb;
    $table_name = $wpdb->prefix . "category";
    $id = $_GET["id"];
    $name = $_POST["name"];
	$description = $_POST["description"];

//update
    if (isset($_POST['update'])) {
        
		if(!empty($titre) /*&& !empty($type) && !empty($price)*/){
			
			$wpdb->update(
					$table_name, //table
					array('Titre' => $titre, 'description' => $description), //data
					array('ID' => $id), //where
					array('%s', '%s'), //data format
					array('%s') //where format
			);
		
		} else {
			
			if(empty($name)){
				$error .= "Veuillez indiquer le nom de la catégorie<br>";
			}
			
			
		}
    }
//delete
    else if (isset($_POST['delete'])) {
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %s", $id));
    } else {//selecting value to update	
        $categories = $wpdb->get_results($wpdb->prepare("SELECT id,name,description from $table_name where id=%s", $id));
      foreach ($categories as $s) {
      $name = $s->name;
			$description = $s->description;
        }
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>./service-global/assets/css/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Categories</h2>
		
		<?php if ($_POST['delete'] && !isset($error)) { ?>
            <div class="updated"><p>Categorie deleted</p></div>
            <a href="<?php echo admin_url('admin.php?page=categories_list') ?>">&laquo; Retour à la liste des categories</a>

        <?php } else if ($_POST['update'] && !isset($error)) { ?>
            <div class="updated"><p>Categorie updated</p></div>
            <a href="<?php echo admin_url('admin.php?page=categories_list') ?>">&laquo; Retour à la liste des categories</a>

        <?php } else { ?>
		
			<?php if (isset($error)): ?><div class="error"><p><?php echo $error; ?></p></div><?php endif; ?>
			
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <table class='wp-list-table widefat fixed'>
                    <tr><th>Nom categorie</th><td><input type="text" name="name" value="<?php echo $name; ?>"/></td></tr>
					<tr>
						<th class="ss-th-width">Categorie Description</th>
						<td><textarea name="description" rows="5" cols="60"><?php echo $description; ?></textarea></td>
					</tr>
				</table>
                <input type='submit' name="update" value='Save' class='button'> &nbsp;&nbsp;
                <input type='submit' name="delete" value='Delete' class='button' onclick="return confirm('Categorie supprimer')">
            </form>
        <?php } ?>

    </div>
    <?php
}