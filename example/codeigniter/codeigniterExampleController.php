<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class codeigniterExampleController extends CI_Controller {

	/*******************************************/
	/*******	 Add contact in a list 	********/
	/*******************************************/

	function add_contact() {

        require_once('application/libraries/active-campaign/includes/ActiveCampaign.class.php');
	    $ac = new ActiveCampaign("https://example.api-us1.com", "e58b452sfw32fsdbgty5308e4e927e1fabb380a08b854hkri5we4g515d900bc29c2d0");

		$email = 'mrtest@gmail.com';
		$firstName = 'Mr';
		$lastName = 'Test';
		$phone = '+88*********';
		$contactListId = 3;

		$contact = array(
		    "email"              		=> $email,
		    "first_name"              	=> $firstName,
		    "last_name"              	=> $lastName,
		    "phone"              		=> $phone,
		    "p[{$contactListId}]"       => $contactListId,
		    "status[{$contactListId}]"  => 1, // "Active" status
		);

		$contact_sync = $ac->api("contact/sync", $contact);

		echo '<pre>';
		print_r($contact_sync);

	}


	/***************************************************************/
	/*******	 Add contact in a list with custom field 	********/
	/***************************************************************/

	function add_contact_with_custom_field() {

        require_once('application/libraries/active-campaign/includes/ActiveCampaign.class.php');
	    $ac = new ActiveCampaign("https://example.api-us1.com", "e58b452sfw32fsdbgty5308e4e927e1fabb380a08b854hkri5we4g515d900bc29c2d0");

		$email = 'mrtest@gmail.com';
		$firstName = 'Mr';
		$lastName = 'Test';
		$phone = '+88*********';
		$contactListId = 3;

		$contact = array(
		    "email"              		=> $email,
		    "first_name"              	=> $firstName,
		    "last_name"              	=> $lastName,
		    "phone"              		=> $phone,
		    "p[{$contactListId}]"       => $contactListId,
		    "status[{$contactListId}]"  => 1, // "Active" status
		);

		$paidUserURL = "https://example.com/meal-plan/".md5($email);

		$contact['field'] = array(
			'%URL%,0' => $paidUserURL,
		);

		$contact_sync = $ac->api("contact/sync", $contact);

		echo '<pre>';
		print_r($contact_sync);

	}


	/***************************************************************/
	/***********	 Get all contacts for a specific list 	********/
	/***************************************************************/

	function get_all_contact() {

        require_once('application/libraries/active-campaign/includes/ActiveCampaign.class.php');
	    $ac = new ActiveCampaign("https://example.api-us1.com", "e58b452sfw32fsdbgty5308e4e927e1fabb380a08b854hkri5we4g515d900bc29c2d0");

		$list_id = 3;
		$ac->version(2);
		$contacts_view = $ac->api("contact/list?listid=".$list_id."&limit=2000");
		$allData = json_decode($contacts_view);

		echo '<pre>';
		print_r($allData);

	}


	// For more example checkout "example/row-php/rowphp-example.php"


}
