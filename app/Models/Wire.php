<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Wire extends Model
{
    use HasFactory, Notifiable;

    /**
     * @var string
     */
    protected $table = 'coil_wires';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'conductor_d',
        'full_d',
        'materials_id',
    ];

    /**
     * @return mixed
     */
    public function material()
    {
        return $this->belongsTo('App\Models\Material', 'materials_id');
    }

    /**
     * @return mixed
     */
    public function coils()
    {
        return $this->hasMany('App\Models\Coil', 'wires_id');
    }
}