<?php

namespace Modules\Account\Http\Controllers;

use Modules\Support\Country;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Address;
use Modules\Account\Entities\DefaultAddress;
use Modules\Account\Http\Requests\SaveAddressRequest;

class AccountAddressController extends Controller
{
    public function index()
    {
        return view('storefront::public.account.addresses.index', [
            'addresses' => auth()->user()->addresses->keyBy('id'),
            'defaultAddress' => auth()->user()->defaultAddress,
            'countries' => Country::supported(),
        ]);
    }


    public function store(SaveAddressRequest $request)
    {
        $address = auth()->user()->addresses()->create($request->all());

        return response()->json([
            'address' => $address,
            'message' => trans('account::messages.address_created'),
        ]);
    }


    public function update(SaveAddressRequest $request, $id)
    {
        $address = Address::find($id);
        $address->update($request->all());

        return response()->json([
            'address' => $address,
            'message' => trans('account::messages.address_updated'),
        ]);
    }


    public function destroy($id)
    {
        auth()->user()->addresses()->find($id)->delete();

        return response()->json([
            'message' => trans('account::messages.address_deleted'),
        ]);
    }


    public function changeDefault()
    {
        DefaultAddress::updateOrCreate(
            ['customer_id' => auth()->id()],
            ['address_id' => request('address_id')]
        );

        return trans('account::messages.default_address_updated');
    }
}
