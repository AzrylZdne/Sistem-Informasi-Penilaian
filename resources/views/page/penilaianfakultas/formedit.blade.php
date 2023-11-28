@extends('main')

@section('content')
    <!-- Begin Page Content -->
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="font-weight-bold mb-0 ml-5">Edit Data Penilaian Fakultas</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- /.container-fluid -->
    <div class="col-lg-12 grid-margin stretch-card mt-3">
        <form method="POST" action="{{ url('penilaian-fakultas/updateData') }}" class="formSimpan">
            @method('PUT')
            @csrf
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">
                        <button type="button" class="btn btn-warning"
                            onclick="window.location='{{ url('penilaian-fakultas/index') }}'">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </button>
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Kode Penilaian <small><span class="badge badge-info">Kode
                                            Otomatis</span></small></label>
                                <input type="text" name="kodepenilaian" id="kodepenilaian" value="{{ $kodepenilaian }}"
                                    readonly class="form-control">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Fakultas</label>
                                <input type="hidden" value="{{ $datafakultas->kode_fakultas }}" name="idfakultas"
                                    id="idfakultas">
                                <input type="text" value="{{ $datafakultas->nama_fakultas }}" readonly
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Tanggal Penilaian</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control"
                                    value="{{ $datapenilaian->penilaian_tgl }}" readonly="true">
                                <div class="invalid-feedback err-tanggal">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info" role="alert">
                                Silahkan Edit Nilai Pada Tabel di Bawah, Jika ada yang perlu diubah :
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
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
                                    @foreach ($datadetailpenilaian as $item)
                                        @if ($loop->first || $item->nama_kategori != $datadetailpenilaian[$loop->index - 1]->nama_kategori)
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
                                                <input type="hidden" name="idpenilaian[]"
                                                    value="{{ $item->idpenilaian }}">
                                                <input type="hidden" name="jmlbobot[]"
                                                    value="{{ $item->jmlbobotdetail }}">
                                                <input type="hidden" name="iddetailkategori[]"
                                                    value="{{ $item->iddetailkategori }}">
                                                <input type="number" value="{{ $item->nilai }}" name="masuknilai[]"
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
                                                Update Data
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
            $('.formSimpan').submit(function(e) {
                Swal.fire({
                    title: 'Apakah Yakin Meng-Update Penilaian ini ? Silahkan diperiksa terlebih dahulu !',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Iya, Update',
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
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil !',
                                        html: `${response.sukses}`,
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
                                    'Update Data');
                                $(window).scrollTop(0);
                            },
                            error: function(e) {
                                // alert(e.responseText);
                                console.log(e.responseJSON.errors);
                                $(window).scrollTop(0);
                            }
                        });
                    } else if (result.isDenied) {
                        window.location.reload();
                    }
                });
                return false;
            });
        });
    </script>
@endsection
