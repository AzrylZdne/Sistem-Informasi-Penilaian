@extends('main')

@section('content')
<!-- Begin Page Content -->
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="font-weight-bold mb-0 ml-5">Data Penilaian Prodi</h4>
            </div>
        </div>
    </div>
</div>

<!-- /.container-fluid -->
<div class="col-lg-12 grid-margin stretch-card mt-3">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                @if (Auth::user()->role == 'juri')
                <button type="button" class="btn btn-primary btnTambahData"
                    onclick="window.location='{{ url('penilaian-prodi/add') }}'">
                    <i class="fas fa-plus"></i> Tambah Data
                </button>
                @elseif (Auth::user()->role == 'admin')
                <button type="button" class="btn btn-success"
                    onclick="window.location='{{ url('penilaian-prodi/doExportExcel') }}'">
                    <i class="fas fa-file-excel"></i> Export Excel
                </button>
                @endif

            </h4>
            <div class="table-responsive">
                <table id="datapenilaian" class="table table-striped table-sm display nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            @if (Auth::user()->role == 'admin')
                            <th>#</th>
                            @endif
                            <th>No</th>
                            <th>Kode Penilaian</th>
                            <th>Tanggal</th>
                            <th>Nama Prodi</th>
                            <th>Fakultas</th>
                            <th>Total Bobot</th>
                            <th>Total Nilai</th>
                            <th>Total Score</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function editdata(id) {
            window.location.href = ("{{ url('penilaian-prodi/edit') }}" + '/' + id);
        }

        function removedata(id) {
            Swal.fire({
                title: 'Hapus Penilaian',
                text: "Yakin menghapus data penilaian prodi ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('penilaian-prodi/deleteData') }}" + '/' + id,
                        dataType: "json",
                        beforeSend: function() {
                            $('#deleteIcon_' + id).hide();
                            $('#deleteSpinner_' + id).show();
                        },
                        complete: function() {
                            $('#deleteIcon_' + id).show();
                            $('#deleteSpinner_' + id).hide();
                        },
                        success: function(response) {
                            if (response.sukses) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil !',
                                    text: `${response.sukses}`,
                                }).then((result) => {
                                    /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {
                                        $('#datapenilaian').DataTable().ajax.reload();
                                    }
                                })
                            }
                        },
                        error: function(e) {
                            console.log(e.responseText);
                        }
                    });
                }
            })
        }

        @if (Auth::user()->role == 'admin')
            function format(details) {
                let data = ``;
                details.forEach(element => {
                    data += `
                <tr>
                    <td>:${element.nama_juri}</td>
                    <td>:${element.total_score}</td>
                    <td>:${element.total_nilai}</td>
                </tr>`;
                })
                return (`<table>
                    <tr>
                        <td>Nama Juri</td>
                        <td>Total Score</td>
                        <td>Total Nilai</td>
                    </tr>
                ` +
                    data +
                    `</table>`);
            }
        @endif

        $(document).ready(function() {
            @if (Auth::user()->role == 'admin')
                const format_table = [{
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: ''
                    },
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'penilaian_kode',
                        name: 'penilaian_kode'
                    }, {
                        data: 'penilaian_tgl',
                        name: 'penilaian_tgl'
                    },
                    {
                        data: 'namaprodi',
                        name: 'namaprodi'
                    },
                    {
                        data: 'namafakultas',
                        name: 'namafakultas'
                    },
                    {
                        data: 'totalbobot',
                        name: 'totalbobot'
                    },
                    {
                        data: 'totalnilai',
                        name: 'totalnilai'
                    },
                    {
                        data: 'totalscore',
                        name: 'totalscore'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ];
                @else
                const format_table = [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'penilaian_kode',
                        name: 'penilaian_kode'
                    }, {
                        data: 'penilaian_tgl',
                        name: 'penilaian_tgl'
                    },
                    {
                        data: 'namaprodi',
                        name: 'namaprodi'
                    },
                    {
                        data: 'namafakultas',
                        name: 'namafakultas'
                    },
                    {
                        data: 'totalbobot',
                        name: 'totalbobot'
                    },
                    {
                        data: 'totalnilai',
                        name: 'totalnilai'
                    },
                    {
                        data: 'totalscore',
                        name: 'totalscore'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ];
            @endif

            const table = $('#datapenilaian').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ url('penilaian-prodi/index') }}",
                columns: format_table,
                columnDefs: [{
                    targets: 8,
                    width: '10%',
                    className: 'text-center'
                }]
            });
            @if (Auth::user()->role == 'admin')
                table.on('click', 'td.dt-control', function(e) {
                    let tr = e.target.closest('tr');
                    let row = table.row(tr);

                    if (row.child.isShown()) {
                        // This row is already open - close it
                        row.child.hide();
                    } else {
                        // Open this row
                        row.child(format(row.data().detail)).show();
                    }
                });
            @endif
        });
</script>
@endsection