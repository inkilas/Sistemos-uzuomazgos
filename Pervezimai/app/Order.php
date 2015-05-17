<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    protected $fillable = [
        'order_date',
        'extra_services',
        'order_comment',
        'pickup_address',
        'deliver_address',
        'order_key',
        'auto_registration_id',
        'provider_id',
        'category_id',
        'client_id',
        'order_activation'
    ];

    //protected $dates = ['order_date'];

    /**
     * užsakymas priklauso vienam vartotojui ir turi vieną tiekėją.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider()
    {
        return $this->belongsTo('App\User', 'provider_id');
    }
    public function client()
    {
        return $this->belongsTo('App\User', 'client_id');
    }

    /**
     * vienas užsakymas turi vieną kategoriją
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order_category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * Vienas užsakymas turi daug auto_registracijų
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function provider_auto()
    {
        return $this->belongsTo('App\Auto_registration');
    }


}
