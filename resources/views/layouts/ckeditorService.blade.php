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