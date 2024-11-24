<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        // Add other columns that are safe to mass-assign here
        'file',
        'created_by',
        'created_date',
        'sended_to',
        'sended_date',
        'accepted_by',
        'accepted_date',
        'return_by',
        'return_date',
        'forwareded_by',
        'forwareded_to',
        'forwarded_date',
        'approved_by',
        'approved_date',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function accepted()
    {
        return $this->belongsTo(User::class, 'accepted_by');
    }

    public function forwarded()
    {
        return $this->belongsTo(User::class, 'forwareded_to');
    }

    public function approved()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function return()
    {
        return $this->belongsTo(User::class, 'return_by');
    }

   
}
