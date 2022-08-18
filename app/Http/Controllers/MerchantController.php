<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merchants = Merchant::limitPaginate();
        return $this->setStatusCode(200)
            ->setMessage("Merchants Fetch Successfully")
            ->setResourceName('merchants')
            ->responseWithCollection($merchants);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
                    'name' => $request->name,
                    'mobile' => $request->mobile,
                    'website' => $request->website,
                    'fb_page' => $request->fb_page,
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function show(Merchant $merchant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function edit(Merchant $merchant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
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
                    'name' => $request->name,
                    'mobile' => $request->mobile,
                    'website' => $request->website,
                    'fb_page' => $request->fb_page,
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

    /**
     * Remove the specified resource from storage.
     *+ 0.
     * @param  \App\Models\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Merchant $merchant)
    {
        if (!auth()->user()->can('merchant.delete')) {
            return $this->responseWithNotAllowed();
        }

        try {
            $merchant->delete();
            return $this->setStatusCode(200)
                        ->setMessage("Merchant Deleted Successfully");
        } catch (\Exception $exception) {
            return $this->setStatusCode(500)
                ->setMessage($exception->getMessage())
                ->responseWithError();
        }
    }
}
