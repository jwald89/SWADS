<?php
    use Carbon\Carbon;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Guarante Letter Print</title>
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
    </style>
</head>
<body >
    {{-- Header --}}
    <div>

        <div class="container-header">
            <div class="province-logo logo">
                <img src="C:/nginx-1.26.2/html/swads-app/public/assets/img/sds.png" alt="logo">
            </div>
            <div class="header">
                    <h3 style="line-height: 0.8">Republic of the Philippines</h3>
                    <h2 style="line-height: 0">PROVINCE OF SURIGAO DEL SUR</h2>
                    <h3 style="line-height: 0.3; font-weight: normal">Capitol Hills, Telaje, Tandag City</h3>
                    <h3 style="line-height: 0.3; font-weight: normal">Telefax No. (086) 211-3656</h3>
            </div>
            <div class="pswdo-logo logo">
                <img src="C:/nginx-1.26.2/html/swads-app/public/assets/img/pswdo-logo-2.jpg" alt="logo">
            </div>
        </div>
        {{-- End Header --}}

        {{-- Office --}}
        <div style="text-align: center; line-height: 0; margin-top: 5%">
            <h3>PROVINCIAL SOCIAL WELFARE AND DEVELOPMENT OFFICE</h3>
        </div>
        {{-- End of Office --}}

        <div style="margin-top: 5%; font-size: 1.05rem">
            @foreach ($medicines as $medicine)
            <p style="line-height: 0.3">Date: <span style="text-decoration: underline">{{ Carbon::parse($medicine->date_started)->format('F j, Y') }}</span>
                                        &nbsp;Valid Until: <span style="text-decoration: underline">{{ Carbon::parse($medicine->date_ended)->format('F j, Y') }}</span>
            </p>
            @endforeach
            @foreach ($medicines as $medicine)
            <p style="line-height: 0.3">Pharmacy: {{ ucwords($medicine->pharmacy) }}</p>
            @endforeach

            <p style="margin-top: 40px">Dear Sir/ Ma’am:</p>
            @inject('formatter', 'App\Utility\Formatter')

            <div style="display: flex;">
                @foreach($medicines as $medicine)
                <p style="margin-bottom: 2rem">
                    The Provincial Social Welfare and Development guarantees to pay the amount of
                    <span style="margin-bottom: 1em; display: inline-block; border-bottom: 1px solid black; min-width: auto; padding: 1px 5px 0 5px; position: relative; text-align: center;">
                        {{ ucwords($formatter->amountInWords($medicine->amount) . " Only") }}
                        <span style="font-size: 0.8em; position: absolute; width: 100%; left: 0">Amount in words</span>
                    </span>
                    <span style="display: inline-block; border-bottom: 1px solid black; min-width: auto; padding: 1px 10px 0 10px; text-align: center; margin-top: 0.5em">{{ number_format($medicine->amount, 2, '.', ',') }}</span>
                    <span>for</span>
                    <span style="margin-bottom: 0.5em; display: inline-block; border-bottom: 1px solid black; min-width: auto; padding: 1px 25px 0 25px; position: relative; text-align: center; margin-top: 0.5em">
                        {{ strtoupper($medicine->first_name) }} {{ $medicine->middle_name !== NULL ? strtoupper(substr($medicine->middle_name, 0, 1)) . "." : "" }} {{ strtoupper($medicine->last_name) }} {{ $medicine->suffix !== NULL ? strtoupper($medicine->suffix) : "" }}
                        <span style="font-size: 0.8em; position: absolute; width: 100%; left: 0">Name of client</span>
                    </span>
                    <span>resident of</span>
                    <span style="margin-bottom: 1.5em; display: inline-block; border-bottom: 1px solid black; min-width: auto; padding: 1px 15px 0 15px; position: relative; text-align: center;">
                        {{ strtoupper($medicine->barangay->barangay) . "," }} {{ strtoupper($medicine->municipal->municipality) . ", SURIGAO DEL SUR" }}
                        <span style="font-size: 0.8em; position: absolute; width: 100%; left: 0">Current address</span>
                    </span>
                    <span>for</span>
                    <span style="margin-bottom: 0.5em; display: inline-block; border-bottom: 1px solid black; min-width: auto; padding: 1px 50px 0 50px; position: relative; text-align: center;">
                        Medicines
                        <span style="font-size: 0.8em; position: absolute; width: 100%; left: 0">Type of assistance</span>
                    </span>
                    <span>intended for</span>
                    @if($medicine->beneficiary !== NULL)
                    <span style="margin-bottom: 0.5em; display: inline-block; border-bottom: 1px solid black; min-width: auto; padding: 1px 100px 0 100px; position: relative; text-align: center;">
                        {{ $medicine->beneficiary !== NULL ? ucwords($medicine->beneficiary) : "" }}
                        <span style="font-size: 0.8em; position: absolute; width: 100%; left: 0">Beneficiary of Client</span>
                    </span>
                    @else
                    <span style="margin-bottom: 0.5em; display: inline-block; border-bottom: 1px solid black; min-width: auto; padding: 1px 50px 0 50px; position: relative; text-align: center; color: white">
                        Blank Space
                        <span style="font-size: 0.8em; position: absolute; width: 100%; left: 0; color: black">Beneficiary of Client</span>
                    </span>
                    @endif
                    <span>,</span>
                    @if($medicine->relationship !== NULL)
                    <span style="margin-bottom: 0.5em; display: inline-block; border-bottom: 1px solid black; min-width: auto; padding: 1px 100px 0 100px; position: relative; text-align: center;">
                        {{ $medicine->relationship !== NULL ? ucwords($medicine->famRelation->name) : "" }}
                        <span style="font-size: 0.8em; position: absolute; width: 100%; left: 0">Relationship</span>
                    </span>
                    @else
                    <span style="margin-bottom: 0.5em; display: inline-block; border-bottom: 1px solid black; min-width: auto; padding: 1px 50px 0 50px; position: relative; text-align: center; color: white">
                        Blank Space
                        <span style="font-size: 0.8em; position: absolute; width: 100%; left: 0; color: black">Relationship</span>
                    </span>
                    @endif
                </p>
                @endforeach
                <p>Please be informed that the check is payable to you company. Should have any quarries, you may call us 214-3656. Thank you for your consideration.</p>
                <p style="text-indent: 20%">Kinds of Medicine:  {{ $medicine->kinds_of_med }}</p>
                <br>
                <p>Prepared by: </p>
                <p style="font-weight: bold; margin-bottom: 0.5em; display: inline-block; border-bottom: 1px solid black; min-width: auto; position: relative; text-align: center; line-height: 1">
                    {{ $createdBy }}
                    @foreach($medicines as $medicine)
                    <span style="margin-top: 5px; position: absolute; width: 100%; font-weight: normal; font-size: 0.8em">{{ ucwords($medicine->user->designation) }}</span>
                    @endforeach
                </p>
                <br>
                <p style="text-indent: 50%">Approved by:</p>
                <div style="text-align: right; margin-right: 10%">
                    <p style="text-align: center; font-weight: bold; min-width: auto; display: inline-block; border-bottom: 1px solid black; padding: 0 30px 0 25px; position: relative; line-height: 1">
                        HERSHE L. NUÑEZ, RSW
                        <span style="margin-top: 5px; text-decoration: none; margin-right: -75px; position: absolute; width: 170% ; font-weight: normal; font-size: 0.9em; right: 0">Provincial Social Welfare and Development Officer</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    {{-- End of Signatories --}}
</body>
</html>
{{-- END OF 1st PAGE --}}
