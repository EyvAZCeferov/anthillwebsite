{{-- <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
<script>
    class MyUploadAdapter {
        constructor(loader) {
            // The file loader instance to use during the upload. It sounds scary but do not
            // worry — the loader will be passed into the adapter later on in this guide.
            this.loader = loader;
        }
        // Starts the upload process.
        upload() {
            return this.loader.file
                .then(file => new Promise((resolve, reject) => {
                    this._initRequest();
                    this._initListeners(resolve, reject, file);
                    this._sendRequest(file);
                }));
        }
        // Aborts the upload process.
        abort() {
            if (this.xhr) {
                this.xhr.abort();
            }
        }
        // Initializes the XMLHttpRequest object using the URL passed to the constructor.
        _initRequest() {
            const xhr = this.xhr = new XMLHttpRequest();
            // Note that your request may look different. It is up to you and your editor
            // integration to choose the right communication channel. This example uses
            // a POST request with JSON as a data structure but your configuration
            // could be different.
            xhr.open('POST', '{{ $uploadUrl }}', true);
            xhr.setRequestHeader('x-csrf-token', '{{ csrf_token() }}');
            xhr.responseType = 'json';
        }
        // Initializes XMLHttpRequest listeners.
        _initListeners(resolve, reject, file) {
            const xhr = this.xhr;
            const loader = this.loader;
            const genericErrorText = `Couldn't upload file: ${ file.name }.`;
            xhr.addEventListener('error', () => reject(genericErrorText));
            xhr.addEventListener('abort', () => reject());
            xhr.addEventListener('load', () => {
                const response = xhr.response;
                // This example assumes the XHR server's "response" object will come with
                // an "error" which has its own "message" that can be passed to reject()
                // in the upload promise.
                //
                // Your integration may handle upload errors in a different way so make sure
                // it is done properly. The reject() function must be called when the upload fails.
                if (!response || response.error) {
                    return reject(response && response.error ? response.error.message : genericErrorText);
                }
                // If the upload is successful, resolve the upload promise with an object containing
                // at least the "default" URL, pointing to the image on the server.
                // This URL will be used to display the image in the content. Learn more in the
                // UploadAdapter#upload documentation.
                resolve({
                    default: response.url
                });
            });
            // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
            // properties which are used e.g. to display the upload progress bar in the editor
            // user interface.
            if (xhr.upload) {
                xhr.upload.addEventListener('progress', evt => {
                    if (evt.lengthComputable) {
                        loader.uploadTotal = evt.total;
                        loader.uploaded = evt.loaded;
                    }
                });
            }
        }
        // Prepares the data and sends the request.
        _sendRequest(file) {
            // Prepare the form data.
            const data = new FormData();
            data.append('upload', file);
            // Important note: This is the right place to implement security mechanisms
            // like authentication and CSRF protection. For instance, you can use
            // XMLHttpRequest.setRequestHeader() to set the request headers containing
            // the CSRF token generated earlier by your application.
            // Send the request.
            this.xhr.send(data);
        }
        // ...
    }

    function SimpleUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            // Configure the URL to the upload script in your back-end here!
            return new MyUploadAdapter(loader);
        };
    }

    let editors = [];

    @foreach ($editors as $editor)
        @if (str_contains($editor, 'faq_tab'))

        for(var i=0;i<40;i++){ newEditor("faq_tab_"+i.toString()); } @else ClassicEditor
    .create(document.querySelector('.{{ $editor }}'), {
        mediaEmbed: {
            previewsInData: true
        },
        // fontSize: {
        //     options: [
        //         9,
        //         11,
        //         13,
        //         'default',
        //         17,
        //         19,
        //         21,
        //         22,
        //         23,
        //         25,
        //         28,
        //         31,
        //         33,
        //         36,
        //         39,
        //         41,
        //         45,
        //         48,
        //         53,
        //         55,
        //         60,
        //         65,
        //         70,
        //         75
        //     ]
        // },
        // toolbar: [
        //     'heading', 'bold', 'italic', 'underline', 'strikethrough', 'fontFamily', 'fontSize', 'fontColor', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo','image','media','embed','table'
        // ],
        extraPlugins: [SimpleUploadAdapterPlugin],
    })
    .then(editor => {
        editors['{{ $editor }}'] = editor;
        // Simulate label behavior if textarea had a label
        if (editor.sourceElement.labels.length > 0) {
            editor.sourceElement.labels[0].addEventListener('click', e => editor.editing.view.focus());
        }
    })
    .catch(error => {
        console.error(error);
    });

        @endif
    @endforeach

    function newEditor(id) {
        var clas = document.getElementsByClassName(id);
        if (clas.length > 0) {
            ClassicEditor.create(document.querySelector('.' + id.toString()), {
                mediaEmbed: {
                        previewsInData:true
                    },
                    extraPlugins: [SimpleUploadAdapterPlugin],
                   
                }).then(editor => {
                    editors[id] = editor;
                    // Simulate label behavior if textarea had a label
                    if (editor.sourceElement.labels.length > 0) {
                        editor.sourceElement.labels[0].addEventListener('click', e => editor.editing.view
                            .focus());
                    }

                })
                .catch(error => {
                    console.log(error);
                });

        }
    }
</script> --}}
<script  src="https://cdn.tiny.cloud/1/0j6r4v4wrpghb7ht8z0yf85cuzcv8iadyrza5gp8f4lxi1ib/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script >
    @foreach ($editors as $editor)
        tinymce.init({
            selector: '.{{ $editor }}',
             media_live_embeds: true,
            file_picker_types: 'media',
            plugins: 'anchor autolink charmap textcolor codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize forecolor backcolor | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    @endforeach

  </script>