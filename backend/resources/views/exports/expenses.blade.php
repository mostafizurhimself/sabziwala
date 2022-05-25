@extends('layouts.export')

@section('content')
    <table class="table">
        <tbody>
            <tr>
                <td colspan="5" class="text-center">
                    <h1>Expense Report</h1>
                </td>
            </tr>
            <tr>
                <td>#</td>
                <td>Date</td>
                <td>Expense Type</td>
                <td>Description</td>
                <td>Amount</td>
            </tr>

            @foreach ($models as $model)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $model->createdAt }}</td>
                <td>{{ $model->expenseType->name }}</td>
                <td>{{ $model->description }}</td>
                <td>{{ $model->amount }}</td>
            </tr>

        @endforeach
        <tr class="tfoot">
            <td colspan="4">Total</td>
            <td>{{ $models->sum('amount') }}</td>

        </tr>

        </tbody>
    </table>
@endsection
