<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'documents';

    protected $fillable = [
        'user_id',
        'title',
        'document_file',
        'status'
    ];

    public function users()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
