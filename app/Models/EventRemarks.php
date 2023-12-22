<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRemarks extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_remarks';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'event_no';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $foreignKey = 'appointment_no'; 

    protected $fillable = [
        'status'
    ];
}