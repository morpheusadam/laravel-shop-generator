<?php

namespace Modules\User\Entities;

use Modules\Order\Entities\Order;
use Modules\User\Admin\UserTable;
use Illuminate\Http\JsonResponse;
use Modules\Review\Entities\Review;
use Illuminate\Auth\Authenticatable;
use Modules\Address\Entities\Address;
use Modules\Product\Entities\Product;
use Modules\User\Repositories\Permission;
use Cartalyst\Sentinel\Users\EloquentUser;
use Modules\Address\Entities\DefaultAddress;
use Illuminate\Database\Eloquent\Collection;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends EloquentUser implements AuthenticatableContract
{
    use Authenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'phone',
        'password',
        'last_name',
        'first_name',
        'permissions',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions' => 'json',
        'last_login' => 'datetime',
    ];


    public static function registered($email)
    {
        return static::where('email', $email)->exists();
    }


    public static function findByEmail($email)
    {
        return static::where('email', $email)->first();
    }


    public static function totalCustomers()
    {
        return Role::findOrNew(setting('customer_role'))->users()->count();
    }


    /**
     * Login the user.
     *
     * @return $this|bool
     */
    public function login()
    {
        return auth()->login($this);
    }


    /**
     * Determine if the user is a customer.
     *
     * @return bool
     */
    public function isCustomer()
    {
        if ($this->hasRoleName('admin')) {
            return false;
        }

        return $this->hasRoleId(setting('customer_role'));
    }


    /**
     * Checks if a user belongs to the given Role Name.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasRoleName($name)
    {
        return $this->roles()->whereTranslation('name', $name)->count() !== 0;
    }


    /**
     * Get the roles of the user.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles')->withTimestamps();
    }


    /**
     * Checks if a user belongs to the given Role ID.
     *
     * @param int $roleId
     *
     * @return bool
     */
    public function hasRoleId($roleId)
    {
        return $this->roles()->whereId($roleId)->count() !== 0;
    }


    /**
     * Check if the current user is activated.
     *
     * @return bool
     */
    public function isActivated()
    {
        return Activation::completed($this);
    }


    /**
     * Get the recent orders of the user.
     *
     * @param int $take
     *
     * @return Collection
     */
    public function recentOrders($take)
    {
        return $this->orders()->latest()->take($take)->get();
    }


    /**
     * Get the orders of the user.
     *
     * @return HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }


    /**
     * Get the default address of the user.
     *
     * @return HasMany
     */
    public function defaultAddress()
    {
        return $this->hasOne(DefaultAddress::class, 'customer_id')->withDefault();
    }


    /**
     * Get the addresses of the user.
     *
     * @return HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class, 'customer_id');
    }


    /**
     * Get the reviews of the user.
     *
     * @return HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }


    /**
     * Get the full name of the user.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }


    /**
     * Set user's permissions.
     *
     * @param array $permissions
     *
     * @return void
     */
    public function setPermissionsAttribute(array $permissions)
    {
        $this->attributes['permissions'] = Permission::prepare($permissions);
    }


    /**
     * Determine if the user has access to the given permissions.
     *
     * @param array|string $permissions
     *
     * @return bool
     */
    public function hasAccess($permissions)
    {
        $permissions = is_array($permissions) ? $permissions : func_get_args();

        return $this->getPermissionsInstance()->hasAccess($permissions);
    }


    /**
     * Determine if the user has access to any given permissions
     *
     * @param array|string $permissions
     *
     * @return bool
     */
    public function hasAnyAccess($permissions)
    {
        $permissions = is_array($permissions) ? $permissions : func_get_args();

        return $this->getPermissionsInstance()->hasAnyAccess($permissions);
    }


    public function wishlistHas($productId)
    {
        return self::wishlist()->where('product_id', $productId)->exists();
    }


    /**
     * Get the wishlist of the user.
     *
     * @return BelongsToMany
     */
    public function wishlist()
    {
        return $this->belongsToMany(Product::class, 'wish_lists')->withTimestamps();
    }


    /**
     * Get table data for the resource
     *
     * @return JsonResponse
     */
    public function table()
    {
        return new UserTable($this->newQuery());
    }
}
