<div class="row">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Atribut yarat
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Atribut yarat</h5>
                    <button type="button" class="close ml-5" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="attributeStore">
                        @csrf
                        <input type="text" value="" placeholder="Adı daxil edin..." class="form-control"
                            name="attribute_az_name" id="attribute_az_name">
                        <br>
                        <input type="text" value="" placeholder="Введите имя ..." class="form-control"
                            name="attribute_ru_name" id="attribute_ru_name">
                        <br>
                        <input type="text" value="" placeholder="Enter the name ..." class="form-control"
                            name="attribute_en_name" id="attribute_en_name">
                        <br>
                        
                        <span style="font-size: 14px; margin-bottom:5px;display:block;">Sıra nömrəsi</span>
                        <input type="number" value="" placeholder="Sıra nömrəsi yazın ..." class="form-control"
                            name="attribute_order" id="attribute_order">
                        <br/>
                        <span style="font-size: 14px; margin-bottom:5px;display:block;">Tip</span>
                        <select class="form-control"
                            name="attribute_group" id="attribute_group">
                            <option value="0">Atribut</option>
                            <option value="1" selected>Atribut Qrupu</option>
                        </select>
                        <br>
                        <div id="getGrrId" class="d-none">
                            <span style="font-size: 14px; margin-bottom:5px;display:block;">Atributun aid olduğu qrup</span>

                            <select name="group_id" class="form-control" id="group_id">
                                <option value="">Qrup seç</option>
                                @foreach ($data->whereNull("group_id") as $group)
                                    <option value="{{$group->id}}">{{$group->name['az_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <span style="font-size: 14px; margin-bottom:5px;display:block;">Məlumat tipi</span>
                        <select class="form-control"
                            name="datatype" id="datatype">
                            <option value="string">Yazı</option>
                            <option value="integer">Ədəd (rəqəm)</option>
                            <option value="price">Məbləğ (€)</option>
                            <option value="boolean">Seçim</option>
                        </select>
                        <br>
                        <div class="align-right justify-content-end text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
                            <button type="button" onclick="attributeStore()" class="btn btn-primary">Yadda saxla</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
