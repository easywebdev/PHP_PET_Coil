<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Design extends Model
{
    use HasFactory, Notifiable;

    /**
     * @var string
     */
    protected $table = 'coil_designs';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'inner_d',
        'outer_d',
        'length',
    ];

    /**
     * @return mixed
     */
    public function coils()
    {
        return $this->hasMany('App\Models\Coil', 'designs_id');
    }
}