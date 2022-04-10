<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{   
    use HasFactory;

    protected $table = 'todos';

    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'done',
        'done_at'
    ];

    protected $casts = [
        'done' => 'boolean',
    ];

    public function done(): void
    {
        $this->update([
            'done' => true,
            'done_at' => Carbon::now()
        ]);
    }

    public function undone(): void
    {
        $this->update([
            'done' => false,
            'done_at' => null
        ]);
    }

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        
    ];
}
