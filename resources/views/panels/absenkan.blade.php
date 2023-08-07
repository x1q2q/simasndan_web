@extends('layouts.app')
@section('extrahead')
    <title>Simasndan Web Apps - Absenkan Page</title>
    <meta name="description" content="Dashboard Page Sistem Informasi Manajemen Santri Al-Windan" />
    <meta name="_token" content="{{csrf_token()}}" />
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">umum / <a href="{{ route('jadwal') }}">Data Jadwal</a> / </span> Absenkan </h4>
    <div class="bs-toast toast toast-placement-ex top-0 end-0 m-3 sld-down"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
        data-delay="2000"
        id="toast-alert">
        <div class="toast-header">
            <i class="bx bx-bell me-2"></i>
            <div class="me-auto fw-semibold toast-title"></div>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"></div>
    </div>
    <!-- Striped Rows -->
    <div class="card">
    <div class="card-header row">
        <div class="col">
            <h5>{{ $jadwal->kegiatan }} - 
                    Kelas {{ $jadwal->nama_kelas }} - 
                    Semester ke-{{ $jadwal->semester }} ({{ $jadwal->tahun_pelajaran }}) </h5>
        </div>
        <div class="col-auto">
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="switchbtn" id="btnradio1" autocomplete="off" onClick="switchValue()">
                <label class="btn btn-outline-secondary" for="btnradio1"><?php echo ($jadwal->sistem_penilaian == 'kehadiran') ? 'Hadir':'100'; ?>-kan Semua</label>
                <input type="radio" class="btn-check" name="switchbtn" id="btnradio2" autocomplete="off" onClick="switchValue()">
                <label class="btn btn-outline-secondary" for="btnradio2"><?php echo ($jadwal->sistem_penilaian == 'nilai') ? '0':'Absen'; ?>-kan Semua</label>
              </div>
            <button type="button" class="btn btn-success rounded-3" onclick="saveAllData()" >
                Update Semua <i class="bx bx-sm bx-check-double"></i>
            </button>
        </div>
    </div>
    <div class="table-responsive p-4">
        <table class="table table-striped table-responsive">
        <thead class="bg-success">
            <tr>
                <th class="text-white">No.</th>
                <th class="text-white">Nama Santri</th>
                <th style="width: 10%;" class="text-white">Nilai/Presensi</th>
                <th class="text-white">Deskripsi</th>
                <th style="width: 15%;" class="text-center text-white">Aksi</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-1">
            @for($i=0; $i<count($penilaian); $i++)
                <tr data-id="{{ $penilaian[$i]->id }}">
                    <td>{{ $i+1 }}</td>
                    <td>{{ $penilaian[$i]->nama_santri }}</td>
                    <td>
                        @if($jadwal->sistem_penilaian == 'kehadiran')
                            <select class="form-control form-select" id="kehadiran"
                                name="kehadiran" style="width:100%">
                                <option value="hadir" <?php echo ($penilaian[$i]->presensi == 'hadir') ? 'selected':''; ?>>Hadir</option>
                                <option value="absen" <?php echo ($penilaian[$i]->presensi == 'absen') ? 'selected':''; ?>>Absen</option>
                            </select>
                        @elseif($jadwal->sistem_penilaian == 'nilai')
                            <input type="number" class="form-control" name="nilai" id="nilai" 
                            placeholder="0-100" style="width:100%" value="{{ $penilaian[$i]->nilai }}">
                        @endif
                    </td>
                    <td data-id="{{ $penilaian[$i]->id }}">
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="1" data-oldval="{{ $penilaian[$i]->deskripsi }}">{{ $penilaian[$i]->deskripsi }}</textarea>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn rounded-pill btn-icon btn-success" onclick="saveData('{{ $penilaian[$i]->id}}')">
                            <span class="tf-icons bx bx-md bxs-check-circle"></span>
                        </button>
                    </td>
                </tr>
            @endfor
        </tbody>
        </table>
    </div>
    </div>
    <!--/ Striped Rows -->
</div>

{{-- modal confirm --}}
<div class="modal fade" id="confirm-update" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered sld-up" role="document">
        <form class="modal-content" method="POST" action="" id="form-update">
        @csrf
        @method('POST')
        <div class="modal-header border-bottom">
            <h5 class="modal-title">Yakin untuk mengupdate semua data?</h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
        </div>
        <div class="modal-body p-4 pb-0"> 
            <p>Anda akan mengupdate semua field data yang telah dirubah</p> 
        </div>    
        <div class="modal-footer p-4 pt-0">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <input type="submit" id="confirm-button" class="btn btn-success" value="Ya, Update">
        </div>
        </form>
    </div>
</div>
<style type="text/css">

</style>
@endsection
@section('extrascript')
<script src="{{ asset('assets/vendor/libs/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/ui-modals.js') }}"></script>
    @if(session('success'))
    <script type="text/javascript">
        let msg = "{{ session('success') }}"
        showToast('success','Sukses',msg,'#toast-alert');
    </script>
    @endif
    @if(session('error'))
        <script type="text/javascript">
            let msg = "{{ session('error') }}"
            showToast('danger','Peringatan',msg,'#toast-alert');
        </script>
    @endif
