@extends('layouts.export')

@section('content')
    <table class="table">
        <tbody>
            <tr>
                <td colspan="7" class="text-center">
                    <h1>Loan Report</h1>
                </td>
            </tr>
            <tr>
                <td>#</td>
                <td>Date</td>
                <td>Name</td>
                <td>Amount</td>
                <td>Paid</td>
                <td>Due</td>
                <td>Status</td>
            </tr>

            @foreach ($models as $model)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $model->loanDate }}</td>
                <td>{{ $model->employee->name }}</td>
                <td>{{ $model->loanAmount }}</td>
                <td>{{ $model->paidAmount }}</td>
                <td>{{ $model->dueAmount}}</td>
                <td>{{Str::upper($model->status) }}</td>
            </tr>
        @endforeach
        <tr class="tfoot">
            <td colspan="3">Total</td>
            <td>{{ $models->sum('loanAmount') }}</td>
            <td>{{ $models->sum('paidAmount') }}</td>
            <td>{{ $models->sum('dueAmount') }}</td>
            <td></td>
            <td></td>
        </tr>

        </tbody>
    </table>
@endsection
