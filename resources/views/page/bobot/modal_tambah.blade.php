<div class="modal fade" id="modaltambah" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="modaltambahLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltambahLabel">Tambah Data Sub Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ url('sub-kategori/saveData') }}" class="formsave">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Pilih Kategori</label>
                        <select name="idkategori" id="idkategori" class="form-control">
                            <option value="" selected>-Silahkan Pilih-</option>
                            @foreach ($databobot as $bo)
                            <option value="{{ $bo->id }}">{{ $bo->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback err-idkategori">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Detail Kategori / Penilaian Bobot</label>
                        <textarea name="kategori_detail" id="kategori_detail" class="form-control" rows="4"></textarea>
                        <div class="invalid-feedback err-kategori_detail">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Bobot</label>
                        <input type="number" name="bobot" id="bobot" class="form-control"
                            onkeyup="if(this.value > 100){this.value=100} else if (this.value < 0){this.value = 0}">
                        <div class="invalid-feedback err-bobot">
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
                                $('#databobot').DataTable().ajax.reload();
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
                    if (e.status == 422) {
                        let err = e.responseJSON.errors;
                        if (err.idkategori) {
                            $('#idkategori').addClass('is-invalid');
                            $('.err-idkategori').html(err.idkategori);
                        } else {
                            $('#idkategori').removeClass('is-invalid');
                            $('#idkategori').addClass('is-valid');
                            $('.err-idkategori').html('');
                        }
                        if (err.kategori_detail) {
                            $('#kategori_detail').addClass('is-invalid');
                            $('.err-kategori_detail').html(err.kategori_detail);
                        } else {
                            $('#kategori_detail').removeClass('is-invalid');
                            $('#kategori_detail').addClass('is-valid');
                            $('.err-kategori_detail').html('');
                        }
                        if (err.bobot) {
                            $('#bobot').addClass('is-invalid');
                            $('.err-bobot').html(err.bobot);
                        } else {
                            $('#bobot').removeClass('is-invalid');
                            $('#bobot').addClass('is-valid');
                            $('.err-bobot').html('');
                        }
                    }
                }
            });
            return false;
        });
    });
</script>