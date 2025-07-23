<?php
    use Carbon\Carbon;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Assistance Slip Print</title>
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
    <div style="text-align: center">
        <h3 style="line-height: 0.8">Republic of the Philippines</h3>
        <h3 style="line-height: 0.5">Province of Surigao del Sur</h3>
        <h3 style="line-height: 0.3">Tandag City</h3>
    </div>
    {{-- End Header --}}

    {{-- Office --}}
    <div style="text-align: center; line-height: 0; margin-top: 5%; margin-bottom: 4%">
        <h3>PROVINCIAL SOCIAL WELFARE AND DEVELOPMENT OFFICE</h3>
    </div>
    {{-- End of Office --}}

    <h3 style="text-align: center; font-weight: bold">ASSISTANCE SLIP</h3>

    <div style="font-size: 1.05rem; margin-top: 30px">
        @foreach($medicines as $medicine)
        <p style="text-indent: 70%; font-weight: bold">Date: <span class="fw-normal text-underlined">{{ Carbon::parse($medicine->created_at)->format('F j, Y') }}</span></p>

        <div style="margin-top: 40px">
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
        </div>

        <p class="fw-bold" style="margin-top: 30px; line-height: 1.6rem; word-spacing: 3px">Problem Presented:
            <span class="fw-normal text-underlined">{{ $medicine->problem_present }}</span>
        </p>
        <p class="fw-bold" style="margin-top: 30px; line-height: 1.6rem; word-spacing: 3px">Asistance Needed:
            <span class="fw-normal text-underlined">{{ $medicine->assistance_need }}</span>
        </p>
        @endforeach


        <div style="display: flex; justify-content: space-between; margin-top: 40px">
            <div style="display: inline-block">
                <p style="margin-bottom: 5px">Prepared by:</p>
                <p class="fw-bold" style="line-height: 1.4; border-bottom: solid black 1px;">{{ $createdBy }}</p>
                @foreach ($medicines as $medicine)
                    <p style="line-height: 0; text-align: center">{{ strtoupper($medicine->user->designation) }}</p>
                @endforeach
            </div>
            <div style="display: inline-block; margin-left: 35%">
                <p style="margin-bottom: 5px">Noted by:</p>
                <p class="fw-bold" style="line-height: 1.4; text-indent: 25%; border-bottom: solid black 1px;">HERSHE L. NUÑEZ, RSW</p>
                <p style="line-height: 0;">Provincial Social Werlfare and Development Officer</p>
            </div>
        </div>
    </div>
</body>
</html>
{{-- END OF 1st PAGE --}}
