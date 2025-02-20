<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $appends = ['aging'];

    protected $table = 'sp_ticket';

    protected $fillable = ['dueDate', 'ownership', 'request','requestorName','client_contactnum','status','type','client_email',
    'ticket_number','fk_branch'];

    public function getAgingAttribute()
    {
        $createdAt = new \DateTime($this->created_at);
        $now = new \DateTime();
        return $now->diff($createdAt)->days;
    }
}
