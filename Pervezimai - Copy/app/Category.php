<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $fillable = [

        'category',

    ];

    /**
     * Gauti auto registracijas susijusias su kategorija
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function auto_registration()
    {
        return $this->belongsToMany('App\Auto_registration', 'auto_categories');
    }

}
