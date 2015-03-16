<?php
include_once "LiveIDManager.php";
include_once "Models.php";

/**
 * EntityUtils
 * 
 * Manage soap structures to Read, Create, Update, Delete CRM entities
 * 
 * @author Emmanuel Mazurier <emmanuel.mazurier@gmail.com>
 */

class EntityUtils {

	var $organizationServiceURL;
	var $securityData;

	//set authentification
	public function __construct($CRMUrl, $liveIDUseranme, $liveIDPassword) {

		$this->organizationServiceURL = $CRMUrl;
		$liveIDManager = new LiveIDManager();
		$this->securityData = $liveIDManager->authenticateWithLiveID($this->organizationServiceURL, $liveIDUseranme, $liveIDPassword);
	}

    public static function getCRMSoapHeader($organizationServiceURL, $securityData){
        date_default_timezone_set('UTC');
        $soapHeader = '
			<s:Envelope xmlns:s="http://www.w3.org/2003/05/soap-envelope"
			xmlns:a="http://www.w3.org/2005/08/addressing"
			xmlns:u="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
			  <s:Header>
				<a:Action s:mustUnderstand="1">
				http://schemas.microsoft.com/xrm/2011/Contracts/Services/IOrganizationService/Execute</a:Action>
				<a:MessageID>
				urn:uuid:'.LiveIDManager::gen_uuid().'</a:MessageID>
				<a:ReplyTo>
				  <a:Address>
				  http://www.w3.org/2005/08/addressing/anonymous</a:Address>
				</a:ReplyTo>
				<VsDebuggerCausalityData xmlns="http://schemas.microsoft.com/vstudio/diagnostics/servicemodelsink">
				uIDPozJEz+P/wJdOhoN2XNauvYcAAAAAK0Y6fOjvMEqbgs9ivCmFPaZlxcAnCJ1GiX+Rpi09nSYACQAA</VsDebuggerCausalityData>
				<a:To s:mustUnderstand="1">
				'.$organizationServiceURL.'</a:To>
				<o:Security s:mustUnderstand="1"
				xmlns:o="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
				  <u:Timestamp u:Id="_0">
					<u:Created>'.  LiveIDManager::getCurrentTime().'Z</u:Created>
					<u:Expires>'.LiveIDManager::getNextDayTime().'Z</u:Expires>
				  </u:Timestamp>
				  <EncryptedData Id="Assertion0"
				  Type="http://www.w3.org/2001/04/xmlenc#Element"
				  xmlns="http://www.w3.org/2001/04/xmlenc#">
					<EncryptionMethod Algorithm="http://www.w3.org/2001/04/xmlenc#tripledes-cbc">
					</EncryptionMethod>
					<ds:KeyInfo xmlns:ds="http://www.w3.org/2000/09/xmldsig#">
					  <EncryptedKey>
						<EncryptionMethod Algorithm="http://www.w3.org/2001/04/xmlenc#rsa-oaep-mgf1p">
						</EncryptionMethod>
						<ds:KeyInfo Id="keyinfo">
						  <wsse:SecurityTokenReference xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
	
							<wsse:KeyIdentifier EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary"
							ValueType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509SubjectKeyIdentifier">
							'.$securityData->getKeyIdentifier().'</wsse:KeyIdentifier>
						  </wsse:SecurityTokenReference>
						</ds:KeyInfo>
						<CipherData>
						  <CipherValue>
						  '.$securityData->getSecurityToken0().'</CipherValue>
						</CipherData>
					  </EncryptedKey>
					</ds:KeyInfo>
					<CipherData>
					  <CipherValue>
					  '.$securityData->getSecurityToken1().'</CipherValue>
					</CipherData>
				  </EncryptedData>
				</o:Security>
			  </s:Header>';

        

        return $soapHeader;
    }

