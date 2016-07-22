<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	  /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    protected $fillable = [
        'label', 'name'
    ];

    /**
     * Create relationship with a user
     * @return Illuminate\Database\Eloquent\Relations
     */
    public function user()
    {
    	return $this->hasMany(User::class);
    }

    /**
     * Create relationship with permissions
     * @return Illuminate\Database\Eloquent\Relations
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Assign a permission to a role
     * @param  App\Permission|string $permission
     * @return boolean
     */
    public function giveRolePermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::whereName($permission)->firstOrFail();
        }
        return $this->permissions()->save($permission);
    }

    /**
     * Check if role has a permission
     * @param  App\Permission|string  $permission
     * @return boolean
     */
    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            return $this->permissions->contains('name', $permission);
        }

        return $this->permissions->contains('name', $permission->name);
    }
}
