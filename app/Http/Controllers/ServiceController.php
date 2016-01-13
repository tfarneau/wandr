<?php

namespace App\Http\Controllers;

use Validator;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

use App\Modules\GoogleAnalyticsModule;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Service;
use App\Generator;

class ServiceController extends ApiController
{

    public function index_slack(){
        $services = Service::where('slug', 'slack')->where('user_id', Auth::user()->id)->get();
        return view('services.slack')->with(compact('services'));
    }

    public function index_stats(){
        $services = Service::where('slug', 'ga')->where('user_id', Auth::user()->id)->get();
        return view('services.stats')->with(compact('services'));
    }

    public function delete($id){

        $deleted = Service::where('id', $id)->where('user_id', Auth::user()->id)->delete();

        Generator::where('ga_service_id', $id)->where('user_id', Auth::user()->id)->update(['ga_service_id' => -1,'is_active' => 0]);
        Generator::where('slack_service_id', $id)->where('user_id', Auth::user()->id)->update(['slack_service_id' => -1,'is_active' => 0]);

        $message = $deleted == 1 ? "Service successfully deleted !" : "Error deleting service";

        return redirect()->back()->with('message',$message);

    }

    public function create($slug){

        return view('services.add')->with('slug',$slug);

    }

    public function add(Request $request){


        $input = $request->all();
        isset($request->slug) ? $input['slug'] = $request->slug : null;

        if($input['slug'] == "slack"){

            $validator = Validator::make(
                $input, 
                [
                    'var1' => 'required|max:255|min:1',
                    'var2' => 'required|max:255|min:30'
                ]
            );


            if ($validator->fails())
            {
                return redirect()->back()
                    ->with('message', 'Error adding your service')
                    ->withErrors($validator)
                    ->withInput();
            }
            else
            {

                $service = new Service([
                    'user_id' => Auth::user()->id,
                    'slug' => $validator->getData()['slug'],
                    'status' => 'ADDED',
                    'var1' => $validator->getData()['var1'],
                    'var2' => $validator->getData()['var2'],
                ]);

                $status = $service->save();

                if($status == 1){
                    return redirect()->back()->with('message', 'Your service was successfully added !');
                }else{
                    return redirect()->back()
                        ->with('message', 'Unknown error while adding your service. Please contact an administrator.')
                        ->withInput();
                }

            }

        }else if($input['slug'] == "ga"){

            $client = new \Google_Client();
            $client->setAuthConfigFile(public_path().'/private/google_oauth.json');
            $client->setAccessType("offline");
            $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/me/service/add/ga');

            $client->addScope(\Google_Service_Analytics::ANALYTICS_READONLY);
            $client->addScope("email");
            $client->addScope("profile");

            if (!isset($_GET['code'])) {
                $auth_url = $client->createAuthUrl();
                return redirect(filter_var($auth_url, FILTER_SANITIZE_URL));
            } else {
                $client->authenticate($_GET['code']);

                $plus = new \Google_Service_Oauth2($client);
                $userinfos = $plus->userinfo->get();

                $tokens = json_decode($client->getAccessToken());

                $service = new Service([
                    'user_id' => Auth::user()->id,
                    'slug' => 'ga',
                    'status' => 'ADDED',
                    'var1' => $userinfos->email,
                    'var2' => $tokens->refresh_token,
                    'var3' => $userinfos->id,
                    'var4' => $userinfos->locale,
                    'var5' => $userinfos->picture,
                    'var6' => $userinfos->name
                ]);

                $service->save();

                return redirect()->back()->with('message', 'Your service was successfully added !');
            }

        }

    }

    /*public function test($id){

        $generator = Service::where('id',(int) $id)->where('user_id', Auth::user()->id)->first();

        $client = GoogleAnalyticsModule::create_google_client($generator);
        $analytics = GoogleAnalyticsModule::create_analytics_client($client);

        $accounts = $analytics->management_accounts->listManagementAccounts();

        return [$generator, $accounts->getItems()];

    }*/


}
