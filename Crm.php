<?php

/*****

Authour: Nnadozie Omeonu and Akinyele V. Olubodun
Date: June 17, 2014.
Company: Oaks Telecoms and Technology Limited
License: GPL

/*****
/******************************************************************************************************************************************************************************
Sample Implementation (Datatypes (Boolean DateTime Decimal Double UniqueIdentifier Integer BigInt String EntityReference OptionSetValue Money BooleanManagedProperty))

Step 1: Include the library

		include("../../CRMClass.php");


Step 2: Build Ur Array in the following format	

		$array = array
					  (
							array(field name,value,datatype),
							array("LastName","Nnadozie","String"),
							array("Amount",78.099,"Decimal"),
							array("Age",78,"Integer"),
							array("Amount2",78.099,"Double"),
							.
							.
							.
							array("money",78.099,"Money"),
							
							
					  );

Step 3: Create an Object Passing in 3 Argumments username,password,and link

$test = new CRM("crmadmin","P@ssw0rd1234","http://testserver:80/Server/XRMServices/2011/OrganizationData.svc/pcl_ContactSet/");

Step 4: Build The JSON File

$data = $test->buildJSON($array);

Step 5: Post Your Data

$response = $test->PostData($data);


$crm = new Crm("test","P@ssw0rd","http://testserver:80/Server/XRMServices/2011/OrganizationData.svc/pcl_ContactSet/(guid'cda450bd-65f1-e311-85bb-001bcd0310a3')");
$data = $crm->buildJSON($array);
$crm->RetrieveData("127.0.0.1");


*******************************************************************************************************************************************************************************/
class Crm
{
	private $username;
	private $password;
	private $url;
	private $post = "POST";
	private $get = "GET";

	function __construct($user, $pass, $CRMurl)
	{
		$this->username = 	$user;
		$this->password = $pass;
		$this->url = $CRMurl;
	}

	public function buildJSON($array)
	{
			$data=array();
		 	for ($row = 0; $row < count($array); $row++)
			{	
						switch ($array[$row][2]) 
						{
							case "Boolean":
								$type = "Edm.Boolean";
								break;
							case "DateTime":
								$type = "Edm.DateTime";
								break;
							case "Decimal":
								$type = "Edm.Decimal";
								break;
							case "Double":
								$type = "Edm.Double";
								break;
							case "UniqueIdentifier":
								$type = "Edm.Guid";
								break;
							case "Integer":
								$type = "Edm.Int32";
								break;
							case "BigInt":
								$type = "Edm.Int64";
								break;
							case "String":
								$type = "Edm.String";
								break;
							case "EntityReference ":
								$type = "Microsoft.Crm.Sdk.Data.Services.EntityReference";
								break;
							case "OptionSetValue":
								$type = "Microsoft.Crm.Sdk.Data.Services.OptionSetValue";
								break;
							case "Money":
								$type = "Microsoft.Crm.Sdk.Data.Services.Money";
								break;
							case "BooleanManagedProperty":
								$type = "Microsoft.Crm.Sdk.Data.Services.BooleanManagedProperty";
								break;
							default:
								$type = "";
								
					}

					if((trim($type) == ""))
					{
						$data[$array[$row][0]] = $array[$row][1];
					}
					else
					{
						
						$data[$array[$row][0]] = array(
															 "__metadata" => array("type" => $type), 
															 "Value" => $array[$row][1] 
														);
					}
					
			}
			var_dump($data);
			return json_encode($data);
	}

	public function connection($data_string,$method,$host,$CUSTOMREQUEST)
	{
		$ch = curl_init();
		$headers = array(
				 'Method: '.$method,
				 'Connection: keep-alive',
				 'User-Agent: PHP-SOAP-CURL',
				 'Content-Type: application/json; charset=utf-8',
				 'Accept: application/json',
				 'Content-Length: ' . strlen($data_string),
				 'Host '.$host);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $this->url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $CUSTOMREQUEST);                                                                    
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
			curl_setopt($ch, CURLOPT_USERPWD, $this->username.":".$this->password);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			return $ch;
	}	

	public function closeConnection($ch)
	{
		curl_close($ch);	
		return 0;	
	}

	public function PostData($data,$host)
	{
			$connection = $this->connection($data,$this->post,$host);			
			$response = curl_exec($connection);
			$this->closeConnection($connection);
			return $response;
	}
	
	public function UpateData($data,$host)
	{
			$connection = $this->connection($data,$this->post,$host,"MERGE");			
			$response = curl_exec($connection);
			$this->closeConnection($connection);
			echo $response;
			return $response;
	} 	
	
	public function DeleteData($host)
	{
			$connection = $this->connection($this->post,$host,"DELETE");			
			$response = curl_exec($connection);
			$this->closeConnection($connection);
			return $response;
	}
	
	public function RetrieveData($host)
	{
			$connection = $this->connection($this->post,$host,$this->get);			
			$response = curl_exec($connection);
			$this->closeConnection($connection);
			return $response;
	}


}


?>
