


https://app.creditrepaircloud.com/

username : jayneferens100@gmail.com
Password : Credit1234
//////////////////////////////////////


https://developer.experian.com/apps

Email : priya.wartiz@gmail.com
password : Developer@1234
security answer : developer
/////////////////////////////////////


http://wartiz.com/squareone
username : lovepreet.wartiz@gmail.com
pass : 12345678


<?php
$url = 'https://us-api.experian.com/oauth2/v1/token';
$username='priya.wartiz@gmail.com'; // Your Experian Developer UserName
$password='Developer@1234';  // Your Experian Developer Password

$data = array(
    "usernamedd" => $username,
    "password" => $password,
    "client_id" => 'mcnkigUFC7qIHou02u9fi2tcI65AKiD0',
    "client_secret" => 'k8WOAneg6XnMXD15',
);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode($data),
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Content-type: application/json',
    'Grant_type: password'
  ),
));

$response = curl_exec($curl);
echo "<pre>";
print_r($response);
curl_close($curl);

die;
?>