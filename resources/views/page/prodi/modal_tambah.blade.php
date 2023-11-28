<div class="modal fade" id="modaltambah" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="modaltambahLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltambahLabel">Tambah Data Prodi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ url('prodi/saveData') }}" class="formsave">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Kode Prodi</label>
                        <input type="text" name="kodeprodi" id="kodeprodi" class="form-control">
                        <div class="invalid-feedback err-kodeprodi">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Nama Prodi</label>
                        <input type="text" name="namaprodi" id="namaprodi" class="form-control">
                        <div class="invalid-feedback err-namaprodi">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Pilih Fakultas</label>
                        <select name="idfakultas" id="idfakultas" class="form-control">
                            <option value="" selected>-Silahkan Pilih-</option>
                            @foreach ($datafakultas as $f)
                                <option value="{{ $f->kode_fakultas }}">{{ $f->nama_fakultas }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback err-idfakultas">
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
                                $('#dataprodi').DataTable().ajax.reload();
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
                        if (err.namaprodi) {
                            $('#namaprodi').addClass('is-invalid');
                            $('.err-namaprodi').html(err.namaprodi);
                        } else {
                            $('#namaprodi').removeClass('is-invalid');
                            $('#namaprodi').addClass('is-valid');
                            $('.err-namaprodi').html('');
                        }
                        if (err.kodeprodi) {
                            $('#kodeprodi').addClass('is-invalid');
                            $('.err-kodeprodi').html(err.kodeprodi);
                        } else {
                            $('#kodeprodi').removeClass('is-invalid');
                            $('#kodeprodi').addClass('is-valid');
                            $('.err-kodeprodi').html('');
                        }
                        if (err.idfakultas) {
                            $('#idfakultas').addClass('is-invalid');
                            $('.err-idfakultas').html(err.idfakultas);
                        } else {
                            $('#idfakultas').removeClass('is-invalid');
                            $('#idfakultas').addClass('is-valid');
                            $('.err-idfakultas').html('');
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
