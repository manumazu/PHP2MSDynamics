<?php

include_once "library/EntityUtils.php";

/**
 * 
 * Examples of queries between Drupal and Dynamic CRM : read, update and create
 * All the datas are managed in input and output with json format (REST simulation) 
 *
 * @author Emmanuel Mazurier <emmanuel.mazurier@gmail.com>
 */

// set MS Dynamics CRM identifiers for authentification
$liveIDUseranme = "";
$liveIDPassword = "";
$CRMUrl = ""; //https://[crm_dynamics_domain]/XRMServices/2011/Organization.svc


//Create a new instance of the CRM Entity
$entity = new EntityUtils($CRMUrl, $liveIDUseranme, $liveIDPassword); 

/****************************
 *		 CRM 2 DRUPAL 		*
 ****************************/

//Example for reading a single value
$contact =  $entity->getEntityData('contact', array('name'=>'contactid', 'value'=>'adac8d0e-decb-e411-ba28-d89d6763fcc4'));
echo(json_encode($contact));

//Example for collecting range of values (condition : updated after)
/*$contacts =  $entity->getEntityData('contact', array(
			array('name'=>'modifiedon', 'value'=>'YYYY-MM-DD', 'op'=>'on-or-after'),
			), null, null, '5000');*/


/****************************
 *		 DRUPAL 2 CRM 		*
 ****************************/

//Simulate json Drupal api's output 
//array as : array([drupal_table_name] => array([field_name] =>[value]))
$drupal_response = '{"users":{"access":"20150315","name":"test create","created":"20150315","status":1,"field_guid_value":"40F21221-64E3-4033-BB53-216EF2837BF3"}}';

//Example to create a new record in MS Dynamics CRM, in the contact entity

//$new_CRMID = $entity->createEntityData('contact',json_decode($drupal_response, true));
//echo $new_CRMID;


//Example to update a record in MS Dynamics CRM, in the contact entity

//$entity->updateEntityData('contact',json_decode($drupal_response, true));


?>
