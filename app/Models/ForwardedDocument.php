<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForwardedDocument extends Model
{
    use HasFactory;
    protected $fillable = ['document_id', 'forwarded_to', 'accepted_by', 'accepted_date'];

    public function forwarded(){
        return $this->belongsTo(User::class, 'forwarded_to');
    }

    public function accepted(){
        return $this->belongsTo(User::class, 'accepted_by');
    }

    public function file(){
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function sender(){
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function senderemail(){
        return $this->belongsTo(User::class, 'forwarded');
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

}
