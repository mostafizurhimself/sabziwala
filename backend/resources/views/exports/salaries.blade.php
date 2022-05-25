@extends('layouts.export')

@section('content')
    <table class="table">
        <tbody>
            <tr>
                <td colspan="9" class="text-center">
                    <h1>Salary Report</h1>
                </td>
            </tr>
            <tr>
                <td>#</td>
                <td>Month</td>
                <td>Zone</td>
                <td>Name</td>
                <td>Amount</td>
                <td>Paid</td>
                <td>Deducted</td>
                <td>Due</td>
                <td>Status</td>
            </tr>

            @foreach ($models as $model)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $model->monthFormatted }}</td>
                <td>{{ $model->zone->name}}</td>
                <td>{{ $model->employee->name }}</td>
                <td>{{ $model->totalAmount }}</td>
                <td>{{ $model->totalPaid}}</td>
                <td>{{ $model->totalDeducted}}</td>
                <td>{{ $model->totalDue}}</td>
                <td>{{Str::upper($model->status) }}</td>
            </tr>
        @endforeach

        <tr class="tfoot">
            <td colspan="4">Total</td>
            <td>{{ $models->sum('totalAmount') }}</td>
            <td>{{ $models->sum('totalPaid') }}</td>
            <td>{{ $models->sum('totalDeducted') }}</td>
            <td>{{ $models->sum('totalDue') }}</td>
            <td></td>
        </tr>
        </tbody>
    </table>
@endsection
