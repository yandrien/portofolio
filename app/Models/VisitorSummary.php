<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorSummary extends Model
{
    // Mengizinkan mass assignment agar firstOrCreate bisa berjalan lancar
    protected $fillable = ['id', 'total_visitors', 'total_hits'];
}
