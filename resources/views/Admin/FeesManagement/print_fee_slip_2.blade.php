


<!DOCTYPE html>
<html lang="en">

<head>
    <style type="text/css">
        .vertical {
            position: absolute;
            top: 11px;
            bottom: 0;
            left: 47.7%;
            height: 1118px;
            border-left: 1px dashed #8c8b8b;
        }

        .vertical2 {
            position: absolute;
            top: 11px;
            bottom: 0;
            left: 64.7%;
            height: 1118px;
            border-left: 1px dashed #8c8b8b;
        }
    </style>
    <style>

        /*! normalize.css v3.0.3 | MIT License | github.com/necolas/normalize.css */

        /**
         * 1. Set default font family to sans-serif.
         * 2. Prevent iOS and IE text size adjust after device orientation change,
         *    without disabling user zoom.
         */

        html {
            font-family: sans-serif; /* 1 */
            -ms-text-size-adjust: 100%; /* 2 */
            -webkit-text-size-adjust: 100%; /* 2 */
        }

        /**
         * Remove default margin.
         */

        body {
            margin: 0;
        }

        /* HTML5 display definitions
           ========================================================================== */

        /**
         * Correct `block` display not defined for any HTML5 element in IE 8/9.
         * Correct `block` display not defined for `details` or `summary` in IE 10/11
         * and Firefox.
         * Correct `block` display not defined for `main` in IE 11.
         */

        article,
        aside,
        details,
        figcaption,
        figure,
        footer,
        header,
        hgroup,
        main,
        menu,
        nav,
        section,
        summary {
            display: block;
        }

        /**
         * 1. Correct `inline-block` display not defined in IE 8/9.
         * 2. Normalize vertical alignment of `progress` in Chrome, Firefox, and Opera.
         */

        audio,
        canvas,
        progress,
        video {
            display: inline-block; /* 1 */
            vertical-align: baseline; /* 2 */
        }

        /**
         * Prevent modern browsers from displaying `audio` without controls.
         * Remove excess height in iOS 5 devices.
         */

        audio:not([controls]) {
            display: none;
            height: 0;
        }

        /**
         * Address `[hidden]` styling not present in IE 8/9/10.
         * Hide the `template` element in IE 8/9/10/11, Safari, and Firefox < 22.
         */

        [hidden],
        template {
            display: none;
        }

        /* Links
           ========================================================================== */

        /**
         * Remove the gray background color from active links in IE 10.
         */

        a {
            background-color: transparent;
        }

        /**
         * Improve readability of focused elements when they are also in an
         * active/hover state.
         */

        a:active,
        a:hover {
            outline: 0;
        }

        /* Text-level semantics
           ========================================================================== */

        /**
         * Address styling not present in IE 8/9/10/11, Safari, and Chrome.
         */

        abbr[title] {
            border-bottom: 1px dotted;
        }

        /**
         * Address style set to `bolder` in Firefox 4+, Safari, and Chrome.
         */

        b,
        strong {
            font-weight: bold;
        }

        /**
         * Address styling not present in Safari and Chrome.
         */

        dfn {
            font-style: italic;
        }

        /**
         * Address variable `h1` font-size and margin within `section` and `article`
         * contexts in Firefox 4+, Safari, and Chrome.
         */

        h1 {
            font-size: 2em;
            margin: 0.67em 0;
        }

        /**
         * Address styling not present in IE 8/9.
         */

        mark {
            background: #ff0;
            color: #000;
        }

        /**
         * Address inconsistent and variable font size in all browsers.
         */

        small {
            font-size: 80%;
        }

        /**
         * Prevent `sub` and `sup` affecting `line-height` in all browsers.
         */

        sub,
        sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline;
        }

        sup {
            top: -0.5em;
        }

        sub {
            bottom: -0.25em;
        }

        /* Embedded content
           ========================================================================== */

        /**
         * Remove border when inside `a` element in IE 8/9/10.
         */

        img {
            border: 0;
        }

        /**
         * Correct overflow not hidden in IE 9/10/11.
         */

        svg:not(:root) {
            overflow: hidden;
        }

        /* Grouping content
           ========================================================================== */

        /**
         * Address margin not present in IE 8/9 and Safari.
         */

        figure {
            margin: 1em 40px;
        }

        /**
         * Address differences between Firefox and other browsers.
         */

        hr {
            box-sizing: content-box;
            height: 0;
        }

        /**
         * Contain overflow in all browsers.
         */

        pre {
            overflow: auto;
        }

        /**
         * Address odd `em`-unit font size rendering in all browsers.
         */

        code,
        kbd,
        pre,
        samp {
            font-family: monospace, monospace;
            font-size: 1em;
        }

        /* Forms
           ========================================================================== */

        /**
         * Known limitation: by default, Chrome and Safari on OS X allow very limited
         * styling of `select`, unless a `border` property is set.
         */

        /**
         * 1. Correct color not being inherited.
         *    Known issue: affects color of disabled elements.
         * 2. Correct font properties not being inherited.
         * 3. Address margins set differently in Firefox 4+, Safari, and Chrome.
         */

        button,
        input,
        optgroup,
        select,
        textarea {
            color: inherit; /* 1 */
            font: inherit; /* 2 */
            margin: 0; /* 3 */
        }

        /**
         * Address `overflow` set to `hidden` in IE 8/9/10/11.
         */

        button {
            overflow: visible;
        }

        /**
         * Address inconsistent `text-transform` inheritance for `button` and `select`.
         * All other form control elements do not inherit `text-transform` values.
         * Correct `button` style inheritance in Firefox, IE 8/9/10/11, and Opera.
         * Correct `select` style inheritance in Firefox.
         */

        button,
        select {
            text-transform: none;
        }

        /**
         * 1. Avoid the WebKit bug in Android 4.0.* where (2) destroys native `audio`
         *    and `video` controls.
         * 2. Correct inability to style clickable `input` types in iOS.
         * 3. Improve usability and consistency of cursor style between image-type
         *    `input` and others.
         */

        button,
        html input[type="button"], /* 1 */
        input[type="reset"],
        input[type="submit"] {
            -webkit-appearance: button; /* 2 */
            cursor: pointer; /* 3 */
        }

        /**
         * Re-set default cursor for disabled elements.
         */

        button[disabled],
        html input[disabled] {
            cursor: default;
        }

        /**
         * Remove inner padding and border in Firefox 4+.
         */

        button::-moz-focus-inner,
        input::-moz-focus-inner {
            border: 0;
            padding: 0;
        }

        /**
         * Address Firefox 4+ setting `line-height` on `input` using `!important` in
         * the UA stylesheet.
         */

        input {
            line-height: normal;
        }

        /**
         * It's recommended that you don't attempt to style these elements.
         * Firefox's implementation doesn't respect box-sizing, padding, or width.
         *
         * 1. Address box sizing set to `content-box` in IE 8/9/10.
         * 2. Remove excess padding in IE 8/9/10.
         */

        input[type="checkbox"],
        input[type="radio"] {
            box-sizing: border-box; /* 1 */
            padding: 0; /* 2 */
        }

        /**
         * Fix the cursor style for Chrome's increment/decrement buttons. For certain
         * `font-size` values of the `input`, it causes the cursor style of the
         * decrement button to change from `default` to `text`.
         */

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            height: auto;
        }

        /**
         * 1. Address `appearance` set to `searchfield` in Safari and Chrome.
         * 2. Address `box-sizing` set to `border-box` in Safari and Chrome.
         */

        input[type="search"] {
            -webkit-appearance: textfield; /* 1 */
            box-sizing: content-box; /* 2 */
        }

        /**
         * Remove inner padding and search cancel button in Safari and Chrome on OS X.
         * Safari (but not Chrome) clips the cancel button when the search input has
         * padding (and `textfield` appearance).
         */

        input[type="search"]::-webkit-search-cancel-button,
        input[type="search"]::-webkit-search-decoration {
            -webkit-appearance: none;
        }

        /**
         * Define consistent border, margin, and padding.
         */

        fieldset {
            border: 1px solid #c0c0c0;
            margin: 0 2px;
            padding: 0.35em 0.625em 0.75em;
        }

        /**
         * 1. Correct `color` not being inherited in IE 8/9/10/11.
         * 2. Remove padding so people aren't caught out if they zero out fieldsets.
         */

        legend {
            border: 0; /* 1 */
            padding: 0; /* 2 */
        }

        /**
         * Remove default vertical scrollbar in IE 8/9/10/11.
         */

        textarea {
            overflow: auto;
        }

        /**
         * Don't inherit the `font-weight` (applied by a rule above).
         * NOTE: the default cannot safely be changed in Chrome and Safari on OS X.
         */

        optgroup {
            font-weight: bold;
        }

        /* Tables
           ========================================================================== */

        /**
         * Remove most spacing between table cells.
         */

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        td,
        th {
            padding: 0;
        }

        @page {
            margin: 0
        }

        body {
            margin: 0
        }

        .sheet {
            margin: 0;
            overflow: hidden;
            position: relative;
            box-sizing: border-box;
            page-break-after: always;
        }

        /** Paper sizes **/
        body.A3 .sheet {
            width: 297mm;
            height: 419mm
        }

        body.A3.landscape .sheet {
            width: 420mm;
            height: 296mm
        }

        body.A4 .sheet {
            width: 210mm;
            height: 296mm
        }

        body.A4.landscape .sheet {
            width: 333mm;
            height: 235mm
        }

        body.A5 .sheet {
            width: 148mm;
            height: 209mm
        }

        body.A5.landscape .sheet {
            width: 210mm;
            height: 147mm
        }

        /** Padding area **/
        .sheet.padding-10mm {
            padding: 5mm
        }

        .sheet.padding-15mm {
            padding: 15mm
        }

        .sheet.padding-20mm {
            padding: 20mm
        }

        .sheet.padding-25mm {
            padding: 25mm
        }

        /** For screen preview **/
        @media screen {
            body {
                background: #e0e0e0
            }

            .sheet {
                background: white;
                box-shadow: 0 .5mm 2mm rgba(0, 0, 0, .3);
                margin: 5mm;
            }
        }

        /** Fix for Chrome issue #273306 **/
        @media print {
            body.A3.landscape {
                width: 400mm
            }

            body.A3, body.A4.landscape {
                width: 335mm
            }

            body.A4, body.A5.landscape {
                width: 210mm
            }

            body.A5 {
                width: 148mm
            }
        }
    </style>

    <style>
        img {
            width: 100%
        }

        img {
            width: 100%
        }
    </style>
    <style>
        .container {
            border: 1px solid black;
            width: 100%;
        }

        header, footer {
            padding: 0em;
            color: black;
            clear: left;
            text-align: center;
        }
    </style>
    <style>
        .container1 {
            width: 100%;
            height: 341px;
            border: 1px solid black;
        }

        header, footer {
            padding: 0em;
            color: black;
            clear: left;
            text-align: left;
        }
    </style>
    <style>
        .container2 {
            width: 95%;
            margin: 10px;
            border: 1px solid black;
        }

        header, footer {
            padding: 1em;
            color: black;
            clear: left;
            text-align: left;
        }

        .container3 {
            width: 100%;
            border: 1px solid black;
        }
    </style>
    <style>
        table, th, td {

            border: 1px solid black;
        }

        th, td {

            text-align: left;
        }
    </style>
    <meta charset="utf-8">
    <title>Fees Slip</title>


    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>@page {
            size: A4 landscape
        }</style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4 landscape">

