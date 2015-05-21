<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model {

    protected $fillable = [
        'evaluation',
        'provider_id',
        'client_id',
        'evaluation_comment'
    ];

    /**
     * įvertinimas priklauso vienam vartotojui ir turi vieną tiekėją.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function evaluate_provider()
    {
        return $this->belongsTo('App\User', 'provider_id');
    }
    public function evaluate_client()
    {
        return $this->hasOne('App\User', 'id', 'client_id');
    }

}

