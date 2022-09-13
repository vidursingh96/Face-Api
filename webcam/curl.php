<?php
    function getFile($filePath)
    {
        sleep(2);
        if(!file_exists("/home2/gradetrade/public_html/prakher/webcam/$filePath")){
            getFile($filePath);
        }
        return $content = file_get_contents("/home2/gradetrade/public_html/prakher/webcam/$filePath");
    }
    $curl = curl_init();
    // log file come from webhook.php
    $fileName = time(). '.log';
    //deepaffects audio api
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://proxy.api.deepaffects.com/audio/generic/api/v1/async/analytics/interaction?apikey=ZpiI5BO7c14tFePMj1Iy5bRuiS9eaR7Y&webhook=https://grade.techmente.com/prakher/webcam/webhook.php?fileName='.$fileName,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{"url": "https://grade.techmente.com/prakher/webcam/'.$path.$actual_audio_name.'", "sampleRate": 8000, "encoding": "wav", "languageCode": "en-US", "metrics": ["all"]}',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ) ,
    ));
    $response = curl_exec($curl);
      //print_r($response); exit();
    curl_close($curl);
    //echo $response;
    
    $log = getFile($fileName);
    $audio = json_decode($log, true);
    $audio_val = $audio["response"]["segments"][0]['emotion_score'];
    $aud_emot = $audio["response"]["segments"][0]['emotion'];
    header('location: showData.php'."?webval=".$expvalue."&webemot=".$expname."&imgval=".$img_value."&aud_val=".$audio_val."&aud_emot=".$aud_emot);
?>