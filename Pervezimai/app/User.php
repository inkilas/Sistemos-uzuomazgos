<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

	protected $fillable = [
        'name',
        'surname',
        'company',
        'email',
        'phone',
        'password',
        'company_code',
        'PVM',
        'countryID',
        'city',
        'address',
        'comment',
        'type'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $table = 'users';

    /**
     * Vartotojas gali turėti daug užsakymų
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clientorders()
    {
        return $this->hasMany('App\Order', 'client_id');
    }

    public function providerorders()
    {
        return $this->hasMany('App\Order', 'provider_id');
    }

    /**
     * Vartotojas gali prisiregistruoti vienoje šalyje
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_country()
    {
        return $this->belongsTo('App\Country');
    }

    /**
     * Vartotojas gali priregistruoti daug transporto priemonių
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_auto()
    {
        return $this->hasMany('App\Auto_registration');
    }

    /**
     * Vartotojas gali būti įvertintas daugelio vartotojų
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evaluation()
    {
        return $this->hasMany('App\Evaluation');
    }

}
