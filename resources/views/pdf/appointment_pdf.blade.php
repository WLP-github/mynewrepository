<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF Download</title>
    <style>
        h3 {
            text-align: center !important;
            margin: 0 30%;
        }
        table{
            font-weight: bold;
            font-size: 16px;
        }
        table tr>td{
            padding: 4px;
        }
        ol#myList {
            font-family: 'zawgyi';
            list-style-type:decimal;
        }
    </style>

</head>
<body style="font-family: padauk">
    <h2 style="text-align: center">Appointment Letter</h2>
    <br>
    @if ($data['department_id'] == 1) {{-- cosmetic dept --}}
        <h3 style="background-color: yellow">{{ $data['time'] }}</h3>
    @elseif($data['department_id'] == 2) {{-- medical device dept --}}
        <h3 style="background-color: blue">{{ $data['time'] }}</h3>
    @else {{-- grouping dept --}}
        <h3>{{ $data['time'] }}</h3>
    @endif
    <br><br>
    <table>
            <tr><td colspan=2>ApplicationID: {{$data['app_cat_short_name']}}-{{ date("Ymd", strtotime( $data['date'])) }}-{{$data['token_no']}}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>1. Application Type</td><td>-</td><td>{{ $data['app_cat_name'] }}</td></tr>
            <tr><td>2. Schedule Date</td><td>-</td><td>{{ date("d-M-Y", strtotime($data['date'])) }}</td></tr>
            <tr><td>3. Brand Name</td><td>-</td><td>{{ $data['brand_name'] }}</td></tr>
            @if ($data['department_id'] !=3 )
                <tr><td>4. Number Of Items</td><td>-</td><td>{{ $data['item_amonut'] }}</td></tr>
                <tr><td>5. Schedule Time</td><td>-</td><td><b>{{ $data['time'] }}</b></td></tr>
            @else
                <tr><td>4. Include Content Quantity</td><td>-</td><td>{{ $data['item_amonut'] }}</td></tr>
            @endif
            <tr><td>6.  Company Registration No</td><td>-</td><td> {{ $data['company_registration_no'] }}</td></tr>
            <tr><td>7. Company Name</td><td>-</td><td> {{ $data['company_name'] }}</td></tr>
            <tr><td>8. Applicant Name</td><td>-</td><td> {{ $data['applicant_name'] }}</td></tr>
            <tr><td>9. Applicant's NRC</td><td>-</td><td> {{ $data['applicant_nrc'] }}</td></tr>
            <tr><td>10. Applicant Phone No.</td><td>-</td><td> {{ $data['applicant_phone_no'] }}</td></tr>
        </table>
        <div>
           {{-- {!! QrCode::color(0, 0, 0)->size(100)->generate($data['app_cat_name']."/".date("Ymd", strtotime( $data['date']))); !!} --}}
           <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($data['app_cat_name']."/".date("Ymd", strtotime( $data['date'])))) !!} ">
        </div>
        <br>
        <div style="font-family: zawgyi;">
            မွတ္ခ်က္
        </div>
        @if ($data['department_id'] !=3 )
            <pre style="font-family: zawgyi;">
                (၁) ယူထားသည့္ Items အေရအတြက္ အတိအက်ျဖင့္ လာေရာက္ရမည္။
                (၂) ရက္ခ်ိန္းေန႔တြင္ လာေရာက္ျခင္းမရွိပါက (သို႔မဟုတ္) ရယူထားသည္႕ Items 
                        အေရအတြက္ အတိုင္းမဟုတ္ပါက (၁) လ အထိ ရက္ခ်ိန္းေလွ်ာက္ထားျခင္းကို ပိတ္ပင္ပါမည္။
                (၃) ယူထားသည့္ ကုမၸဏီမွလြဲ၍ အျခားကုမၸဏီျဖင့္ လာေရာက္အစားထိုးေလွ်ာက္ထားျခင္းကို လက္မခံပါ။
                (၄) သတ္မွတ္လာေရာက္ရမည့္ အခ်ိန္ထက္ ေက်ာ္လြန္ ေရာက္ရွိပါက ရက္ခ်ိန္းစာရင္းမွ
                        အလိုအေလ်ာက္ ပယ္ဖ်က္ပါမည္။
                (၅) သတ္မွတ္လာေရာက္ရမည့္ အခ်ိန္ထက္ မိနစ္ ၃၀ ႀကိဳေရာက္ရန္ႏွင့္ ေရာက္ရွိပါက စာရင္းေပး
                        အေၾကာင္းၾကားရန္။
                (၆) Cancellation ကိုတစ္ပတ္ၾကိဳတင္ ေလွ်ာက္ထားရန္။
            </pre>
        
        @else
            <ol id="myList">
                <li>
                    Appointment Letter ေလွ်ာက္ထားရာတြင္ Registered ထြက္ထားေသာ 	User Name ႏွင့္ Password မ်ားျဖင့္     ဌာန၏ Domain Link သို႔ ၀င္ေရာက္ေလွ်ာက္ထားရပါမည္။
                </li>
                <li>
                    Appointment Letter ရရွိၿပီးေသာ သူမ်ားသည္ (၁)ပတ္ႀကိဳတင္၍ ဌာန၏ E-mail ျဖစ္ေသာ fdamd@mohs.gov.mm     သို႔ဆက္သြယ္၍ ဌာနမွေပးေသာ ရက္ခ်ိန္းရယူႏိုင္ပါသည္။            
                </li>
                <li>
                    E-mail ပို႔ရာတြင္ Appointment Letter, Product Information မ်ားႏွင့္ Product List မ်ား ထည့္သြင္း    ေဖာ္ျပေပးႏိုင္ပါသည္။
                </li>
                <li>
                    ဌာနသို႔ Grouping ရက္ခ်ိန္းလာေရာက္ပါက ေဆးႏွင့္ေဆးပစၥည္းအသင္း၀င္ ကဒ္ျပားမိတၱဴ၊ မွတ္ပံုတင္မိတၱဴ၊     Appointment Letter တို႔ျဖင့္ လာေရာက္ဆက္ သြယ္ရမည္။"
                </li>
                <li>
                    Cancellation ကို (၁)ပတ္ႀကိဳတင္ေလွ်ာက္ထားႏိုင္ပါသည္။
                </li>
                <li>
                    ရက္ခ်ိန္းေန႔တြင္ လာေရာက္ ျခင္းမရွိပါက (သို႔မဟုတ္) ရယူထားသည့္ Item အေရအတြက္အတိုင္း မဟုတ္ပါက (၁)လ အထိ ရက္ခ်ိန္းေလွ်ာက္ထားျခင္းကို ပိတ္ပင္ပါမည္။
                </li>
            </ol>
        @endif
        
</body>
</html>

