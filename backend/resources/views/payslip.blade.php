<html>

<head>
    <title>Payslip</title>
    <style>
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p {
            margin-bottom: 0;
        }

        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .font-bold {
            font-weight: bold;
        }

        .text-lg {
            font-size: 14px;
        }

        .text-xl {
            font-size: 18px;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .w-full {
            width: 100%;
        }

        .d-inline-block {
            display: inline-block;
        }

        .pt-4 {
            padding-top: 8px;
        }

        .border-top {
            border-top: 1px solid black;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
        }

        .table,
        .table th,
        .table td {
            border: 1px solid black;
        }

        .table th,
        .table td {
            padding: 10px;
        }

    </style>
</head>


<div class="">
    <div>
        <h3 class="text-xl text-center">{{ $settings->data ? $settings->data['name'] : 'Company Name' }}</h3>
        <p class="text-lg font-bold text-center">
            {{ $settings->data ? $settings->data['street'] . ',' : 'Street Address, ' }}
            {{ $settings->data ? $settings->data['city'] . '-' : 'City- ' }}
            {{ $settings->data ? $settings->data['zip'] . ',' : '' }}
            {{ $settings->data ? $settings->data['country'] : 'Country' }}
        </p>
    </div>
    <br>
    <table class="w-full">
        <tbody>
            <tr>
                <td style="width: 50%">
                    <p><span class="font-bold">Employee Id: </span> {{ $payslip->employee->id }} </p>
                    <p><span class="font-bold">Employee Name: </span> {{ $payslip->employee->name }} </p>
                    <p><span class="font-bold">Employee Designation: </span>
                        {{ $payslip->employee->designation }}
                    </p>
                    <p><span class="font-bold">Employee Mobile: </span> {{ $payslip->employee->phone }} </p>
                </td>
                <td style="width: 50%">
                    <p><span class="font-bold">Pay Period: </span> {{ $payslip->salary->monthFormatted }} </p>
                    <p><span class="font-bold">Pay Date: </span> {{ $payslip->dateFormatted }} </p>
                    <p><span class="font-bold">Total Paid: </span>
                        {{ $payslip->paidAmountFormatted }}
                    </p>
                    <p><span class="font-bold">Total Deduction: </span> {{ $payslip->deductedFormatted }}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="table">
        <tbody>
            <tr>
                <th class="text-left" style="width: 50%">Description</th>
                <th class="text-right" style="width: 50%">Amount</th>
            </tr>
            <tr>
                <td class="text-left">Gross Salary</td>
                <td class="text-right">{{ $payslip->salary->totalAmountFormatted }}</td>
            </tr>
            <tr>
                <td class="text-left">Total Deduction</td>
                <td class="text-right">(-) {{ $payslip->deductedFormatted }}</td>
            </tr>
            <tr>
                <td class="text-left">Total Due</td>
                <td class="text-right">(-) {{ $payslip->salary->totalDueFormatted }}</td>
            </tr>
            <tr>
                <td class="text-left font-bold">Total Paid</td>
                <td class="text-right font-bold">{{ $payslip->paidAmountFormatted }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <br>
    <table class="w-full">
        <tbody>
            <tr>
                <td>
                    <span class="font-bold border-top">Authorize Signature</span>
                </td>
                <td class="text-right">
                    <span class="font-bold border-top">Employee Signature</span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</body>

</html>
