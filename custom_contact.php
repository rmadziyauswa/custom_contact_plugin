<?php
/*
Plugin Name: Custom Contact Form
Plugin URI: http://www.rennie.kozmikinc.com
Description: A very basic contact form.
Version: 1.0.0
Author: Ransome Madziyauswa
Author URI:  http://www.rennie.kozmikinc.com
License: GPL
*/

/*
This program is free software; you can redistribute it 
*/


function custom_contact_print()
{

	if(!is_admin())
	{
		echo "<h2>Contact Us</h2>";
		echo "<div><form action='sendcontact.php' method='post'><legend>Fill in the fields and send</legend>
		<label for='cName'>Full Name</label><input type='text' name='cName' id='cName' />
		<label for='cEmail'>Email</label><input type='text' name='cEmail' id='cEmail' />
		<label for='cMessage'>Message</label><textarea name='cMessage' id='cMessage'></textarea>
		<input type='submit' name='btnSubmit' id='btnSubmit' value='Send'/>
		</form></div>";
		}
	
}


function custom_contact_menu_page()
{
	echo "<h2>Contact Form Entries</h2>";
	echo "<table><tr><th>Name</th><th>Email</th><th>Message</th></tr></table>";
}


function custom_contact_menu()
{
	add_menu_page("Contact Form Admin","Custom Contact Form","manage_options","ccf_menu","custom_contact_menu_page");
}

register_activation_hook(__FILE__,'custom_contact_db_create');
register_deactivation_hook(__FILE__,'custom_contact_db_drop');
add_action("init","custom_contact_print");
add_action("admin_menu","custom_contact_menu");

function custom_contact_db_create()
{
	global $wpdb;
	
	$tablename = $wpdb->prefix."custom_contact";
	
	if($wpdb->get_var('SHOW TABLES LIKE '.$tablename) != $tablename)
	{
		$sql = 'CREATE TABLE '. $tablename .'(
		id INT UNSIGNED AUTO_INCREMENT,
		ptime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		fullname VARCHAR(100),
		email VARCHAR(50),
		message VARCHAR(255),
		PRIMARY KEY (id)
		)';
		
		require_once(ABSPATH.'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		
	}
}


function custom_contact_db_drop()
{
	global $wpdb;
	$wpdb->get_var('DROP TABLE '.$tablename) ;
}
