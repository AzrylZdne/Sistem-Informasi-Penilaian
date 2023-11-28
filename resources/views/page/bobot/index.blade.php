@extends('main')

@section('content')
    <!-- Begin Page Content -->
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="font-weight-bold mb-0 ml-5">Data Sub Kategori</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- /.container-fluid -->
    <div class="col-lg-12 grid-margin stretch-card mt-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <button type="button" class="btn btn-primary btnTambahData">
                        <i class="fas fa-plus"></i> Tambah Data
                    </button>
                </h4>
                <div class="table-responsive">
                    <table id="databobot" class="table table-striped table-sm display nowrap" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Bobot Penilaian</th>
                                <th>Bobot</th>
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
    <div class="viewmodaltambah" style="display: none;"></div>
    <div class="viewmodaledit" style="display: none;"></div>
    <script>
        function removedata(id) {
            Swal.fire({
                title: 'Hapus Detail Kategori',
                text: "Yakin menghapus data detail ini ?",
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
                        url: "{{ url('sub-kategori/deleteData') }}" + '/' + id,
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
                                        $('#databobot').DataTable().ajax.reload();
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

        function editdata(id) {
            $.ajax({
                type: "GET",
                url: "{{ url('sub-kategori/edit') }}" + '/' + id,
                dataType: "json",
                beforeSend: function() {
                    $('#editIcon_' + id).hide();
                    $('#editSpinner_' + id).show();
                },
                complete: function() {
                    $('#editIcon_' + id).show();
                    $('#editSpinner_' + id).hide();
                },
                success: function(response) {
                    if (response.data) {
                        $('.viewmodaledit').html(response.data).show();
                        $('#modaledit').modal('show');
                    }
                },
                error: function(e) {
                    console.log(e.responseText);
                }
            });
        }
        $(document).ready(function() {

            $('.btnTambahData').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "{{ url('sub-kategori/add') }}",
                    dataType: "json",
                    beforeSend: function() {
                        $('.btnTambahData').html('<i class="fas fa-spin fa-spinner"></i>');
                        $('.btnTambahData').attr('disabled', true);
                    },
                    complete: function() {
                        $('.btnTambahData').html('<i class="fas fa-plus"></i> Tambah Data');
                        $('.btnTambahData').attr('disabled', false);
                    },
                    success: function(response) {
                        if (response.data) {
                            $('.viewmodaltambah').html(response.data).show();
                            $('#modaltambah').modal('show');
                            $('#databobot').DataTable().ajax.reload();
                        }
                    },
                    error: function(e) {
                        console.log(e.responseText);
                    }
                });
            });
            $('#databobot').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ url('sub-kategori/index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'namakategori',
                        name: 'namakategori'
                    },
                    {
                        data: 'kategori_detail',
                        name: 'kategori_detail'
                    },
                    {
                        data: 'bobot',
                        name: 'bobot'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                columnDefs: [{
                        targets: 4,
                        width: '10%',
                        className: 'text-center'
                    },
                    {
                        targets: [0, 3],
                        width: '5%'
                    },
                    {
                        targets: 1,
                        width: '20%'
                    },
                    {
                        targets: 2,
                        width: '60%'
                    },
                ]
            });
        });
    </script>
@endsection