    public static function getCreateCRMSoapHeader($organizationServiceURL, $securityData){
        date_default_timezone_set('UTC');
        $soapHeader = '
			<s:Envelope xmlns:s="http://www.w3.org/2003/05/soap-envelope"
			xmlns:a="http://www.w3.org/2005/08/addressing"
			xmlns:u="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
			  <s:Header>
				<a:Action s:mustUnderstand="1">
				http://schemas.microsoft.com/xrm/2011/Contracts/Services/IOrganizationService/Create</a:Action>
				<a:MessageID>
				urn:uuid:'.LiveIDManager::gen_uuid().'</a:MessageID>
				<a:ReplyTo>
				  <a:Address>
				  http://www.w3.org/2005/08/addressing/anonymous</a:Address>
				</a:ReplyTo>
				<VsDebuggerCausalityData xmlns="http://schemas.microsoft.com/vstudio/diagnostics/servicemodelsink">
				uIDPozJEz+P/wJdOhoN2XNauvYcAAAAAK0Y6fOjvMEqbgs9ivCmFPaZlxcAnCJ1GiX+Rpi09nSYACQAA</VsDebuggerCausalityData>
				<a:To s:mustUnderstand="1">
				'.$organizationServiceURL.'</a:To>
				<o:Security s:mustUnderstand="1"
				xmlns:o="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
				  <u:Timestamp u:Id="_0">
					<u:Created>'.  LiveIDManager::getCurrentTime().'Z</u:Created>
					<u:Expires>'.LiveIDManager::getNextDayTime().'Z</u:Expires>
				  </u:Timestamp>
				  <EncryptedData Id="Assertion0"
				  Type="http://www.w3.org/2001/04/xmlenc#Element"
				  xmlns="http://www.w3.org/2001/04/xmlenc#">
					<EncryptionMethod Algorithm="http://www.w3.org/2001/04/xmlenc#tripledes-cbc">
					</EncryptionMethod>
					<ds:KeyInfo xmlns:ds="http://www.w3.org/2000/09/xmldsig#">
					  <EncryptedKey>
						<EncryptionMethod Algorithm="http://www.w3.org/2001/04/xmlenc#rsa-oaep-mgf1p">
						</EncryptionMethod>
						<ds:KeyInfo Id="keyinfo">
						  <wsse:SecurityTokenReference xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
	
							<wsse:KeyIdentifier EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary"
							ValueType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509SubjectKeyIdentifier">
							'.$securityData->getKeyIdentifier().'</wsse:KeyIdentifier>
						  </wsse:SecurityTokenReference>
						</ds:KeyInfo>
						<CipherData>
						  <CipherValue>
						  '.$securityData->getSecurityToken0().'</CipherValue>
						</CipherData>
					  </EncryptedKey>
					</ds:KeyInfo>
					<CipherData>
					  <CipherValue>
					  '.$securityData->getSecurityToken1().'</CipherValue>
					</CipherData>
				  </EncryptedData>
				</o:Security>
			  </s:Header>';

        

        return $soapHeader;
    }

      public static function getUpdateCRMSoapHeader($organizationServiceURL, $securityData){
        date_default_timezone_set('UTC');
        $soapHeader = '
			<s:Envelope xmlns:s="http://www.w3.org/2003/05/soap-envelope"
			xmlns:a="http://www.w3.org/2005/08/addressing"
			xmlns:u="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
			  <s:Header>
				<a:Action s:mustUnderstand="1">
				http://schemas.microsoft.com/xrm/2011/Contracts/Services/IOrganizationService/Update</a:Action>
				<a:MessageID>
				urn:uuid:'.LiveIDManager::gen_uuid().'</a:MessageID>
				<a:ReplyTo>
				  <a:Address>
				  http://www.w3.org/2005/08/addressing/anonymous</a:Address>
				</a:ReplyTo>
				<VsDebuggerCausalityData xmlns="http://schemas.microsoft.com/vstudio/diagnostics/servicemodelsink">
				uIDPozJEz+P/wJdOhoN2XNauvYcAAAAAK0Y6fOjvMEqbgs9ivCmFPaZlxcAnCJ1GiX+Rpi09nSYACQAA</VsDebuggerCausalityData>
				<a:To s:mustUnderstand="1">
				'.$organizationServiceURL.'</a:To>
				<o:Security s:mustUnderstand="1"
				xmlns:o="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
				  <u:Timestamp u:Id="_0">
					<u:Created>'.  LiveIDManager::getCurrentTime().'Z</u:Created>
					<u:Expires>'.LiveIDManager::getNextDayTime().'Z</u:Expires>
				  </u:Timestamp>
				  <EncryptedData Id="Assertion0"
				  Type="http://www.w3.org/2001/04/xmlenc#Element"
				  xmlns="http://www.w3.org/2001/04/xmlenc#">
					<EncryptionMethod Algorithm="http://www.w3.org/2001/04/xmlenc#tripledes-cbc">
					</EncryptionMethod>
					<ds:KeyInfo xmlns:ds="http://www.w3.org/2000/09/xmldsig#">
					  <EncryptedKey>
						<EncryptionMethod Algorithm="http://www.w3.org/2001/04/xmlenc#rsa-oaep-mgf1p">
						</EncryptionMethod>
						<ds:KeyInfo Id="keyinfo">
						  <wsse:SecurityTokenReference xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
	
							<wsse:KeyIdentifier EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary"
							ValueType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509SubjectKeyIdentifier">
							'.$securityData->getKeyIdentifier().'</wsse:KeyIdentifier>
						  </wsse:SecurityTokenReference>
						</ds:KeyInfo>
						<CipherData>
						  <CipherValue>
						  '.$securityData->getSecurityToken0().'</CipherValue>
						</CipherData>
					  </EncryptedKey>
					</ds:KeyInfo>
					<CipherData>
					  <CipherValue>
					  '.$securityData->getSecurityToken1().'</CipherValue>
					</CipherData>
				  </EncryptedData>
				</o:Security>
			  </s:Header>';

        

        return $soapHeader;
    }

