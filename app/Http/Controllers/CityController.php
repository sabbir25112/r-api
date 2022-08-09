<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::limitPaginate();
        return $this->setStatusCode(200)
                    ->setMessage("Cities Fetch Successfully")
                    ->setResourceName('cities')
                    ->responseWithCollection($cities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('city.create')) {
            return $this->responseWithNotAllowed();
        }
        $this->validate($request, [
            'name' => 'required | unique:cities',
        ]);
        try {
            $city = City::create(['name' => $request->name]);
            return $this->setStatusCode(200)
                        ->setMessage("City Created Successfully")
                        ->setResourceName('city')
                        ->responseWithItem($city);
        } catch (\Exception $exception) {
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        if (!auth()->user()->can('city.update')) {
            return $this->responseWithNotAllowed();
        }

        $this->validate($request, [
            'name' => 'required'
        ]);

        try {
            $city->update($request->all());
            return $this->setStatusCode(200)
                        ->setMessage("City Updated Successfully")
                        ->setResourceName('city')
                        ->responseWithItem($city);
        } catch (\Exception $exception) {
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        if (!auth()->user()->can('city.delete')) {
            return $this->responseWithNotAllowed();
        }

        try {
            $city->delete();
            return $this->setStatusCode(200)
                ->setMessage("City Deleted Successfully");
        } catch (\Exception $exception) {
            dd($exception);
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }
    }

    public function showTrashed()
    {
        if (!auth()->user()->can('show.trashed.city')) {
            return $this->responseWithNotAllowed();
        }
        $trashedCitites = City::onlyTrashed()->limitPaginate();
        return $this->setStatusCode(200)
                    ->setMessage("Trashed Cities Fetch Successfully")
                    ->setResourceName('trashed_cities')
                    ->responseWithCollection($trashedCitites);
    }

        public function restoreAll()
    {
        if (!auth()->user()->can('city.restore')) {
            return $this->responseWithNotAllowed();
        }

        $restoredCity = City::onlyTrashed()->restore();
        return $this->setStatusCode(200)
                    ->setMessage("All Cities Restored Successfully");
    }


}
