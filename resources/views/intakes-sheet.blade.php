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

        #container-1 {
            display: flex;
            justify-content: space-between;
            margin-bottom: -15px;
        }

        .case, .date {
            display: inline-block;
            vertical-align: middle;
        }

        .case {
            width: auto;
        }

        .date {
            width: auto;
            margin-left: 40%;
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
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="tree">

        <div id="container">
            <div class="logo">
                <img src="file:///laragon/www/SWADS/public/assets/img/sds.png" alt="logo">
            </div>
            <div class="text">
                {{-- <div style="text-align: center; margin-bottom: 2em;"> --}}
                    <h4 style="line-height: 0.8">Republic of the Philippines</h4>
                    <h3 style="line-height: 0">PROVINCE OF SURIGAO DEL SUR</h3>

                    <h4 style="line-height: 0; font-weight: normal">Capitol Hills, Telaje, Tandag City</h4>
                    <h4 style="line-height: 0; font-weight: normal">Telefax No. (086) 211-3656</h4>
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
            <div class="date">
                @foreach($intakes as $intake)
                <p class="fw-bold" style="line-height: 1; font-size: 17px">Date Administered: <span style="font-weight: normal">{{ \Carbon\Carbon::parse($intake->date_intake)->format('F j, Y') }}</span></p>
                <p class="fw-bold" style="line-height: 0; font-size: 17px">Category: <span style="font-weight: normal">{{ $intake->category }}</span></p>
                @endforeach
            </div>
        </div>


        {{-- Identify Data --}}
        <div>
            <div style="margin-top: 1%">
                <h3 style="text-indent: 2rem">I. <span style="margin-left: 2%">IDENTIFYING DATA</span></h3>
            </div>
            <div class="roboto-regular" style="margin-left: 8%; line-height: 0.5">
                @foreach($intakes as $intake)
                    <p class="fw-bold" style="font-size: 17px">Name : <span style="font-weight: normal">{{ strtoupper($intake->first_name) }} {{ substr($intake->middle_name, 0, 1) }}. {{ strtoupper($intake->last_name) }}</span></p>
                    <p class="fw-bold" style="font-size: 17px">N-name : <span style="font-weight: normal">{{ strtoupper($intake->nick_name) }}</span></p>
                    <p class="fw-bold" style="font-size: 17px">Age : <span style="font-weight: normal">{{ $intake->age }}</span></p>
                    <p class="fw-bold" style="font-size: 17px">Sex : <span style="font-weight: normal">{{ ucwords($intake->sex) }}</span></p>
                    <p class="fw-bold" style="font-size: 17px">Civil Status : <span style="font-weight: normal">{{ ucwords($intake->civil_stats) }}</span></p>
                    <p class="fw-bold" style="font-size: 17px">Address : <span style="font-weight: normal">Prk. {{ $intake->purok }} {{ $intake->street }} St., {{ $intake->barangay }}, {{ $intake->municipality }}, Surigao Del Sur</span style="font-weight: normal"></p>
                    <p class="fw-bold" style="font-size: 17px">Birth Date : <span style="font-weight: normal">{{ \Carbon\Carbon::parse($intake->birthdate)->format('F j, Y') }}</span></p>
                    <p class="fw-bold" style="font-size: 17px">Occupation : <span style="font-weight: normal">{{ $intake->job }}</span></p>
                    <p class="fw-bold" style="font-size: 17px">Income: <span style="font-weight: normal">{{ $intake->income }}</span></p>
                    <p class="fw-bold" style="font-size: 17px">Contact # : <span style="font-weight: normal">{{ $intake->contact_no }}</span></p>
                @endforeach
            </div>
        </div>
        {{-- End of Identifying Data --}}

        {{-- Family Composition --}}
        <div style="margin-top: 5%">
            <h3 style="text-indent: 2rem">II. <span style="margin-left: 2%">FAMILY COMPOSITION</span></h3>
        </div>
        <table style="width: 100%; border: 1px">
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
                    <td>{{ $data->educ_attainment }}</td>
                    <td>{{ $data->remarks }}</td>
                </tr>
            </tbody>
            @endforeach
        </table>
        {{-- End of Family Composition --}}

        {{-- Circumstances of Referral --}}
        <div style="margin-top: 5%">
            <h3 style="text-indent: 2rem">III. <span style="margin-left: 2%">CIRCUMSTANCES OF REFERRAL</span></h3>
            @foreach ($referrals as $referral)
            <div style="margin-left: 8%">
                <p class="roboto-regular" style="text-indent: 3rem">{{ $referral->content }}</p>
            </div>
            @endforeach
        </div>
        {{-- End of Circumstances of Referral --}}

        {{-- Remarks/Recommendations --}}
        <div style="margin-top: 5%">
            <h3 style="text-indent: 2rem">IV. <span style="margin-left: 2%">REMARKS/ RECOMMENDATIONS</span></h3>
            @foreach ($remarks as $remark)
            <div style="margin-left: 8%">
                <p class="roboto-regular" style="text-indent: 3rem">{{ $remark->content }}</p>
            </div>
            @endforeach
        </div>
        {{-- End of Remarks/Recommendations --}}


        {{-- Signatories --}}
        <p class="fw-bold" style="font-size: 17px;">Prepared by:</p>

        <div id="container-1">
            <div class="case" style="line-height: 0.5">
                <p class="fw-bold" style="text-decoration: underline;">JUNIE, JR. A.BAPOR, RSW</p>
                <p style="text-indent: 3rem">PSWDO Staff</p>
            </div>
            <div class="date" style="text-align: right; line-height: 0.5">
                @foreach ($intakes as $data)
                    <p class="fw-bold">Attested by: &nbsp;<span style="text-decoration: underline;">{{ strtoupper($data->first_name) }} {{ strtoupper(substr($data->middle_name, 0, 1)) }}. {{ strtoupper($data->last_name) }}</span></p>
                @endforeach
                <p style="margin-right; 10px; padding-right: 50px">Client</p>
            </div>
        </div>

        <div style="margin-left: 40%;">
            <p class="fw-bold" style="font-size: 17px">Noted by:</p>
        </div>

        <div style="margin-left: 50%; margin-top: 3%; line-height: 0.5">
            <p class="fw-bold" style="text-decoration: underline">HERSHE LORENZANA-NUÑEZ, RSW</p>
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
    <title>Document</title>
</head>
<body>
    <div id="container">
        <div class="logo">
            <img src="file:///laragon/www/SWADS/public/assets/img/sds.png" alt="logo">
        </div>
        <div class="text">
            <h4 style="line-height: 0.8">Republic of the Philippines</h4>
            <h3 style="line-height: 0">PROVINCE OF SURIGAO DEL SUR</h3>

            <h4 style="line-height: 0; font-weight: normal">Capitol Hills, Telaje, Tandag City</h4>
            <h4 style="line-height: 0; font-weight: normal">Telefax No. (086) 211-3656</h4>
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
    <div style="margin-top: 3%">
        <div class="roboto-regular" style="margin-left: 4%;">
            <p style="font-size: 17px; text-indent: 3rem">
                <span class="fw-bold">THIS IS TO CERTIFY</span> that <span class="fw-bold">{{ $intake->first_name }} {{ substr($intake->middle_name, 0, 1) }}. {{ $intake->last_name }}</span>, legal age, resident at <span class="fw-bold">Purok Catmon, {{ $intake->municipality }}, Surigao del Sur</span> has been found eligible for <span class="fw-bold">{{ $intake->category }}</span> after having been interviewed and a case summary had been made.
            </p>
        </div>
    </div>

    <div style="margin-top: 3%">
        <div class="roboto-regular" style="margin-left: 4%;">
                <p style="font-size: 17px; text-indent: 3rem">
                    Records of the Case Summary Reports dated <span class="fw-bold">29 January 2024</span>, are in the confidential file of the Provincial Social Welfare and Development Office.
                </p>
        </div>
    </div>

    <div style="margin-top: 3%">
        <div class="roboto-regular" style="margin-left: 4%;">
            <p style="font-size: 17px; text-indent: 3rem">
                This client has been recommended for financial assistance.
            </p>
        </div>
    </div>

    <div style="margin-top: 10%; margin-left: 70%; line-height: 0.5">
        <p class="fw-bold" style="text-decoration: underline; text-align: right; margin-right: 20px">{{ strtoupper($intake->first_name) }} {{ strtoupper(substr($intake->middle_name, 0, 1)) }}. {{ strtoupper($intake->last_name) }}</p>
        <p style="text-align: center; margin-right; 10px">Client</p>
    </div>

    <div>
        <div class="roboto-regular" style="margin-left: 4%;">
            <p class="fw-bold" style="margin-top: 10%; font-size: 17px">
                RECORDS AND INTAKE REVIEWED
            </p>
        </div>
    </div>

    <div style="margin-top: 10%; margin-left: 60%; line-height: 0.5">
        <p class="fw-bold" style="text-decoration: underline">HERSHE LORENZANA-NUÑEZ, RSW</p>
        <p>Provincial Social Welfare and Development Officer</p>
        <p style="font-style: italic">PRC Lic No. 0009119</p>
    </div>

    {{-- Signatories --}}
    <div style="margin-top: 10%">
        <div style="margin-left: 4%">
            <p class="fw-bold" style="font-size: 17px; ">Approved:</p>
        </div>
    </div>
    <div style="margin-top: 5%">
        <div style="margin-left: 4%; text-indent: 3rem; line-height: 0.5">
            <p class="fw-bold" style="text-decoration: underline">ALEXANDER T. PIMENTEL</p>
            <p style="text-indent: 5rem">Provincial Governor</p>
        </div>
    </div>
    @endforeach
</body>
</html>
{{-- END OF 2nd PAGE --}}
