<?php


/*
 * This file is part of Laravel Addressable.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Blok\Addressable\Traits;

use Blok\Addressable\Models\Address;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasAddresses
{
    /**
     * @param string $role
     *
     * @return bool
     */
    public function hasAddress($role)
    {
        return !empty($this->address($role));
    }

    /**
     * @param string $role
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function address($role, $address = null)
    {
        if (is_array($address)) {
            $address = $this->addresses()->create($address);
        }

        if ($address instanceof Model) {
            $address->role($role);
        }

        return $this->addresses()->whereRole($role)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses()
    {
        return $this->morphMany(config('laravel-addressable.models.address'), 'model');
    }
}
