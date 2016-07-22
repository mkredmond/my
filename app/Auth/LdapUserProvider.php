<?php

namespace App\Auth;

use App\Auth\Ldap;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Auth\User;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Support\Str;

class LdapUserProvider implements UserProvider
{
    /**
     * The hasher implementation.
     *
     * @var \Illuminate\Contracts\Hashing\Hasher
     */
    protected $hasher;

    /**
     * The Eloquent user model.
     *
     * @var string
     */
    protected $model;

    /**
     * Create a new database user provider.
     *
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @param  string  $model
     * @return void
     */
    public function __construct(HasherContract $hasher, $model)
    {
        $this->model  = $model;
        $this->hasher = $hasher;
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        return $this->createModel()->newQuery()->find($identifier);
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed  $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        $model = $this->createModel();

        return $model->newQuery()
            ->where($model->getAuthIdentifierName(), $identifier)
            ->where($model->getRememberTokenName(), $token)
            ->first();
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $token
     * @return void
     */
    public function updateRememberToken(UserContract $user, $token)
    {
        $user->setRememberToken($token);

        $user->save();
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials)) {
            return;
        }

        $ldap = new Ldap('academia.sjfc.edu');
        $ldap->openConnection();

        if ($ldap->attemptLogin($credentials)) {

            $adUser = $ldap->getUserInfo();

            $ldap->closeConnection();

            $query = $this->createModel()->newQuery();

            if (!$query->where('username', $adUser['dn'])->exists()) {
                $this->insertAdUser($adUser, $credentials);
            }

            $appUser = $query->first();

            if (!$this->hasher->check($credentials['password'], $appUser->getAuthPassword())) {
                $this->syncNewAdPassword($appUser, $credentials);
                $appUser->assignRole('user');
            }

            return $appUser;

        } else {
            $query = $this->createModel()->newQuery();

            foreach ($credentials as $key => $value) {
                if (! Str::contains($key, 'password')) {
                    $query->where($key, $value);
                }
            }

            return $query->first();
        } 
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['password'];

        return $this->hasher->check($plain, $user->getAuthPassword());
    }

    /**
     * Create a new instance of the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createModel()
    {
        $class = '\\' . ltrim($this->model, '\\');
        return new $class;
    }

    /**
     * Gets the hasher implementation.
     *
     * @return \Illuminate\Contracts\Hashing\Hasher
     */
    public function getHasher()
    {
        return $this->hasher;
    }

    /**
     * Sets the hasher implementation.
     *
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @return $this
     */
    public function setHasher(HasherContract $hasher)
    {
        $this->hasher = $hasher;

        return $this;
    }

    /**
     * Gets the name of the Eloquent user model.
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Sets the name of the Eloquent user model.
     *
     * @param  string  $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Add the necessary information for a user
     * logging in for the first time.
     *
     * @param  array $attributes
     * @param  array $credentials
     * @return boolean
     */
    public function insertAdUser($attributes, $credentials)
    {
        $user = new \App\User;

        $user->username  = $attributes['dn'];
        $user->givenname = $attributes['givenname'];
        $user->surname   = $attributes['surname'];
        $user->email     = $attributes['email'];
        $user->title     = $attributes['title'];
        $user->user_type = 'Active Directory';

        return $user->save();
    }

    /**
     * Update password within the app database if the
     * user was able to bind to LDAP but hashed
     * password does not match hash in app database.
     *
     * @param  \App\User $user
     * @param  array    $credentials
     * @return boolean
     */
    public function syncNewAdPassword(\App\User $user, $credentials)
    {
        $user->password = $credentials['password'];
        return $user->save();
    }
}
