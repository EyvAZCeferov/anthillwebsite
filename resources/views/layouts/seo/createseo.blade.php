
@if ($langKey == 'az')
    <div class="row">
        <button type="button"
            onclick="crSeo('az_name','az_description','az_meta_title','az_meta_description','az_meta_keywords')"
            class="btn btn-success btn-full text-center" style="width: 100%"><i class="fa fa-google"></i> Seo
            Taglar yarat</button>
        <br>
        <br>


        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-label">Meta Başlıq</label>
                    <div class="controls">
                        <input type="text" id="az_meta_title" class="form-control" name="az_meta_title"
                            value="{{ isset($data) &&isset($data->name)  &&isset($data->name['az_meta_title'])? $data->name['az_meta_title']: null }}">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-label">Meta Açıqlama</label>
                    <div class="controls">
                        <textarea rows="3" cols="4" id="az_meta_description" class="form-control"
                            name="az_meta_description">{{ isset($data) &&isset($data->description)  &&isset($data->description['az_meta_description'])? $data->description['az_meta_description']: null }}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-label">Meta Açar Söz</label>
                    <div class="controls">
                        <input type="text" class="form-control " name="az_meta_keywords" id="az_meta_keywords" value="{{ isset($data) &&isset($data->keywords)  &&isset($data->keywords['az_meta_keywords'])? $data->keywords['az_meta_keywords']: null }}">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif ($langKey == 'ru')
    <div class="row">
        <button type="button"
            onclick="crSeo('ru_name','ru_description','ru_meta_title','ru_meta_description','ru_meta_keywords')"
            class="btn btn-success btn-full text-center" style="width: 100%"><i class="fa fa-google"></i> Создать теги
            SEO</button>
        <br>
        <br>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-label">Meta Заголовок</label>
                    <div class="controls">
                        <input type="text" id="ru_meta_title" class="form-control" name="ru_meta_title"
                            value="{{ isset($data) &&isset($data->name)  &&isset($data->name['ru_meta_title'])? $data->name['ru_meta_title']: null }}">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-label">Meta Описание</label>
                    <div class="controls">
                        <textarea rows="3" cols="4" id="ru_meta_description" class="form-control"
                            name="ru_meta_description">
                            {{ isset($data) &&isset($data->description)  &&isset($data->description['ru_meta_description'])? $data->description['ru_meta_description']: null }}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-label">Meta Ключевые слова</label>
                    <div class="controls">
                        <input type="text" class="form-control " name="ru_meta_keywords" id="ru_meta_keywords" value="{{ isset($data) &&isset($data->keywords)  &&isset($data->keywords['ru_meta_keywords'])? $data->keywords['ru_meta_keywords']: null }}" />
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif ($langKey == 'en')
    <div class="row">
        <button type="button"
            onclick="crSeo('en_name','en_description','en_meta_title','en_meta_description','en_meta_keywords')"
            class="btn btn-success btn-full text-center" style="width: 100%"><i class="fa fa-google"></i> Create SEO
            Tags</button>
        <br>
        <br>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-label">Meta Title</label>
                    <div class="controls">
                        <input type="text" id="en_meta_title" class="form-control" name="en_meta_title"
                            value="{{ isset($data) &&isset($data->name)  &&isset($data->name['en_meta_title'])? $data->name['en_meta_title']: null }}">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-label">Meta Description</label>
                    <div class="controls">
                        <textarea rows="3" cols="4" id="en_meta_description" class="form-control"
                            name="en_meta_description">{{ isset($data) &&isset($data->description)  &&isset($data->description['en_meta_description'])? $data->description['en_meta_description']: null }}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-label">Meta Keywords</label>
                    <div class="controls">
                        <input type="text" class="form-control " name="en_meta_keywords"
                            id="en_meta_keywords" value="{{ isset($data) &&isset($data->keywords)  &&isset($data->keywords['en_meta_keywords'])? $data->keywords['en_meta_keywords']: null }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif ($langKey == 'tr')
    <div class="row">
        <button type="button"
            onclick="crSeo('tr_name','tr_description','tr_meta_title','tr_meta_description','tr_meta_keywords')"
            class="btn btn-success btn-full text-center" style="width: 100%"><i class="fa fa-google"></i> 
        SEO teqleri oluştur    
        </button>
        <br>
        <br>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-label">Meta Başlık</label>
                    <div class="controls">
                        <input type="text" id="tr_meta_title" class="form-control" name="tr_meta_title"
                            value="{{ isset($data) &&isset($data->name)  &&isset($data->name['tr_meta_title'])? $data->name['tr_meta_title']: null }}">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-label">Meta Açıklama</label>
                    <div class="controls">
                        <textarea rows="3" cols="4" id="tr_meta_description" class="form-control"
                            name="tr_meta_description">{{ isset($data) &&isset($data->description)  &&isset($data->description['tr_meta_description'])? $data->description['tr_meta_description']: null }}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="form-label">Meta Anahtar kelimler</label>
                    <div class="controls">
                        <input type="text" class="form-control " name="tr_meta_keywords"
                            id="tr_meta_keywords" value="{{ isset($data) &&isset($data->keywords)  &&isset($data->keywords['tr_meta_keywords'])? $data->keywords['tr_meta_keywords']: null }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
