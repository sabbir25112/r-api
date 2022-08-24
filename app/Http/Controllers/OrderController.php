<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Parcel;
use App\Models\ParcelOrder;
use App\Order\DeliveryShift;
use App\Order\PaymentType;
use App\Order\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if (!auth()->user()->can('order.create')) {
            return $this->responseWithNotAllowed();
        }

        $PARCEL_ORDER_DOT   = 'parcel_orders.*.';
        $PARCEL_DOT         = 'parcels.*.';

        $this->validate($request, [
            // Order Validation
            'service_id'    => 'required|integer|exists:services,id',
            'merchant_id'   => 'required|integer|exists:merchants,id',
            'pickup_date'   => 'required|date',
            'payment_type'  => 'required|in:' . implode(',', PaymentType::TYPES),

            // Parcel Order Validation
            $PARCEL_ORDER_DOT. 'customer_mobile'    => ['required', 'regex:/(^(01))[1|3-9]{1}(\d){8}$/'],
            $PARCEL_ORDER_DOT. 'customer_address'   => 'required',
            $PARCEL_ORDER_DOT. 'customer_name'      => 'required',
            $PARCEL_ORDER_DOT. 'city_id'            => 'required',
            $PARCEL_ORDER_DOT. 'delivery_shift'     => 'required|in:' . implode(',', DeliveryShift::SHIFTS),
            $PARCEL_ORDER_DOT. "parcels"            => 'required',

            // Parcel Validation
            $PARCEL_ORDER_DOT. $PARCEL_DOT. 'name'          => 'required',
            $PARCEL_ORDER_DOT. $PARCEL_DOT. 'quantity'      => 'required',
            $PARCEL_ORDER_DOT. $PARCEL_DOT. 'cod_amount'    => 'required|integer',

        ]);

        DB::beginTransaction();

        try {
            $order = Order::create(
                [
                    'service_id'    => $request->service_id,
                    'pickup_date'   => Carbon::parse($request->pickup_date),
                    'merchant_id'   => $request->merchant_id,
                    'payment_type'  => $request->payment_type,
                    'status'        => Status::PLACED,
                ]);

            foreach ($request->parcel_orders as $request_parcel_order)
            {
                $parcel_order = ParcelOrder::create([
                    'order_id'              => $order->id,
                    'customer_name'         => $request_parcel_order['customer_name'],
                    'customer_mobile'       => $request_parcel_order['customer_mobile'],
                    'customer_address'      => $request_parcel_order['customer_address'],
                    'city_id'               => $request_parcel_order['city_id'],
                    'pickup_date'           => $request->pickup_date,
                    'order_request'         => $request_parcel_order['order_request'],
                    'delivery_shift'        => $request_parcel_order['delivery_shift'],
                ]);

                $parcels = [];
                foreach ($request_parcel_order['parcels'] as $parcel)
                {
                     $parcels[] = [
                         'parcel_order_id'   => $parcel_order->id,
                         'name'              => $parcel['name'],
                         'quantity'          => $parcel['quantity'],
                         'cod_amount'        => $parcel['cod_amount'],
                     ];
                }
                Parcel::insert($parcels);
            }

            DB::commit();
            return $this->setStatusCode(200)
                        ->setMessage("Order Created Successfully")
                        ->setResourceName('order')
                        ->responseWithItem($order);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order_info = $order->with('parcelOrders.parcels')
                            ->get();

        return $this->setStatusCode(200)
                    ->setMessage("Order Fetch Successfully")
                    ->setResourceName('order_info')
                    ->responseWithItem($order_info);
    }


    public function showParcel(ParcelOrder $parcel_order, $parcel_order_id)
    {
        return $parcel_order->with('parcels')->find($parcel_order_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
