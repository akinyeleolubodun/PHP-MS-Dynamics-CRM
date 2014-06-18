PHP-MS-Dynamics-CRM
===================

This is a PHP library to connect to MS Dynamics CRM. It helps create, retreive, update and delete records using JSON.

Sample Implementation (Datatypes (Boolean DateTime Decimal Double UniqueIdentifier Integer BigInt String EntityReference OptionSetValue Money BooleanManagedProperty))

Step 1: Include the library

		include("../../Crm.php");


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

		$test = new Crm("test","P@ssw0rd","http://testserver:80/Server/XRMServices/2011/OrganizationData.svc/pcl_ContactSet/");

Step 4: Build The JSON File

		$data = $test->buildJSON($array);

Step 5: Post Your Data

		$response = $test->PostData($data);
		
Retrieving Data

	$crm = new Crm("test","P@ssw0rd","http://testserver:80/Server/XRMServices/2011/OrganizationData.svc/pcl_ContactSet/(guid'cda450bd-65f1-e311-85bb-001bcd0310a3')");
	$data = $crm->buildJSON($array);
	$crm->RetrieveData("127.0.0.1");

