<?php
/*
 * Author : Cleve Gomes
 */

require_once 'API.php';

/**
 * Telecom is the Telecom Service api that extends the API class
 * Class Telecom
 */
class Telecom  extends API
{

	//This key can be different for different for different users .But for simplicity kept it simple.


	// This is the list of all users and phone number with activity status.. in reality it will come from some db
	private $userPhoneList = ["john"=>[["0504567876",1],["0507856712",0]],"jane"=>[["0507456743",1]]];


	public function __construct($request)
	{

		parent::__construct($request);

	}

	/**
	 * phone no will give list of all phone numbers,list particular phone numbers ,activate a phone number
	 * @return array
	 * @throws Exception
	 */
	protected function phoneno()
	{


		if($this->method == 'GET')
		{
			if($this->verb == "list")
			{
				return $this->userPhoneList;
			}

			else if ($this->verb == "customer")
			{
				if(isset($this->args[0]) && isset($this->userPhoneList[strtolower($this->args[0])]))
				{
					return $this->userPhoneList[strtolower($this->args[0])];
				}
				else
				{
					throw new Exception("Invalid customer");
				}

			}
			else if ($this->verb == "activate")
			{
				if(isset($this->args[0]))
				{
					$foundFlag = false;
					foreach($this->userPhoneList as $customer => $phoneList)
					{
						foreach($phoneList as  $selPhoneno)
						{


							if($selPhoneno[0] == $this->args[0])
							{
								if($selPhoneno[1] == 0)
									return "Phone No :".$selPhoneno[0]." of customer  ".$customer." has been activated";

								else
									return "Phone No :".$selPhoneno[0]." of customer  ".$customer." is already active";


							}


						}


					}
					if($foundFlag == false)
						throw new Exception("Invalid phone number");
				}
				else
				{
					throw new Exception("Invalid phone number");
				}
			}
			else
			{
				throw new Exception("Method not found");
			}
		}
		throw new Exception("Method not found");

	}

}
















