<div class="modal fade" id="modaledit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modaleditLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="modaleditLabel">Edit Data Sub Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ url('sub-kategori/updateData') }}" class="formupdate">
                @csrf
                @method('PUT')
                <input type="hidden" name="idbobot" value="{{ $datadetail->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Pilih Kategori Bobot</label>
                        <select name="idkategori" id="idkategori" class="form-control">
                            @foreach ($datakategori as $bo)
                                <option @selected($datadetail->id_kategori == $bo->id) value="{{ $bo->id }}">
                                    {{ $bo->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback err-idkategori">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Detail Kategori</label>
                        <textarea name="detailkategori" id="detailkategori" class="form-control" rows="4">{{ $datadetail->kategori_detail }}</textarea>
                        <div class="invalid-feedback err-detailkategori">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Bobot</label>
                        <input type="number" name="bobot" id="bobot" class="form-control"
                            value="{{ $datadetail->bobot }}">
                        <div class="invalid-feedback err-bobot">
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
                                $('#databobot').DataTable().ajax.reload();
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
                    alert(e.responseText);
                    console.log(e.responseJSON.errors);
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
                        if (err.detailkategori) {
                            $('#detailkategori').addClass('is-invalid');
                            $('.err-detailkategori').html(err.detailkategori);
                        } else {
                            $('#detailkategori').removeClass('is-invalid');
                            $('#detailkategori').addClass('is-valid');
                            $('.err-detailkategori').html('');
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
