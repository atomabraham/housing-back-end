<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propertie extends Model
{
    use HasFactory;
    protected $fillable = [
        'propertyName',
        'propertyType',
        'propertyStatus',
        'bedrooms',
        'bathrooms',
        'area',
        'price',
        'country',
        'city',
        'quartier',
        'postalcode',
        'description',
        'agrement',
        'images',
        'contactName',
        'contactEmail',
        'contactPhone',
        'contactEnable',
    ];

    public function user()
    {
        return $this -> belongsTo(User::class,'id');
    }
}
