<script src="{{ asset('/assets/js/ckeditor.js') }}"></script>
<script>
    var config = {
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'blockQuote',
                    'undo',
                    'redo',
                    'insertTable',
                    'sourceEditing'
                ]
            },
            language: 'en'
        }
        document.querySelectorAll('.ckeditor').forEach(editorClass => {
            ClassicEditor
            .create(  editorClass,config)
            .catch( error => {
            console.error( error );
            } );
        });
        
</script>

<style>
    .ck-editor__editable_inline,.ck-source-editing-area {
        min-height: 200px;
        max-height: 400px;
        overflow-y: auto;
    }
</style>

<script src="{{ asset('admin/assets/plugins/tinymce/tinymce.min.js') }}"></script>
