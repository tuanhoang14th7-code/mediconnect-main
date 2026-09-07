@extends('admin/AdminLayout')

@section('admin-content')
    <style>
        .dashbord-tables {
            animation: transitionIn-Y-over 0.5s;
        }

        .filter-container {
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }


        .dashboard-items {
            border: 2px solid #c9cbce9f;
            border-radius: 7px;
            color: #0A76D8;
            background-color: #d8ebfa25;
            box-shadow: 0 3px 5px 0 rgba(95, 95, 97, 0.3);
        }

        .h1-dashboard {
            margin: 0;
            padding: 0;
            font-size: 25px;
            font-weight: 600;
            line-height: 0;
            padding-top: 20px;
        }

        .h3-dashboard {
            margin: 0;
            padding: 0;
            font-size: 20px;
            font-weight: 500;
            color: #212529e3;
        }

        .dashboard-icons {
            background-color: rgba(184, 184, 184, 0.247);
            /* padding: inherit; */
            padding-top: 30px;
            padding-bottom: 30px;
            border-radius: 7px;
            margin-left: 40px;
            margin-right: 0px;
            width: 80%;
        }

        .dashboard-icons-setting {

            padding-top: 30px;
            padding-bottom: 30px;
            border-radius: 7px;
            margin-left: 5px;
            margin-right: 20px;

        }
    </style>
    <div class="container filter-container">
        <div class="row my-4">
            <div class="col">
                <p style="font-size: 20px;font-weight:600;padding-left: 12px;">Status</p>
            </div>
        </div>
        <div class="row" style="width:70%;">
            <div class="col">
                <div class="dashboard-items" style="padding:20px;margin:auto;display: flex;">
                    <div class="row ps-3">
                        <div class="h1-dashboard">{{ $total_doctor }}</div>
                        <br>
                        <div class="h3-dashboard"> Doctors </div>
                    </div>
                    <div class="row">
                        <img style="background-color: rgba(184, 184, 184, 0.247);"
                            src="{{ asset('assets/img/icons/doctors-hover.svg') }}" class="btn-icon-back dashboard-icons"
                            alt="" srcset="">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="dashboard-items" style="padding:20px;margin:auto;display: flex;">
                    <div class="row ps-3">
                        <div class="h1-dashboard">{{ $total_patient }}</div>
                        <br>
                        <div class="h3-dashboard"> Patients </div>
                    </div>
                    <div class="row">
                        <img style="background-color: rgba(184, 184, 184, 0.247);"
                            src="{{ asset('assets/img/icons/patients-hover.svg') }}" class="btn-icon-back dashboard-icons"
                            alt="" srcset="">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="dashboard-items" style="padding:20px;margin:auto;display: flex; ">
                    <div class="row ps-3">
                        <div class="h1-dashboard">{{ $total_apt }}</div>
                        <br>
                        <div class="h3-dashboard"> Appointments </div>
                    </div>
                    <div class="row">
                        <img style="background-color: rgba(184, 184, 184, 0.247);"
                            src="{{ asset('assets/img/icons/book-hover.svg') }}" class="btn-icon-back dashboard-icons"
                            alt="" srcset="">
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
