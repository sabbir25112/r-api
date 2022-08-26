<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::limitPaginate();
        return $this->setStatusCode(200)
                    ->setMessage("Cities Fetch Successfully")
                    ->setResourceName('cities')
                    ->responseWithCollection($cities);
    }

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

    public function show(City $city)
    {
        //
    }

    public function edit(City $city)
    {
        //
    }

    public function update(Request $request, City $city)
    {
        if (!auth()->user()->can('city.update')) {
            return $this->responseWithNotAllowed();
        }

        $this->validate($request, [
            'name' => 'required'
        ]);

        try {
            $city->update(['name' => $request->name]);
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

    public function destroy(City $city)
    {
        if (!auth()->user()->can('city.delete')) {
            return $this->responseWithNotAllowed();
        }

        try {
            $city->delete();
            return $this->setStatusCode(200)
                        ->setMessage("City Deleted Successfully")
                        ->responseWithSuccess();
        } catch (\Exception $exception) {
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }
    }
}
