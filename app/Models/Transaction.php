<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'transaction_date', 'amount', 'description','user_id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['transaction_date'];

    /**
     * Get the category that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function setTransactionDateAtribute($value)
    {
        $this->attributes['transaction_date'] = Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');
    }

    protected static function booted()
    {
        static::addGlobalScope('by_user', function (Builder $builder){
            $builder->where('user_id', auth()->id());
        });
    }
}
