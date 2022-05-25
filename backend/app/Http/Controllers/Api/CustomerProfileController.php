<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use App\Facades\Response;
use App\Enums\AddressType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AddressRequest;

class CustomerProfileController extends Controller
{
    /**
     * Get the authenticated customer profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        $customer = Customer::find(auth()->user()->id);
        return new ApiResource($customer->load('address')->append('billingAddress', 'shippingAddress'));
    }

    /**
     * Update authenticated customer profile.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $validated = $this->validate($request, [
            'firstName'                => 'required|string|between:2,100',
            'lastName'                 => 'required|string|between:2,100',
            'email'                    => ['required', 'email', Rule::unique('customers', 'email')->ignore(auth()->user()->id)],
            'phone'                    => ['required', 'min:10', Rule::unique('customers', 'phone')->ignore(auth()->user()->id)],
        ]);

        auth()->user()->update(array_merge(
            $request->only('firstName', 'lastName', 'email', 'phone')
        ));

        return new ApiResource(auth()->user());
    }

    /**
     * Update authenticated customer address.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAddress(AddressRequest $request)
    {
        DB::transaction(function () use ($request) {
            // Set present address
            if (!empty($request->billingAddress)) {
                auth()->user()->address()->updateOrCreate(
                    [
                        'type'      => AddressType::BILLING_ADDRESS(),
                    ],
                    [
                        'street'    => $request->billingAddress['street'],
                        'city'      => $request->billingAddress['city'],
                        'state'     => $request->billingAddress['state'],
                        'zipcode'   => $request->billingAddress['zipcode'],
                        'country'   => $request->billingAddress['country'],
                    ]
                );
            }

            // Set shipping address
            if (!empty($request->shippingAddress)) {
                auth()->user()->address()->updateOrCreate(
                    [
                        'type'      => AddressType::SHIPPING_ADDRESS(),
                    ],
                    [
                        'street'    => $request->shippingAddress['street'],
                        'city'      => $request->shippingAddress['city'],
                        'state'     => $request->shippingAddress['state'],
                        'zipcode'   => $request->shippingAddress['zipcode'],
                        'country'   => $request->shippingAddress['country'],
                    ]
                );
            }
        });
        return new ApiResource(auth()->user());
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
        return Response::error("Old password doesn't matched.", [], 422);
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

        return new ApiResource(auth()->user());
    }
}
