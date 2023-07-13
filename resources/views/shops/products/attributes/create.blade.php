<div class="row">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        @lang('additional.page_types.create')
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang("additional.urls.attributes") @lang("additional.page_types.create")</h5>
                    <button type="button" class="close ml-5" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="attributeStore">
                        @csrf
                        <input type="hidden" name="attribute_id" id="attribute_id" value="">
                       
                        <input type="text" value="" placeholder="Enter the name ..." class="form-control"
                            name="attribute_en_name" id="attribute_en_name">
                        <br>
                        
                        {{-- <span style="font-size: 14px; margin-bottom:5px;display:block;">@lang("additional.forms.order")</span>
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
                        <br> --}}
                        {{-- <span style="font-size: 14px; margin-bottom:5px;display:block;">@lang("additional.forms.type")</span>
                        <select class="form-control" name="datatype" id="datatype">
                            <option value="string">@lang("additional.inputtypes.string")</option>
                            <option value="integer">@lang("additional.inputtypes.integer")</option>
                            <option value="price">@lang("additional.inputtypes.price")</option>
                            <option value="boolean">@lang("additional.inputtypes.dropdown")</option>
                        </select>
                        <br> --}}

                        <div class="align-right justify-content-end text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang("additional.buttons.cancel")</button>
                            <button type="button" onclick="attributeStore()" class="btn btn-primary">@lang("additional.buttons.submit")</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
