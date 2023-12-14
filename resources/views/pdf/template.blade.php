<!DOCTYPE html>
<html>
<head>
    <title>Atskaite</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }

        h1 {
            margin-top: 30px;
        }

        h2 {
            margin-top: 20px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>

<h1>Atskaite par produktiem</h1>

@foreach ($data as $category => $products)
    <h2>{{ $category }}</h2>

    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Count</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($products as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->count }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endforeach

</body>
</html>
