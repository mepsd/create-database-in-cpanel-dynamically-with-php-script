
<?php  
 
 $database_name = ""; //Database Name
 $database_user = ''; //Database User
 $database_pass = ""; //Database User Password
 $cpanel_username = ""; //Cpamel username
 $cpanel_pass = ""; //Cpamel password
 $cpanel_theme = "paper_lantern"; //Cpanel theme
 
 function createDb($cpanel_theme, $cPanelUser, $cPanelPass, $dbName)
 {
     $buildRequest = "/frontend/" . $cpanel_theme . "/sql/addb.html?db=" . $dbName;
 
     $openSocket = fsockopen('localhost', 2082);
     if (!$openSocket) {
         return "Socket error";
         exit();
     }
 
     $authString = $cPanelUser . ":" . $cPanelPass;
     $authPass = base64_encode($authString);
     $buildHeaders = "GET " . $buildRequest . "\r\n";
     $buildHeaders .= "HTTP/1.0\r\n";
     $buildHeaders .= "Host:localhost\r\n";
     $buildHeaders .= "Authorization: Basic " . $authPass . "\r\n";
     $buildHeaders .= "\r\n";
 
     fputs($openSocket, $buildHeaders);
     while (!feof($openSocket)) {
         fgets($openSocket, 128);
     }
     fclose($openSocket);
 }
 
 function createUser($cpanel_theme, $cPanelUser, $cPanelPass, $userName, $userPass)
 {
     $buildRequest = "/frontend/" . $cpanel_theme . "/sql/adduser.html?user=" . $userName . "&pass=" . $userPass;
 
     $openSocket = fsockopen('localhost', 2082);
     if (!$openSocket) {
         return "Socket error";
         exit();
     }
 
     $authString = $cPanelUser . ":" . $cPanelPass;
     $authPass = base64_encode($authString);
     $buildHeaders = "GET " . $buildRequest . "\r\n";
     $buildHeaders .= "HTTP/1.0\r\n";
     $buildHeaders .= "Host:localhost\r\n";
     $buildHeaders .= "Authorization: Basic " . $authPass . "\r\n";
     $buildHeaders .= "\r\n";
 
     fputs($openSocket, $buildHeaders);
     while (!feof($openSocket)) {
         fgets($openSocket, 128);
     }
     fclose($openSocket);
 }
 
 function addUserToDb($cpanel_theme, $cPanelUser, $cPanelPass, $userName, $dbName, $privileges)
 {
     $buildRequest = "/frontend/" . $cpanel_theme . "/sql/addusertodb.html?user=" . $cPanelUser . "_" . $userName . "&db=" . $cPanelUser . "_" . $dbName . "&privileges=" . $privileges;
 
     $openSocket = fsockopen('localhost', 2082);
     if (!$openSocket) {
         return "Socket error";
         exit();
     }
 
     $authString = $cPanelUser . ":" . $cPanelPass;
     $authPass = base64_encode($authString);
     $buildHeaders = "GET " . $buildRequest . "\r\n";
     $buildHeaders .= "HTTP/1.0\r\n";
     $buildHeaders .= "Host:localhost\r\n";
     $buildHeaders .= "Authorization: Basic " . $authPass . "\r\n";
     $buildHeaders .= "\r\n";
 
     fputs($openSocket, $buildHeaders);
     while (!feof($openSocket)) {
         fgets($openSocket, 128);
     }
     fclose($openSocket);
 }
 
 //Create Db
 createDb($cpanel_theme, $cpanel_username, $cpanel_pass, $database_name);
 
 //Create User
 createUser($cpanel_theme, $cpanel_username, $cpanel_pass, $database_user, $database_pass);
 
 //Add user to DB - ALL Privileges
 addUserToDb($cpanel_theme, $cpanel_username, $cpanel_pass, $database_user, $database_name, 'ALL PRIVILEGES');
 
 ?>
 