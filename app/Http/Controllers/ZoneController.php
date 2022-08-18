<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zones = Zone::limitPaginate();
        return $this->setStatusCode(200)
                    ->setMessage("Zones Fetch Successfully")
                    ->setResourceName('zones')
                    ->responseWithCollection($zones);
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
        if (!auth()->user()->can('zone.create')) {
            return $this->responseWithNotAllowed();
        }
        $this->validate($request, [
            'name' => 'required',
            'city_id' => 'required',
        ]);
        try {
            $zone = Zone::create([
                'name' => $request->name,
                'city_id' => $request->city_id,
            ]);
            return $this->setStatusCode(200)
                        ->setMessage("Zone Created Successfully")
                        ->setResourceName('zone')
                        ->responseWithItem($zone);
        } catch (\Exception $exception) {
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function show(Zone $zone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function edit(Zone $zone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zone $zone)
    {
        if (!auth()->user()->can('zone.update')) {
            return $this->responseWithNotAllowed();
        }

        $this->validate($request, [
            'name' => 'required',
            'city_id' => 'required',
        ]);

        try {
            $zone->update([
                'name' => $request->name,
                'city_id' => $request->city_id,
            ]);
            return $this->setStatusCode(200)
                        ->setMessage("Zone Updated Successfully")
                        ->setResourceName('zone')
                        ->responseWithItem($zone);
        } catch (\Exception $exception) {
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zone $zone)
    {
        if (!auth()->user()->can('zone.delete')) {
            return $this->responseWithNotAllowed();
        }

        try {
            $zone->delete();
            return $this->setStatusCode(200)
                ->setMessage("Zone Deleted Successfully");
        } catch (\Exception $exception) {
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }
    }
}
