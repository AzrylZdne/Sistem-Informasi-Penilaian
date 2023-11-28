<div class="modal fade" id="modaltambah" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="modaltambahLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltambahLabel">Tambah Data Fakultas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ url('fakultas/saveData') }}" class="formsave">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Kode Fakultas</label>
                        <input type="text" name="kodefakultas" id="kodefakultas" class="form-control">
                        <div class="invalid-feedback err-kodefakultas">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Nama Fakultas</label>
                        <input type="text" name="namafakultas" id="namafakultas" class="form-control">
                        <div class="invalid-feedback err-namafakultas">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat Web</label>
                        <input type="text" name="linkweb" id="linkweb" class="form-control">
                        <div class="invalid-feedback err-linkweb">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btnSimpanData">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('.formsave').submit(function(e) {
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
                        $('#modaltambah').modal('hide');
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
                    $('.btnSimpanData').prop('disabled', true);
                    $('.btnSimpanData').html(
                        '<i class="fas fa-spin fa-spinner"></i> Proses');
                },
                complete: function() {
                    $('.btnSimpanData').prop('disabled', false);
                    $('.btnSimpanData').html(
                        'Simpan');
                },
                error: function(e) {
                    // alert(e.responseText);
                    console.log(e.responseJSON.errors);
                    if (e.status == 422) {
                        let err = e.responseJSON.errors;
                        if (err.namafakultas) {
                            $('#namafakultas').addClass('is-invalid');
                            $('.err-namafakultas').html(err.namafakultas);
                        } else {
                            $('#namafakultas').removeClass('is-invalid');
                            $('#namafakultas').addClass('is-valid');
                            $('.err-namafakultas').html('');
                        }
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
