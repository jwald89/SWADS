<?php
    use Carbon\Carbon;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Intakes print</title>
    <style>
        body {
                font-family: 'Calibri';
                margin: 20px;
            }
        .container-header {
            white-space: nowrap;
            margin: 80px;
            margin-bottom: -15px;
        }

        .logo, .header {
            display: inline-block;
            vertical-align: middle;
        }

        .logo {
            width: 15%;
        }

        .province-logo img {
            width: 110%;
            height: auto;
        }

        .pswdo-logo img {
            width: 160%;
            height: auto;
        }

        .header {
            width: 70%;
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        .fw-normal {
            font-weight: normal;
        }

        .text-underlined {
            text-decoration: underline;
        }
    </style>
</head>
<body >
    {{-- Header --}}
    <div>

        <div style="text-align: center">
            {{-- <div class="container-header"> --}}
                {{-- <div class="province-logo logo">
                    <img src="file:///laragon/www/SWADS/public/assets/img/sds.png" alt="logo">
                </div> --}}
                {{-- <div class="header"> --}}
                        <h3 style="line-height: 0.8">Republic of the Philippines</h3>
                        <h3 style="line-height: 0.5">Province of Surigao del Sur</h3>
                        <h3 style="line-height: 0.3">Tandag City</h3>
                {{-- </div> --}}
                {{-- <div class="pswdo-logo logo">
                    <img src="file:///laragon/www/SWADS/public/assets/img/pswdo-logo-2.jpg" alt="logo">
                </div> --}}
            {{-- </div> --}}
        </div>
        {{-- End Header --}}

        {{-- Office --}}
        <div style="text-align: center; line-height: 0; margin-top: 5%">
            <h3>PROVINCIAL SOCIAL WELFARE AND DEVELOPMENT OFFICE</h3>
        </div>
        {{-- End of Office --}}

        <p style="text-align: center; font-weight: bold">ASSISTANCE SLIP</p>

        @foreach($medicines as $medicine)
        <p style="text-indent: 70%; font-weight: bold">Date: <span class="fw-normal text-underlined">{{ Carbon::parse($medicine->created_at)->format('F j, Y') }}</span></p>

        <p class="fw-bold" style="line-height: 0">Name:
            <span class="fw-normal text-underlined">
                {{ ucwords($medicine->first_name) }}
                {{ $medicine->middle_name !== NULL ? ucwords(substr($medicine->middle_name, 0, 1)) . "." : "" }}
                {{ ucwords($medicine->last_name) }}{{ $medicine->suffix !== NULL ? ", " . ucwords($medicine->suffix) : "" }}
            </span>
        </p>
        <p class="fw-bold" style="line-height: 0.9">Address:
            <span class="fw-normal text-underlined">
                {{ $medicine->barangay->barangay . "," }} {{ $medicine->municipal->municipality . ", Surigao del Sur" }}
            </span>
        </p>

        <p class="fw-bold" style="margin-top: 30px">Problem Presented: <span class="fw-normal text-underlined">{{ $medicine->problem_present }}</span></p>
        <p class="fw-bold" style="margin-top: 20px">Asistance Needed: <span class="fw-normal text-underlined">{{ $medicine->assistance_need }}</span></p>
        @endforeach


        <div style="display: flex; justify-content: space-between;">
            <div style="display: inline-block; vertical-align: middle;">
                <p>Recommeding Approval:</p>
                <p class="fw-bold" style="line-height: 0; text-indent: 20%; margin-top: 10%">HERSHE L. NUÑEZ, RSW</p>
                <p style="line-height: 0">Provincial Social Welfare and Development Officer</p>
            </div>
            <div style="display: inline-block; vertical-align: middle; margin-left: 30%">
                <p>Approved:</p>
                <p class="fw-bold" style="line-height: 0; margin-top: 20%">ALEXANDER T. PIMENTEL</p>
                <p style="line-height: 0; text-indent: 15%">Provincial Governor</p>
            </div>
        </div>
</body>
</html>
{{-- END OF 1st PAGE --}}