<!-- Each sheet element should have the class "sheet" -->
<!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
@php
    $campus = Session::get('CAMPUS');  //dd($campus);
@endphp
@foreach ($record as $key => $value)
    <section class="sheet padding-10mm">
        <div style="width: 46%; float: left;    margin: -8px 40.5px 0px 0px; ">
            <body>
            <div class="container3">
                <table style="width:563px">
                    <tr>
                        <td colspan="2" style="width:46%;padding:5px; border-top:double black;">
                            <span style="font-size:12px;"><b>Fees Slip</b></span><br>
                            @php $logo = (trim($campus->LOGO_IMAGE) == "") ? 'https://via.placeholder.com/60x60?text=LOGO' : asset('upload/'.$campus->LOGO_IMAGE) @endphp
                            <img src="{{$logo}}"
                                    style="width:20%">

                        </td>
                        <td colspan="2" style="width:46%;text-align:right; border-top:double black; padding:5px;">
                            <input type="hidden" class="std_bcode" value="233110010127693119">
                            <div class="233110010127693119" style="padding: 0px; overflow: auto; width: 156px;">
                            </div>
                            {{-- <span style="font-size:12px;">Receipt No:
                                <u>4279</u></span><br> --}}
                            <span style="font-size:12px;">Month:
                                 @foreach($value['student_fee_months'] as $month)<small> {{$month}}</small>, @endforeach
                            </span><br>
                            <span style="font-size:12px;">Due Date:
                                {{$value['DUE_DATE']}}</span><br>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="4" style="font-size:12px; padding:5px;">
                            <center>
                                <b style="font-family:;">{{strtoupper($campus->SCHOOL_NAME)}}</b><br>
                                Ph # {{$campus->PHONE_NO}}<br>
                               {{$campus->SCHOOL_ADDRESS}}<br>
                                                                        <br/>
                                Student Copy #                                 </center>
                        </td>
                    </tr>
                </table>
                <table style="width: 563px;  height: 20px; border-bottom: 0px solid black;border-left: 0px solid black; border-right: 0px solid black;">
                    <tr>
                        <td style="font-size: 13px; width: 35%; border-bottom: 0px solid black;border-left: 0px solid black; ">
                            &nbsp Student's Name
                        </td>
                        <td colspan="1" ;
                            style="border-bottom: 0px; font-size:13px; padding-left:2px; border-right: 0px">{{$value['NAME']}} </td>
                    </tr>
                </table>
                <table style="width:563px; height: 20px; border-bottom: 0px solid black;border-left: 0px solid black; border-right: 0px solid black;">
                    <tr>
                        <td style="font-size: 13px; width: 35%; border-bottom: 0px solid black;border-left: 0px solid black;">
                            &nbsp Father's Name
                        </td>
                        <td colspan="1" ;
                            style="border-bottom: 0px;font-size:13px;padding-left:2px; border-right: 0px">{{$value['FATHER_NAME']}} </td>
                    </tr>
                </table>
                <table style="width:563px; height: 20px;border-bottom: 0px solid black;border-left: 0px solid black; border-right: 0px solid black;">
                    <tr>
                        <td style="font-size: 13px; width: 34.9%; border-bottom: 0px solid black;border-left: 0px solid black;">
                            &nbsp REG-No.
                        </td>
                        <td style="width: 20%;border-bottom: 0px;font-size:13px; text-align: center; border-right: 0px">
                           {{$value['REG_NO']}}</td>
                        <td style="width: 20%; font-size: 14px; border-bottom: 0px; border-right: 0px;">&nbsp{{Session::get('class')}}
                        </td>
                        <td style="width: 28%; padding-left: 2px; font-size:12px; border-bottom: 0px; border-right: 0px">
                        @foreach($class as $clas)
                            {{ $clas['Class_id']==$value['CLASS_ID']?$clas['Class_name']:''}}</td>
                         @endforeach
                    </tr>
                </table>
                <table style="width:563px; height: 20px; border-bottom: 0px solid black;border-left: 0px solid black; border-right: 0px solid black;">
                    <tr>
                        <td style="font-size: 13px; width: 19%; border-bottom: 0px solid black;border-left: 0px solid black;">
                            &nbsp {{Session::get('section')}}
                        </td>
                        <td colspan="2" style="width: 27%; border-bottom: 0px; font-size:13px; text-align: center; border-right: 0px;">
                        @foreach($Section as $sec)
                            {{ $sec['Section_id']==$value['SESSION_ID']?$sec['Section_name']:''}}</td>
                         @endforeach

                          </td>
                        <td style="font-size: 13px; border-bottom: 0px; text-align: center; border-right: 0px;">
                            &nbsp {{Session::get('session')}}
                        </td>
                        <td colspan="2"  style="width: 27%; border-bottom: 0px; font-size:13px; text-align: center; border-right: 0px;">

                        @foreach($Session as $ses)
                            {{ $ses['SB_ID']==$value['SESSION_ID']?$ses['SB_NAME']:''}}</td>
                         @endforeach
                         </td>
                    </tr>
                </table>
                <div style="width:563px; height: 200px; border-bottom: 0px solid black; ">

                    <table class="table table-bordered" style="margin-bottom: 0px; width: 563px;">
                        <thead>
                        <tr style="background-color: #f4f4f4;">
                            <th style="width: 70%; font-size: 13px;border-left: 0px;border-bottom: 0px; padding: 5px;">
                                Fee Description
                            </th>
                            <th style="width: 70%; font-size: 13px;border-left: 0px;border-bottom: 0px; padding: 5px;">
                                Amount
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                            @php $total = 0; $monthsTotal = count($value['student_fee_months']) @endphp
                            @foreach ($value['student_fees'] as $k => $v)
                            @php $total += ($v['fee_amount'] * $monthsTotal ); $total += $v['prev_balance'];  @endphp
                              <tr>
                                    <td style=" text-align:right;padding:5px; width: 70%; font-size: 13px;border-left: 0px;border-bottom: 1px solid #f4f4f4; background-color:#EEE;" >
                                        {{$v['fee_category']}}
                                    </td>
                                    <td style=" text-align:right;padding:5px; width:30%; text-align: right; border-bottom: 1px solid #f4f4f4; padding: 2px; font-size: 13px; background-color:#EEE;">
                                          {{$v['fee_amount']}}
                                    </td>

                                </tr>

                            @endforeach



                        <tr>
                        </tr>
                        <tr>
                        </tr>
                        <tr>
                        </tr>

                        <tr>
                        </tr>
                        <tr>
                        </tr>


                        <tr>
                            <td colspan="1"
                                style="background-color:#EEE; border-top:1px solid  border-top:1px solid black; padding:5px; font-size:12px;">
                                Total Fee Amount
                            </td>
                        <td style="text-align:right;border:1px solid black; padding-left:5px; background-color:#EEE; font-size:12px;">{{$total}}</td>
                        </tr>
                        @if(!$v['prev_balance'] == 0 AND $v['prev_type'] == 1 )
                            <tr>
                                <td colspan="1"
                                    style="text-align:right; background-color:#EEE; border-top:1px solid black; padding-left:5px; font-size:12px;">
                                Balance
                                </td>
                                <td style="text-align:right;padding:5px; background-color:#EEE; font-size:12px;">
                                {{$v['prev_balance']}} </td>
                            </tr>
                            @else
                            <tr>
                                <td colspan="1"
                                    style="text-align:right; background-color:#EEE; border-top:1px solid black; padding-left:5px; font-size:12px;">
                                Advance
                                </td>
                                <td style="text-align:right;padding:5px; background-color:#EEE; font-size:12px;">
                                {{$v['prev_balance']}} </td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="1"
                                style="background-color:#EEE; border-top:1px solid  border-top:1px solid black; padding:5px; font-size:12px;">
                                Payable Amount
                            </td>
                            @php $total = ($total <0 ) ? 0.00 : $total @endphp
                        <td style="text-align:right;border:1px solid black; padding-left:5px; background-color:#EEE; font-size:12px;">{{$total}}</td>
                        </tr>
                        </tbody>

                        <tfoot>


                    </table>


                </div>
            </div>
            <div class="container1" style="margin-top: 8px;border-top:0px;">
                        <header style="font-size: 11px; margin: -8px 0px 0px 0px;">
                            <b><u>PAYMENT TERMS</u></b>
                        </header>
                        <div class="" width="35%" style="margin-top: -7px; height: 165px">
                             @if ($terms)
                            <div style="margin-top:-15px;padding: 5px 0 0 4px;font-size:10px;">
                              <p>  {!!$terms->FEE_TERMS_CONDETIONS!!}</p>
                            </div>
                            @endif
                            {{-- <p style="font-size: 11px; margin-top: 2px">&nbsp Respected Parents</p>
                            <div style="margin-top:-15px;padding: 5px 0 0 4px;">
                                <a style="font-size:10px;">1-</a> <a style="font-size:10px;">Please Deposit Your Child Dues
                                    Upto
                                    10 of every Month. After Due Date Rs.10 /- per day will be Charged.</a><br> <a
                                        style="font-size:10px;">2-</a> <a style="font-size:10px;">Iff you did not Receive
                                    Fee
                                    Voucher Kindly contact School Administration </a><br> <a style="font-size:10px;">3-</a>
                                <a
                                        style="font-size:10px;">Any error in Fee Voucher Please Contact Account
                                    Office.</a><br>
                                <a style="font-size:10px;">4-</a> <a style="font-size:10px;">Please Keep This Receipt
                                    Securely
                                    with you for future Correspondence .You must take the Fee Receipt after Depositing the
                                    School Fee & No Claim will be entertained without deposit Slip</a><br> <a
                                        style="font-size:10px;">5-</a> <a style="font-size:10px;">Without slip, Don't Submit
                                    Your Child Fee</a><br></div> --}}
                        </div>


                        <footer style="font-size: 12px; margin-top: 84px"><h4>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Stamp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                 Authorized Signature</h4></footer>
                        <div style="margin-left: 94px; margin-top:0px">

                        </div>
                    </div>
            </body>
        </div>
        <hr class="vertical">
        {{-- <hr class="vertical2"> --}}

        {{-- second accounts copy --}}
         <div style="width: 46%; float: left;    margin: -8px 40.5px 0px 0px; ">
            <body>
            <div class="container3">
                <table style="width:563px">
                    <tr>
                        <td colspan="2" style="width:46%;padding:5px; border-top:double black;">
                            <span style="font-size:12px;"><b>Fees Slip</b></span><br>
                            @php $logo = (trim($campus->LOGO_IMAGE) == "") ? 'https://via.placeholder.com/60x60?text=LOGO' : asset('upload/'.$campus->LOGO_IMAGE) @endphp
                            <img src="{{$logo}}"
                                    style="width:20%">
                        </td>
                        <td colspan="2" style="width:46%;text-align:right; border-top:double black; padding:5px;">
                            <input type="hidden" class="std_bcode" value="233110010127693119">
                            <div class="233110010127693119" style="padding: 0px; overflow: auto; width: 156px;">
                            </div>
                            {{-- <span style="font-size:12px;">Receipt No:
                                <u>4279</u></span><br> --}}
                            <span style="font-size:12px;">Month:
                                 @foreach($value['student_fee_months'] as $month)<small> {{$month}}</small>, @endforeach
                            </span><br>
                            <span style="font-size:12px;">Due Date:
                                {{$value['DUE_DATE']}}</span><br>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="4" style="font-size:12px; padding:5px;">
                            <center>
                                <b style="font-family:;">{{strtoupper($campus->SCHOOL_NAME)}}</b><br>
                                Ph # {{$campus->PHONE_NO}}<br>
                               {{$campus->SCHOOL_ADDRESS}}<br>
                                                                        <br/>
                                Accounts Copy #                                 </center>
                        </td>
                    </tr>
                </table>
                <table style="width: 563px;  height: 20px; border-bottom: 0px solid black;border-left: 0px solid black; border-right: 0px solid black;">
                    <tr>
                        <td style="font-size: 13px; width: 35%; border-bottom: 0px solid black;border-left: 0px solid black; ">
                            &nbsp Student's Name
                        </td>
                        <td colspan="1" ;
                            style="border-bottom: 0px; font-size:13px; padding-left:2px; border-right: 0px">{{$value['NAME']}} </td>
                    </tr>
                </table>
                <table style="width:563px; height: 20px; border-bottom: 0px solid black;border-left: 0px solid black; border-right: 0px solid black;">
                    <tr>
                        <td style="font-size: 13px; width: 35%; border-bottom: 0px solid black;border-left: 0px solid black;">
                            &nbsp Father's Name
                        </td>
                        <td colspan="1" ;
                            style="border-bottom: 0px;font-size:13px;padding-left:2px; border-right: 0px">{{$value['FATHER_NAME']}} </td>
                    </tr>
                </table>
                <table style="width:563px; height: 20px;border-bottom: 0px solid black;border-left: 0px solid black; border-right: 0px solid black;">
                    <tr>
                        <td style="font-size: 13px; width: 34.9%; border-bottom: 0px solid black;border-left: 0px solid black;">
                            &nbsp REG-No.
                        </td>
                        <td style="width: 20%;border-bottom: 0px;font-size:13px; text-align: center; border-right: 0px">
                           {{$value['REG_NO']}}</td>
                        <td style="width: 15%; font-size: 14px; border-bottom: 0px; border-right: 0px;">&nbsp
                            {{Session::get('class')}}
                        </td>
                        <td style="width: 28%; padding-left: 2px; font-size:12px; border-bottom: 0px; border-right: 0px">
                        @foreach($class as $clas)
                            {{ $clas['Class_id']==$value['CLASS_ID']?$clas['Class_name']:''}}</td>
                         @endforeach
                    </tr>
                </table>
                <table style="width:563px; height: 20px; border-bottom: 0px solid black;border-left: 0px solid black; border-right: 0px solid black;">
                    <tr>
                        <td style="font-size: 13px; width: 19%; border-bottom: 0px solid black;border-left: 0px solid black;">
                            &nbsp {{Session::get('section')}}
                        </td>
                        <td colspan="2" style="width: 27%; border-bottom: 0px; font-size:13px; text-align: center; border-right: 0px;">
                        @foreach($Section as $sec)
                            {{ $sec['Section_id']==$value['SESSION_ID']?$sec['Section_name']:''}}</td>
                         @endforeach
                          </td>
                        <td style="font-size: 13px; border-bottom: 0px; text-align: center; border-right: 0px;">
                            &nbsp
                           {{Session::get('session')}}
                        </td>
                        <td colspan="2"  style="width: 27%; border-bottom: 0px; font-size:13px; text-align: center; border-right: 0px;">
                        @foreach($Session as $ses)
                            {{ $ses['SB_ID']==$value['SESSION_ID']?$ses['SB_NAME']:''}}</td>
                         @endforeach
                         </td>
                    </tr>
                </table>
                        <div style="width:563px; height: 200px; border-bottom: 0px solid black; ">

                    <table class="table table-bordered" style="margin-bottom: 0px; width: 563px;">
                        <thead>
                        <tr style="background-color: #f4f4f4;">
                            <th style="width: 70%; font-size: 13px;border-left: 0px;border-bottom: 0px; padding: 5px;">
                                Fee Description
                            </th>
                            <th style="width: 70%; font-size: 13px;border-left: 0px;border-bottom: 0px; padding: 5px;">
                                Amount
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                            @php $total = 0; $monthsTotal = count($value['student_fee_months']) @endphp
                            @foreach ($value['student_fees'] as $k => $v)
                            @php $total += ($v['fee_amount'] * $monthsTotal ); $total += $v['prev_balance'];  @endphp
                              <tr>
                                    <td style=" text-align:right;padding:5px; width: 70%; font-size: 13px;border-left: 0px;border-bottom: 1px solid #f4f4f4; background-color:#EEE;" >
                                        {{$v['fee_category']}}
                                    </td>
                                    <td style=" text-align:right;padding:5px; width:30%; text-align: right; border-bottom: 1px solid #f4f4f4; padding: 2px; font-size: 13px; background-color:#EEE;">
                                          {{$v['fee_amount']}}
                                    </td>

                                </tr>

                            @endforeach



                        <tr>
                        </tr>
                        <tr>
                        </tr>
                        <tr>
                        </tr>

                        <tr>
                        </tr>
                        <tr>
                        </tr>


                        <tr>
                            <td colspan="1"
                                style="background-color:#EEE; border-top:1px solid  border-top:1px solid black; padding:5px; font-size:12px;">
                                Total Fee Amount
                            </td>
                        <td style="text-align:right;border:1px solid black; padding-left:5px; background-color:#EEE; font-size:12px;">{{$total}}</td>
                        </tr>
                        @if(!$v['prev_balance'] == 0 AND $v['prev_type'] == 1 )
                            <tr>
                                <td colspan="1"
                                    style="text-align:right; background-color:#EEE; border-top:1px solid black; padding-left:5px; font-size:12px;">
                                Balance
                                </td>
                                <td style="text-align:right;padding:5px; background-color:#EEE; font-size:12px;">
                                {{$v['prev_balance']}} </td>
                            </tr>
                            @else
                            <tr>
                                <td colspan="1"
                                    style="text-align:right; background-color:#EEE; border-top:1px solid black; padding-left:5px; font-size:12px;">
                                Advance
                                </td>
                                <td style="text-align:right;padding:5px; background-color:#EEE; font-size:12px;">
                                {{$v['prev_balance']}} </td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="1"
                                style="background-color:#EEE; border-top:1px solid  border-top:1px solid black; padding:5px; font-size:12px;">
                                Payable Amount
                            </td>
                            @php $total = ($total <0 ) ? 0.00 : $total @endphp
                        <td style="text-align:right;border:1px solid black; padding-left:5px; background-color:#EEE; font-size:12px;">{{$total}}</td>
                        </tr>
                        </tbody>

                        <tfoot>


                    </table>


                </div>
            </div>
            <div class="container1" style="margin-top: 8px;border-top:0px;">
                        <header style="font-size: 11px; margin: -8px 0px 0px 0px;">
                            <b><u>PAYMENT TERMS</u></b>
                        </header>
                        <div class="" width="35%" style="margin-top: -7px; height: 165px">
                             @if ($terms)
                            <div style="margin-top:-15px;padding: 5px 0 0 4px;font-size:10px;">
                              <p>  {!!$terms->FEE_TERMS_CONDETIONS!!}</p>
                            </div>
                            @endif
                            {{-- <p style="font-size: 11px; margin-top: 2px">&nbsp Respected Parents</p>
                            <div style="margin-top:-15px;padding: 5px 0 0 4px;">
                                <a style="font-size:10px;">1-</a> <a style="font-size:10px;">Please Deposit Your Child Dues
                                    Upto
                                    10 of every Month. After Due Date Rs.10 /- per day will be Charged.</a><br> <a
                                        style="font-size:10px;">2-</a> <a style="font-size:10px;">Iff you did not Receive
                                    Fee
                                    Voucher Kindly contact School Administration </a><br> <a style="font-size:10px;">3-</a>
                                <a
                                        style="font-size:10px;">Any error in Fee Voucher Please Contact Account
                                    Office.</a><br>
                                <a style="font-size:10px;">4-</a> <a style="font-size:10px;">Please Keep This Receipt
                                    Securely
                                    with you for future Correspondence .You must take the Fee Receipt after Depositing the
                                    School Fee & No Claim will be entertained without deposit Slip</a><br> <a
                                        style="font-size:10px;">5-</a> <a style="font-size:10px;">Without slip, Don't Submit
                                    Your Child Fee</a><br></div> --}}
                        </div>


                        <footer style="font-size: 12px; margin-top: 84px"><h4>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Stamp &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                 Authorized Signature</h4></footer>
                        <div style="margin-left: 94px; margin-top:0px">

                        </div>
                    </div>
            </body>
        </div>
        <hr class="vertical">
    </section>
@endforeach











</body>
</html>
</body>
</html>
