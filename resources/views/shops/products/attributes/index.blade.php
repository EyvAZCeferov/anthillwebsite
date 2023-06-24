@extends('layouts.app')
@section('menu_products_elements', 'open')
@section('title')
@lang("additional.urls.attributes")
@endsection

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.24/r-2.2.7/rr-1.2.7/datatables.min.js"></script>

    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>


    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#example').DataTable({
                    responsive: true,
                    "ordering": false,
                    "info": true,
                    "scrollCollapse": true,
                });
            }, 500);
        });
    </script>
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->
    <script>
        // Attach a submit handler to the form
        function attributeStore() {

            // Stop form from submitting normally
            event.preventDefault();

            // Get some values from elements on the page:
            var
                en_name = $("form#attributeStore input#attribute_en_name").val();
                group_id = $("form#attributeStore select#group_id").val(),
                datatype = $("form#attributeStore select#datatype").val();
                order = $("form#attributeStore input#attribute_order").val();

            var name = {};

            name['en_name'] = en_name;
            token = $("input[name='_token']").val();

            var posting = $.ajax({
                url: '{{ route('attributes.store') }}',
                dataType: 'json',
                data: {
                    name: name,
                    group_id: group_id,
                    datatype: datatype,
                    _token: token,
                    order:order
                },
                type: 'post',
                success: function(data) {
                    if (data == 1) {
                        toastr.success(trans('additional.messages.created'));
                        $('#exampleModal').modal('toggle');
                        window.location.href = "{{ url()->current() }}";
                    } else {
                        toastr.error(trans("additional.messages.tryagain"));
                    }
                },
                error: function(data) {
                    if (data == 0) {
                        toastr.error(trans("additional.messages.tryagain"));
                    } else {
                        toastr.success(trans('additional.messages.created'));
                        $('#exampleModal').modal('toggle');
                        window.location.href = "{{ url()->current() }}";
                    }
                }
            });


        }
    </script>

    {{-- Edit function --}}
    <script>
        function getEdit(id) {

            var url = '{{ env('APP_URL ') }}/attributes/' + id;
            $.ajax({
                url: `${url}`,
                dataType: 'json',
                type: 'get',
                success: function(data) {
                    $("form#attributeUpdate input#attribute_id").val(data['id']);
                    $("form#attributeUpdate input#attribute_en_name").val(data['name']['en_name']);
                    $("form#attributeUpdate select#attribute_group").val(data['type']);
                    $("form#attributeUpdate input#attribute_order").val(data['order_att']);
                    if (data['group_id'] != null || data['group_id'] !== null) {
                        $('form#attributeUpdate div#getGrrId').css('display', 'block');
                        $("form#attributeUpdate select#group_id").val(data['group_id'] ?? null);
                    } else {
                        $('form#attributeUpdate div#getGrrId').css('display', 'none');
                    }

                    $("form#attributeUpdate select#datatype").val(data['datatype']);

                    $('#editModal').modal('toggle');

                },
                error: function(data) {
                    toastr.error(trans("additional.messages.tryagain"));
                }
            })
        }
    </script>
    {{-- Edit function --}}

    <script>
        // Attach a submit handler to the form
        function attributeUpdate() {

            // Stop form from submitting normally
            event.preventDefault();

            // Get some values from elements on the page:
            var
                en_name = $("form#attributeUpdate input#attribute_en_name").val(),
                group_id = $("form#attributeUpdate select#group_id").val(),
                datatype = $("form#attributeUpdate select#datatype").val(),
                order = $("form#attributeUpdate input#attribute_order").val();
            var name = {};
            name['az_name'] = az_name;
            name['ru_name'] = ru_name;
            name['en_name'] = en_name;
            name['tr_name'] = tr_name;
            token = $("input[name='_token']").val();
            var id = $("form#attributeUpdate input#attribute_id").val();

            var posting = $.ajax({
                url: '{{ env('APP_URL ') }}/attributes/' + id,
                dataType: 'json',
                data: {
                    name: name,
                    group_id: group_id,
                    datatype: datatype,
                    order: order,
                    _token: token
                },
                type: 'patch',
                success: function(data) {
                    if (data == 1) {
                        toastr.success("@lang('additional.messages.updated')");
                        $('#editModal').modal('toggle');
                        $("form#attributeUpdate input#attribute_id").val();
                        $("form#attributeUpdate input#attribute_en_name").val();
                        $("form#attributeUpdate input#attribute_order").val();
                        window.location.href = "{{ url()->current() }}";
                    } else {
                        toastr.error(trans("additional.messages.tryagain"));
                    }
                },
                error: function(data) {
                    if (data == 0) {
                        toastr.error(trans("additional.messages.tryagain"));
                    } else {
                        toastr.success("@lang('additional.messages.updated')");
                        $('#editModal').modal('toggle');
                        window.location.href = "{{ url()->current() }}";
                    }
                }
            });


        }
    </script>

    <!-- Atribute Group Activate -->
    <script>
        $("div#getGrrId").css('display', 'none');
        $('select#attribute_group').on('change', function() {
            if (this.value == 0) {
                $('div#getGrrId').css('display', 'block');
            } else {
                $('div#getGrrId').css('display', 'none');
            }
        })
    </script>

@endsection

