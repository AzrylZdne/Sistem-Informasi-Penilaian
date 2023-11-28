<div class="modal fade" id="modaltambah" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="modaltambahLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltambahLabel">Tambah Data User Juri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ url('user-juri/saveData') }}" class="formsave">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Lengkap</label>
                        <input type="text" name="fullname" id="fullname" class="form-control">
                        <div class="invalid-feedback err-fullname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">E-Mail</label>
                        <input type="text" name="email" id="email" class="form-control">
                        <div class="invalid-feedback err-email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="pass" id="pass" class="form-control">
                        <div class="invalid-feedback err-pass">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Confirm Password</label>
                        <input type="password" name="confirmpass" id="confirmpass" class="form-control">
                        <div class="invalid-feedback err-confirmpass">
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
                                $('#datajuri').DataTable().ajax.reload();
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
                     alert(e.responseText);
                    console.log(e.responseJSON.errors);
                    if (e.status == 422) {
                        let err = e.responseJSON.errors;
                        if (err.fullname) {
                            $('#fullname').addClass('is-invalid');
                            $('.err-fullname').html(err.fullname);
                        } else {
                            $('#fullname').removeClass('is-invalid');
                            $('#fullname').addClass('is-valid');
                            $('.err-fullname').html('');
                        }
                        if (err.email) {
                            $('#email').addClass('is-invalid');
                            $('.err-email').html(err.email);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('#email').addClass('is-valid');
                            $('.err-email').html('');
                        }
                        if (err.pass) {
                            $('#pass').addClass('is-invalid');
                            $('.err-pass').html(err.pass);
                        } else {
                            $('#pass').removeClass('is-invalid');
                            $('#pass').addClass('is-valid');
                            $('.err-pass').html('');
                        }
                         if (err.confirmpass) {
                            $('#confirmpass').addClass('is-invalid');
                            $('.err-confirmpass').html(err.confirmpass);
                        } else {
                            $('#confirmpass').removeClass('is-invalid');
                            $('#confirmpass').addClass('is-valid');
                            $('.err-confirmpass').html('');
                        }
                    }
                }
            });
            return false;
        });
    });
</script>