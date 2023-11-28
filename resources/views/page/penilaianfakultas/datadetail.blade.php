<table class="table table-sm table-stripped table-bordered" style="width: 100%;">
    <thead>
        <tr>
            <th>No</th>
            <th>Kategori Penilaian</th>
            <th>Detail</th>
            <th>Jml Bobot</th>
            <th>Nilai</th>
            <th>Score</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 0;
        @endphp
        @forelse ($datadetail as $t)
            <tr>
                <td>{{ ++$no }}</td>
                <td>{{ $t->namakategori }}</td>
                <td>{{ $t->detailkategori }}</td>
                <td style="width: 5%;">{{ $t->jmlbobot }}</td>
                <td style="width: 5%;">{{ $t->masuk_nilai }}</td>
                <td style="width: 5%;">{{ number_format($t->score, 2, ',', '.') }}</td>
                <td style="width: 5%;">
                    <button type="button" title="Hapus" class="btn btn-sm btn-danger"
                        onclick="hapusDetail('{{ $t->idpenilaian }}');">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <th colspan="7">Data Belum ada...</th>
            </tr>
        @endforelse
    </tbody>
</table>
<script>
    function hapusDetail(id) {
        Swal.fire({
            title: 'Hapus Detail',
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
                    url: "{{ url('penilaian-fakultas/deleteDetail') }}" + '/' + id,
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil !',
                                text: `${response.sukses}`,
                            }).then((result) => {
                                kosongkan();
                                tampilDataDetail();
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
</script>
