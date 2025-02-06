<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Company;



class Listing extends Model
{
    use HasFactory;
    // protected $primaryKey = 'id';
    protected $fillable = ['title','company','location','website','email','description','tags','logo','user_id','company_id'];
 
    public function scopeFilter($query, array $filters){
        if($filters['tag'] ?? false){
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }

        if($filters['search'] ?? false){
            $query->where('title', 'like', '%' . request('search') . '%')->orWhere('description', 'like', '%' . request('search') . '%')->orWhere('tags', 'like', '%' . request('search') . '%');
        }
        
    }

    // Relationship To User
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

     // Relationship To componay
    public function company() {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
