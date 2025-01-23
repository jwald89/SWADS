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

        table, th, td {
            border: 1px solid black;
            text-align: center;
            border-collapse: collapse;
        }

        #container {
            white-space: nowrap;
            margin: 80px;
            margin-bottom: -15px;
        }

        .container-1 {
            display: flex;
            justify-content: space-between;
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

        .roboto-regular {
            font-family: "Roboto", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .tree {
            page-break-inside: avoid;
        }

        .fw-bold {
            font-weight: bold;
        }

        /* .text-centered {
            display: flex;
        } */

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
<body >
    {{-- Header --}}
    <div>

        <div id="container">
            <div class="logo">
                <img src="file:///laragon/www/SWADS/public/assets/img/sds.png" alt="logo">
            </div>
            <div class="text">
                {{-- <div style="text-align: center; margin-bottom: 2em;"> --}}
                    <h3 style="line-height: 0.8">Republic of the Philippines</h3>
                    <h2 style="line-height: 0">PROVINCE OF SURIGAO DEL SUR</h2>

                    <h3 style="line-height: 0.3; font-weight: normal">Capitol Hills, Telaje, Tandag City</h3>
                    <h3 style="line-height: 0.3; font-weight: normal">Telefax No. (086) 211-3656</h3>
                {{-- </div> --}}
            </div>
            <div class="logo">
                <img src="file:///laragon/www/SWADS/public/assets/img/pswdo-logo.jpg" alt="logo">
            </div>
        </div>
        {{-- End Header --}}

        {{-- Office --}}
        <div style="text-align: center; line-height: 0; margin-top: 5%">
            <h3>PROVINCIAL SOCIAL WELFARE AND DEVELOPMENT OFFICE</h3>
            <hr style="border-style: solid; width: 65%">
        </div>
        {{-- End of Office --}}

        {{-- Title --}}
        <div style="text-align: center; margin-top: 3%">
            <h3>INTAKE SHEET 2024</h3>
        </div>
        {{-- End of Title --}}

        <div id="container-1">
            <div class="case">
                <h3>CASE NO. ________</h3>
            </div>
            <div class="date" style="margin-left: 40%">
                @foreach($intakes as $intake)
                <p class="fw-bold" style="line-height: 1; font-size: 1.1rem">Date Administered: <span style="font-weight: normal">{{ Carbon::parse($intake->date_intake)->format('j F Y') }}</span></p>
                <p class="fw-bold" style="line-height: 0; font-size: 1.1rem">Category: <span style="font-weight: normal">{{ $intake->assistance->name }}</span></p>
                @endforeach
            </div>
        </div>


        {{-- Identify Data --}}
        <div>
            <div style="margin-top: -20px">
                <h3 style="text-indent: 2rem">I. <span style="margin-left: 2%">IDENTIFYING DATA</span></h3>
            </div>
            <div class="roboto-regular d-flex" style="margin-left: 6%; line-height: 0.5; font-size: 1.1rem; margin-top: -10px">
                @foreach($intakes as $intake)
                    <div>
                        <p class="fw-bold">Name </p>
                        <p class="fw-bold">N-name </p>
                        <p class="fw-bold">Age </p>
                        <p class="fw-bold">Sex </p>
                        <p class="fw-bold">Civil Status </p>
                        <p class="fw-bold">Address </p>
                        <p class="fw-bold">Birth Date </p>
                        <p class="fw-bold">Occupation </p>
                        <p class="fw-bold">Income </p>
                        <p class="fw-bold">Contact # </p>
                    </div>
                    <div>
                        <p style="font-weight: normal">: {{ strtoupper($intake->first_name) }} {{ strtoupper(substr($intake->middle_name, 0, 1)) }}. {{ strtoupper($intake->last_name) }}</p>
                        <p style="font-weight: normal">: {{ strtoupper($intake->nick_name) }}</p>
                        <p style="font-weight: normal">: {{ $intake->age }}</p>
                        <p style="font-weight: normal">: {{ ucwords($intake->sex) }}</p>
                        <p style="font-weight: normal">: {{ ucwords($intake->civil_stats) }}</p>
                        <p style="font-weight: normal">: <?php echo !empty(trim($intake->purok)) ? "Purok " . $intake->purok . ",": "" ?> <?php echo !empty(trim($intake->street)) ? $intake->street . " St., " : "" ?> {{ $intake->barangay }}, {{ $intake->municipality }}, Surigao Del Sur</p style="font-weight: normal">
                        <p style="font-weight: normal">: {{ Carbon::parse($intake->birthdate)->format('F j, Y') }}</p>
                        <p style="font-weight: normal">: <?php echo !empty(trim($intake->job)) ? $intake->job : "N/A" ?></p>
                        <p style="font-weight: normal">: <?php echo !empty(trim($intake->income)) ? $intake->income : "N/A" ?></p>
                        <p style="font-weight: normal">: {{ $intake->contact_no }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- End of Identifying Data --}}

        {{-- Family Composition --}}
        <div style="margin-top: -10px">
            <h3 style="text-indent: 2rem">II. <span style="margin-left: 2%">FAMILY COMPOSITION</span></h3>
        </div>
        <table style="width: 100%; border: 1px; font-size: 1.1rem">
            <thead>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Relationship</th>
                    <th>Educational Attainment</th>
                    <th>Remark</th>
            </thead>
            @foreach ($famCompose as $data)
            <tbody>
                <tr>
                    <td>{{ $data->firstname }} {{ substr($data->middlename, 0, 1) }}. {{ $data->lastname }}</td>
                    <td>{{ $data->age }} years old</td>
                    <td>{{ $data->relationship }}</td>
                    <td><?php echo !empty(trim($data->educ_attainment)) ? $data->educ_attainment : "N/A" ?></td>
                    <td>{{ $data->remarks }}</td>
                </tr>
            </tbody>
            @endforeach
        </table>
        {{-- End of Family Composition --}}

        {{-- Circumstances of Referral --}}
        <div style="margin-top: 1%">
            <h3 style="text-indent: 2rem">III. <span style="margin-left: 2%">CIRCUMSTANCES OF REFERRAL</span></h3>
            @foreach ($referrals as $referral)
            <div style="margin-left: 8%; margin-top: -10px">
                <p class="roboto-regular" style="text-indent: 3rem; font-size: 1.09rem; text-align: justify;">
                    {{ $referral->content }}
                </p>
            </div>
            @endforeach
        </div>
        {{-- End of Circumstances of Referral --}}

        {{-- Remarks/Recommendations --}}
        <div style="margin-top: 1%">
            <h3 style="text-indent: 2rem">IV. <span style="margin-left: 2%">REMARKS/ RECOMMENDATIONS</span></h3>
            @foreach ($remarks as $remark)
            <div style="margin-left: 8%; margin-top: -10px">
                <p class="roboto-regular" style="text-indent: 3rem; font-size: 1.09rem; text-align: justify">{{ $remark->content }}</p>
            </div>
            @endforeach
        </div>
        {{-- End of Remarks/Recommendations --}}


        {{-- Signatories --}}
        <p class="fw-bold" style="font-size: 1.1rem; margin-top: 3%">Prepared by:</p>

        <div class="container-1" style="width: auto; max-width: 100%">
            <div class="case text-centered" style="line-height: 0.5">
                <p class="fw-bold" style="text-decoration: underline; font-size: 1.1rem">{{ $createdBy }}</p>
                <p>PSWDO Staff</p>
            </div>
            <div class="date text-centered" style="line-height: 0.5; margin-left: 30%; font-size: 1.1rem">
                @foreach ($intakes as $data)
                    <p class="fw-bold">Attested by: &nbsp;<span style="text-decoration: underline">{{ strtoupper($data->first_name) }} {{ strtoupper(substr($data->middle_name, 0, 1)) }}. {{ strtoupper($data->last_name) }}</span></p>
                @endforeach
                <p style="text-indent: 3rem">Client</p>
            </div>
        </div>

        <div style="margin-left: 40%;">
            <p class="fw-bold" style="font-size: 1.1rem">Noted by:</p>
        </div>

        <div style="margin-left: 50%; margin-top: 3%; line-height: 0.5">
            <p class="fw-bold" style="text-decoration: underline; font-size: 1.1rem">HERSHE LORENZANA-NUÑEZ, RSW</p>
            <p >Provincial Social Welfare and Development Officer</p>
            <p style="font-style: italic">PRC Lic No. 0009119</p>
            <p>Valid until November 28, 2024</p>
        </div>
    </div>
    {{-- End of Signatories --}}
</body>
</html>
{{-- END OF 1st PAGE --}}


{{-- START OF 2nd PAGE --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CERTIFICATE OF ELIGIBILITY</title>
</head>
<body>
    <div id="container">
        <div class="logo">
            <img src="file:///laragon/www/SWADS/public/assets/img/sds.png" alt="logo">
        </div>
        <div class="text">
            <h3 style="line-height: 0.8">Republic of the Philippines</h3>
            <h2 style="line-height: 0">PROVINCE OF SURIGAO DEL SUR</h2>

            <h3 style="line-height: 0.3; font-weight: normal">Capitol Hills, Telaje, Tandag City</h3>
            <h3 style="line-height: 0.3; font-weight: normal">Telefax No. (086) 211-3656</h3>
        </div>
        <div class="logo">
            <img src="file:///laragon/www/SWADS/public/assets/img/pswdo-logo.jpg" alt="logo">
        </div>
    </div>
    {{-- End Header --}}

    {{-- Office --}}
    <div style="text-align: center; line-height: 0; margin-top: 5%">
        <h3>PROVINCIAL SOCIAL WELFARE AND DEVELOPMENT OFFICE</h3>
        <hr style="border-style: solid; width: 65%">
    </div>
    {{-- End of Office --}}

    {{-- Title --}}
    <div style="text-align: center; margin-top: 5%">
        <h1>CERTIFICATE OF ELIGIBILITY</h1>
    </div>
    {{-- End of Title --}}

    @foreach($intakes as $intake)
    <div style="margin-top: 5%">
        <div class="roboto-regular" style="margin-left: 4%;">
            <p style="font-size: 1.1rem; text-indent: 3rem; text-align: justify">
                <span class="fw-bold">THIS IS TO CERTIFY &nbsp;</span> that
                <span class="fw-bold">
                    {{ $intake->first_name }} {{ substr($intake->middle_name, 0, 1) }}. {{ $intake->last_name }},
                </span> legal age, resident at
                <span class="fw-bold">
                    <?php echo !empty(trim($intake->purok)) ? 'Purok '.$intake->purok.',' : '' ?> {{ $intake->barangay }}, {{ $intake->municipality }}, Surigao del Sur
                </span>
                &nbsp;has been found eligible for
                <span class="fw-bold">{{ ucfirst($intake->assistance->name) }}</span>
                after having been interviewed and a case summary had been made.
            </p>
        </div>
    </div>

    <div style="margin-top: 3%">
        <div class="roboto-regular" style="margin-left: 4%;">
            @foreach($intakes as $intake)
            <p style="font-size: 1.1rem; text-indent: 3rem; text-align: justify">
                Records of the Case Summary Reports dated &nbsp;<span class="fw-bold">{{ Carbon::parse($intake->date_intake)->format('j F Y') }}</span>, are in the confidential file of the Provincial Social Welfare and Development Office.
            </p>
            @endforeach
        </div>
    </div>

    <div style="margin-top: 3%">
        <div class="roboto-regular" style="margin-left: 4%;">
            <p style="font-size: 1.1rem; text-indent: 3rem">
                This client has been recommended for financial assistance.
            </p>
        </div>
    </div>

    <div class="text-centered" style="margin-top: 10%; margin-left: 70%; line-height: 0.5">
        <p class="fw-bold" style="text-decoration: underline; font-size: 1.1rem">
            {{ strtoupper($intake->first_name) }} {{ strtoupper(substr($intake->middle_name, 0, 1)) }}. {{ strtoupper($intake->last_name) }}
        </p>
        <p>Client</p>
    </div>

    <div>
        <div class="roboto-regular" style="margin-left: 4%;">
            <p class="fw-bold" style="margin-top: 10%; font-size: 1.1rem">
                RECORDS AND INTAKE REVIEWED
            </p>
        </div>
    </div>

    <div style="margin-top: 10%; margin-left: 60%; line-height: 0.5">
        <p class="fw-bold" style="text-decoration: underline; font-size: 1.1rem">HERSHE LORENZANA-NUÑEZ, RSW</p>
        <p>Provincial Social Welfare and Development Officer</p>
        <p style="font-style: italic">PRC Lic No. 0009119</p>
    </div>

    {{-- Signatories --}}
    <div style="margin-top: 10%">
        <div style="margin-left: 4%">
            <p class="fw-bold" style="font-size: 1.1rem; ">Approved:</p>
        </div>
    </div>

    <div class="text-centered" style="margin-top: 5%; line-height: 0.5; margin-left: -50%">
        <p class="fw-bold" style="text-decoration: underline; font-size: 1.1rem">ALEXANDER T. PIMENTEL</p>
        <p>Provincial Governor</p>
    </div>
    @endforeach
</body>
</html>
{{-- END OF 2nd PAGE --}}
