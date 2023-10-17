<?php

declare(strict_types=1);


namespace ElAdmin\LaravelVueAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use SoftDeletes;
}
