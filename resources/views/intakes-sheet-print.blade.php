<?php
    use Carbon\Carbon;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Intake Sheet Print</title>
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
            justify-content: space-between; /* Adjusts spacing between the two divs */
            align-items: flex-start; /* Align items to the start */
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
<body >
    {{-- Header --}}
    <div>

        <div id="container">
            <div class="logo">
                <img src="C:/nginx-1.26.2/html/swads-app/public/assets/img/sds.png" alt="logo">
            </div>
            <div class="text">
                    <h3 style="line-height: 0.8">Republic of the Philippines</h3>
                    <h2 style="line-height: 0">PROVINCE OF SURIGAO DEL SUR</h2>

                    <h3 style="line-height: 0.3; font-weight: normal">Capitol Hills, Telaje, Tandag City</h3>
                    <h3 style="line-height: 0.3; font-weight: normal">Telefax No. (086) 211-3656</h3>
            </div>
            <div class="logo">
                <img src="C:/nginx-1.26.2/html/swads-app/public/assets/img/pswdo-logo.jpg" alt="logo">
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
            <h3>INTAKE SHEET</h3>
        </div>
        {{-- End of Title --}}

        <div style="display: flex; justify-content: space-between">
            <div style="display: inline-block; width: 55%; text-indent: 1rem">
                @foreach ($intakes as $intake)
                    <h3>
                        CASE NO.&nbsp;
                        <span style="line-height: 0;
                                    border-bottom: 1px solid #000000;
                                    padding-bottom: 0.1px;
                                    padding-left: 20px;
                                    padding-right: 20px;
                                    font-size: 1.2em;
                                    font-weight: normal"
                                    >
                                    {{ $intake->case_no }}
                        </span>
                    </h3>
                    <p class="fw-bold" style="line-height: 0">
                        TYPE OF CASE :
                        <span style="font-weight: normal;
                                    margin-left: 5px;
                                    font-size: 1.2rem"
                                    >
                                    {{ $intake->case }}
                        </span>
                    </p>
                @endforeach
            </div>
            <div style="display: inline-block; width: 40%;">
                @foreach($intakes as $intake)
                    <p class="fw-bold" style="line-height: 1; font-size: 1.1rem">
                        Date Administered:
                        <span style="font-weight: normal">
                            {{ Carbon::parse($intake->date_intake)->format('j F Y') }}
                        </span>
                    </p>
                    <p class="fw-bold" style="line-height: 0; font-size: 1.1rem">
                        Category:
                        <span style="font-weight: normal">
                            {{ ucwords($intake->assistance->name) }}
                        </span>
                    </p>
                @endforeach
            </div>
        </div>


        {{-- Identify Data --}}
        <div>
            <div style="margin-top: -10px">
                <h3 style="text-indent: 2rem">I. <span style="margin-left: 2%">IDENTIFYING DATA</span></h3>
            </div>
            <div class="roboto-regular d-flex">
                    <div style="max-width: 30%; margin-left: 6%; line-height: 0.5; font-size: 1.1rem; margin-top: -10px ">
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
                @foreach($intakes as $intake)
                    <div style="max-width: 80%; margin-left: 2%; line-height: 0.5; font-size: 1.1rem; margin-top: -10px">
                        <p style="font-weight: normal">:
                            {{ strtoupper($intake->first_name) }} {{ $intake->middle_name ? strtoupper(substr($intake->middle_name, 0, 1)) . "." : "" }} {{ strtoupper($intake->last_name) }}{{ $intake->extn_name ? ', ' . strtoupper($intake->extn_name) : '' }}
                        </p>
                        <p style="font-weight: normal">:
                            {{ strtoupper($intake->nick_name) }}
                        </p>
                        <p style="font-weight: normal">:
                            {{ $intake->age }}
                        </p>
                        <p style="font-weight: normal">:
                            {{ ucwords($intake->sex) }}
                        </p>
                        <p style="font-weight: normal">:
                            {{ ucwords($intake->civil_stats) }}
                        </p>
                        <p style="font-weight: normal">:
                            {{ !empty(trim($intake->purok)) ? "Purok " . ucwords($intake->purok) : "" }}
                            {{ !empty(trim($intake->street)) ? ucwords($intake->street) . " St., " : "" }}
                            {{ ucwords($intake->brgy->barangay) . "," }}
                            {{ ucwords($intake->municipal->municipality) . ", Surigao del Sur" }}
                        </p>
                        <p style="font-weight: normal">:
                            {{ Carbon::parse($intake->birthdate)->format('F j, Y') }}
                        </p>
                        <p style="font-weight: normal">:
                            {{ !empty(trim($intake->job)) ? ucwords($intake->job) : "N/A" }}
                        </p>
                        <p style="font-weight: normal">:
                            @php
                                $income = !empty(trim($intake->income)) ? str_replace(',', '', trim($intake->income)) : null;

                                if(is_numeric($income) && $income !== null) {
                                    echo number_format((float)$income, 2, '.', ',');
                                }else {
                                    if($intake->income !== null && !str_contains($intake->income, '0')){
                                        echo $intake->income;
                                    }else {
                                        echo "N/A";
                                    }
                                }
                            @endphp
                        </p>
                        <p style="font-weight: normal">:
                            {{ $intake->contact_no }}
                        </p>
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
            <tbody>
                @foreach ($famCompose as $data)
                <tr>
                    <td>{{ ucwords($data->firstname) }} {{ $data->middlename != null ? strtoupper(substr($data->middlename, 0, 1)) . '.' : "" }} {{ ucwords($data->lastname) }}</td>
                    <td>{{ $data->age != null ? $data->age . " years old" : "" }}</td>
                    <td>
                        @php
                            if ($data->relationship !== null) {
                                $relationship = str_replace('-', ' ', $data->famRelation->name);
                                $rel = ucwords($relationship);

                                if(str_contains($data->famRelation->name, '-')) {
                                    echo str_replace(' ', '-', $rel);
                                }else {
                                    echo ucwords($data->famRelation->name);
                                }
                            }
                        @endphp
                    </td>
                    <td>{{ !empty(trim($data->educ_attainment)) ? ucwords($data->educ_attainment) : "" }}</td>
                    <td>{{ ucfirst($data->remarks) }}</td>
                </tr>
                @endforeach
            </tbody>
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
        <p class="fw-bold" style="font-size: 1.1rem; margin-top: 3%; margin-left: 3%">Prepared by:</p>

        <div class="container-1" style="width: auto; max-width: 100%">
            <div class="case text-centered" style="line-height: 0.5; margin-left: 3%">
                <p class="fw-bold" style="text-decoration: underline; font-size: 1.1rem">{{ $createdBy }}</p>
                <p>PSWDO Staff</p>
            </div>
            <div class="date text-centered" style="line-height: 0.5; margin-left: 35%; font-size: 1.1rem">
                @foreach ($intakes as $data)
                    <p class="fw-bold">Attested by: &nbsp;<span style="text-decoration: underline">{{ strtoupper($data->first_name) }} {{ $data->middle_name ? strtoupper(substr($data->middle_name, 0, 1)) ."." : "" }} {{ strtoupper($data->last_name) }}{{ $data->extn_name ? ", " . strtoupper($data->extn_name) : "" }}</span></p>
                @endforeach
                <p style="text-indent: 3rem">Client</p>
            </div>
        </div>

        <div style="margin-left: 35%;">
            <p class="fw-bold" style="font-size: 1.1rem">Noted by:</p>
        </div>

        <div style="margin-left: 50%; margin-top: 3%; line-height: 0.5">
            <p class="fw-bold" style="text-decoration: underline; font-size: 1.1rem">HERSHE LORENZANA-NUÑEZ, RSW</p>
            <p>Provincial Social Welfare and Development Officer</p>
            <p style="font-style: italic">PRC Lic No. 0009119</p>
            <p style="font-style: italic">Valid until November 28, 2027</p>
        </div>
    </div>
    {{-- End of Signatories --}}
</body>
</html>

