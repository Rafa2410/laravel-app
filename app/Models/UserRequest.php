<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'invoice_code',
        'request_num',
        'company_id',
        'plant_id',
        'cost_center_id',
        'user_id',
        'status_id',
        'contact_id',
        'reason',
        'start_date',
        'end_date',
        'room_id',
        'can_interrump',
        'content',
        'number_persons'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    /**
     * Get the user for the requests.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get the request company.
     */
    public function company()
    {
        return $this->hasOne(Company::class);
    }

    /**
     * Get the request plant.
     */
    public function plant()
    {
        return $this->hasOne(Plant::class);
    }

    /**
     * Get the request cost center.
     */
    public function costCenter()
    {
        return $this->hasOne(CostCenter::class);
    }

    /**
     * Get the request user
     */
    public function requestUser()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get the approvers users
     */
    public function approvers()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the status of the request
     */
    public function status()
    {
        return $this->hasOne(Status::class);
    }

    /**
     * Get the contact user of the request
     */
    public function contact()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get the request room
     */
    public function room()
    {
        return $this->hasOne(Room::class);
    }

    /**
     * Get the service types of the request
     */
    public function serviceTypes()
    {
        return $this->belongsToMany(ServiceType::class);
    }

    /**
     * Get user
     */
    public function getUser($id) {
        return User::findOrFail($id);
    }

    /**
     * Get company
     */
    public function getCompany($id) {
        return Company::findOrFail($id);
    }

    /**
     * Get plant
     */
    public function getPlant($id) {
        return Plant::findOrFail($id);
    }

    /**
     * Get cost center
     */
    public function getCostCenter($id) {
        return CostCenter::findOrFail($id);
    }

    /**
     * Get status
     */
    public function getStatus($id) {
        return Status::findOrFail($id);
    }
}
