
<section>
    <div class="row">
        <div class="container">
            @if(isset($data->additionalinfo->company_name[app()->getLocale().'_name']))
            <div class="row company_topper_info">

                <div class="image">
                    <img class="lazyload blur-up" draggable="false" data-src="{{ App\Helpers\Helper::getImageUrl($data->additionalinfo->company_image, 'users') ?? asset('assets/images/no-user.png') }}"
                        alt="{{ $data->additionalinfo->company_name[app()->getLocale() . '_name'] }}">

                </div>
                <div class="info">
                    <h1 class="name">{{ $data->additionalinfo->company_name[app()->getLocale() . '_name'] ?? $data->name_surname }}</h1>
                    <p class="descriptive">{!! $data->additionalinfo->company_description[app()->getLocale() . '_description'] ?? null !!}</p>
                </div>
                <div class="column-15 contact">
                    {{--@if (isset($data->user->phone) && !empty($data->user->phone))
                        <div class="contact-element" onclick="window.open(`tel:{{ $data->user->phone }}`)">
                            <i class="las la-phone"></i>
                            {{ $data->user->phone }}
                        </div>
                    @endif--}}
                    {{--@if (isset($data->user->phone_2) && !empty($data->user->phone_2))
                        <div class="contact-element" onclick="window.open(`tel:{{ $data->user->phone_2 }}`)">
                            <i class="las la-phone"></i>
                            {{ $data->user->phone_2 }}
                        </div>
                    @endif--}}
                    {{--@if (isset($data->user->email) && !empty($data->user->email))
                        <div class="contact-element" onclick="window.open(`mailto:{{ $data->user->email }}`)">
                            <i class="las la-envelope"></i>
                            {{ $data->user->email }}
                        </div>
                    @endif--}}
                </div>
            </div>
            @endif

        </div>
    </div>
</section>
