<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sabziwala | Export</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        h1,
        p {
            text-align: center;
        }

        h1 {
            margin-bottom: 10px;
        }

        p {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td,
        tr {
            border: 1px solid black;
        }

        table thead {
            text-align: left;
        }

        /* tr:nth-child(2n + 1){
            background: #dadada;
        } */

        tr:first-child {
            font-weight: bold
        }

        th,
        td {
            padding: 1rem;
        }

        .tfoot {
            font-weight: bold;

        }

    </style>
</head>

<body>
    @yield('content')
</body>

</html>
