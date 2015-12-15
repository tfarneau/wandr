<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Flynsarmy\CsvSeeder\CsvSeeder;

use App\User;
use App\Checkpoint;

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
        $this->call('CheckpointTableSeeder');

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
                ['name' => 'Ryan Chenkie', 'email' => 'ryanchenkie@gmail.com', 'password' => Hash::make('secret')],
                ['name' => 'Chris Sevilleja', 'email' => 'chris@scotch.io', 'password' => Hash::make('secret')],
                ['name' => 'Holly Lloyd', 'email' => 'holly@scotch.io', 'password' => Hash::make('secret')],
                ['name' => 'Adnan Kukic', 'email' => 'adnan@scotch.io', 'password' => Hash::make('secret')],
        );
            
        foreach ($users as $user)
        {
            User::create($user);
        }

        Model::reguard();

    }
}

class CheckpointTableSeeder extends CsvSeeder
{
    public function __construct()
    {
        $this->table = 'landuses';
        $this->csv_delimiter = ';';
        $this->filename = base_path().'/database/seeds/csvs/grass.csv';
        $this->offset_rows = 1;
        $this->mapping = [
            0 => 'key',
            1 => 'value',
            2 => 'name',
            3 => 'lat',
            4 => 'lng',
            5 => 'source_id',
            6 => 'source_type',
            7 => 'surface'
        ];
    }

    public function run()
    {

        DB::table('checkpoints')->delete(); // OR DB::table($this->table)->truncate();
        parent::run();        

    }
}
