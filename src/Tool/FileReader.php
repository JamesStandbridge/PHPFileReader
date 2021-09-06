<?php

namespace PHPFileReader\Tool;

class FileReader {
    public static function CSV_ARRAY(string $path, $delimiter = ",", bool $first_line_is_headers = false)
    {
        try {
            if (!file_exists($path) || !is_readable($path)) {
                return FALSE;
            }      
            $data = array();
        	$headers = array();
        	$index = 0;

            if (($handle = fopen($path, "r")) !== FALSE) {
                while ($row = fgetcsv($handle, 1000, $delimiter)) {
                	//headers builder
                	if($index === 0 && $first_line_is_headers) {
                		if($first_line_is_headers) {
                			foreach($row as $key => $header) 
                				$headers[$key] = $header;
                		}
                	} else {
	                 	$line = $row;

	                	if($first_line_is_headers) {
		                	$line = array();
		                	foreach($row as $key => $slug) {
		                		$line[$headers[$key]] = $slug;
		                	}                		
	                	}

	                    $data[] = $line;               		
                	}

                    $index++;
                }
                fclose($handle);
            }
        } catch (\Exception $e) {
            throw $e;
        }
        return $data;
    }
}