<?php

function services_list() {
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>./service-global/assets/css/style-admin.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="wrap">
        <h2>Services</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
               <!-- <a href="<?php echo admin_url('admin.php?page=services_create'); ?>">Ajouter Nouveau</a> -->
                <button class="btn-service fa fa-plus" onclick="window.location.href='<?php echo admin_url('admin.php?page=services_create'); ?>'" >&nbsp;Ajouter Nouveau service</button>
        </div><br class="clear">        
    </div>
     <?php
        global $wpdb;
        $table_name = $wpdb->prefix . "services";
        $rows = $wpdb->get_results("SELECT ID, TITRE,DESCRIPTION,ICONE,GALLERIE from $table_name");
     ?>
        <table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <!--<th class="manage-column ss-list-width">ID</th>-->
                <th class="manage-column ss-list-width">Nom de service</th>
                <th class="manage-column ss-list-width">Description</th>
				<th class="manage-column ss-list-width">Icone image</th>
				<th class="manage-column ss-list-width">Gallerie Image</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($rows as $row) { ?>
                <tr>
                    <!--<td class="manage-column ss-list-width"><?php echo $row->ID; ?></td>-->
                    <td class="manage-column ss-list-width"><?php echo $row->TITRE; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->DESCRIPTION ;?></td>
					<td class="manage-column ss-list-width"><?php echo $row->ICONE ; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->GALLERIE ; ?></td>
                    <td><button class="btn-update fa fa-fire" onclick="window.location.href='<?php echo admin_url('admin.php?page=services_update&ID=' . $row->ID); ?>'" >&nbsp;Mise a jour</button>
                    <button class="btn-delete btn fa fa-trash" onclick="window.location.href='<?php echo admin_url('admin.php?page=services_update&ID=' . $row->id); ?>'" >&nbsp;Supprimer</button></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <?php
}