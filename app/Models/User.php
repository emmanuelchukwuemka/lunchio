<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'phone',
        'company_name',
        'owner_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function teamMembers(): HasMany
    {
        return $this->hasMany(User::class, 'owner_id');
    }

    /**
     * The founder/business-owner account this user's business data belongs to.
     * Returns the user itself for founders, or the founder for invited team members.
     */
    public function businessOwner(): User
    {
        return $this->owner_id ? $this->owner : $this;
    }

    public function isTeamMember(): bool
    {
        return ! is_null($this->owner_id);
    }

    /**
     * Founders always have full access to their own business.
     * Team members must have the specific permission assigned by their founder.
     */
    public function canAccess(string $permission): bool
    {
        return ! $this->isTeamMember() || $this->can($permission);
    }

    /**
     * Whether the business this user belongs to has purchased a package
     * that includes a feature matching the given name/pillar keyword.
     * Admin/staff always pass, since they need to see everything to deliver it.
     */
    public function hasPackageFeatureLike(string $needle): bool
    {
        if ($this->hasRole(['admin', 'staff'])) {
            return true;
        }

        return $this->businessOwner()->orders()->whereHas('package.features', function ($query) use ($needle) {
            $query->where(function ($q) use ($needle) {
                $q->where('name', 'like', "%{$needle}%")
                    ->orWhere('pillar', 'like', "%{$needle}%");
            })->where('package_feature.included', true);
        })->exists();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function websites(): HasMany
    {
        return $this->hasMany(Website::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }

    public function assignedOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'assigned_staff_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function contentCalendarItems(): HasMany
    {
        return $this->hasMany(ContentCalendarItem::class);
    }

    public function intakeDrafts(): HasMany
    {
        return $this->hasMany(IntakeDraft::class);
    }

    public function expertBookings(): HasMany
    {
        return $this->hasMany(ExpertBooking::class);
    }

    public function blogPosts(): HasMany
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }
}
