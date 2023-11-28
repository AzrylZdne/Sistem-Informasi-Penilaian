<div class="modal fade" id="modaledit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modaleditLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaleditLabel">Edit Data Prodi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ url('prodi/updateData') }}" class="formupdate">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Kode Prodi</label>
                        <input type="text" name="kodeprodi" id="kodeprodi" class="form-control" readonly
                            value="{{ $kodeprodi }}">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Prodi</label>
                        <input type="text" name="namaprodi" id="namaprodi" class="form-control"
                            value="{{ $data->nama_prodi }}">
                        <div class="invalid-feedback err-namaprodi">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Pilih Fakultas</label>
                        <select name="idfakultas" id="idfakultas" class="form-control">
                            @foreach ($datafakultas as $f)
                                @if ($f->kode_fakultas == $data->prodi_kodefakultas)
                                    <option selected value="{{ $f->kode_fakultas }}">
                                        {{ $f->nama_fakultas }}
                                    </option>
                                @else
                                    <option value="{{ $f->kode_fakultas }}">
                                        {{ $f->nama_fakultas }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <div class="invalid-feedback err-idfakultas">
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
                                $('#dataprodi').DataTable().ajax.reload();
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
                        if (err.namaprodi) {
                            $('#namaprodi').addClass('is-invalid');
                            $('.err-namaprodi').html(err.namaprodi);
                        } else {
                            $('#namaprodi').removeClass('is-invalid');
                            $('#namaprodi').addClass('is-valid');
                            $('.err-namaprodi').html('');
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
