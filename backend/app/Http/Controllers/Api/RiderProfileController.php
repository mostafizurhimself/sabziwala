<?php

namespace App\Http\Controllers\Api;

use App\Models\Rider;
use App\Facades\Response;
use App\Enums\AddressType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RiderProfileController extends Controller
{
    /**
     * Get the authenticated Rider profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        $rider = Rider::find(auth()->user()->id);
        return new ApiResource($rider);
    }

    /**
     * Update authenticated rider profile.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $validated = $this->validate($request, [
            'firstName'                => 'required|string|between:2,100',
            'lastName'                 => 'required|string|between:2,100',
            'email'                    => ['required', 'email', Rule::unique('riders', 'email')->ignore(auth()->user()->id)],
            'phone'                    => ['required', 'min:10', Rule::unique('riders', 'phone')->ignore(auth()->user()->id)],
        ]);

        auth()->user()->update(array_merge(
            $request->only('firstName', 'lastName', 'email', 'phone')
        ));
        $rider = Rider::find(auth()->user()->id);
        return new ApiResource($rider);
    }

    /**
     * Update authenticated rider address.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAddress(Request $request)
    {
        $validated = $this->validate($request, [
            'presentAddress'           => 'required|array',
            'presentAddress.street'    => 'required_with:presentAddress|string|max:250',
            'presentAddress.city'      => 'required_with:presentAddress|string|max:250',
            'presentAddress.state'     => 'required_with:presentAddress|string|max:250',
            'presentAddress.zipcode'   => 'required_with:presentAddress|string|max:50',
            'presentAddress.country'   => 'required_with:presentAddress|string|max:50',
            'permanentAddress'          => 'required|array',
            'permanentAddress.street'   => 'required_with:permanentAddress|string|max:250',
            'permanentAddress.city'     => 'required_with:permanentAddress|string|max:250',
            'permanentAddress.state'    => 'required_with:permanentAddress|string|max:250',
            'permanentAddress.zipcode'  => 'required_with:permanentAddress|string|max:50',
            'permanentAddress.country'  => 'required_with:permanentAddress|string|max:50',
        ]);

        DB::transaction(function () use ($request) {
            // Set present address
            if (!empty($request->presentAddress)) {
                auth()->user()->address()->updateOrCreate(
                    [
                        'type'      => AddressType::PRESENT_ADDRESS(),
                    ],
                    [
                        'street'    => $request->presentAddress['street'],
                        'city'      => $request->presentAddress['city'],
                        'state'    => $request->presentAddress['state'],
                        'zipcode'   => $request->presentAddress['zipcode'],
                        'country'   => $request->presentAddress['country'],
                    ]
                );
            }

            // Set permanent address
            if (!empty($request->permanentAddress)) {
                auth()->user()->address()->updateOrCreate(
                    [
                        'type'      => AddressType::PERMANENT_ADDRESS(),
                    ],
                    [
                        'street'    => $request->permanentAddress['street'],
                        'city'      => $request->permanentAddress['city'],
                        'state'      => $request->permanentAddress['state'],
                        'zipcode'   => $request->permanentAddress['zipcode'],
                        'country'   => $request->permanentAddress['country'],
                    ]
                );
            }
        });
        $rider = Rider::find(auth()->user()->id);
        return new ApiResource($rider);
    }


    /**
     * Reset password for auth user
     */
    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'oldPassword' => 'required|string|min:6',
            'password'    => 'required|string|confirmed|min:6',
        ]);
        if (Hash::check($request->oldPassword, auth()->user()->password)) {
            auth()->user()->update(['password' => Hash::make($request->password)]);
            return Response::success("Password updated successfully.");
        }
        return Response::error("Old password doesn't matched.");
    }

    /**
     * Update profile photo
     */
    public function updateProfilePhoto(Request $request)
    {
        $this->validate($request, [
            'photo' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        auth()->user()->addMedia($request->photo)->toMediaCollection('profile-photo');

        $rider = Rider::find(auth()->user()->id);
        return new ApiResource($rider);
    }

    /**
     * Update verification images
     */
    public function updateVerification(Request $request)
    {
        $this->validate($request, [
            'verificationFront' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'verificationBack'  => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        auth()->user()->addMedia($request->verificationFront)->toMediaCollection('verification-front');
        auth()->user()->addMedia($request->verificationBack)->toMediaCollection('verification-back');

        $rider = Rider::find(auth()->user()->id);
        return new ApiResource($rider);
    }
}