<?php

namespace App\Modules;

class GoogleAnalyticsModule{

	public static function create_google_client($generator){

		$client = new \Google_Client();
        $client->setAuthConfigFile(public_path().'/private/google_oauth.json');
        $client->refreshToken($generator['var2']);
        return $client;

	}

	public static function create_analytics_client($client){

        return new \Google_Service_Analytics($client);;

	}

	public static function create_report($generator){

        $slack_service = $generator->slack_service;
        $analytics_service = $generator->analytics_service;

        // ---------------------
        // Get all the variables
        // ---------------------

        $pattern = "/{{(.*?)}}/";

        preg_match_all($pattern, $generator->template, $metrics);
        
        isset($metrics[1]) ? $metrics = $metrics[1] : null;

        $metrics_requests = [];
        foreach($metrics as $metric){

            $_metric = explode("|",$metric);
            if(count($_metric) == 1){ // Only metric
                $metric_request = ['metric' => $_metric[0]];
            }else if(count($_metric) == 2){ // Metric + Dimension
                $metric_request = ['metric' => $_metric[0], 'dimensions' => $_metric[1]];
            }else if(count($_metric) == 3){ // Metric + Dimension + Limit
                $metric_request = ['metric' => $_metric[0], 'dimensions' => $_metric[1], 'limit' => $_metric[2]];
            }
            array_push($metrics_requests,$metric_request);

        }

        // ---------------------
        // Init Google Analytics
        // ---------------------
       
        $client = new \Google_Client();
        $client->setAuthConfigFile(public_path().'/private/google_oauth.json');
        $client->refreshToken($analytics_service->var2);
        $analytics = new \Google_Service_Analytics($client);

        // -----------
        // Request API
        // -----------

        $final_data = [];

        foreach($metrics_requests as $metrics_request){

            $opts = [];
            isset($metrics_request['dimensions']) ? $opts['dimensions'] = $metrics_request['dimensions'] : null;

            $data = $analytics->data_ga->get(
                'ga:' . $generator->ga_profile,
                $generator->end_date,
                $generator->start_date,
                $metrics_request['metric'],
                $opts
            );


            $data = $data->getRows();

            $_data = [];

            usort($data, function($a, $b) {
                if(count($a) == 1){
                    return $b[0] - $a[0];
                }else{
                    return $b[1] - $a[1];
                }
            });

            foreach($data as $k => $d){

                $line = "";
                if(count($d) == 1){
                    $line .= $d[0];
                }else{
                    $line .= $d[1].' - '.$d[0];
                }
                array_push($_data,$line);

            }

            array_push($final_data, $_data);

        }

        // $final_metrics = [];
        // foreach($final_data as $k => $v){
        //     $final_metrics[$metrics[$k]] = $v;
        // }

        $message = $generator->template;

        // Clean brs
        $message = preg_replace("/(<br\s*\/?>\s*)+/", "<br/><br/>", $message);

        foreach($final_data as $k => $v){
            $line = implode("\r\n",$v);
            $message = str_replace("{{".$metrics[$k]."}}", ($line), $message);
        }

        // Add final message

        $message = $message."\r\n\r\n Like Kubby ? <".config('constants.TWITTER_SHARE_LINK')."|Tweet it !>";

        $carbon = \Carbon\Carbon::now();
        $date = $carbon->format('H:00');
        $date_full = $carbon->format('Y/m/d');

        return [
            'message' => $message,
            'generator' => $generator,
            'date' => $date,
            'date_full' => $date_full
        ];

	}
}