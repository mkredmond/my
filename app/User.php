<?php

namespace App;

use App\Group;
use App\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // protected $permissions = ['do_not_allow'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'givenname', 'email', 'password', 'dn', 'surname', 'title',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Mutator to enforce that passwords are encrypted everytime
     * @param string $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Setup relationship to be used with a pivot table
     * @return Illuminate\Database\Eloquent\Relations
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Create relationship between user and a role
     * @param  App\Role|string $role
     * @return void
     */
    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->firstOrFail();
        }

        $this->role_id = $role->id;
        return $this->save();
    }

    /**
     * Checks if a user has a role
     * @param  App\Role|string  $role
     * @return boolean
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->role->name === $role;
        }
        return $role->contains('name', $this->role->name);
    }

    /**
     * Setup relationship to be used with a pivot table
     * @return Illuminate\Database\Eloquent\Relations
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    /**
     * Add a user to a group
     * @param App\Group|string $group
     */
    public function addToGroup($group)
    {
        if (is_string($group)) {
            $group = Group::where('name', $group)->firstOrFail();
        }

        $this->groups()->save($group);
    }

    /**
     * Check if user is a member of a group
     * @param  App\Group|string  $group
     * @return boolean
     */
    public function isMemberOfGroup($group)
    {
        if (is_string($group)) {
            return $this->groups->contains('name', $group);
        }

        return (bool) $group->intersect($this->groups)->count();
    }
}
