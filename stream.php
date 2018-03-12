<?php
	header('Content-Type: text/event-stream');
	header('Cache-Control: no-cache');


	$plot_smile = fopen("./data_save/plot_smile.json", "r");
	$json = fgets($plot_smile);
	$data =$json;
	fclose($plot_smile);

	echo $data;
?>