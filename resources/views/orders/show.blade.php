@extends('layouts.app')
@section('title')
    @lang('additional.urls.orderinfo')
@endsection
@section('content')
    @include('auth.left_profile_tab')
    <section>
        <div class="container">
            <div class="row profile_heaader">
                <h1 class="w-100 text-center">@lang('additional.urls.orderinfo')</h1>
            </div>
            <div class="order_statuses">
                @for ($i = 0; $i < 4; $i++)
                    <div
                        class="order_status @if ($data->status > $i) active @elseif($data->status == $i) process @endif ">
                        <h5>@lang('additional.pages.payments.status_' . $i)</h5>
                        <div class="order_status_infographic_area @if ($data->status == $i || $data->status >= $i) active @endif ">
                        </div>
                    </div>
                @endfor
            </div>
            <div class="order-details_area">
                <div class="title_area">
                    <h3>@lang('additional.pages.payments.order_title_area')</h3>
                </div>
                <div class="row" style="justify-content: space-between">
                    <div class="column column-45">
                        <div class="description_area">
                            <div class="description_element"><span>@lang('additional.forms.servicename'):</span>
                                {{ $data->payment->data['name'][app()->getLocale() . '_name'] ?? null }}</div>
                            <div class="description_element"><span>@lang('additional.pages.payments.table.orderdate'):</span>
                                {{ $data->created_at != null ? App\Helpers\Helper::getDateTimeViaTimeStamp($data->created_at, false) : null }}
                            </div>
                            <div class="description_element"><span>@lang('additional.forms.price'):</span> {{ $data->price }}€</div>
                            @if(isset($data->payment_id) && !empty($data->payment))
                                <div class="description_element"><span>@lang('additional.pages.payments.paymentstatus'):</span>
                                @if($data->payment->payment_status==0)
                                <span style='color:red !important'>@lang('additional.pages.payments.notpayed')</span>
                                @else
                                <span style='color:green !important'>@lang('additional.pages.payments.payed')</span>
                                @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="column column-45">
                        @if (auth()->check() && auth()->user()->type == 1)
                            @if (isset($data->from_id) && !empty($data->from_id))
                                <div class="info_receiver">
                                    <h4>{{ $data->from->name_surname }}</h4>
                                    <p><a href="tel:{{ $data->from->phone }}" target="_blank">{{ $data->from->phone }}</a>
                                    </p>
                                    <p><a href="mailto:{{ $data->from->email }}" target="_blank">{{ $data->from->email }}</a>
                                    </p>
                                </div>
                            @endif
                        @else
                        @if(isset($data->to_id) && !empty($data->to_id))
                            <div class="info_receiver">
                                <h4>{{ $data->touser->name_surname }}</h4>
                                <p><a href="tel:{{ $data->touser->phone }}" target="_blank">{{ $data->touser->phone }}</a>
                                </p>
                                <p><a href="mailto:{{ $data->touser->email }}" target="_blank">{{ $data->touser->email }}</a>
                                </p>

                            </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            @if (auth()->check() && auth()->id() == $data->from_id)
                <div class="order_status_data">
                    <form onchange="changestat_order('#changestat_order')" id="changestat_order"
                        class="w-100 order_status_data">
                        @csrf
                        <input type="hidden" name="authent" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="order" value="{{ $data->uid }}">
                        <input type="hidden" name="language" value="{{ app()->getLocale() }}">
                        <div id="messages"></div>
                        <select name="change_status" onchange="changestat_order('#changestat_order')"
                            @if ($data->status == 3) disabled @endif>
                            @for ($i = 0; $i < 4; $i++)
                                <option value="{{ $i }}" @if ($data->status == $i) selected @endif>
                                    @lang('additional.pages.payments.status_' . $i)</option>
                            @endfor
                        </select>
                    </form>
                </div>
            @endif
        </div>
    </section>
    <br />
@endsection

@push('js')
    <script>
        function changestat_order(id) {
            showLoader();

            var formData = new FormData(document.querySelector(id));

            const data = {};
            for (const [key, value] of formData.entries()) {
                data[key] = value;
            }
            sendAjaxRequest('{{ route('changestat.order') }}', 'post', data, function(err, response) {

                if (err) {
                    hideLoader();
                    createalert('error', err);
                } else {
                    hideLoader();
                    let parsedResponse = JSON.parse(response);
                    createalert(parsedResponse.status, parsedResponse.message);
                    window.location.reload();
                }
            });
        }
    </script>
@endpush
