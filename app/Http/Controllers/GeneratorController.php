<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\Generator;
use App\Service;

use Cache;

use Validator;

class GeneratorController extends ApiController
{

    public function index(){
        $generators = Generator::where('user_id', Auth::user()->id)->get();
        return view('generators.index')->with('generators',$generators);
    }

    public function edit($id){

        $services = Auth::user()->services;
        $is_slack_service = false;
        $is_ga_service = false;

        foreach($services as $service){
            if($service['slug'] == "slack"){ $is_slack_service = true; }
            if($service['slug'] == "ga"){ $is_ga_service = true; }
        }

        if(!$is_slack_service OR !$is_ga_service){
            return redirect()->back()->with('message', 'You have to import at least one Slack team and one Google Analtics account to create a generator !');
        }

        if(!$is_slack_service OR !$is_ga_service){
            return redirect()->back()->with('message', 'You have to import at least one Slack team and one Google Analtics account to create a generator !');
        }

        $metas = json_decode(file_get_contents(public_path().'/json/metas.json'))->items;
        $generator = Generator::where('user_id', Auth::user()->id)->where('id',(int) $id)->first();
        return view('generators.create')->with([
            'generator' => $generator,
            'metas' => $metas
        ]);
    }

    public function activate($id){
        $generator = Generator::where('user_id', Auth::user()->id)->where('id',(int) $id)->first();

        if($generator['ga_service_id'] != -1 && $generator['slack_service_id'] != -1){

            $generator->is_active = 1;
            $generator->save();

            return redirect()->back()->with('message','Generator successfully activated');
            
        }else{
            return redirect()->back()->with('message','Error, you have to add a Slack and Analytics account ! Maybe you deleted an account related to this generator.');
        }
    }

    public function unactivate($id){
        $generator = Generator::where('user_id', Auth::user()->id)->where('id',(int) $id)->first();
        $generator->is_active = 0;
        $generator->save();

        return redirect()->back()->with('message','Generator successfully unactivated');
    }

    public function save(Request $request){

        $inputs = $request->all();

        if(isset($inputs['id'])){
            $is_valid = false;
            $generator_check = Generator::where('user_id', Auth::user()->id)->where('id',(int) $inputs['id'])->first();
            if(count($generator_check) == 1){ $is_valid = true; }
        }else{
            $is_valid = true;
        }

        $v = Validator::make(
            $inputs, 
            [
                'ga_service_id' => 'required|exists:services,id',
                'slack_service_id' => 'required|exists:services,id',
                // 'is_active' => 'required',
                'name' => 'required|min:1|max:255',
                'ga_account' => 'required|min:1|max:255',
                'ga_property' => 'required|min:1|max:255',
                'ga_profile' => 'required|min:1|max:255',
                'slack_channel' => 'required|min:1|max:255',
                'start_date' => 'required|min:1|max:255',
                'end_date' => 'required|min:1|max:255',
                'template' => 'required|min:5',
                'activation_hours' => 'required|min:1',
                'activation_days' => 'required|min:1'
            ]
        );


        if ($v->fails() && $is_valid)
        {
            return ['status' => 'error', 'data' => $v->errors()];
        }
        else
        {

            $inputs['user_id'] = Auth::user()->id;

            if(isset($inputs['id'])){
                $generator = Generator::where('user_id', Auth::user()->id)->where('id',(int) $inputs['id'])->first();
                $generator->fill($inputs);
            }else{
                $generator = new Generator($inputs);
            }

            $generator->save();

            return ['status' => 'success', 'data' => null];

        }

    }

    public function test($id){

        $generator = Generator::where('user_id', Auth::user()->id)->where('id',(int) $id)->first();

        if($generator['is_active'] == 1){
            $data = Generator::createReport($generator);

            $settings = [
                'username' => 'Slackreport',
                'link_names' => true
            ];
            $client = new \Maknz\Slack\Client($data['generator']['slack_service']['var2'], $settings);
            $client->send($data['message']);

            return redirect()->back()->with('message', 'A test report was sent to your slack channel');
        }else{
            return redirect()->back()->with('message', 'Error, you have to activate this generator to be enable to test it.');
        }
    }

    public function create(Request $request)
    {   
        $services = Auth::user()->services;
        $is_slack_service = false;
        $is_ga_service = false;

        foreach($services as $service){
            if($service['slug'] == "slack"){ $is_slack_service = true; }
            if($service['slug'] == "ga"){ $is_ga_service = true; }
        }

        if(!$is_slack_service OR !$is_ga_service){
            return redirect()->back()->with('message', 'You have to import at least one Slack team and one Google Analtics account to create a generator !');
        }

        $metas = json_decode(file_get_contents(public_path().'/json/metas.json'))->items;
        return view('generators.create')->with(compact('metas'));
    }

    public function actions($force,$action,$param = null,$param2 = null,$param3 = null){

        if($param != null){

            $service = Service::where('id', (int) $param)->where('user_id', Auth::user()->id)->first();

            $client = new \Google_Client();
            $client->setAuthConfigFile(public_path().'/private/google_oauth.json');
            $client->refreshToken($service['var2']);
            $analytics = new \Google_Service_Analytics($client);

            $cache_key = "ga_".$action."_".$service['id']."_".Auth::user()->id;
            if (Cache::has($cache_key) && $force == "unforce"){
                return Cache::get($cache_key);
            }

        }

        if($action == "getservices"){
            return Service::transformMany(Service::where('slug', 'slack')->orWhere('slug', 'ga')->where('user_id', Auth::user()->id)->get());
        }

        if($action == "getaccounts"){
            $accounts = $analytics->management_accounts->listManagementAccounts();
            $data = $accounts->getItems();
            Cache::add($cache_key, $data, 43200);
            return $data;
        }

        if($action == "getproperties"){
            $properties = $analytics->management_webproperties->listManagementWebproperties($param2);
            $data = $properties->getItems();
            Cache::add($cache_key, $data, 43200);
            return $data;
        }

        if($action == "getprofiles"){
            $profiles = $analytics->management_profiles->listManagementProfiles($param2, $param3);
            $data = $profiles->getItems();
            Cache::add($cache_key, $data, 43200);
            return $data;
        }

        if($action == "testslack"){
            $client = new \Maknz\Slack\Client($service['var2'],[
                'username' => 'Cyril',
                'channel' => '#'.$param2,
                'link_names' => true
            ]);
            
            $client->send('Hey, this is a test message from SlackReport !');
            return 'success';
        }
        
    }

}
