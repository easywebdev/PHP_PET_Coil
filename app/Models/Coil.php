<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Coil extends Model
{
    use HasFactory, Notifiable;

    /**
     * @var string
     */
    protected $table = 'coil_coils';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'design_id',
        'wires_id',
    ];

    /**
     * @return mixed
     */
    public function design()
    {
        return $this->belongsTo('App\Models\Design', 'designs_id');
    }

    /**
     * @return mixed
     */
    public function wire()
    {
        return $this->belongsTo('App\Models\Wire', 'wires_id');
    }
}