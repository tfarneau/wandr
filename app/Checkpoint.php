<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkpoint extends Model
{
    protected $table = 'checkpoints';

    protected $fillable = ['fs_id','name','lat','lng','checkin_count','photo_original','photo_saved','url','rating','address','tip'];
}