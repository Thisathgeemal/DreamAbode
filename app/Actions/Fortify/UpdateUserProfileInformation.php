<?php
namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo'         => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'mobile_number' => ['nullable', 'string', 'max:15'],
            'address'       => ['nullable', 'string', 'max:255'],
            'gender'        => ['nullable', 'in:male,female,other'],
            'dob'           => ['nullable', 'date'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name'          => $input['name'],
                'email'         => $input['email'],
                'mobile_number' => $input['mobile_number'] ?? $user->mobile_number,
                'address'       => $input['address'] ?? $user->address,
                'gender'        => $input['gender'] ?? $user->gender,
                'dob'           => $input['dob'] ?? $user->dob,
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name'              => $input['name'],
            'email'             => $input['email'],
            'email_verified_at' => null,
            'mobile_number'     => $input['mobile_number'] ?? $user->mobile_number,
            'address'           => $input['address'] ?? $user->address,
            'gender'            => $input['gender'] ?? $user->gender,
            'dob'               => $input['dob'] ?? $user->dob,
        ])->saveOrFail();

        $user->sendEmailVerificationNotification();
    }
}
