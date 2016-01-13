<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Generator;
use App\Report;

use App\Modules\GoogleAnalyticsModule;
use App\Modules\SlackModule;

class GenerateReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'engine:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run engine and watch for reports';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Generating reports ...');

        $generators = Generator::where('is_active',1)->get();
        foreach($generators as $generator){

            $activation_hours = explode(',',$generator['activation_hours']);
            $activation_days = explode(',',$generator['activation_days']);

            $this->info('Testing '.$generator['name'].' ...');

            $is_day = false;
            $is_hour = false;
            $actual_time = time()+3600; // UTC+1 = 3600 secondes

            $actual_day = date( "w", $actual_time);
            foreach($activation_days as $day){
                if($day == $actual_day){ $is_day = true; }
            }
            if($is_day){ $this->info('It is today !'); }

            $actual_hour = date( "H", $actual_time);
            foreach($activation_hours as $hour){
                if($hour == $actual_hour){ $is_hour = true; }
            }
            if($is_hour){ $this->info('It is hour !'); }

            if($is_day == true && $is_hour == true){
                $this->info('Publishing to slack ...');

                $data = GoogleAnalyticsModule::create_report($generator);
                SlackModule::send_report($data, $generator);

                $report = new Report([
                    'user_id' => $generator['user_id'],
                    'generator_id' => $generator['id'],
                    'text' => 'nothing'
                ]);

                $report->save();
            }

        }



    }
}
