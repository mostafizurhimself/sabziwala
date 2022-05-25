@extends('layouts.export')

@section('content')
    <table class="table">
        <tbody>
            <tr>
                <td colspan="9" class="text-center">
                    <h1>Order Report</h1>
                </td>
            </tr>
            <tr>
                <td>#</td>
                <td>Date</td>
                <td>Invoice No</td>
                <td>Zone</td>
                <td>Customer</td>
                <td>Rider</td>
                <td>Grand Total</td>
                <td>Method</td>
                <td>Status</td>
            </tr>
            @foreach ($models as $model)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $model->dateFormatted }}</td>
                    <td>{{ $model->invoiceNo }}</td>
                    <td>{{ $model->zone->name }}</td>
                    <td>{{ $model->customer->name }}</td>
                    <td>{{ $model->rider->name }}</td>
                    <td>{{ $model->grandTotal }}</td>
                    <td>{{ Str::upper($model->paymentMethod) }}</td>
                    <td>{{ Str::upper($model->status) }}</td>

                </tr>
            @endforeach
            <tr class="tfoot">
                <td colspan="6">Total</td>
                <td>{{ $models->sum('grandTotal') }}</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
@endsection
