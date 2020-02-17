<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF Download</title>
    <style>
        h3 {
            background-color: yellow;
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
    </style>
    <script>
     $(function(){
         console.log("ready");
     })
    </script>
</head>
<body style="font-family: padauk">
    <h2 style="text-align: center">Appointment Letter</h2>
    <br>
    {{-- @foreach ($appLists as $appList) --}}
    <h3>{{ $data['time'] }}</h3>
    <br><br>
    {{-- {{dd($data)}} --}}
    <table>
            <tr><td colspan=2>ApplicationID: {{$data['app_cat_short_name']}}-{{ date("Ymd", strtotime( $data['date'])) }}-001</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Application Type</td><td>-</td><td>{{ $data['app_cat_name'] }}</td></tr>
            <tr><td>Schedule Date</td><td>-</td><td>{{ date("d,M-Y", strtotime($data['date'])) }}</td></tr>
            <tr><td>Brand Name</td><td>-</td><td>{{ $data['brand_name'] }}</td></tr>
            <tr><td>Number Of Item</td><td>-</td><td>{{ $data['item_amonut'] }}</td></tr>
            <tr><td>Schedule Time</td><td>-</td><td><b>{{ $data['time'] }}</b></td></tr>
            <tr><td>Company Registration No</td><td>-</td><td> {{ $data['company_registration_no'] }}</td></tr>
            <tr><td>Company Name</td><td>-</td><td> {{ $data['company_name'] }}</td></tr>
            <tr><td>Applicant Name</td><td>-</td><td> {{ $data['applicant_name'] }}</td></tr>
            <tr><td>Applicant NRC</td><td>-</td><td> {{ $data['applicant_nrc'] }}</td></tr>
            <tr><td>Applicant Phone No.</td><td>-</td><td> {{ $data['applicant_phone_no'] }}</td></tr>
        </table>
        <div>
           {!! QrCode::color(0, 0, 0)->size(100)->generate($data['app_cat_name']."/".date("Ymd", strtotime( $data['date']))); !!}
        </div>
        <br>
        <div style="font-family: zawgyi;">
            မွတ္ခ်က္
        </div>
        <pre style="font-family: zawgyi;">
            {{-- <li>(၁) ယူထားသညါ့ Items အ‌ေရေအတွက် အတိအကျ ြဖင့် လာ‌ေရာက်ရမည်။ </li>
            <li>(၂) ရက်ချိန်းနေ့ တွင် လာ‌ေရာက် ြခင်း မရှိပါက (သို့မဟုတ်) ရယူထားသည့် Items အရေအတွက် အတိုင်း မဟုတ်ပါက (၁) လ အထိ ရက်ချိန်း ရယူြခင်း ပိတ်ပင်ပါမည်။</li>
            <li>(၃) ယူထားသည့္ ကုမၸဏီမွလြဲ၍ အျခားကုမၸဏီျဖင့္ လာေရာက္အစားထိုးေလွ်ာက္ထားျခင္းကို လက္မခံပါ။</li> --}}
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
    
    {{-- @endforeach --}}
        
</body>
</html>

