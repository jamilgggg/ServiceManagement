<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $appends = ['aging'];

    protected $table = 'sp_ticket';

    public function getAgingAttribute()
    {
        $createdAt = new \DateTime($this->created_at);
        $now = new \DateTime();
        return $now->diff($createdAt)->days;
    }
}
