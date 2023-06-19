<section>
    <div class="row">
        <div class="container">
            <form class="w-75" onsubmit="formsend()" id="formsend" style="margin-bottom:15px">
                <div id="messages"></div>
                @csrf
                <input type="hidden" name="language" value="{{ app()->getLocale() }}" />
                <div class="form-group">
                    <input type="text" onkeyup="searchinfields('query','datas','{{ $type }}')" name="query"
                        placeholder="@lang('additional.forms.searchkeyword')" class="form-control searchkeywords" style="border-radius: 25px;">
                    <span class="eye-icon" id="query-eye-icon" onclick="searchinfields()"><i
                            class="las la-search"></i></span>
                </div>
                {{-- @if (isset($filters) && !empty($filters))
                    @foreach ($filters as $filter)
                        @if (isset($filter) && !empty($filter) && isset($filter['type']) && !empty($filter['type']))
                            @if ($filter['type'] == 'rating')
                               
                            @elseif($filter['type'] == 'price_filter')

                            @elseif($filter['type'] == 'companies')

                            @elseif($filter['type'] == 'select')
                                <select name="{{ $filter['name'] }}" class="form-control">
                                    @foreach ($filter['data'] as $dat)
                                        <option value="{{ $dat['value'] }}">{{ $dat['name'] }}</option>
                                    @endforeach
                                </select>
                            @endif
                        @endif
                    @endforeach
                @endif --}}
                
            </form>
        </div>
    </div>
</section>
