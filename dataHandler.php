<?php
    set_time_limit(0);
    function download($url,$file){
        $curl = curl_init($url);

        // Update as of PHP 5.4 array() can be written []
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
        //  CURLOPT_BINARYTRANSFER => 1, --- No effect from PHP 5.1.3
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FILE           => $file,
            CURLOPT_TIMEOUT        => 50,
            CURLOPT_USERAGENT      => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'
        ]);

        $response = curl_exec($curl);

        if($response === false) {
            // Update as of PHP 5.3 use of Namespaces Exception() becomes \Exception()
            throw new \Exception('Curl error: ' . curl_error($curl));
        }

        return $response; // Do something with the response
    }


    $url_csv = 'http://192.168.137.136/data_save/realtime_video_cues.csv';
    $file_csv = fopen(dirname(__FILE__) . '/uploads/video.csv', 'w+');

    $url_audio = 'http://192.168.137.136/file.wav';
    $file_audio = fopen(dirname(__FILE__) . '/uploads/file.wav', 'w+');

    if(download($url_csv,$file_csv)==1){
        echo "video csv downlaoded";
    }else{
        echo "error in download for csv";
    }
    if(download($url_audio,$file_audio)==1){
        echo "audio downlaoded";
    }else{
        echo "error in download for wav";
    }
?>