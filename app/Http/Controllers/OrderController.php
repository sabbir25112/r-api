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
    public function index()
    {
        $orders = Order::with('parcelOrders.parcels')->limitPaginate();
        return $this->setStatusCode(200)
            ->setMessage("Orders Fetch Successfully")
            ->setResourceName('orders')
            ->responseWithCollection($orders);
    }

    public function create()
    {
        //
    }

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
            $PARCEL_ORDER_DOT. 'parcels'            => 'required',

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

    public function show(Order $order)
    {
        $order_info = $order->with('parcelOrders.parcels')
                            ->get();

        return $this->setStatusCode(200)
                    ->setMessage("Order Fetch Successfully")
                    ->setResourceName('order_info')
                    ->responseWithItem($order_info);
    }

    public function showParcelOrder(ParcelOrder $parcel_order, $parcel_order_id)
    {
        $parcel_order_info = $parcel_order->with('parcels')
                                        ->find($parcel_order_id);

        return $this->setStatusCode(200)
                    ->setMessage("Parcel Order Fetch Successfully")
                    ->setResourceName('parcel_order_info')
                    ->responseWithItem($parcel_order_info);
    }

    public function edit(Order $order)
    {
        //
    }

    public function update(Request $request, Order $order)
    {
        if (!auth()->user()->can('order.update')) {
            return $this->responseWithNotAllowed();
        }

        $this->validate($request, [
            'service_id'    => 'required|integer|exists:services,id',
            'merchant_id'   => 'required|integer|exists:merchants,id',
            'pickup_date'   => 'required|date',
            'payment_type'  => 'required|in:' . implode(',', PaymentType::TYPES),
        ]);
        if($request->status)
        {
            return $this->setStatusCode(400)
                        ->setMessage("status cant be changed from here")
                        ->responseWithError();
        }

        try {
            $order->update(
                [
                    'service_id'    => $request->service_id,
                    'pickup_date'   => Carbon::parse($request->pickup_date),
                    'merchant_id'   => $request->merchant_id,
                    'payment_type'  => $request->payment_type,
                ]
            );
            return $this->setStatusCode(200)
                        ->setMessage("Order Updated Successfully")
                        ->setResourceName('order')
                        ->responseWithItem($order);
        } catch (\Exception $exception) {
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }
    }

    public function updateParcelOrder(Request $request, $parcel_order_id)
    {
        if (!auth()->user()->can('parcel.order.update')) {
            return $this->responseWithNotAllowed();
        }

        $parcel_order = ParcelOrder::find($parcel_order_id);

        $this->validate($request, [
            'customer_mobile'   => ['required', 'regex:/(^(01))[1|3-9]{1}(\d){8}$/'],
            'customer_address'  => 'required',
            'customer_name'     => 'required',
            'city_id'           => 'required',
            'pickup_date'       => 'required|date',
            'delivery_shift'    => 'required|in:' . implode(',', DeliveryShift::SHIFTS),
        ]);
        if($request->status)
        {
            return $this->setStatusCode(400)
                        ->setMessage("status cant be changed from here")
                        ->responseWithError();
        }

        try {
            $parcel_order->update(
                [
                    'customer_name'     => $request->customer_name,
                    'customer_mobile'   => $request->customer_mobile,
                    'customer_address'  => $request->customer_address,
                    'city_id'           => $request->city_id,
                    'pickup_date'       => $request->pickup_date,
                    'order_request'     => $request->order_request,
                    'delivery_shift'    => $request->delivery_shift,
                ]
            );
            return $this->setStatusCode(200)
                        ->setMessage("Parcel Order Updated Successfully")
                        ->setResourceName('parcel_order')
                        ->responseWithItem($parcel_order);
        } catch (\Exception $exception) {
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }
    }

    public function updateParcel(Request $request, $parcel_id)
    {
        if (!auth()->user()->can('parcel.update')) {
            return $this->responseWithNotAllowed();
        }

        $parcel = Parcel::find($parcel_id);

        $this->validate($request, [
            'name'      => 'required',
            'quantity'  => 'required',
            'cod_amount'=> 'required|integer',
        ]);
        if($request->status)
        {
            return $this->setStatusCode(400)
                        ->setMessage("status cant be changed from here")
                        ->responseWithError();
        }

        try {
            $parcel->update(
                [
                    'name'      => $request->name,
                    'quantity'  => $request->quantity,
                    'cod_amount'=> $request->cod_amount,
                ]
            );
            return $this->setStatusCode(200)
                        ->setMessage("Parcel Updated Successfully")
                        ->setResourceName('parcel')
                        ->responseWithItem($parcel);
        } catch (\Exception $exception) {
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }
    }

    public function destroy(Order $order)
    {
        if(!auth()->user()->can('order.delete')) {
            return $this->responseWithNotAllowed();
        }

        try {
            $order->delete();
            return $this->setStatusCode(200)
                        ->setMessage("Order Deleted Successfully")
                        ->responseWithSuccess();
        } catch (\Exception $exception) {
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }
    }

    public function destroyParcelOrder($parcel_order_id)
    {
        if(!auth()->user()->can('parcel.order.delete')) {
            return $this->responseWithNotAllowed();
        }

        try {
            ParcelOrder::find($parcel_order_id)->delete();
            return $this->setStatusCode(200)
                        ->setMessage("Parcel Order Deleted Successfully")
                        ->responseWithSuccess();
        } catch (\Exception $exception) {
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }
    }

    public function destroyParcel($parcel_id)
    {
        if(!auth()->user()->can('parcel.delete')) {
            return $this->responseWithNotAllowed();
        }

        try {
            Parcel::find($parcel_id)->delete();
            return $this->setStatusCode(200)
                        ->setMessage("Parcel Deleted Successfully")
                        ->responseWithSuccess();
        } catch (\Exception $exception) {
            return $this->setStatusCode(500)
                        ->setMessage($exception->getMessage())
                        ->responseWithError();
        }
    }

}
