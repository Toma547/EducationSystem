<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'name_kana',
        'email',
        'profile_image',
        'password'
    ];

    // プロフィール更新処理
    public function updateProfile(array $validated, $imageFile = null)
    {
        return DB::transaction(function() use ($validated, $imageFile) {
            $path = $this->profile_image;

            if ($imageFile) {
                $path = $imageFile->store('images/profile', 'public');
            }

            $this->update([
                'name'         => $validated['name'],
                'name_kana'    => $validated['name_kana'],
                'email'        => $validated['email'],
                'profile_image'=> $path,
            ]);

            return $this;
        });
    }

    // パスワード更新処理
    public function updatePassword(string $newPassword): self
    {
        return DB::transaction(function() use ($newPassword) {
            $this->password = Hash::make($newPassword);
            $this->save();

            return $this;
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
