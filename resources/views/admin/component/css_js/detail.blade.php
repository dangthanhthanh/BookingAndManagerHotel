<script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/decoupled-document/ckeditor.js"></script>
<script>
  DecoupledEditor
      .create( document.querySelector( '#editor' ),{
        image: {
          toolbar: [
                      'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
                      '|', 'toggleImageCaption', 'imageTextAlternative',
                      '|', 'resizeImage', 'removeImage'
                  ],
                  styles: ['full', 'side', 'alignLeft', 'alignCenter', 'alignRight'],
                  resizeOptions: [
                      {
                          name: 'resizeImage:original',
                          label: 'Original',
                          value: null
                      },
                ]
            },
        ckfinder: {
                uploadUrl: "{{ route('upload.file').'?_token='.csrf_token()}}",
            },
        mediaEmbed: {
                previewsInData:true,
            },
      })
      .then( editor => {
          const toolbarContainer = document.querySelector( '#toolbar-container' );
          toolbarContainer.appendChild( editor.ui.view.toolbar.element );
          editor.model.document.on('change:data', () => {
            let content = editor.getData();
            console.log('Editor content:', content);
          const form = document.querySelector('#form-action');
          form.addEventListener('submit', () => {
            const descriptionInput = document.querySelector('#description-input');
            descriptionInput.value = content;
        });
        });
      } )
      .catch( error => {
          console.error( error );
      } );

  $(document).ready(function() {
    $('#image').change(function() {
      var file = this.files[0];
      var reader = new FileReader();
      console.log(file);
      reader.onload = function(e) {
        $('#image-show').attr('src', e.target.result);
      };
      reader.readAsDataURL(file);
    });
  });
</script>