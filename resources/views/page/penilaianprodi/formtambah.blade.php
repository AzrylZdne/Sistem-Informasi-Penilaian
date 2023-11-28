@extends('main')

@section('content')
    <!-- Begin Page Content -->
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="font-weight-bold mb-0 ml-5">Tambah Data Penilaian Prodi</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- /.container-fluid -->
    <div class="col-lg-12 grid-margin stretch-card mt-3">
        <form method="POST" action="{{ url('penilaian-prodi/simpan') }}" class="formSimpan">
            @csrf
            <div class="card">
                <div class="card-header bg-success">
                    <h3 class="card-title">
                        <button type="button" class="btn btn-warning"
                            onclick="window.location='{{ url('penilaian-prodi/index') }}'">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </button>
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Kode Penilaian <small><span class="badge badge-info">Kode
                                            Otomatis</span></small></label>
                                <input type="text" name="kodepenilaian" id="kodepenilaian" value="{{ $kodepenilaian }}"
                                    readonly class="form-control">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Pilih Fakultas</label>
                                <select name="idfakultas" id="idfakultas" class="form-control">
                                    <option value="" selected>-Silahkan Pilih-</option>
                                    @foreach ($datafakultas as $f)
                                        <option value="{{ $f->kode_fakultas }}">
                                            {{ $f->nama_fakultas }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback err-idfakultas">
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Pilih Prodi</label>
                                <select name="idprodi" id="idprodi" class="form-control">
                                    <option value="" selected>-Pilih Prodi-</option>
                                </select>
                                <div class="invalid-feedback err-idprodi">
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Tanggal Penilaian</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control">
                                <div class="invalid-feedback err-tanggal">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <hr style="border: 2px solid green">
                            <h4>Silahkan Lakukan Penilaian Dengan Mengisi Nilai Pada Form Tabel Berikut :</h4>
                            <table class="table table-sm table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kategori</th>
                                        <th>Detail</th>
                                        <th>Bobot</th>
                                        <th>Input Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $nomor = 0;
                                    @endphp
                                    @foreach ($datapenilaian as $item)
                                        @if ($loop->first || $item->nama_kategori != $datapenilaian[$loop->index - 1]->nama_kategori)
                                            <tr>
                                                <td>{{ ++$nomor }}</td>
                                                <td>{{ $item->nama_kategori }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>{{ $item->nmkategoridetail }}</td>
                                            <td>{{ $item->jmlbobotdetail }}</td>
                                            <td>
                                                <input type="hidden" name="idkategori[]" value="{{ $item->idkategori }}">
                                                <input type="hidden" name="jmlbobot[]"
                                                    value="{{ $item->jmlbobotdetail }}">
                                                <input type="hidden" name="iddetailkategori[]"
                                                    value="{{ $item->iddetailkategori }}">
                                                <input type="number" value="0" name="masuknilai[]"
                                                    class="form-control form-control-sm" max="100"
                                                    onkeyup="if(this.value > 100){this.value=100} else if (this.value < 0){this.value = 0}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" style="text-align: right;">
                                            <button type="submit" class="btn btn-success btnSimpanData">
                                                Simpan Data
                                            </button>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="viewmodalcari" style="display: none;"></div>
    <script>
        $(document).ready(function() {
            $('#idfakultas').change(function(e) {
                e.preventDefault();
                let idfak = $(this).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "post",
                    url: "{{ url('penilaian-prodi/pilihProdi') }}",
                    data: {
                        idfakultas: idfak
                    },
                    success: function(response) {
                        $('#idprodi').html(response);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            $('.formSimpan').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Yakin Menyimpan Penilaian ini ? Silahkan diperiksa terlebih dahulu !',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Iya, Simpan',
                    denyButtonText: `Batal`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
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
                                        html: `${response.sukses}`,
                                        showCancelButton: true
                                    }).then((result) => {
                                        /* Read more about isConfirmed, isDenied below */
                                        if (result.isConfirmed) {
                                            window.location.reload();
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
                                    'Simpan Data');
                                $(window).scrollTop(0);
                            },
                            error: function(e) {
                                // alert(e.responseText);
                                $(window).scrollTop(0);
                                console.log(e.responseJSON.errors);
                                if (e.status == 422) {
                                    let err = e.responseJSON.errors;
                                    if (err.idfakultas) {
                                        $('#idfakultas').addClass('is-invalid');
                                        $('.err-idfakultas').html(err.idfakultas);
                                    } else {
                                        $('#idfakultas').removeClass('is-invalid');
                                        $('#idfakultas').addClass('is-valid');
                                        $('.err-idfakultas').html('');
                                    }
                                    if (err.idprodi) {
                                        $('#idprodi').addClass('is-invalid');
                                        $('.err-idprodi').html(err.idprodi);
                                    } else {
                                        $('#idprodi').removeClass('is-invalid');
                                        $('#idprodi').addClass('is-valid');
                                        $('.err-idprodi').html('');
                                    }
                                    if (err.tanggal) {
                                        $('#tanggal').addClass('is-invalid');
                                        $('.err-tanggal').html(err.tanggal);
                                    } else {
                                        $('#tanggal').removeClass('is-invalid');
                                        $('#tanggal').addClass('is-valid');
                                        $('.err-tanggal').html('');
                                    }
                                }
                            }
                        });
                    }
                });

                return false;
            });
        });
    </script>
@endsection
