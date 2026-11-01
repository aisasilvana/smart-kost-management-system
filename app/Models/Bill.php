<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_assignment_id',
        'billing_month',
        'amount',
        'due_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'due_date' => 'date',
        ];
    }

    public function roomAssignment()
    {
        return $this->belongsTo(RoomAssignment::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