<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $('#form-update').submit(function(e){
            e.preventDefault();
            let data = [];
            $('table > tbody  > tr').each(function(i) { 
                var deskripsi = $(this).find('td:eq(3) textarea').val();
                var idTr = $(this).data('id');
                var sistem = {!! json_encode($jadwal->sistem_penilaian) !!};
                var tagSelected = (sistem == 'kehadiran') ? 'select':'input';
                var nilai = $(this).find(`td:eq(2) ${tagSelected}`).val();

                var newObj = {
                    'id':idTr,
                    'deskripsi':deskripsi,
                    'nilai':'',
                    'presensi':'',
                };
                if(sistem == 'kehadiran'){
                    newObj.presensi=nilai;
                    newObj.nilai= (nilai == 'absen') ? 0 : 100;
                }else if(sistem == 'nilai'){
                    newObj.nilai=parseInt(nilai);
                    newObj.presensi= (parseInt(nilai) > 0) ? 'hadir':'absen';
                }
                data.push(newObj);
            });
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                dataType: "json",
                data: JSON.stringify({ data }),
                contentType: "application/json; charset=utf-8",
                success: function(response){ 
                    var resp = response;
                    var data = resp.data;
                    $('#confirm-update').modal('hide');
                    if(parseInt(resp.status) == 200){
                        window.location.reload();
                        showToast('success','Sukses',resp.message,'#toast-alert');
                    }else{
                        showToast('danger','Peringatan',resp.message,'#toast-alert');
                    }
                },error: function(){
                    $('#confirm-update').modal('hide');
                    showToast('danger','Peringatan','Gagal! Database server error','#toast-alert');
                }
            });
        });
        
    });

    function switchValue(){
        $('table > tbody  > tr').each(function(i) { 
            var idTr = $(this).data('id');
            var sistem = {!! json_encode($jadwal->sistem_penilaian) !!};;
            var checkedValPresensi = $('#btnradio1').is(":checked") ? 'hadir': 'absen';
            var checkedValNilai = $('#btnradio2').is(":checked") ? '0': '100';
            var oldDesc = $(this).find('td:eq(3) textarea').data('oldval');
            var newDesc = "";
            $(this).find(`td:eq(2) select option[value="hadir"]`).attr('selected',false);
            $(this).find(`td:eq(2) select option[value="absen"]`).attr('selected',false);
            if(sistem == 'kehadiran'){
                $(this).find(`td:eq(2) select option[value="${checkedValPresensi}"]`).attr('selected',true);
                newDesc = `Santri ${checkedValPresensi} pada jadwal kelas ini `;
            }else if(sistem == 'nilai'){
                $(this).find(`td:eq(2) input`).val(checkedValNilai)
                newDesc = `Santri mendapat nilai ${checkedValNilai}/100 pada jadwal kelas ini `;
            }
            if(oldDesc == ''){
                $(this).find('td:eq(3) textarea').val(newDesc);
            }
        });
    }

    function addData(){
        $('#form-save .modal-title').text("Tambah Data");
        $('#form-save').attr('tipe','add');
    }
    function editData(id){
            $('#form-save .modal-title').text("Edit Data");
            $('#form-save').attr('tipe','edit');
            let urlEdit = "{{ route('semester.detail',':id')}}";
            $.ajax({
                type:'GET',
                url: urlEdit.replace(':id',id),
                success:function(response){
                    var resp = JSON.parse(response);
                    var data = resp.semester;
                    $('#form-save').find('#id_semester').val(data.id);
                    $('#form-save').find('input#semester').val(data.semester);
                    $('#form-save').find('input#tahun_pelajaran').val(data.tahun_pelajaran);

                    $('#modal-save').modal('show');
                }
            });
    }
    function saveData(id){
        let siteUrl = "{{ route('absenkan.update') }}";
        var deskripsi = $(`table tr[data-id=${id}]`).find('td:eq(3) textarea').val();
        var sistem = {!! json_encode($jadwal->sistem_penilaian) !!};
        var tagSelected = (sistem == 'kehadiran') ? 'select':'input';
        var nilai = $(`table tr[data-id=${id}]`).find(`td:eq(2) ${tagSelected}`).val();
        let formData = new FormData();
        formData.append('id',id);
        formData.append('sistem_penilaian',sistem);
        formData.append('deskripsi',deskripsi);
        formData.append('nilai',nilai);
        $.ajax({
            type: 'POST',
            url: siteUrl,
            data:formData,
            processData:false,
            contentType:false,
            cache:false,
            success: function(response){ 
                var resp = response;
                var data = resp.data;
                if(parseInt(resp.status) == 200){
                    window.location.reload();
                    showToast('success','Sukses',resp.message,'#toast-alert');
                }else{
                    showToast('danger','Peringatan',resp.message,'#toast-alert');
                }
            },error: function(){
                showToast('danger','Peringatan','Gagal! Database server error','#toast-alert');
            }
        });
    }
    
    function saveAllData(){
        let urlUpdateAll = "{{ route('absenkan.updateall')}}";
        $("#confirm-update").modal('show');
        $('#confirm-update').find('form').attr('action',urlUpdateAll);
    }
    
</script>
@endsection
