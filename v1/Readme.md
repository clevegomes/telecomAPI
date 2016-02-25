4. Telecom APIs


Ans) Below is a brief description of Class and files in the Telecom API system

API.php     : This Abstract class is responsible for all the housekeeping functionality for a REST API

Telecom.php : This class extends the API class  to create a Telecom API . It has the functionality to fetch
              1)List of all customers phone numbers.
              2)Phone numbers of a particular function
              3) Activate a particular phone number.

index.php    : This is the entry point for the API and it also catches all exceptions thrown,

.htaccess    : Re writes the URL if its not a file or directory

              http://localhost/api/v1/phoneno/list    is re written to localhost/api/v1/index.php?request=phoneno/list

              http://localhost/api/v1/phoneno/customer/john    is re written to localhost/api/v1/index.php?request=phoneno/customer/john

              http://localhost/api/v1/phoneno/activate/0507856712 is re written to localhost/api/v1/index.php?request=phoneno/activate/0507856712

              URS.
              example.org/api/vi/phoneno/list

              example.org/api/vi/phoneno/customer/john

              example.org/api/vi/phoneno/activate/0507856712


Expected results

http://localhost/api/v1/phoneno/list

{"success":{"john":[["0504567876",1],["0507856712",0]],"jane":[["0507456743",1]]}}


http://localhost/api/v1/phoneno/customer/john

{"success":[["0504567876",1],["0507856712",0]]}


http://localhost/api/v1/phoneno/activate/0507856712

{"success":"Phone No :0507856712 of customer  john has been activated"}


