@extends('layouts.export')

@section('content')
    <table class="table">
        <tbody>
            <tr>
                <td colspan="9" class="text-center">
                    <h1>Employee Report</h1>
                </td>
            </tr>
            <tr>
                <td>#</td>
                <td>Joining Date</td>
                <td>Name</td>
                <td>Zone</td>
                <td>Designation</td>
                <td>Phone</td>
                <td>Email</td>
                <td>Salary</td>
                <td>Status</td>
            </tr>

            @foreach ($models as $model)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $model->joiningDate }}</td>
                <td>{{ $model->name }}</td>
                <td>{{ $model->zone->name}}</td>
                <td>{{ $model->designation }}</td>
                <td>{{ $model->phone}}</td>
                <td>{{ $model->email}}</td>
                <td>{{ $model->salary}}</td>
                <td>{{Str::upper($model->status) }}</td>
            </tr>
        @endforeach

        <tr class="tfoot">
            <td colspan="7">Total</td>
            <td>{{ $models->sum('salary') }}</td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
    </table>
@endsection
