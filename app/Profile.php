<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class Profile extends Model
{
    use InsertOnDuplicateKey;

    //protected $primaryKey = ['battle_tag','server'];
    protected $fillable = ['battle_tag','server'];
}
