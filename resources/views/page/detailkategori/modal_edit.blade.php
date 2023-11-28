<div class="modal fade" id="modaledit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modaleditLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaleditLabel">Tambah Data Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ url('kategori/updateData') }}" class="formupdate">
                @csrf
                @method('PUT')
                <input type="hidden" name="idkategori" value="{{ $idkategori }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Kategori</label>
                        <input type="text" name="namakategori" id="namakategori" class="form-control"
                            value="{{ $data->nama_kategori }}">
                        <div class="invalid-feedback err-namakategori">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Jumlah Bobot</label>
                        <input type="text" name="jumlahbobot" id="jumlahbobot" class="form-control"
                            value="{{ $data->jumlahbobot }}">
                        <div class="invalid-feedback err-jumlahbobot">
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
                                $('#datakategori').DataTable().ajax.reload();
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
                        if (err.namakategori) {
                            $('#namakategori').addClass('is-invalid');
                            $('.err-namakategori').html(err.namakategori);
                        } else {
                            $('#namakategori').removeClass('is-invalid');
                            $('#namakategori').addClass('is-valid');
                            $('.err-namakategori').html('');
                        }
                        if (err.jumlahbobot) {
                            $('#jumlahbobot').addClass('is-invalid');
                            $('.err-jumlahbobot').html(err.jumlahbobot);
                        } else {
                            $('#jumlahbobot').removeClass('is-invalid');
                            $('#jumlahbobot').addClass('is-valid');
                            $('.err-jumlahbobot').html('');
                        }
                    }
                }
            });
            return false;
        });
    });
</script>
