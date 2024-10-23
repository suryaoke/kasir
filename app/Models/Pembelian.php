<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PhpParser\Node\Stmt\Return_;

class Pembelian extends Model
{
    //
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(supplier::class);
    }
}