      public static function getDeleteCRMSoapHeader($organizationServiceURL, $securityData){
        date_default_timezone_set('UTC');
        $soapHeader = '
			<s:Envelope xmlns:s="http://www.w3.org/2003/05/soap-envelope"
			xmlns:a="http://www.w3.org/2005/08/addressing"
			xmlns:u="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
			  <s:Header>
				<a:Action s:mustUnderstand="1">
				http://schemas.microsoft.com/xrm/2011/Contracts/Services/IOrganizationService/Delete</a:Action>
				<a:MessageID>
				urn:uuid:'.LiveIDManager::gen_uuid().'</a:MessageID>
				<a:ReplyTo>
				  <a:Address>
				  http://www.w3.org/2005/08/addressing/anonymous</a:Address>
				</a:ReplyTo>
				<VsDebuggerCausalityData xmlns="http://schemas.microsoft.com/vstudio/diagnostics/servicemodelsink">
				uIDPozJEz+P/wJdOhoN2XNauvYcAAAAAK0Y6fOjvMEqbgs9ivCmFPaZlxcAnCJ1GiX+Rpi09nSYACQAA</VsDebuggerCausalityData>
				<a:To s:mustUnderstand="1">
				'.$organizationServiceURL.'</a:To>
				<o:Security s:mustUnderstand="1"
				xmlns:o="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
				  <u:Timestamp u:Id="_0">
					<u:Created>'.  LiveIDManager::getCurrentTime().'Z</u:Created>
					<u:Expires>'.LiveIDManager::getNextDayTime().'Z</u:Expires>
				  </u:Timestamp>
				  <EncryptedData Id="Assertion0"
				  Type="http://www.w3.org/2001/04/xmlenc#Element"
				  xmlns="http://www.w3.org/2001/04/xmlenc#">
					<EncryptionMethod Algorithm="http://www.w3.org/2001/04/xmlenc#tripledes-cbc">
					</EncryptionMethod>
					<ds:KeyInfo xmlns:ds="http://www.w3.org/2000/09/xmldsig#">
					  <EncryptedKey>
						<EncryptionMethod Algorithm="http://www.w3.org/2001/04/xmlenc#rsa-oaep-mgf1p">
						</EncryptionMethod>
						<ds:KeyInfo Id="keyinfo">
						  <wsse:SecurityTokenReference xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
	
							<wsse:KeyIdentifier EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary"
							ValueType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509SubjectKeyIdentifier">
							'.$securityData->getKeyIdentifier().'</wsse:KeyIdentifier>
						  </wsse:SecurityTokenReference>
						</ds:KeyInfo>
						<CipherData>
						  <CipherValue>
						  '.$securityData->getSecurityToken0().'</CipherValue>
						</CipherData>
					  </EncryptedKey>
					</ds:KeyInfo>
					<CipherData>
					  <CipherValue>
					  '.$securityData->getSecurityToken1().'</CipherValue>
					</CipherData>
				  </EncryptedData>
				</o:Security>
			  </s:Header>';

        

        return $soapHeader;
    }

