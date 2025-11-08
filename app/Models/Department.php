<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
        'level',
        'employee_count',
        'ambassador_name',
    ];

    protected $casts = [
        'level' => 'integer',
        'employee_count' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Department::class, 'parent_id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('ambassador_name', 'like', "%{$search}%");
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }
}
