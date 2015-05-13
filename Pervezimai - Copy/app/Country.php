<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {

    protected $fillable = [

    ];

    /** Gauti auto registracijas susijusias su šalimi
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function auto_registration()
    {
        return $this->belongsToMany('App\Auto_registration', 'auto_countries');
    }
}
