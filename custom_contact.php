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

function custom_contact_print($atts)
{

		//$atts will for shortcode attributes but we are not using them in this case
		
		if(!is_admin())
	{
	
		
		echo "<h2>Contact Us</h2>";
		echo "<div><form action='' method='post'><legend>Fill in the fields and send</legend>
		<label for='cSubject'>Subject</label><input type='text' name='cSubject' id='cSubject' /><br />
		<label for='cEmail'>Email</label><input type='text' name='cEmail' id='cEmail' /><br />
		<label for='cMessage'>Message</label><textarea name='cMessage' id='cMessage'></textarea><br />
		<input type='submit' name='btnSubmit' id='btnSubmit' value='Send'/>
		</form></div>";
		}
	
}


function custom_contact_menu_page()
{
	echo "<h2>Contact Form Details</h2>";
	echo "<p>Just put this short code in the page you would like to show the contact form [custom_contact]</p>
	<p>Please Note that the info entered on the contact form will be sent 
	to the blog administrators email address <strong>(". get_option('admin_email').")</strong></p>";

}


function custom_contact_menu()
{
	add_menu_page("Contact Form Admin","Custom Contact Form","manage_options","ccf_menu","custom_contact_menu_page");
}

function custom_contact_form_post()
{
	
	//send an email to the blog admin if the send button on contact form is pressed
	if(!is_admin() && isset($_POST['cSubject']))
	{
		$to = get_option('admin_email');
		$subject = $_POST['cSubject'];
		$message = $_POST['cMessage'];

		mail($to,$subject,$message);
	}
}


function custom_contact_activation()
{
	//activation code
}

function custom_contact_deactivation()
{
		//deactivation code

}

//action hooks and filters section
register_activation_hook(__FILE__, 'custom_contact_activation');
register_deactivation_hook(__FILE__, 'custom_contact_deactivation');
add_action("admin_menu","custom_contact_menu");
add_shortcode('custom_contact','custom_contact_print');
custom_contact_form_post();
