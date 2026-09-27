<?php

namespace Lara\Common\Models;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    /**
     * @var string
     */
    protected $table = 'lara_sys_blacklist';

    /**
     * @var string[]
     */
    protected $fillable = [
        'ipaddress',
    ];
}
