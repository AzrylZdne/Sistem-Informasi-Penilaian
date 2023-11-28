<div class="modal fade" id="modaltambah" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="modaltambahLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltambahLabel">Tambah Data Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ url('kategori/saveData') }}" class="formsave">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Kategori</label>
                        <input type="text" name="namakategori" id="namakategori" class="form-control">
                        <div class="invalid-feedback err-namakategori">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Jumlah Bobot</label>
                        <input type="number" name="jumlahbobot" id="jumlahbobot" class="form-control"
                            onkeyup="if(this.value > 100){this.value=100} else if (this.value < 0){this.value = 0}">
                        <div class="invalid-feedback err-jumlahbobot">
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
                                $('#datakategori').DataTable().ajax.reload();
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
                    console.log(e.responseJSON);
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