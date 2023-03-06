<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Roles extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'roles';

    protected $dates = ['deleted_at'];

    public function role_permission(): HasMany
    {
        return $this->hasMany(RolePermission::class, 'role_id');
    }

    // /**
    //  * The roles that belong to the Roles
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    //  */
    // public function roles(): BelongsToMany
    // {
    //     return $this->belongsToMany(Role::class, 'role_user_table', 'user_id', 'role_id');
    // }
}
