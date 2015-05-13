<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model {

    protected $fillable = [
        'evaluation',
        'providerID',
        'evaluation_comment'
    ];

}