	/**
	* getEntityData
	* build and execute a soap query to retrieve datas and mapping results with given model
	* @entity string as CRM model's name (account, contact, address ...) 
	* @filter array as fields on which values must be filtered
	* @join array as entities linked
	* @groupby string as field on which values must be grouped
	* @limit as integer as number of values returned
	* @return array as entity_key => entity_value
	*/
	public function getEntityData($entity, $filter = null, $join = null, $groupby = null, $limit = 50) {

		$domainname = substr($this->organizationServiceURL,8,-1);
	    $pos = strpos($domainname, "/");
	    $domainname = substr($domainname,0,$pos);

	    $query = '<fetch mapping="logical" count="'.$limit.'" version="1.0"';
	    if(is_array($groupby))
	    	$query .= ' aggregate="true"';
	    $query .= '>';
	    $query .= '<entity name="'.$entity.'">';

	    $fields[$entity] = Models::getCrmModel($entity);
	    //check for aggragate fields
	    if(is_array($groupby)) {
	    	foreach ($groupby as $field)
	    	{//
	    		 $query .= '<attribute groupby="true" alias="'.$field.'" name="'.$field.'" />';
	    	}
	    }
	    //set filed mapping
	    else {
			foreach ($fields[$entity] as $field) 
			{//fields main entity
			  	$query .= '<attribute name = "'.$field.'"/>';
			}
	    }

	    if(is_array($join)) 
	    {//joining attributes
	    	foreach ($join as $entitydest => $keynames) 
	    	{
	    		$fields[$entitydest] = getCrmModel($entitydest);
	    		$query .= '<link-entity name="'.$entitydest.'" from="'.$keynames[0].'" to="'.$keynames[1].'" alias="'.$keynames[2].'" link-type="outer" visible="false">';
	    		foreach ($fields[$entitydest] as $field) 
	    		{//fields joined entity
	    			$query .= '<attribute name = "'.$field.'"/>';
	    		}
	    		$query .= '</link-entity>';
	    	}
	    }

	    if(is_array($filter)) 
	    {//filter attributes
	    	if(isset($filter['name'])) 
	    		{//SINGLE FILTER
		    	$op = isset($filter['op']) ? $filter['op'] : 'eq';
		    	$query .= '<filter type="and"><condition attribute="'.$filter['name'].'" operator="'.$op.'" value="'.$filter['value'].'" /></filter>';
	    	}
	    	else 
	    	{//MULTIPLE FILTER 
	    		foreach ($filter as $filter) {
			    	$op = isset($filter['op']) ? $filter['op'] : 'eq';
			    	$query .= '<filter type="and"><condition attribute="'.$filter['name'].'" operator="'.$op.'" value="'.$filter['value'].'" /></filter>';
	    		}
	    	}
	    }

	    $query .= '</entity></fetch>';

	    $entityRequest = self::buildQuery($this->organizationServiceURL, $this->securityData, $query);

	    $response =  LiveIDManager::GetSOAPResponse("/Organization.svc", $domainname, $this->organizationServiceURL, $entityRequest);
		//var_dump($response);//exit;

		$result = EntityUtils::buildResponse($response, $fields);
		return $result;
	}		

    /**
    * buildQuery 
    * encapsulate soap query structure 
    * @organizationServiceURL
    * @securityData
    * @query string
    * @return string
    */
    public static function buildQuery($organizationServiceURL, $securityData, $query) {
       
        $request = EntityUtils::getCRMSoapHeader($organizationServiceURL, $securityData) .
        '
              <s:Body>
                    <Execute xmlns="http://schemas.microsoft.com/xrm/2011/Contracts/Services">
                            <request i:type="b:RetrieveMultipleRequest" xmlns:b="http://schemas.microsoft.com/xrm/2011/Contracts" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
                                    <b:Parameters xmlns:c="http://schemas.datacontract.org/2004/07/System.Collections.Generic">
                                            <b:KeyValuePairOfstringanyType>
                                                    <c:key>Query</c:key>
                                                    <c:value i:type="b:FetchExpression">
                                                    	<b:Query>
                                                    	'.self::formatQuery($query).'
                                                    	</b:Query>
                                                    </c:value>
                                            </b:KeyValuePairOfstringanyType>
                                    </b:Parameters>
                                    <b:RequestId i:nil="true"/><b:RequestName>RetrieveMultiple</b:RequestName>
                            </request>
                    </Execute>
                    </s:Body>
            </s:Envelope>
			';

			//echo $request;exit;	

			return $request;

    }



