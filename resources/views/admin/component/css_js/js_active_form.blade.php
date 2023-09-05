<script>
    $('.toggle-checkbox').change(function() {
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, default it!'
        }).then((result) => {
        if (result.isConfirmed) {
            let url = $(this).data("url");
            $.ajax({
                type:"POST",
                url: url,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    console.log(res);
                    if(res['rep'] == 1.1){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Update Success',
                            showConfirmButton: false,
                            timer: 1000
                        });
                    }else{
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'False connect Database',
                            showConfirmButton: false,
                            timer: 1000
                        });
                    }
                },
                error: function(xhr, status, error) {
            }
        });
        }else{
            let status = $(this).is(':checked') ? false : true
            $(this).prop("checked", status);
        };
    });
    });
  </script>