<?php
namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sku', 'description', 'price', 'quantity', 'category_id', 'image', 'user_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user', function ($query) {
            if (Auth::check()) {
                $query->where('user_id', Auth::id());
            }
        });

        static::creating(function ($product) {
            $product->user_id = Auth::id();
        });

        static::updating(function ($product) {
            if ($product->user_id !== Auth::id()) {
                abort(403, 'Unauthorized access');
            }
        });

        static::deleting(function ($product) {
            if ($product->user_id !== Auth::id()) {
                abort(403, 'Unauthorized access');
            }
        });
    }
}
