<?php
    use Carbon\Carbon;

    date_default_timezone_set("Asia/Manila");
    $currentTime = date("h:i A"); // Uppercase 'A' for AM/PM
    $formattedDate = date("M d, Y", strtotime($currentTime));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Summary Report</title>

    <style>
        #tableData {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #tableData td, #tableData th {
            border: 1px solid #a09d9d;
            padding: 8px;
        }

        #tableData tr:nth-child(even){background-color: #f2ebf8}

        #tableData tr:hover {background-color: #90b4ce;}

        #tableData th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #581b98;
            color: #fffffe;
        }

        .mt-5 {
            padding-top: 2em
        }

        #total {
            border-collapse: collapse;
            width: 74%;
            margin-left: 230px;
        }


        #total th {
            padding-top: 12px;
            padding-bottom: 12px;
        }


        .text-decoration-underline {
            text-decoration: underline;
        }

        .logo, .header {
            display: inline-block;
            vertical-align: middle;
        }

        .logo {
            width: 9%;
        }

        .logo img {
            width: 100%;
            height: auto;
        }

        .header {
            width: 80%;
            text-align: center;
        }

        #container {
            white-space: nowrap;
            margin: 100px;
            margin-bottom: 2rem;
        }

    </style>

</head>
<body>
    <div id="container">
        <div class="logo">
            <img src="C:/nginx-1.26.2/html/swads-app/public/assets/img/sds.png" alt="logo">
        </div>
        <div class="header">
            <h3 style="line-height: 0.8">Republic of the Philippines</h3>
            <h2 style="line-height: 0">PROVINCE OF SURIGAO DEL SUR</h2>
            <h3 style="font-weight: normal">Capitol Hills, Tandag City</h3>
            <h2 style="line-height: 0.3">Provincial Social Welfare and Development Office</h2>
            <h1 style="line-height: 0.3; margin-top: 2rem">SUMMARY REPORT</h1>
        </div>
        <div class="logo">
            <img src="C:/nginx-1.26.2/html/swads-app/public/assets/img/pswdo-logo.jpg" alt="logo">
        </div>
    </div>

    <h4 style="font-family: Arial, Helvetica, sans-serif;">Covered Period: <span>{{ Carbon::parse($printFrom)->format('F j, Y') }}   -  {{ Carbon::parse($printTo)->format('F j, Y') }}</span></span></h3>

    <div class="table-responsive">
        <table id="tableData">
            <thead>
                <tr>
                    <th style="text-align: center">No.</th>
                    <th style="text-align: center">Sector</th>
                    <th style="text-align: center">Municipality</th>
                    <th style="text-align: center">Classification</th>
                    <th style="text-align: center">Amount</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($summary as $key => $data)
                <tr>
                    <td style="text-align: center">{{ $key + 1 }}</td>
                    <td style="text-align: center">{{ $data->sectorName->name }}</td>
                    <td style="text-align: center">{{ $data->municipal->municipality }}</td>
                    <td style="text-align: center">{{ $data->classificationName->name }}</td>
                    <td style="text-align: center">{{ number_format($data->amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tr style="background-color: rgb(255, 255, 255); color: #474747; font-size: 1.5rem; font-weight: bold">
                <td colspan="4" style="text-align: right">TOTAL &nbsp; </td>
                <td colspan="2" style="text-align: center">&nbsp; {{ number_format($totalAmt, 2) }}</td>
            </tr>
        </table>
    </div>

    <p style="margin-top: 3rem; font-family: Arial, Helvetica, sans-serif; font-style: italic">
        Date Generated: &nbsp;{{ $formattedDate }} &nbsp;&nbsp; {{ $currentTime }}
    </p>
</body>
</html>

