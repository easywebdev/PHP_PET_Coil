<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Material extends Model
{
    use HasFactory, Notifiable;

    /**
     * @var string
     */
    protected $table = 'coil_materials';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'density',
        'resistivity',
    ];

    /**
     * @return mixed
     */
    public function wires()
    {
        return $this->hasMany('App\Models\Wire', 'materials_id');
    }
}