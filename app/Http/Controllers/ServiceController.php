<?php

namespace App\Http\Controllers;

// use Slack;
use Validator;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Service;
use App\Generator;

class ServiceController extends ApiController
{

    public function delete($id){

        $deleted = Service::where('id', $id)->where('user_id', Auth::user()->id)->delete();

        Generator::where('ga_service_id', $id)->where('user_id', Auth::user()->id)->update(['ga_service_id' => -1,'is_active' => 0]);
        Generator::where('slack_service_id', $id)->where('user_id', Auth::user()->id)->update(['slack_service_id' => -1,'is_active' => 0]);

        $message = $deleted == 1 ? "Service successfully deleted !" : "Error deleting service";

        return redirect()->back()->with('message',$message);

    }

    public function create($slug){

        if($slug == "slack"){

            $setup = [
                'main' => [
                    'title' => 'Slack',
                    'slug' => $slug,
                    'boxtitle' => 'Create a Slack service'
                ],
                'help' => [
                    'title' => 'Create a slack service',
                    'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. In, vitae. Enim natus quas quia. Distinctio commodi, consequatur aperiam enim aut!'
                ],
                'form' => [
                    'var1' => [
                        'label' => "Team's name"
                    ],
                    'var2' => [
                        'label' => 'Slack endpoint',
                        'help' => 'Your slack endpoint can be found in your slack team management area. You can create one <a href="https://my.slack.com/services/new/incoming-webhook">here</a>',
                    ]
                ]
            ];

        }else if($slug == "ga"){
            $setup = [
                'main' => [
                    'title' => 'Google Analytics',
                    'slug' => $slug,
                    'boxtitle' => 'Create a Google Analytics service'
                ],
                'help' => [
                    'title' => 'Create a GA service',
                    'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. In, vitae. Enim natus quas quia. Distinctio commodi, consequatur aperiam enim aut!'
                ],
                'form' => [
                    'var1' => [
                        'label' => "Account's name"
                    ],
                    'var2' => [
                        'label' => "Service's account email"
                    ],
                    'var3' => [
                        'label' => "Keyfile content",
                        'type' => 'file'
                    ]
                ]
            ];
        }

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

                /*$settings = [
                    'username' => 'Slackreport',
                    // 'channel' => '#test2',
                    'link_names' => true
                ];

                $client = new \Maknz\Slack\Client($input['var2'], $settings);
                $status = $client->send('Hey, this is a test message from SlackReport !');*/

                $service = new Service([
                    'user_id' => Auth::user()->id,
                    'slug' => $validator->getData()['slug'],
                    'status' => 'ADDED',
                    'var1' => $validator->getData()['var1'],
                    'var2' => $validator->getData()['var2'],
                ]);

                $status = $service->save();

                if($status == 1){
                    return redirect('me/dashboard')
                        ->with('message', 'Your service was successfully added !');
                }else{
                    return redirect()->back()
                        ->with('message', 'Unknown error while adding your service. Please contact an administrator.')
                        ->withInput();
                }

            }

        }else if($input['slug'] == "ga"){

            /*if (Input::file('var3')->isValid()) {

                $keyfileName = Input::file('var3')->getClientOriginalName();
                $keyfilePath = "/keys/".Auth::user()->id;
                File::makeDirectory(public_path().$keyfilePath, $mode = 0777, true, true);
                Input::file('var3')->move(public_path().$keyfilePath, $keyfileName); // uploading file to given path

            }else{

                return redirect()->back()
                    ->with('message', 'Certificate is not valid.')
                    ->withInput();

            }

            $service_account_email = $input['var2'];
            $key = file_get_contents(public_path().$keyfilePath.'/'.$keyfileName);

            $validp12 = openssl_pkcs12_read($key,$certs,'notasecret');
            if(!$validp12){
                return redirect()->back()
                    ->with('message', 'Invalid p12file')
                    ->withInput();
            }

            $client = new \Google_Client();
            $client->setApplicationName("HelloAnalytics");
            $analytics = new \Google_Service_Analytics($client);

            $cred = new \Google_Auth_AssertionCredentials($service_account_email,array(\Google_Service_Analytics::ANALYTICS_READONLY),$key);
            $client->setAssertionCredentials($cred);
            if($client->getAuth()->isAccessTokenExpired()) {
                try {
                    $client->getAuth()->refreshTokenWithAssertion($cred);
                } catch (\Exception $e){
                    $error = "Error while connecting to your account.";
                    if(strpos($e->getMessage(), 'invalid_grant') != false){ $error = "Invalid email or certificate file"; }
                    return redirect()->back()
                        ->with('message', $error)
                        ->withInput();
                }
            }
     
            $accounts = $analytics->management_accounts->listManagementAccounts();

            if(count($accounts->getItems()) > 0){

                $service = new Service([
                    'user_id' => Auth::user()->id,
                    'slug' => $input['slug'],
                    'status' => 'ADDED',
                    'var1' => $input['var1'],
                    'var2' => $service_account_email,
                    'var3' => $keyfileName,
                    'var4' => $keyfilePath.'/'.$keyfileName
                ]);

                $status = $service->save();

                if($status == 1){
                    return redirect('me/dashboard')
                        ->with('message', 'Your Google service was successfully added !');
                }else{
                    return redirect()->back()
                        ->with('message', 'Unknown error while adding your service. Please contact an administrator.')
                        ->withInput();
                }

            }else{

                return redirect()->back()
                        ->with('message', 'Error, add a website to your analytics account !')
                        ->withInput();
            }*/

            
            

            /*$code = $request->get('code');
            $googleService = \OAuth::consumer('Google');

            if ( ! is_null($code))
            {

                $token = $googleService->requestAccessToken($code);
                // $result = json_decode($googleService->request('https://www.googleapis.com/analytics/v3/management/accounts'), true);
                $result = json_decode($googleService->request('https://www.googleapis.com/oauth2/v1/userinfo'), true);

                $service = new Service([
                    'user_id' => Auth::user()->id,
                    'slug' => 'ga',
                    'status' => 'ADDED',
                    'var1' => $result['email'],
                    'var2' => $result['name'],
                ]);

                $status = $service->save();

                if($status == 1){
                    return redirect('/dashboard')
                        ->with('message', 'Your service was successfully added !');
                }else{
                    return redirect()->back()
                        ->with('message', 'Unknown error while adding your service. Please contact an administrator.')
                        ->withInput();
                }

            }
            else
            {
                $url = $googleService->getAuthorizationUri();
                return redirect((string)$url);
            }*/



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

                return redirect('me/dashboard')->with('message', 'Your service was successfully added !');
            }

        }

    }

    public function test($id){

        $generator = Service::where('id',(int) $id)->where('user_id', Auth::user()->id)->first();

        $client = new \Google_Client();
        $client->setAuthConfigFile(public_path().'/private/google_oauth.json');
        $client->refreshToken($generator['var2']);

        $analytics = new \Google_Service_Analytics($client);
        $accounts = $analytics->management_accounts->listManagementAccounts();

        return [$generator, $accounts->getItems()];

    }

    /*public function index()
    {

        $services = JWTAuth::parseToken()->authenticate()->services;

        if($services == null){
            return $this->respondError('NOT_FOUND',[]);
        }else{
            return $this->respondSuccess('SUCCESS', Service::transformMany($services));
        }

    }

    public function show($slug)
    {
        
        $user = JWTAuth::parseToken()->authenticate();
        $service = Service::where('slug', $slug)->where('user_id', $user['id'])->first();
        
        if($service == null){
            return $this->respondError('NOT_FOUND', []);
        }else{
            return $this->respondSuccess('SUCCESS', Service::transform($service));
        }

    }

    public function action($slug,$action)
    {
        
        // Actions by service

        if($slug == "ga"){

            if($action == "hello"){
                return $this->respondSuccess('YO', null);
            }

        }

    }

    public function update()
    {
        
    }

    public function store()
    {
        
    }

    public function delete()
    {
    
    }*/


}
