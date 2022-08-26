<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index()
    {
        $zones = Zone::limitPaginate();
        return $this->setStatusCode(200)
                    ->setMessage("Zones Fetch Successfully")
                    ->setResourceName('zones')
                    ->responseWithCollection($zones);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('zone.create')) {
            return $this->responseWithNotAllowed();
        }
        $this->validate($request, [
            'name'      => 'required',
            'city_id'   => 'required',
        ]);
        try {
            $zone = Zone::create([
                'name'      => $request->name,
                'city_id'   => $request->city_id,
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

    public function show(Zone $zone)
    {
        //
    }

    public function edit(Zone $zone)
    {
        //
    }

    public function update(Request $request, Zone $zone)
    {
        if (!auth()->user()->can('zone.update')) {
            return $this->responseWithNotAllowed();
        }

        $this->validate($request, [
            'name'      => 'required',
            'city_id'   => 'required',
        ]);

        try {
            $zone->update([
                'name'      => $request->name,
                'city_id'   => $request->city_id,
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

    public function destroy(Zone $zone)
    {
        if (!auth()->user()->can('zone.delete')) {
            return $this->responseWithNotAllowed();
        }

        try {
            $zone->delete();
            return $this->setStatusCode(200)
                        ->setMessage("Zone Deleted Successfully")
                        ->responseWithSuccess();
        } catch (\Exception $exception) {
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }
    }
}
