<?php 

/**
 * Models
 * 
 * Describe Dynamics CRM and Drupal default models and the correspondance between them
 * The Drupal's module must use a dynamic way to define them
 * 
 * @author Emmanuel Mazurier <emmanuel.mazurier@gmail.com>
 */

class Models {

	/**
	* Get default CRM list fields for contact, address, account models
	*/

	public static function getCrmModel($entity) {

	$tab_contact = array(
		'modifiedon', 
		'gendercode', 
		'haschildrencode', 
		'familystatuscode',
		'educationcode', 
		'lastname', 
		'donotpostalmail', 
		'donotphone', 
		'preferredcontactmethodcode', 
		'firstname', 
		'donotemail', 
		'fullname', 
		'statuscode', 
		'createdon', 
		'donotsendmm', 
		'donotfax', 
		'modifiedby', 
		'donotbulkemail', 
		'shippingmethodcode', 
		'statecode', 
		'contactid', 
		'donotbulkpostalmail',
		'birthdate',
		'jobtitle',
		'mobilephone',
		'emailaddress1',
		'emailaddress2',
		'telephone2',
		'telephone1',
	);

	$tab_customeraddress = array(
		'customeraddressid',
		'latitude',
		'line1',
		'line2',
		'line3',
		'postalcode',
		'city',
		'country',
		'county',
		'fax',
		'longitude',
		'name',
		'telephone1',
		'telephone2',
		'telephone3'
	);

	$tab_account = array('accountid',
		'name',
		'description',
		'industrycode',
		'address1_addressid',
		'address1_city',
		'address1_country',
		'address1_county',
		'address1_fax',
		'address1_latitude',
		'address1_line1',
		'address1_line2',
		'address1_line3',
		'address1_longitude',
		'address1_name',
		'address1_postalcode',
		'address1_telephone1',
		'address1_telephone2',
		'address1_telephone3',
		'address2_addressid',
		'address2_addresstypecode',
		'address2_addresstypecodename',
		'address2_city',
		'address2_country',
		'address2_county',
		'address2_fax',
		'address2_latitude',
		'address2_line1',
		'address2_line2',
		'address2_line3',
		'address2_longitude',
		'address2_name',
		'address2_postalcode',
		'address2_telephone1',
		'address2_telephone2',
		'address2_telephone3',
		'emailaddress1',
		'emailaddress2',
		'emailaddress3',
		'telephone1',
		'telephone2',
		'telephone3',
		'sic',
		'numberofemployees',
		'websiteurl');

	$tab = 'tab_'.$entity;
	if(isset($$tab))
		return $$tab;

	}


/**
* set correspondance fields as Drupal's fieldName => array(CRM's fieldname, type of field, name of the linked table if needed)
* managed values for "type" : dateTime, OptionSetValue, string, EntityReference, guid, boolean, int
* when type is defined as EntityReference a "reference" value to the linked table name must be given
*/
function getDrupalModel($entity) {

	//users
	$tab_users = array( 
		'uid' => array('fieldname' => 'new_drupal_uid', 'type' => 'int'),//custom CRM field to stock drupal's uid in CRM
		'access' => array('fieldname' => 'modifiedon', 'type' => 'dateTime'),
		'name' => array('fieldname' => 'lastname', 'type' => 'string'),
		'created' => array('fieldname' => 'createdon', 'type' => 'dateTime'),
		'status' => array('fieldname' => 'statecode', 'type' => 'int'),//(if deleted = 1, statecode = 2; else statecode = 1)
		'field_guid_value' => array('fieldname' => 'contactid', 'type' => 'guid') 
	);

	//mandatory : set table field for CRM entity id correspondance
	//custom Drupal field to stock contact CRM ID
	$tab_field_data_field_guid = array(
		'field_guid_value' => array('fieldname' => 'contactid', 'type' => 'guid') 
	);

	//user's address (custom)
	$tab_field_data_field_address = array(
		'field_address_value' => array('fieldname' => 'new_contactid', 'type' => 'guid'),
		/*'access' => array('fieldname' => 'modifiedon', 'type' => 'dateTime'),
		'created' => array('fieldname' => 'createdon', 'type' => 'dateTime'),
		'adresse' => array('fieldname' => 'new_voie1', 'type' => 'string'),
		'adresse_2' => array('fieldname' => 'new_voie2', 'type' => 'string'),
		'adresse_3' => array('fieldname' => 'new_voie3', 'type' => 'string'),
		'c_postal' => array('fieldname' => 'new_codepostal_hors_fr', 'type' => 'string'),
		'ville_2' => array('fieldname' => 'new_complement_adresse', 'type' => 'string')*/
	);

	//entreprises address (custom)
	/*$tab_customeraddress = array(
		//'customeraddressid',
		//'latitude',
		'adresse' => 'line1',
		'adresse_2' => 'line2',
		'adresse_3' => 'line3',
		'c_postal' => 'postalcode',
		'ville' => 'city',
		//'country',
		//'county',
		//'fax',
		//'longitude',
		'c_nom' => 'name',
		'tel' => 'telephone1',
		//'telephone2',
		//'telephone3'
	);*/

	$tab = 'tab_'.$entity;
	if(isset($$tab))
		return $$tab;

}


/**
* Return only fieldnames for given entity
*/
function getDrupalModelFields($entity) {

	$retab = array();
	$model = getModel($entity);
	foreach ($model as $key => $value) {
		$retab[]=$value['fieldname'];
	}

	if(count($retab)>0)
		return $retab;
}

	
}
?>