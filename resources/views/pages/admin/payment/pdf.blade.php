<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        * {
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .mt-3 {
            margin-top: 15px;
        }

        .font-weight-normal {
            margin-left: 20px;
        }

        table thead {
            background-color: #ececec;
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        #logo {
            float: left;
        }

        #logo img {
            height: 40px;
        }

        #text-header p {
            color: #304a68;
            margin-bottom: 3px;
            margin-right: 50px;
            margin-top: 3px;
            text-align: center;
            font-size: 42px;
            line-height: 90%;
        }

        .row {
            margin-top: 20px;
        }

        .column {
            float: left;
            width: 50%;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="">
            {{-- buat yg img make img-kit --}}
            <div class="clearfix">
                <div id="logo">
                    {{-- <img src="{{ asset('themes/img/zumart_logo.png') }}" style="width:180px"> --}}
                </div>
                <div id="text-header">
                    <p>INVOICE</p>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="column">
                    <p><span class="font-weight-normal" style="margin-right: 50px !important;">Nama</span> :
                        {{ $payment->member->name }}</p><br>
                    <p style="margin-top: -30px;"><span class="font-weight-normal"
                            style="margin-right: 45px !important;">Alamat</span> : {{ $payment->member->address }}</p>
                    <br>
                    <p style="margin-top: -30px"><span class="font-weight-normal"
                            style="margin-right: 10px !important;">No. Telphone</span> : {{ $payment->member->phone }}
                    </p>
                    <br>
                    <p style="margin-top: -30px"><span class="font-weight-normal"
                            style="margin-right: 53px !important;">Email</span> : {{ $payment->member->email }}</p><br>
                </div>
                <div class="column">
                    <p><span class="font-weight-normal" style="margin-right: 50px !important;">Tanggal</span> :
                        {{ date('m/d/Y H.i') }}</p><br>
                    <p style="margin-top: -30px"><span class="font-weight-normal"
                            style="margin-right: 65px !important;">Code</span> : {{ $payment->member->code }}</p><br>
                </div>
            </div>

            <div class="">
                <div class="cart">
                    <div class="mt-3">
                        <table border="1" cellspacing="0" cellpadding="8" class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>Tahun</td>
                                    <td>Bulan</td>
                                    <td>Total</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $payment->year }}</td>
                                    <td>{{ $months[$payment['month']] }}</td>
                                    <td>{{ $payment->amount }}</td>
                                    {{-- <td>{{ $payment->status }}</t> --}}
                                    @if ($payment->status == 2)
                                        <td style="color:green"><b>{{ $status[$payment['status']] }}</b></td>
                                    @elseif($payment->status < 2)
                                        <td>{{ $status[$payment['status']] }}</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
</body>

</html>
