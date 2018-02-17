<?php
	header('Content-Type: text/event-stream');
	header('Cache-Control: no-cache');

/*
	function gen(){
		
		while(true)
		{
			*/
			$plot_smile = fopen("./plot_smile.json", "r");
			$json = fgets($plot_smile);
			$data =$json;
			fclose($plot_smile);

			echo $data;
/*
			sleep(1);
		}
	}

	gen();
	*/
?>