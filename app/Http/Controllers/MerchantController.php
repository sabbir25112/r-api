<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function index()
    {
        $merchants = Merchant::limitPaginate();
        return $this->setStatusCode(200)
                    ->setMessage("Merchants Fetch Successfully")
                    ->setResourceName('merchants')
                    ->responseWithCollection($merchants);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('merchant.create')) {
            return $this->responseWithNotAllowed();
        }
        $this->validate($request, [
            'name' => 'required',
        ]);
        try {
            $merchant = Merchant::create(
                [
                    'name'      => $request->name,
                    'mobile'    => $request->mobile,
                    'website'   => $request->website,
                    'fb_page'   => $request->fb_page,
                ]);
            return $this->setStatusCode(200)
                        ->setMessage("Merchant Created Successfully")
                        ->setResourceName('merchant')
                        ->responseWithItem($merchant);
        } catch (\Exception $exception) {
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }
    }

    public function show(Merchant $merchant)
    {
        //
    }

    public function edit(Merchant $merchant)
    {
        //
    }

    public function update(Request $request, Merchant $merchant)
    {
        if (!auth()->user()->can('merchant.update')) {
            return $this->responseWithNotAllowed();
        }

        $this->validate($request, [
            'name' => 'required'
        ]);

        try {
            $merchant->update(
                [
                    'name'      => $request->name,
                    'mobile'    => $request->mobile,
                    'website'   => $request->website,
                    'fb_page'   => $request->fb_page,
                ]);
            return $this->setStatusCode(200)
                        ->setMessage("Merchant Updated Successfully")
                        ->setResourceName('merchant')
                        ->responseWithItem($merchant);
        } catch (\Exception $exception) {
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }
    }

    public function destroy(Merchant $merchant)
    {
        if (!auth()->user()->can('merchant.delete')) {
            return $this->responseWithNotAllowed();
        }

        try {
            $merchant->delete();
            return $this->setStatusCode(200)
                        ->setMessage("Merchant Deleted Successfully")
                        ->responseWithSuccess();
        } catch (\Exception $exception) {
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }
    }
}
