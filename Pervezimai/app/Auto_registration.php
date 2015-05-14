<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Auto_registration extends Model {

    protected $fillable = [
        'auto_id',
        'auto_name',
        'user_id',
        'auto_city',
        'extra_services',
        'price_h',
        'price_km',
        'auto_comment'
    ];

    /**
     * Gauti kategorijas susijusias su auto registracija
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category', 'auto_categories');
    }

    /**
     * Gauti šalis susijusias su auto registracija
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function countries()
    {
        return $this->belongsToMany('App\Country', 'auto_countries');
    }

    /**
     * Vienai auto registracijai priklauso vienas automobilio tipas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function auto_types()
    {
        return $this->belongsTo('App\Auto_type', 'auto_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function auto_orders()
    {
        return $this->hasMany('App\Order');
    }

    /**
     * Gauti sarassa saliu, kurios yra susietos su automobilio id
     *
     * @return mixed
     */
    public function getCategoryListAttribute()
    {
        return $this->categories->lists('id');
    }

    public function getCountryListAttribute()
    {
        return $this->countries->lists('id');
    }
}