@section('content')
    <!-- START CONTENT -->
    <section id="main-content" class=" ">
        <section class="wrapper main-wrapper" style=''>

            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                <div class="page-title">

                    <div class="pull-left">
                        <h1 class="title">Atributlar
                            &nbsp;&nbsp;
                            <span>
                                @include('layouts.topbarbuttons', [
                                    'routename' => 'attributes',
                                    'harddelete' => false,
                                    'add' => false,
                                    'home' => false,
                                    'restoreall' => false,
                                ])</span>
                            @include('shops.products.attributes.create')
                        </h1>

                    </div>
                    <div class="d-none" id="edAr">

                    </div>
                    <div class="pull-right hidden-xs">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i>@lang("additional.urls.dashboard")</a>
                            </li>
                            <li>
                                <a href="{{ route('attributes.index') }}">@lang("additional.urls.attributes")</a>
                            </li>

                        </ol>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-lg-12">
                <section class="box ">
                    <header class="panel_header">
                        <h2 class="title pull-left">@lang("additional.page_types.all") @lang("additional.urls.attributes")</h2>
                        <div class="actions panel_actions pull-right">
                            <i class="box_toggle fa fa-chevron-down"></i>
                            <i class="box_close fa fa-times"></i>
                        </div>
                    </header>
                    <div class="content-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <!-- ********************************************** -->
                                <table id="example" class="table table-striped table-bordered sortable"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>@lang("additional.forms.name")</th>
                                            <th>@lang("additional.forms.assigned")</th>
                                            <th>Növü</th>
                                            <th>@lang("additional.buttons.buttons")</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($data as $dat)
                                            @if(!empty(trim($dat->name['en_name'])))
                                                <tr class="ui-state-default">
                                                    <td>{{ $dat->id }}</td>
                                                    <td>{{ $dat->name['en_name'] }}</td>
                                                    <td>
                                                        @if ($dat->group_id != null || $dat->group_id !== null)
                                                            {{ $dat->group->name['en_name'] }}
                                                        @else
                                                            <span class="text-small text-danger"> @lang("additional.forms.attribute_group")</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($dat->datatype == 'string')
                                                            @lang("additional.inputtypes.string")
                                                        @elseif($dat->datatype == 'integer')
                                                        @lang("additional.inputtypes.integer")
                                                        @elseif($dat->datatype == 'price')
                                                        @lang("additional.inputtypes.price")
                                                        @elseif($dat->datatype == 'boolean')
                                                        @lang("additional.inputtypes.dropdown")
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <button type="button" class="btn btn-warning d-inline-block"
                                                            onClick="getEdit({{ $dat->id }});"><i
                                                                class="fa fa-edit"></i></button>

                                                        @include('layouts.buttons', [
                                                            'data' => $dat,
                                                            'routename' => 'attributes',
                                                            'view' => false,
                                                            'edit' => false,
                                                            'destroy' => true,
                                                            'harddelete' => false,
                                                            'recover' => false,
                                                        ])
                                                    </td>
                                                </tr>
                                            @endif
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
                    <h5 class="modal-title" id="editModalLabel">@lang("additional.urls.attributes") @lang("additional.page_types.update")</h5>
                    <button type="button" class="close ml-5" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="attributeUpdate">
                        @csrf
                        <input type="hidden" name="attribute_id" id="attribute_id" value="">
                       
                        <input type="text" value="" placeholder="Enter the name ..." class="form-control"
                            name="attribute_en_name" id="attribute_en_name">
                        <br>
                        
                        <span style="font-size: 14px; margin-bottom:5px;display:block;">@lang("additional.forms.order")</span>
                        <input type="number" value="" placeholder="@lang("additional.forms.order") ..." class="form-control"
                            name="attribute_order" id="attribute_order">
                        <br/>
                        <span style="font-size: 14px; margin-bottom:5px;display:block;">@lang("additional.forms.type")</span>
                        <select class="form-control" name="attribute_group" id="attribute_group">
                            <option value="0">@lang("additional.inputtypes.attribute_0")t</option>
                            <option value="1">@lang("additional.inputtypes.attribute_1")</option>
                        </select>
                        <br>
                        <div id="getGrrId" class="d-none">
                            <span style="font-size: 14px; margin-bottom:5px;display:block;">@lang("additional.forms.assigned")</span>

                            <select name="group_id" class="form-control" id="group_id">
                                <option value=""></option>
                                @foreach ($data->whereNull("group_id") as $group)
                                    <option value="{{ $group->id }}">{{ $group->name['en_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <span style="font-size: 14px; margin-bottom:5px;display:block;">@lang("additional.forms.type")</span>
                        <select class="form-control" name="datatype" id="datatype">
                            <option value="string">@lang("additional.inputtypes.string")</option>
                            <option value="integer">@lang("additional.inputtypes.integer")</option>
                            <option value="price">@lang("additional.inputtypes.price")</option>
                            <option value="boolean">@lang("additional.inputtypes.dropdown")</option>
                        </select>
                        <br>

                        <div class="align-right justify-content-end text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang("additional.buttons.cancel")</button>
                            <button type="button" onclick="attributeUpdate()" class="btn btn-primary">@lang("additional.buttons.submit")</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    {{-- Edit Modal --}}
@endsection
