<?php

    ini_set('max_execution_time', 300);

    function serverSideAnalysis($id){

        $python = "c:\\python36\\python.exe";
        $file = "C:\\xampp\\htdocs\\pb\\front-end\\serverSideAnalysis.py";

        $output=exec($python . " " . $file);
        
        echo "analysis is called";
        echo "<br>" . $output;
    }

    /**
     * function for getting data from kit
     */
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

    function getDataFromKit(){
        $url_csv = 'http://192.168.137.136/data_save/realtime_video_cues.csv';
        $file_csv = fopen(dirname(__FILE__) . '/data_save/realtime_video_cues.csv', 'w+');

        $url_audio = 'http://192.168.137.136/file.wav';
        $file_audio = fopen(dirname(__FILE__) . '/file.wav', 'w+');

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
    }


    if(isset($_GET["id"])){
        $raspberry_ip = '192.168.137.136';
        $url = $raspberry_ip . "/?id=" . $_GET["id"];
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_POST => false
        ));

        // Send the request & save response to $resp
        $resp = curl_exec($curl);

        //display response
        echo $resp;
        // Close request to clear up some resources
        curl_close($curl);

        if($_GET["id"]=='2'){
            //stop is called initiate data handler
            set_time_limit(0);
            getDataFromKit();
            serverSideAnalysis(3);
        }
    }else{
        echo "Invalid request";
    }
?>