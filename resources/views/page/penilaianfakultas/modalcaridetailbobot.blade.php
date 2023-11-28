<!-- Modal -->
<div class="modal fade" id="modalcaridetailbobot" tabindex="-1" role="dialog" aria-labelledby="modalcaridetailbobotLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalcaridetailbobotLabel">Cari Detail Bobot</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-stripped table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Detail</th>
                        <th>Bobot</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $nomor=0;
                    @endphp
                    @forelse ($dataBobot as $d)
                        <tr>
                            <td>{{ ++$nomor }}</td>
                            <td>{{ $d->kategori_detail }}</td>
                            <td>{{ $d->bobot }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" onclick="pilihData('{{ $d->id }}','{{ $d->kategori_detail }}','{{ $d->bobot }}')">
                                    Pilih
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th colspan="4">Data tidak ada...</th>
                        </tr>
                    @endforelse
                </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script>
    function pilihData(id,k,b){
        $('#iddetailkategori').val(id);
        $('#namadetail').val(k);
        $('#jmlbobot').val(b);

        $('#modalcaridetailbobot').modal('hide');
    }
</script>
