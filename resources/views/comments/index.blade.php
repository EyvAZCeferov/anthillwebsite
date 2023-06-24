@extends('layouts.app')
@section('menu_comments', 'open')
@section('title', trans("additional.urls.comments"))

@section('css')
    <meta name="_token" content="{{ csrf_token() }}">
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.24/r-2.2.7/rr-1.2.7/datatables.min.css" />

    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->
    <!-- Switch -->
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #4bb543;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #4bb543;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
    <!-- Switch -->
@endsection

@section('javascript')
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.24/r-2.2.7/rr-1.2.7/datatables.min.js"></script>

    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>


    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#example').DataTable({
                    responsive: true,
                    "ordering": true,
                    "info": true,
                    "scrollCollapse": true,
                });
            }, 500);
        });
    </script>
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->
    {{-- Change Stat --}}
    <script>
        function changeStat(id, status) {
            var token = $("meta[name='_token']").attr('content');

            var url = '{{ env('APP_URL ') }}/comments_change_stat/' + id;
            $.ajax({
                url: `${url}`,
                dataType: 'json',
                data: {
                    status: status,
                    _token: token
                },
                type: 'patch',
                success: function(data) {
                    toastr.success(trans("additional.messages.updated"));
                },
                error: function(data) {
                    toastr.error(trans("additional.messages.tryagain"));
                }
            })
        }
    </script>
    {{-- Change Stat --}}
@endsection

@section('content')
    <!-- START CONTENT -->
    <section id="main-content" class=" ">
        <section class="wrapper main-wrapper" style=''>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class="page-title">

                    <div class="pull-left">
                        <h1 class="title">@lang('additional.urls.comments')
                            &nbsp;&nbsp;
                            <span>
                                @include('layouts.topbarbuttons', [
                                    'routename' => 'comments',
                                    'harddelete' => false,
                                    'add' => false,
                                    'home' => false,
                                    'restoreall' => false,
                                ])</span>
                        </h1>

                    </div>

                    <div class="pull-right hidden-xs">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>@lang("additional.urls.dashboard")</a>
                            </li>
                            <li>
                                <a href="{{ route('comments.index') }}">@lang('additional.urls.comments')</a>
                            </li>

                        </ol>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-lg-12">
                <section class="box ">
                    <header class="panel_header">
                        <h2 class="title pull-left">@lang("additional.page_types.all") @lang('additional.urls.comments')</h2>
                        <div class="actions panel_actions pull-right">
                            <i class="box_toggle fa fa-chevron-down"></i>
                            <i class="box_close fa fa-times"></i>
                        </div>
                    </header>
                    <div class="content-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <!-- ********************************************** -->
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>@lang("additional.urls.service")</th>
                                            <th>@lang("additional.urls.comment")</th>
                                            <th>@lang("additional.forms.status")</th>
                                            <th>@lang("additional.buttons.buttons")</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($data as $dat)
                                            <tr>

                                                <td>{{ $dat->product->name['en_name'] }}</td>
                                                <td>{{ $dat->comment }}</td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" name="coupon_status"
                                                            @if ($dat->status == 1) checked @endif
                                                            id="coupon_status"
                                                            onChange="changeStat({{ $dat->id }},{{ $dat->status }})">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    @include('layouts.buttons', [
                                                        'data' => $dat,
                                                        'routename' => 'comments',
                                                        'view' => true,
                                                        'edit' => false,
                                                        'destroy' => true,
                                                        'harddelete' => false,
                                                        'recover' => false,
                                                    ])
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                                <!-- ********************************************** -->

                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </section>
    </section>
    <!-- END CONTENT -->

    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Koment məlumatlarını yenilə</h5>
                    <button type="button" class="close ml-5" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="attributeUpdate">
                        @csrf
                        <input type="hidden" name="comment_id" id="comment_id" value="">
                        <input type="text" value="" placeholder="Adı daxil edin..." class="form-control"
                            name="comment_username" id="comment_username">
                        <input type="text" value="" placeholder="Adı daxil edin..." class="form-control"
                            name="comment_productname" id="comment_productname">
                        <br>
                        <input type="text" name="comment_rating" class="form-control" id="comment_rating">
                        <br>
                        <textarea name="comment_message" id="comment_message" cols="30" rows="10" class="form-control"></textarea>
                        <br>
                        <span>Status</span>
                        <label class="switch">
                            <input type="checkbox" name="comment_status" id="comment_status">
                            <span class="slider round"></span>
                        </label>
                        <br>

                    </form>
                </div>

            </div>
        </div>
    </div>
    {{-- Edit Modal --}}

@endsection