    /**
    * Extract keys and value from SOAP query response
    * @return array as entity's key => entity's value
    **/
    public static function buildResponse($response, $fields = null) {

		$accountsArray = array();
        if($response!=null && $response!=""){
        	//echo $response;exit;
        
            $responsedom = new DomDocument();
            $responsedom->loadXML($response);

            $entities = $responsedom->getElementsbyTagName("Entity");
            //if(!is_null($responsedom->getElementsbyTagName("PagingCookie")))
	        //    $cookies = $responsedom->getElementsbyTagName("PagingCookie")->item(0)->textContent;
            //var_dump($cookies);exit();

            foreach($entities as $entity)
            {
                $account = array();
                $kvptypes = $entity->getElementsbyTagName("KeyValuePairOfstringanyType");
		    	foreach($kvptypes as $kvp){
                    $key =  $kvp->getElementsbyTagName("key")->item(0)->textContent;
                    $value =  $kvp->getElementsbyTagName("value")->item(0)->textContent;

				    //clean key names of returned values  
				    foreach ($fields as $entity => $fieldnames) {
				    	$value = str_replace($entity, '', $value);
				    }
					$account[$key] = $value;

                }
	            $accountsArray[] = $account;
            }
        }
        return $accountsArray;
    }


    private static function formatQuery($query) {

    	$tmp = str_replace("\n","&#xD;\n",$query);
    	$tmp = str_replace("<","&lt;",$tmp);
    	$tmp = str_replace(">","&gt;",$tmp);

    	return $tmp;

    }


	/**
	* updateEntityData
	* build and execute a soap query to update datas for given entity id
	* @entity string as CRM model's name (account, contact, address ...) 
	* @contactid string as primary key
	* @querytab array as field's name => array type, value and reference
	* @return array as bool
    **/
	public function updateEntityData($entity, $querytab) {

		$domainname = substr($this->organizationServiceURL,8,-1);
	    $pos = strpos($domainname, "/");
	    $domainname = substr($domainname,0,$pos);

	    $drupal_entity = is_array($querytab) ? array_keys($querytab) : '';
	    //echo print_r($querytab[$drupal_entity[0]]);exit;

	    if(!empty($drupal_entity)) 
	    {//format query with drupal's model correspondance

	        $query = self::formatQueryUpdate($querytab);

			$accountsRequest = self::getUpdateCRMSoapHeader($this->organizationServiceURL, $this->securityData).
				 '<s:Body><Update xmlns="http://schemas.microsoft.com/xrm/2011/Contracts/Services">
	                <entity xmlns:b="http://schemas.microsoft.com/xrm/2011/Contracts" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
	                    <b:Attributes xmlns:c="http://schemas.datacontract.org/2004/07/System.Collections.Generic">'.$query.' </b:Attributes>
	            <b:EntityState i:nil="true"/>
	                    <b:FormattedValues xmlns:c="http://schemas.datacontract.org/2004/07/System.Collections.Generic"/>
	                    <b:Id>'.$querytab[$drupal_entity[0]]['field_guid_value'].'</b:Id>
	                    <b:LogicalName>'.$entity.'</b:LogicalName>
	                    <b:RelatedEntities xmlns:c="http://schemas.datacontract.org/2004/07/System.Collections.Generic"/>
	                </entity></Update>
	            </s:Body>
	        </s:Envelope>';

		    $response =  LiveIDManager::GetSOAPResponse("/Organization.svc", $domainname, $this->organizationServiceURL, $accountsRequest);
		    var_dump($response);
	        
	        return $response;
		}

	} 

