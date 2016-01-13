<?php

use Carbon\Carbon;

namespace App\Modules;

class SlackModule{

	public static function send_report($data, $generator){

		$settings = [
            'username' => config('kubby.SLACK_AUTHOR_NAME'),
            'icon' => config('kubby.SLACK_AUTHOR_ICON'),
            'link_names' => true
        ];

        $client = new \Maknz\Slack\Client($data['generator']['slack_service']['var2'], $settings);

        $finaltext = str_replace('{{date}}',$data['date'],config('kubby.SLACK_PRETEXT'));
        $finaltext = str_replace('{{site}}',$data['generator']['name'],$finaltext);

        $title = 'Kubby report for "'.$data['generator']['name'].'", '.$data['date_full'].' at '.$data['date'];

        $client
        ->to($data['generator']['slack_channel'])
        ->attach([
            'title' => $title,
            'author_name' => config('kubby.SLACK_AUTHOR_NAME'),
            'author_icon' => config('kubby.SLACK_AUTHOR_ICON'),
            'fallback' => $data['message'],
            'text' => $data['message'],
            // 'pretext' => 'Analytics',
            'color' => config('kubby.SLACK_COLOR')
        ])
        ->send($finaltext);

        return true;

	}
}