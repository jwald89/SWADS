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
    </style>
</head>
<body>
    {{-- Header --}}
    {{-- <img src="file:///laragon/www/SWADS/public/assets/img/sds.png" width="100px"> --}}
    <div style="text-align: center; margin-bottom: 2em;">
        <h4 style="line-height: 0.8">Rebublic of the Philippines</h4>
        <h3 style="line-height: 0">PROVINCE OF SURIGAO DEL SUR</h3>
        <h4 style="line-height: 0; font-weight: normal">Capitol Hills, Telaje, Tandag City</h4>
        <h4 style="line-height: 0; font-weight: normal">Telefax No. (086) 211-3656</h4>
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

    {{-- Identify Data --}}
    <div style="margin-top: 3%">
        <div style="margin-left: 60%">
            @foreach($intakes as $intake)
            <p style="line-height: 1; font-size: 17px; font-weight: bold">Date Administered: <span style="font-weight: normal">{{ \Carbon\Carbon::parse($intake->date_intake)->format('F j, Y') }}</span></p>
            <p style="line-height: 0; font-size: 17px; font-weight: bold">Category: <span style="font-weight: normal">{{ $intake->category }}</span></p>
            @endforeach
        </div>
        <div style="margin-top: 1%">
            <h3>I. <span style="margin-left: 2%">IDENTIFYING DATA</span></h3>
        </div>
        <div style="margin-left: 4%; line-height: 0.5">
            @foreach($intakes as $intake)
                <p style="font-size: 17px; font-weight: bold">Name : <span style="font-weight: normal">{{ strtoupper($intake->first_name) }} {{ substr($intake->middle_name, 0, 1) }}. {{ strtoupper($intake->last_name) }}</span></p>
                <p style="font-size: 17px; font-weight: bold">N-name : <span style="font-weight: normal">{{ strtoupper($intake->nick_name) }}</span></p>
                <p style="font-size: 17px; font-weight: bold">Age : <span style="font-weight: normal">{{ $intake->age }}</span></p>
                <p style="font-size: 17px; font-weight: bold">Sex : <span style="font-weight: normal">{{ ucwords($intake->sex) }}</span></p>
                <p style="font-size: 17px; font-weight: bold">Civil Status : <span style="font-weight: normal">{{ ucwords($intake->civil_stats) }}</span></p>
                <p style="font-size: 17px; font-weight: bold">Address : <span style="font-weight: normal">Prk. {{ $intake->purok }} {{ $intake->street }} St., {{ $intake->barangay }}, {{ $intake->municipality }}, Surigao Del Sur</span style="font-weight: normal"></p>
                <p style="font-size: 17px; font-weight: bold">Birth Date : <span style="font-weight: normal">{{ \Carbon\Carbon::parse($intake->birthdate)->format('F j, Y') }}</span></p>
                <p style="font-size: 17px; font-weight: bold">Occupation : <span style="font-weight: normal">{{ $intake->job }}</span></p>
                <p style="font-size: 17px; font-weight: bold">Income: <span style="font-weight: normal">{{ $intake->income }}</span></p>
                <p style="font-size: 17px; font-weight: bold">Contact # : <span style="font-weight: normal">{{ $intake->contact_no }}</span></p>
            @endforeach
        </div>
    </div>
    {{-- End of Identifying Data --}}

    {{-- Family Composition --}}
    <div style="margin-top: 5%">
        <h3>II. <span style="margin-left: 2%">FAMILY COMPOSITION</span></h3>
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
        <h3>III. <span style="margin-left: 2%">CIRCUMSTANCES OF REFERRAL</span></h3>
        @foreach ($referrals as $referral)
            <p>{{ $referral->content }}</p>
        @endforeach
    </div>
    {{-- End of Circumstances of Referral --}}

    {{-- Remarks/Recommendations --}}
    <div style="margin-top: 5%">
        <h3>IV. <span style="margin-left: 2%">REMARKS/ RECOMMENDATIONS</span></h3>
        @foreach ($remarks as $remark)
            <p>{{ $remark->content }}</p>
        @endforeach
    </div>
    {{-- End of Remarks/Recommendations --}}


    {{-- Signatories --}}
    <div>
        <p style="font-size: 17px; font-weight: bold">Prepared by:</p>
        <p style="text-decoration: underline; font-weight: bold">JUNIE, JR. A.BAPOR, RSW</p>
        <p>PSWDO Staff</p>
    </div>
    <div style="margin-left: 60%">
        <p style="font-size: 17px; font-weight: bold">Noted by:</p>
        <p style="text-decoration: underline; font-weight: bold">HERSHE LORENZANA-NUÑEZ, RSW</p>
        <p>Provincial Social Welfare and Development Officer</p>
        <p>PRC Lic No. 0009119</p>
    </div>

    {{-- End of Signatories --}}
</body>
</html>
