# PHP2MSDynamics
Connector between MS Dynamics SOAP protocol and REST model 

* This library has been written in order to build an interface Microsoft Dynamics CRM contents with any REST system
It is able to convert SOAP messages into JSON format in order to work a REST API

* This library is using SOAP hearders delivered with the Microsoft SDK and a specific class "EntityUtils" which build queries to manage datas with CRUD commands

* The Main.php file gives examples of how to read, create and update the "contacts" entity in the CRM

* In order to build a Drupal module, the class "Models" must be dynamicaly managed in the Drupal admin backoffice.
This class describes and makes the correspondance between Drupal and CRM models. You can add any field you need in the models. 

* Mandatory on each systems : 
	In order to make possible the combination between the systems, 2 fields must be created before using this library
	- In Drupal : the table "field_data_field_guid" must be created in order to store CRM's primary keys for each entities which exchanges data
	- In MS Dynamics CRM : the field "new_drupal_uid" must be created in order to store Drupal entity's primary key in the CRM
