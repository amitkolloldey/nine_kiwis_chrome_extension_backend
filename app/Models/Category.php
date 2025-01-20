<?php
namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class);
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


        static::creating(function ($category) {
            $category->user_id = Auth::id();
        });


        static::updating(function ($category) {
            if ($category->user_id !== Auth::id()) {
                abort(403, 'Unauthorized access');
            }
        });


        static::deleting(function ($category) {
            if ($category->user_id !== Auth::id()) {
                abort(403, 'Unauthorized access');
            }
        });
    }
}
