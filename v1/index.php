<?php
/*
 * Author : Cleve Gomes
 */
require_once "Telecom.php";


//   http://localhost/api/v1/phoneno/list                  //All phone numbers
//  http://localhost/api/v1/phoneno/customer/john         // All phone numbers of customer john
//   http://localhost/api/v1/phoneno/activate/0507856712   //Activate a number.


try
{

    if(!isset($_REQUEST["request"]))
        throw new Exception("Invalid request");


	$telecomObjAPI = new Telecom($_REQUEST["request"]);
	echo $telecomObjAPI->processAPI();
}
catch (Exception $e)
{
	echo json_encode(Array("error"=>$e->getMessage()));
}