    /**
	* createEntityData
	* build and execute a soap query to create datas for given entity id
	* @entity string as CRM model's name (account, contact, address ...) 
	* @contactid string as primary key
	* @querytab array as field's name => array type, value and reference
	* @return string
    **/
	public function createEntityData($entity, $querytab) {

		$domainname = substr($this->organizationServiceURL,8,-1);
	    $pos = strpos($domainname, "/");
	    $domainname = substr($domainname,0,$pos);

        $query = self::formatQueryUpdate($querytab);
       
        $accountsRequest = EntityUtils::getCreateCRMSoapHeader($this->organizationServiceURL, $this->securityData).
        '
              <s:Body>
                    <Create xmlns="http://schemas.microsoft.com/xrm/2011/Contracts/Services">
                    <entity xmlns:b="http://schemas.microsoft.com/xrm/2011/Contracts" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
						<b:Attributes xmlns:c="http://schemas.datacontract.org/2004/07/System.Collections.Generic">'.$query.' </b:Attributes>
                        <b:EntityState i:nil="true"/>
                        <b:FormattedValues xmlns:c="http://schemas.datacontract.org/2004/07/System.Collections.Generic"/>
                        <b:Id>00000000-0000-0000-0000-000000000000</b:Id>
                        <b:LogicalName>'.$entity.'</b:LogicalName>
                        <b:RelatedEntities xmlns:c="http://schemas.datacontract.org/2004/07/System.Collections.Generic"/>
                    </entity>
                    </Create>
                </s:Body>
            </s:Envelope>
			';

		$response =  LiveIDManager::GetSOAPResponse("/Organization.svc", $domainname, $this->organizationServiceURL, $accountsRequest);
        //var_dump($response);

        $createResult ="";
        if($response!=null && $response!=""){
            preg_match('/<CreateResult>(.*)<\/CreateResult>/', $response, $matches);
            $createResult =  $matches[1];
        }
     
        return $createResult;

    } 	  

    /**
    * formatQueryUpdate 
    * build soap query structure for given field type
    * @querytab array as Drupal's field name => array Crm's field nam, type, value and reference if needed
    * @return string
    */
    public static function formatQueryUpdate($querytab) {

    	$tmp = "";
    	foreach ($querytab as $drupal_entity => $fieldtab) 
    	{
    		//get CRM model definition
    		$field = Models::getDrupalModel($drupal_entity);
    		//print_r($fieldtab);
    		//print_r($field);exit;

    		$xmlns = "http://www.w3.org/2001/XMLSchema";

	    	foreach ($fieldtab as $fieldname => $value) 
	    	{	
				if($field[$fieldname]['type']=='EntityReference') {
		    		$tmp .= '<b:KeyValuePairOfstringanyType>
		                        <c:key>'.$field[$fieldname]['fieldname'].'</c:key>
		                        <c:value i:type="b:EntityReference">
		                            <b:Id>'.$value.'</b:Id>
		                            <b:LogicalName>'.$field['reference'].'</b:LogicalName>
		                            <b:Name i:nil="true" />
		                        </c:value>
		                    </b:KeyValuePairOfstringanyType>'."\n";				
				}
				elseif ($field[$fieldname]['type']=='OptionSetValue') {
			        $tmp .= '<b:KeyValuePairOfstringanyType>
						      <c:key>'.$field[$fieldname]['fieldname'].'</c:key>
						      <c:value i:type="b:OptionSetValue">
						        <b:Value>'.$value.'</b:Value>
						      </c:value>
						    </b:KeyValuePairOfstringanyType>'."\n";	
				}
				elseif ($field[$fieldname]['type']!='guid') {
					
					if($field[$fieldname]['type'] == 'dateTime')
						$value = date('Y-m-d\TH:i:s\Z',strtotime($value));

		    		$tmp .= '<b:KeyValuePairOfstringanyType>
		                        <c:key>'.$field[$fieldname]['fieldname'].'</c:key>
		                        <c:value i:type="d:'.$field[$fieldname]['type'].'" xmlns:d="'.$xmlns.'">'.$value.'</c:value>
		                    </b:KeyValuePairOfstringanyType>'."\n";
				}
	    	}
    	}

    	return $tmp;
    }  



    /**
    *extractKey 
    *isolate primary key on SQL Server format
    * @return string
    */
    private static function extractKey($key) {
    	if(preg_match("/([A-Za-z0-9]{8})\-([A-Za-z0-9]{4})\-([A-Za-z0-9]{4})\-([A-Za-z0-9]{4})-([A-Za-z0-9]{12})(.*)/", $key, $matches))
    		return $matches[1].'-'.$matches[2].'-'.$matches[3].'-'.$matches[4].'-'.$matches[5];
    	return false;
    }   

    
}

?>
