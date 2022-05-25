@extends('layouts.export')

@section('content')
    <table class="table">
        <tbody>
            <tr>
                <td colspan="7" class="text-center">
                    <h1>Zone Report</h1>
                </td>
            </tr>
            <tr>
                <td>#</td>
                <td>Name</td>
                <td>City</td>
                <td>State</td>
                <td>Country</td>
                <td>Products</td>
                <td>Riders</td>
            </tr>
            @foreach ($models as $model)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $model->name }}</td>
                    <td>{{ $model->city }}</td>
                    <td>{{ $model->state }}</td>
                    <td>{{ $model->country }}</td>
                    <td>{{ $model->productsCount }}</td>
                    <td>{{ $model->ridersCount }}</td>
                </tr>
            @endforeach
            <tr class="tfoot">
                <td colspan="5">Total</td>
                <td>{{ $models->sum('productsCount') }}</td>
                <td>{{ $models->sum('ridersCount') }}</td>
            </tr>
        </tbody>
    </table>
@endsection
