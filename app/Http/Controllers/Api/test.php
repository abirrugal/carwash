<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://3gke3w.api.infobip.com/sms/2/binary/advanced',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{"bulkId":"BULK-ID-123-xyz","messages":[{"binary":{"dataCoding":0,"esmClass":0,"hex":"54 65 73 74 20 6d 65 73 73 61 67 65 2e"},"callbackData":"DLR callback data","destinations":[{"messageId":"MESSAGE-ID-123-xyz","to":"41793026727"},{"to":"41793026834"}],"from":"InfoSMS","intermediateReport":true,"notifyContentType":"application/json","notifyUrl":"https://www.example.com/sms/advanced","validityPeriod":720},{"binary":{"dataCoding":0,"esmClass":0,"hex":"41 20 6C 6F 6E 67 20 74 …20 45 6D 70 69 72 65 2E"},"deliveryTimeWindow":{"days":["MONDAY","TUESDAY","WEDNESDAY","THURSDAY","FRIDAY","SATURDAY","SUNDAY"],"from":{"hour":6,"minute":0},"to":{"hour":15,"minute":30}},"destinations":[{"to":"41793026700"}],"from":"41793026700","sendAt":"2021-08-25T16:00:00.000+0000"}]}',
    CURLOPT_HTTPHEADER => array(
        'Authorization: {authorization}',
        'Content-Type: application/json',
        'Accept: application/json'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
