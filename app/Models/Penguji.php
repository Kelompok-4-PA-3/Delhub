<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;


class Penguji extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserStamps;

    protected $fillable = ['user_id','penguji1','penguji2'];
}
