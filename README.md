# Active-campaign API

I'm showing you how to use some basic part of active-campaign API like List, Contact, Contact Field, Contact Custom Field, Tag etc.

Follow This 3 steps :

	1. Requirements
	2. Initialization
	3. Code

> NB : Download & Check "example" folder When you finish reading this.

### Requirements :

	*) Download "active-campaign" package from this repository.

	*) Create and verify your active campaign account
	*) Get both "URL" & "KEY" from - Active campaign "dashboard->settings->developer"

		For Example:
		URL : https://example.api-us1.com
		Key : e58b452sfw32fsdbgty5308e4e927e1fabb380a08b854hkri5we4g515d900bc29c2d0

### Initialization :

	*) Extract/Unzip "active-campaign" file & kepp it any folder of your directory.
	*) Then load/include this folder in your php file where you want to write code for active-campaign.
	
		For example :

		In codeigniter, i put "active-campaign" package into "application/libraries" folder.
	    require_once('application/libraries/active-campaign/includes/ActiveCampaign.class.php');

	*) Make an object

		For example:

		$ac = new ActiveCampaign("https://example.api-us1.com", "e58b452sfw32fsdbgty5308e4e927e1fabb380a08b854hkri5we4g515d900bc29c2d0");
	    // $ac = new ActiveCampaign("URL", "KEY");

### Code :

I'm showing you some example of code for active campaign. You can use it for php, Codeigniter, Laravel or any type of php related language.

For core php follow this below code :

	<?php

		require_once('active-campaign/includes/ActiveCampaign.class.php');
		$ac = new ActiveCampaign("https://example.api-us1.com", "e58b452sfw32fsdbgty5308e4e927e1fabb380a08b854hkri5we4g515d900bc29c2d0");
		// $ac = new ActiveCampaign("URL", "KEY");

		$email = 'mrtest@gmail.com';
		$firstName = 'Mr';
		$lastName = 'Test';
		$phone = '+88*********';
		$contactListId = 3;


		/***********************************************************************/
		/****************		Add contact in a list 	****************/
		/**********************************************************************/

		$contact = array(
		    "email"              		=> $email,
		    "first_name"              	=> $firstName,
		    "last_name"              	=> $lastName,
		    "phone"              		=> $phone,
		    "p[{$contactListId}]"       => $contactListId,
		    "status[{$contactListId}]"  => 1, // "Active" status
		);
		$contact_sync = $ac->api("contact/sync", $contact);



		/**************************************************************************/
		/****************		Update contact from a list 	***********/
		/**************************************************************************/

		$contact = array(
		    "email"              		=> $email,
		    "first_name"              	=> $firstName,
		    "last_name"              	=> $lastName,
		    "phone"              		=> $phone,
		    "p[{$contactListId}]"       => $contactListId,
		    "status[{$contactListId}]"  => 1, // "Active" status
		);
		$contact_sync = $ac->api("contact/sync", $contact);



		/***********************************************************************/
		/*******	 Add contact in a list with custom field 	********/
		/***********************************************************************/

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


		/*******************************************************************/
		/*********	 Update contact in a list with custom field  *******/
		/*******************************************************************/

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


		/***************************************************************/
		/***********	 Get all contacts for a specific list 	********/
		/***************************************************************/

		$list_id = 3;
		$ac->version(2);
		$contacts_view = $ac->api("contact/list?listid=".$list_id."&limit=2000");
		$allData = json_decode($contacts_view);

		echo '<pre>';
		print_r($allData);


		/*******************************************************************/
		/*****	 Delete contact by contact id from a specific list 	****/
		/*******************************************************************/

		$list_id = 3;
		$contactId = 3;
		$result = $ac->api("contact/delete?listid=".$list_id."&id=".$contactId);

		echo '<pre>';
		print_r($result);



		/***************************************************************/
		/******	 Delete contact by email from a specific list 	********/
		/***************************************************************/

		$list_id = 3;
		$deleted_email = 'example@gmail.com';

		$ac->version(2);
		$contacts_view = $ac->api("contact/list?listid=".$list_id."&limit=2000");
		$allData = json_decode($contacts_view);

		$removeListId = 0;
		$total = $allData->total;
		if($total > 0){    
			foreach($allData->contacts as $newData){
				if($newData->email == $deleted_email){
					$removeListId = $newData->id;
				}
			}
		}
		$result = $ac->api("contact/delete?listid=".$list_id."&id=".$removeListId);

		echo '<pre>';
		print_r($result);




		/******************************************************************/
		/**********	 Add tag in a contact Using Curl 	***********/
		/******************************************************************/

		$url = 'https://example.api-us1.com';
		$params = array(
		    'api_key'      => 'e58b452sfw32fsdbgty5308e4e927e1fabb380a08b854hkri5we4g515d900bc29c2d0',
		    'api_action'   => 'contact_tag_add',
		    'api_output'   => 'serialize',
		);

		$nonPaidUserURL = "https://example.com/panel/key";
		$post = array(
		    //'id' => 12, // contact ID (pass this OR the contact email address)
		    'email' => $email, // contact email address (pass this OR the contact ID)
		    'tags' => $nonPaidUserURL,
		);


		customCurlRequest($url,$params,$post);

		function customCurlRequest($url,$params,$post){
			$query = "";
			foreach( $params as $key => $value ) $query .= urlencode($key) . '=' . urlencode($value) . '&';
			$query = rtrim($query, '& ');
			$data = "";
			foreach( $post as $key => $value ) $data .= urlencode($key) . '=' . urlencode($value) . '&';
			$data = rtrim($data, '& ');
			$url = rtrim($url, '/ ');
			if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');
			if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
			    die('JSON not supported. (introduced in PHP 5.2.0)');
			}
			$api = $url . '/admin/api.php?' . $query;
			$request = curl_init($api);
			curl_setopt($request, CURLOPT_HEADER, 0);
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($request, CURLOPT_POSTFIELDS, $data);
			curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
			$response = (string)curl_exec($request);
			curl_close($request);
		}

	?>

	For Codeigniter follow the below code :

	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class codeigniterExampleController extends CI_Controller {


		/************************************************/
		/*******	 Add contact in a list 	*********/
		/************************************************/

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


		/***********************************************************************/
		/*******	 Add contact in a list with custom field 	********/
		/***********************************************************************/

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


		For more example checkout "example/row-php/rowphp-example.php"


	}

	?>
