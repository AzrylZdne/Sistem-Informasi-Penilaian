<div class="modal fade" id="modaledit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modaleditLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaleditLabel">Edit Data Fakultas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ url('fakultas/updateData') }}" class="formupdate">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Kode Fakultas</label>
                        <input type="text" name="kodefakultas" id="kodefakultas" class="form-control" readonly
                            value="{{ $kodefakultas }}">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Fakultas</label>
                        <input type="text" name="namafakultas" id="namafakultas" class="form-control"
                            value="{{ $data->nama_fakultas }}">
                        <div class="invalid-feedback err-namafakultas">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Web</label>
                        <input type="text" name="linkweb" id="linkweb" class="form-control"
                            value="{{ $data->link_web }}">
                        <div class="invalid-feedback err-linkweb">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btnUpdateData">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('.formupdate').submit(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                cache: false,
                dataType: 'json',
                success: function(response) {
                    if (response.sukses) {
                        $('#modaledit').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil !',
                            text: `${response.sukses}`,
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                $('#datafakultas').DataTable().ajax.reload();
                            }
                        })
                    }
                },
                beforeSend: function() {
                    $('.btnUpdateData').prop('disabled', true);
                    $('.btnUpdateData').html(
                        '<i class="fas fa-spin fa-spinner"></i> Proses');
                },
                complete: function() {
                    $('.btnUpdateData').prop('disabled', false);
                    $('.btnUpdateData').html(
                        'Update');
                },
                error: function(e) {
                    // alert(e.responseText);
                    console.log(e.responseJSON.errors);
                    if (e.status == 422) {
                        let err = e.responseJSON.errors;
                        if (err.kodefakultas) {
                            $('#kodefakultas').addClass('is-invalid');
                            $('.err-kodefakultas').html(err.kodefakultas);
                        } else {
                            $('#kodefakultas').removeClass('is-invalid');
                            $('#kodefakultas').addClass('is-valid');
                            $('.err-kodefakultas').html('');
                        }

                        if (err.linkweb) {
                            $('#linkweb').addClass('is-invalid');
                            $('.err-linkweb').html(err.linkweb);
                        } else {
                            $('#linkweb').removeClass('is-invalid');
                            $('#linkweb').addClass('is-valid');
                            $('.err-linkweb').html('');
                        }
                    }
                }
            });
            return false;
        });
    });
</script>
