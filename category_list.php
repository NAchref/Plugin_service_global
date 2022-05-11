<?php
function categorie_list() {
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>./service-global/assets/css/style-admin.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="wrap">
        <h2>Catégories</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <button class="btn-service fa fa-plus" onclick="window.location.href='<?php echo admin_url('admin.php?page=category_insertion'); ?>'" >&nbsp;Ajouter Nouveau catégorie</button>
        </div><br class="clear">        
    </div>
        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . "categories";
        $rows = $wpdb->get_results("SELECT NOM, DESCRIPTION FROM $table_name");
        ?>
        <table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <!--<th class="manage-column ss-list-width">ID</th>-->
                <th class="manage-column ss-list-width">Nom de catégorie</th>
                <th class="manage-column ss-list-width">Description</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($rows as $row) { ?>
                <tr>
                    <!--<td class="manage-column ss-list-width"><?php echo $row->id; ?></td>-->
                    <td class="manage-column ss-list-width"><?php echo $row->NOM; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->DESCRIPTION ;?></td>
                    <td><button class="btn-update fa fa-fire" onclick="window.location.href='<?php echo admin_url('admin.php?page=categories_update&id=' . $row->id); ?>'" >&nbsp;Mise a jour</button>
                    <button class="btn-delete btn fa fa-trash" onclick="window.location.href='<?php echo admin_url('admin.php?page=services_update&id=' . $row->id); ?>'" >&nbsp;Supprimer</button></td>
            <?php } ?>
        </table>
    </div>
 
 <?php
}