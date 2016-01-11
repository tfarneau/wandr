<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Service;
use App\Generator;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('UserTableSeeder');
        $this->call('ServiceTableSeeder');
        $this->call('GeneratorTableSeeder');
        // $this->call('ReportTableSeeder');

        Model::reguard();
    }
}


class UserTableSeeder extends Seeder
{
    public function run()
    {

        Model::unguard();

        DB::table('users')->delete();

        $users = array(
            ['first_name' => 'Tristan', 'last_name' => "Farneau", 'email' => 'tfarneau@gmail.com', 'password' => Hash::make('secret')],
            ['first_name' => 'Someone', 'last_name' => "Else", 'email' => 'someone@gmail.com', 'password' => Hash::make('secret')]
        );
            
        foreach ($users as $user)
        {
            User::create($user);
        }

        Model::reguard();

    }
}

class ServiceTableSeeder extends Seeder
{
    public function run()
    {

        Model::unguard();

        DB::table('services')->delete();

        $services = array(
            ['user_id' => 1, 'slug' => 'slack', 'status' => 'ADDED', 'var1' => 'DS ByMySide', 'var2' => 'https://hooks.slack.com/services/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', 'var3' => null, 'var4' => null, 'var5' => null, 'var6' => null],
            ['user_id' => 1, 'slug' => 'ga', 'status' => 'ADDED', 'var1' => 'My GA Account', 'var2' => 'report@slackreport-1180.iam.gserviceaccount.com', 'var3' => 'SlackReport-233ac4da5625.p12', 'var4' => '/keys/1/SlackReport-233ac4da5625.p12', 'var5' => null, 'var6' => null]
        );
            
        foreach ($services as $service)
        {
            Service::create($service);
        }

        Model::reguard();

    }
}

class GeneratorTableSeeder extends Seeder
{
    public function run()
    {

        Model::unguard();

        DB::table('generators')->delete();

        $generators = array(
            // ['user_id' => 1, 'timerange' => -7, 'hours' => 9, 'days' => 1],
            // ['user_id' => 1, 'timerange' => -1, 'hours' => 0, 'days' => -1],
            // ['user_id' => 2, 'timerange' => -3, 'hours' => 9, 'days' => -1],
        );
            
        foreach ($generators as $generator)
        {
            Generator::create($generator);
        }

        Model::reguard();

    }
}

