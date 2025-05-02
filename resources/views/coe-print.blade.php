<?php
    use Carbon\Carbon;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificate of Eligibility Print</title>
    <style>
        .container {
            white-space: nowrap;
            margin: 80px;
            margin-bottom: -15px;
        }

        .case, .date {
            display: inline-block;
            vertical-align: middle;
        }

        .logo, .text {
            display: inline-block;
            vertical-align: middle;
        }


        .logo {
            width: 15%;
        }

        .logo img {
            width: 100%;
            height: auto;
        }

        .text {
            width: 70%;
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        .text-centered > p {
            text-align: center;
        }

        .d-flex {
            display: flex;
        }

        .d-flex > div {
            display: inline-block;
            vertical-align: middle;
            text-indent: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="C:/nginx-1.26.2/html/swads-app/public/assets/img/sds.png" alt="logo">
        </div>
        <div class="text">
            <h3 style="line-height: 0.8">Republic of the Philippines</h3>
            <h2 style="line-height: 0">PROVINCE OF SURIGAO DEL SUR</h2>

            <h3 style="line-height: 0.2; font-weight: normal">Capitol Hills, Telaje, Tandag City</h3>
            <h3 style="line-height: 0.2; font-weight: normal">Telefax No. (086) 211-3656</h3>
        </div>
        <div class="logo">
            <img src="C:/nginx-1.26.2/html/swads-app/public/assets/img/pswdo-logo.jpg" alt="logo">
        </div>
    </div>
    {{-- End Header --}}

    {{-- Office --}}
    <div style="text-align: center; line-height: 0; margin-top: 5%">
        <h3>PROVINCIAL SOCIAL WELFARE AND DEVELOPMENT OFFICE</h3>
        <hr style="border-bottom: double; width: 70%">
    </div>
    {{-- End of Office --}}

    {{-- Title --}}
    <div style="text-align: center; margin-top: 5%">
        <h1>CERTIFICATE OF ELIGIBILITY</h1>
    </div>
    {{-- End of Title --}}

    <div style="width: 95%">
    @foreach($intakes as $intake)
        <div style="margin-left: 4%;">
            <p style="font-size: 1.1rem; text-indent: 3rem; text-align: justify">
                <strong>THIS IS TO CERTIFY &nbsp;</strong> that
                <strong>
                    {{ strtoupper($intake->first_name) }}
                    {{ $intake->middle_name ? strtoupper(substr($intake->middle_name, 0, 1)) . ". " : "" }}
                    {{ strtoupper($intake->last_name) }}
                    {{ $intake->extn_name ? ", " . strtoupper($intake->extn_name) : "" }},
                </strong> legal age, resident at
                <strong>
                    {{ !empty(trim($intake->purok)) ? 'Purok ' . ucwords($intake->purok) . ', ' : '' }}
                    {{ ucwords($intake->brgy->barangay) }}, {{ ucwords($intake->municipal->municipality) }}, Surigao del Sur &nbsp;
                </strong> has been found eligible for
                <strong>{{ ucwords($intake->assistance->name) }}</strong> after having been interviewed and a case summary had been made.
            </p>
        </div>

        <div style="margin-left: 4%;">
            @foreach($intakes as $intake)
            <p style="font-size: 1.1rem; text-indent: 3rem; text-align: justify">
                Records of the Case Summary Reports dated &nbsp;<span class="fw-bold">{{ Carbon::parse($intake->date_intake)->format('j F Y') }}</span>, are in the confidential file of the Provincial Social Welfare and Development Office.
            </p>
            @endforeach
        </div>

    <div style="margin-top: 3%">
        <div style="margin-left: 4%;">
            <p style="font-size: 1.1rem; text-indent: 3rem">
                This client has been recommended for financial assistance.
            </p>
        </div>
    </div>

    <div class="text-centered" style="margin-top: 10%; margin-left: 65%; line-height: 0.5">
        <p class="fw-bold" style="text-decoration: underline; font-size: 1.1rem">
            {{ strtoupper($intake->first_name) }} {{ $intake->middle_name ? strtoupper(substr($intake->middle_name, 0, 1)) . "." : "" }} {{ strtoupper($intake->last_name) }}{{ $intake->extn_name ? ", " . strtoupper($intake->extn_name) : "" }}
        </p>
        <p>Client</p>
    </div>

    <div>
        <div style="margin-left: 4%;">
            <p class="fw-bold" style="margin-top: 10%; font-size: 1.1rem">
                RECORDS AND INTAKE REVIEWED
            </p>
        </div>
    </div>

    <div style="margin-top: 10%; margin-left: 60%; line-height: 0.5">
        <p class="fw-bold" style="text-decoration: underline; font-size: 1.1rem">HERSHE LORENZANA-NUÑEZ, RSW</p>
        <p>Provincial Social Welfare and Development Officer</p>
        <p style="font-style: italic">PRC Lic No. 0009119</p>
        <p style="font-style: italic">Valid until November 28, 2027</p>
    </div>

    {{-- Signatories --}}
    <div style="margin-top: 10%">
        <div style="margin-left: 4%">
            <p class="fw-bold" style="font-size: 1.1rem; ">Approved:</p>
        </div>
    </div>

    <div class="text-centered" style="margin-top: 5%; line-height: 0.5; margin-left: -50%">
        <p class="fw-bold" style="text-decoration: underline; font-size: 1.1rem">{{ strtoupper($intake->chargingOffice->first_name) }} {{ strtoupper(substr($intake->chargingOffice->middle_name, 0, 1)) }}. {{ strtoupper($intake->chargingOffice->last_name) }}</p>
        <p>{{ $intake->chargingOffice->title }}</p>
    </div>
    @endforeach
    </div>
</body>
</html>

