<?php
/*
Plugin Name: Service Global Courtier
Description: a peronal specific plugin for global courtier services
Version: 1.0.0
Author: Nefzaoui Achref
Author URI: https://nefzaouiachref.com
*/


defined('ABSPATH') or die('Hey, you cant access here! ');

// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'ss_options_install');
register_deactivation_hook(__FILE__, 'options_desinstall');


// FUNCTION TO CREATE DATABASE USING ACTIVATION HOOK				
function ss_options_install() {

    global $wpdb;

		$table_services 	= $wpdb->prefix . "services";
		$table_categories	= $wpdb->prefix . "categories";
		$table_commandes	= $wpdb->prefix . "commandes";
		$table_commandes_services = $wpdb->prefix . "commandes_services";
		$table_optionservices = $wpdb->prefix . "optionservices";
		$table_options_services = $wpdb->prefix . "options_services";
		$table_services_categories = $wpdb->prefix . "services_categories";
	
    $charset_collate = $wpdb->get_charset_collate();
	

	  //CREATION DATABASE USING SQL	
    $sql_categories = "CREATE TABLE IF NOT EXISTS $table_categories (
			`ID` int(11) NOT NULL AUTO_INCREMENT,
			`NOM` varchar(200) NOT NULL,
			`DESCRIPTION` text NOT NULL,
			PRIMARY KEY (`ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		
		//CREATION TABLE COMMANDES	
		$sql_commandes ="CREATE TABLE IF NOT EXISTS $table_commandes (
			`ID` int(11) NOT NULL AUTO_INCREMENT,
			`COMMANDS` varchar(500) NOT NULL,
			`REF` varchar(100) NOT NULL,
			`DATE_COMMAND` datetime NOT NULL,
			PRIMARY KEY (`ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		
		//CREATION TABLE ASSOCIATION COMMANDES & SERVICES
		$sql_commandes_services = " CREATE TABLE IF NOT EXISTS $table_commandes_services (
			`ID` int(11) NOT NULL AUTO_INCREMENT,
			`CMD_ID` int(11) NOT NULL,
			`SERVICE_ID` int(11) NOT NULL,
			PRIMARY KEY (`ID`),
			KEY `CMD_ID` (`CMD_ID`),
			KEY `SERVICE_ID` (`SERVICE_ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		
		//CREATION TABLE OPTIONS DE SERVICE 
		$sql_optionservices = "CREATE TABLE IF NOT EXISTS $table_optionservices (
			`ID` int(11) NOT NULL AUTO_INCREMENT,
			`DESCRIPTION` varchar(350) NOT NULL,
			`PRICE` float NOT NULL,
			PRIMARY KEY (`ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

		//CREATION TABLE ASSOCIATION OPTIONS & SERVICES
		$sql_options_services = "CREATE TABLE IF NOT EXISTS $table_options_services (
			`ID` int(11) NOT NULL AUTO_INCREMENT,
			`OPTIONS_ID` int(11) NOT NULL,
			`SERVICE_ID` int(11) NOT NULL,
			PRIMARY KEY (`ID`),
			KEY `OPTIONS_ID` (`OPTIONS_ID`),
			KEY `SERVICE_ID` (`SERVICE_ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

		//CREATION TABLE SERVICES
		$sql_services = "CREATE TABLE IF NOT EXIST $table_services (
			`ID` int(11) NOT NULL AUTO_INCREMENT,
			`TITRE` varchar(200) NOT NULL,
			`DESCRIPTION` text NOT NULL,
			`ICONE` varchar(200) NOT NULL,
			`GALLERIE` varchar(200) NOT NULL,
			PRIMARY KEY (`ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;" ;
		
	  //CREATION TABLE ASSOCIATION SERVICES & CATEGORIES
		$sql_services_categories = "CREATE TABLE IF NOT EXISTS $table_services_categories (
			`ID` int(11) NOT NULL AUTO_INCREMENT,
			`CAT_ID` int(11) NOT NULL,
			`SERVICE_ID` int(11) NOT NULL,
			PRIMARY KEY (`ID`),
			KEY `CAT_ID` (`CAT_ID`),
			KEY `SERVICE_ID` (`SERVICE_ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

		
		
		// Contraintes pour les tables déchargées
		
		
		
		$sql_c1 = "ALTER TABLE `wp_commandes_services`
			ADD CONSTRAINT `wp_commandes_services_ibfk_1` FOREIGN KEY (`SERVICE_ID`) REFERENCES `wp_services` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
			ADD CONSTRAINT `wp_commandes_services_ibfk_2` FOREIGN KEY (`CMD_ID`) REFERENCES `wp_commandes` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;";
		
		
		// Contraintes pour la table `wp_options_services`
		

		$sql_c2 = "ALTER TABLE `wp_options_services`
			ADD CONSTRAINT `wp_options_services_ibfk_1` FOREIGN KEY (`OPTIONS_ID`) REFERENCES `wp_optionservices` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
			ADD CONSTRAINT `wp_options_services_ibfk_2` FOREIGN KEY (`SERVICE_ID`) REFERENCES `wp_services` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;";
		
		
		//Contraintes pour la table `wp_services_categories`
		

		$sql_c3 = "ALTER TABLE `wp_services_categories`
			ADD CONSTRAINT `wp_services_categories_ibfk_1` FOREIGN KEY (`CAT_ID`) REFERENCES `wp_categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
			ADD CONSTRAINT `wp_services_categories_ibfk_2` FOREIGN KEY (`SERVICE_ID`) REFERENCES `wp_services` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;";
		

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    dbDelta($sql_categories);
		dbDelta($sql_commandes);
		dbDelta($sql_commandes_services);
		dbDelta($sql_optionservices);
		dbDelta($sql_options_services);
		dbDelta($sql_services);
		dbDelta($sql_services_categories);
		dbDelta($sql_c1);
		dbDelta($sql_c2);
		dbDelta($sql_c3);

}


function options_desinstall(){

	global $wpdb;

	$table_name = $wpdb->prefix . "SERVICE";
	$sql = "DROP TABLE $table_name";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

}


//menu items
add_action('admin_menu','chints_courses_modifymenu');


function chints_courses_modifymenu() {
	
	//this is the main item for the menu
	add_menu_page('Services', //page title
	'Services', //menu title
	'manage_options', //capabilities
	'services_list', //menu slug
	'services_list',//function
	plugins_url('service-global/media/icon_2.png',__DIR__),
	'10'
);
	
	//this is a submenu
	add_submenu_page('services_list', //parent slug
	'Ajouter Nouveau Service', //page title
	'Ajouter', //menu title
	'manage_options', //capability
	'services_create', //menu slug
	'services_create'); //function

	add_submenu_page('services_list', //parent slug
	'Categories', //page title
	'Catégories', //menu title
	'manage_options', //capability
	'categorie_list', //menu slug
	'categorie_list'); //function

	add_submenu_page('services_list', //parent slug
	'commandes', //page title
	'Commandes', //menu title
	'manage_options', //capability
	'services_update', //menu slug
	'services_update'); //function

	//this is a submenu
	add_submenu_page('services_list', //parent slug
	'Ajouter Nouveau Categorie', //page title
	'', //menu title
	'manage_options', //capability
	'category_insertion', //menu slug
	'category_insertion'); //function

}

function online_form_course_fields_js($atts = []){
ob_start();
?>
<?php
global $wpdb;
$table_name = $wpdb->prefix . "service";

$rows = $wpdb->get_results("SELECT id,titre,description,categorie,icone,image_gallerie from $table_name");


foreach ($rows as $row) { ?>
	<input type="hidden" name="<?php echo $row->id."_1"; ?>" id="price_<?php echo $row->id."_1"; ?>" value="<?php echo (($row->categorie) > 0 ? $row->categorie : 'NA' ) ?>" />
	<input type="hidden" name="<?php echo $row->id."_2"; ?>" id="price_<?php echo $row->id."_2"; ?>" value="<?php echo (($row->icone) > 0 ? $row->icone : 'NA' ) ?>" />
	<input type="hidden" name="<?php echo $row->id."_3"; ?>" id="price_<?php echo $row->id."_3"; ?>" value="<?php echo (($row->image_gallerie) > 0 ? $row->image_gallerie : 'NA' ) ?>" />
<?php } 

$services_data = json_encode($wpdb->get_results("SELECT id,titre from $table_name"));
?>

<?php
return ob_get_clean();
}
add_shortcode('online_form_course_fields', 'online_form_course_fields_js');


define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'services-list.php');
require_once(ROOTDIR . 'services-create.php');
require_once(ROOTDIR . 'services-update.php');
require_once(ROOTDIR . 'category_list.php');
require_once(ROOTDIR . 'category_insertion.php');
require_once(ROOTDIR . 'template/services_collection.php');
require_once(ROOTDIR . 'template/singel_page_service.php');

