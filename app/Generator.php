<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Generator extends Model
{
    protected $table = 'generators';

    protected $fillable = ['user_id','ga_service_id','slack_service_id','ga_account','name','ga_property','ga_profile','slack_channel','start_date','end_date','template','activation_hours','timezone','activation_days'];

    public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

    public function analytics_service(){
        return $this->hasOne('App\Service', 'id', 'ga_service_id');
    }

    public function slack_service(){
        return $this->hasOne('App\Service', 'id', 'slack_service_id');
    }

	// -----------------
    // Transform methods
    // -----------------

    public static function transform($generator){

        $_generator = [
        	"id" => $generator['id'],
            "user_id" => $generator['user_id'],
            "ga_service_id" => $generator['ga_service_id'],
            "slack_service_id" => $generator['slack_service_id'],
            "name" => $generator['name'],
            "ga_service" => $generator['ga_service'],
            "ga_account" => $generator['ga_account'],
            "ga_property" => $generator['ga_property'],
            "ga_profile" => $generator['ga_profile'],
            "slack_channel" => $generator['slack_channel'],
            "start_date" => $generator['start_date'],
            "end_date" => $generator['end_date'],
            "template" => $generator['template'],
            "timezone" => $generator['timezone'],
            "activation_hours" => $generator['activation_hours'],
            "activation_days" => $generator['activation_days'],
        ];

        return $_generator;
    }

    public static function transformMany($generators){
        foreach($generators as $k => $v){
            $generators[$k] = Generator::transform($v);
        }
        return $generators;
    }

    // -------------
    // Other methods
    // -------------

    public static function createReport($generator){
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

        // echo "metrics_requests <br><pre>";
        // print_r($metrics_requests);
        // echo "</pre>";

        // ---------------------
        // Init Google Analytics
        // ---------------------

        /*
        $key = file_get_contents(public_path().$analytics_service->var4);
        $client = new \Google_Client();
        $client->setApplicationName("HelloAnalytics");
        $analytics = new \Google_Service_Analytics($client);
        $cred = new \Google_Auth_AssertionCredentials($analytics_service->var2,array(\Google_Service_Analytics::ANALYTICS_READONLY),$key);
        $client->setAssertionCredentials($cred);
        $client->getAuth()->refreshTokenWithAssertion($cred);
        */
       
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
            )->getRows();

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

        // echo "final_data <br><pre>";
        // print_r($final_data);
        // echo "</pre>";

        $message = $generator->template;

        // Clean brs
        // $message = nl2br($message);
        $message = preg_replace("/(<br\s*\/?>\s*)+/", "<br/><br/>", $message);

        foreach($final_data as $k => $v){
            $line = implode("\r\n",$v);
            $message = str_replace("{{".$metrics[$k]."}}", ($line), $message);
        }

        // Add final message

        $message = "===== Slackreport =====\r\n\r\n".$message;

        return [
            'message' => $message,
            'generator' => $generator
        ];
    }
}
