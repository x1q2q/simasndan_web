@extends('layouts.app')
@section('extrahead')
    <title>Simasndan Web Apps - Data Jadwal Page</title>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/css/select2bootstrap.min.css') }}">
    <meta name="description" content="Dashboard Page Sistem Informasi Manajemen Santri Al-Windan" />
    <meta name="_token" content="{{csrf_token()}}" />
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"> absensi / </span> Data Jadwal </h4>
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
    <div class="card-header row justify-content-start">
        <div class="col-auto">
            <button type="button" class="btn btn-dark rounded-3" onclick="addData()"
                data-bs-toggle="modal" data-bs-target="#modal-save">
                Tambah Jadwal <i class="bx bx-sm bxs-plus-circle"></i>
            </button>
        </div>
    </div>
    <form class="nopadding" action="" method="post" enctype="multipart/form-data" onsubmit="return false;">
        @csrf
        <div class="row p-2 bg-light m-0">
            <div class="col-12">
                <div class="input-group input-group-merge">
                    <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                    <input type="text" class="form-control" id="s_keyword" 
                    name="s_keyword" placeholder="Cari di sini ..." aria-label="Search..." aria-describedby="basic-addon-search31">
                </div>
            </div>
        </div>
      
        <div class="form-group row" style="display: none;">
            <div class="col">
                <button type="submit" class="btn btn-alt-primary">Cari</button>
            </div>
        </div>
    </form>
    <div class="table-responsive text-wrap">
        <table class="table table-striped table-responsive" id="datatable-jadwal">
        <thead>
            <tr>
            <th>No.</th>
            <th>Kegiatan</th>
            <th>Kode Kelas</th>
            <th>Waktu Mulai Pelajaran</th>
            <th>Dibuat</th>
            <th style="width: 20%;" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
        </tbody>
        </table>
    </div>
    </div>
    <!--/ Striped Rows -->
</div>

@include('layouts.modal_delete')

<!-- modal save -->
<div class="modal fade" id="modal-save" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog sld-up" role="document">
    <form action="" method="POST" id="form-save" class="modal-content" 
        tipe="" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="id_jadwal" name="id_jadwal"/>
            <div class="modal-header border-bottom">
                <h5 class="modal-title"></h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body p-4 pb-0">
                <div class="row">
                    <div class="col-12 mb-3">
                    <label for="kegiatan" class="form-label">Kegiatan</label>
                    <input type="text" class="form-control" name="kegiatan" id="kegiatan" 
                    placeholder="Masukkan nama kegiatan"/>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <label for="kode_kelas" class="form-label">Kode Kelas</label>
                    <select class="form-control form-select js-select2" id="kode_kelas"
                        name="kode_kelas[]" multiple style="width:100%">
                    </select>
                </div>
                
                <div class="col-12 mb-3">
                    <label for="sistem_penilaian" class="form-label">Sistem Penilaian</label>
                    <select class="form-control form-select" id="sistem_penilaian"
                        name="sistem_penilaian" style="width:100%">
                        <option value="kehadiran">Kehadiran</option>
                        <option value="nilai">Nilai</option>
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <label for="materi_id" class="form-label">Materi</label>
                    <select class="form-control form-select js-select2" id="materi_id"
                        name="materi_id" style="width:100%">
                    </select>
                </div>
                
                <div class="col-12 mb-3">
                    <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                        <input type="text" class="form-control timepicker" id="waktu_mulai" 
                        name="waktu_mulai" placeholder="07:00">
                </div>

            <div class="modal-footer py-4 px-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-success" id="btn-save">Simpan 
                    <span class="tf-icons bx bxs-check-circle"></span>
                </button>
            </div>
        </div>
    </div>
    </div>
</div>

<style type="text/css">

</style>
@endsection
@section('extrascript')
<script src="{{ asset('assets/vendor/libs/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/ui-modals.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/timepicker/jquery.timepicker.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/select2/js/select2.full.min.js') }}"></script>

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
    $(function () {
        $('.js-select2').select2({
            placeholder: "Pilih",
            allowClear: true,
            theme: "bootstrap",
            dropdownParent: $('#modal-save'),
        });
    });
    $(document).ready(function(){
        var dtableJadwal = $('#datatable-jadwal').DataTable({
            "searching": false,
            "autoWidth":false,
            "lengthChange": true,
            "pagingType": "simple",
            language: {
                emptyTable: "Tidak ada data",
                zeroRecords: "Data masih kosong",
            },
            "dom": '<"wrapper m-2 bg-label-secondary p-1"lf>rt<"wrapper rounded-3 bg-label-dark"<i><"row align-items-center"<""><p>>>',
            "processing": true,
            "serverSide": true,
            "aLengthMenu": [[5, 15, 30],[ 5, 15, 30]],
            "order": [
                [0, "desc"]
            ],
            "columns": [
                {
                    'data': 'DT_RowIndex',
                    'className': "text-center",
                    'orderable': false,
                },
                {
                    'data': 'kegiatan',
                    'className': "text-center",
                    'orderable': false,
                },
                {
                    'data': 'kode_kelas',
                    'className': "text-center",
                    'orderable': false,
                },
                {
                    'data': 'waktu_mulai',
                    'className': "text-center",
                    'orderable': false,
                },
                {
                    'data': 'created_at',
                    'className': "text-center",
                    'orderable': false,
                },           
                {
                    'data': 'id', 
                    'className':"text-center",
                    'orderable': false,
                    render: function(data, type, row, meta) {
                    return `<button onclick="detailData('${data}')" type="button" class="btn rounded-pill 
                            btn-icon btn-primary" title="detail data">
                                <span class="tf-icons bx bxs-detail"></span>
                            </button>
                            <button onclick="editData('${data}')" type="button" class="btn rounded-pill btn-icon 
                            btn-warning" title="edit data">
                                <span class="tf-icons bx bx-edit-alt"></span>
                            </button>
                            <button onclick="hapusData('${data}')" type="button" class="btn rounded-pill btn-icon 
                            btn-danger" title="hapus data">
                                <span class="tf-icons bx bx-trash"></span>
                            </button>`;
                    }
                },
            ],
            "rowCallback": function( row, data, index ) {
            },
            columnDefs: [
            ],
            "ajax": {
                "url": "{{route('jadwal.lists')}}",
                "type": "POST",
                'data': function(data) {
                    data.s_keyword = $('#s_keyword').val();

                    data._token =  "{{ csrf_token() }}";
                }
            }
        });

        dtableJadwal.on( 'draw', function () {
            var total_records = dtableJadwal.rows().count();
            var page_length = dtableJadwal.page.info().length;
            var total_pages = Math.ceil(total_records / page_length);
            var current_page = dtableJadwal.page.info().page+1;
        });

        $('#s_keyword').keyup(function() {
            dtableJadwal.draw();
        });

        $("#modal-save").on('hidden.bs.modal', function (e) {
            $('#form-save').trigger('reset');
            resetValidationError();
        });

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $('#form-save').submit(function(e){
                e.preventDefault();
                let siteUrl = "{{ route('jadwal') }}";
                let formData = new FormData(this);
                let idjadwal = $('#form-save').find('#id_jadwal').val();
                let urlPost =  ($(this).attr('tipe') == 'add') ? 
                    `${siteUrl}/insert`: `${siteUrl}/update`;

                formData.append('id',idjadwal)
                resetValidationError(); // agar bisa mengambil kondisi field terbaru
                $.ajax({
                    type: $(this).attr('method'),
                    url: urlPost,
                    data:formData,
                    processData:false,
                    contentType:false,
                    cache:false,
                    success: function(response){ 
                        var resp = response;
                        var data = resp.data;
                        if(parseInt(resp.status) == 200){
                            $('#modal-save').modal('hide');
                            dtableJadwal.draw();
                            showToast('success','Sukses',resp.message,'#toast-alert');
                        }else{
                            for(const val in data){
                                const inputTag = 'form#form-save'+' #'+val;
                                $(inputTag).addClass('is-invalid');
                                if(!$(inputTag).parent().find('.invalid-feedback').length){
                                    $(inputTag).parent().append(
                                        `<div class="invalid-feedback">${data[val]} </div>`);
                                    }                     
                            }
                            showToast('danger','Peringatan',resp.message,'#toast-alert');
                        }
                    },error: function(){
                        $('#modal-save').modal('hide');
                        showToast('danger','Peringatan','Gagal! Database server error','#toast-alert');
                    }
                });
            });

            $('input.timepicker').timepicker({
                zindex:1090,
                timeFormat: 'HH:mm',
                minTime: new Date(0, 0, 0, 7, 0, 0),
                maxTime: new Date(0, 0, 0, 21, 0, 0),
                startTime: new Date(0, 0, 0, 7, 0, 0),
                interval: 10,
                scrollbar:true,
            });
    });
  
    function addKelasData(itemSelected = []){
        let kelas_data = [];
        let urlGetList = "{{ route('kelas.getkelas')}}";
        $('#kode_kelas').html('');
        $('#kode_kelas').append('');
        $.ajax({
            type: 'GET',
            url: urlGetList,
            success: function(response){ 
                var data = JSON.parse(response);
                for(var i=0;i<data.length; i++){
                    var kode = data[i].kode_kelas;
                    kelas_data.push(kode)
                    var opt = new Option(`${data[i].nama_kelas}`,kode);
                    if(jQuery.inArray(kode, itemSelected) >= 0){
                        opt.selected=true;
                    }
                    $('#kode_kelas').append(opt);
                }
            },error: function(){
                showToast('danger','Peringatan','Gagal! Database server error','#toast-alert');
            }
        });
    }
    function addMateriData(itemSelected = []){
        let materi_data = [];
        let urlGetList = "{{ route('kelas.getmateri')}}";
        $('#materi_id').html('');
        $('#materi_id').append('');
        $.ajax({
            type: 'GET',
            url: urlGetList,
            success: function(response){ 
                var data = JSON.parse(response);
                for(var i=0;i<data.length; i++){
                    var materi = data[i].id;
                    materi_data.push(materi)
                    var opt = new Option(`${data[i].nama_materi}`,materi);
                    if(jQuery.inArray(materi, itemSelected) >= 0){
                        opt.selected=true;
                    }
                    $('#materi_id').append(opt);
                }
            },error: function(){
                showToast('danger','Peringatan','Gagal! Database server error','#toast-alert');
            }
        });
    }

    function addData(){
        $('#form-save .modal-title').text("Tambah Data");
        $('#form-save').attr('tipe','add');
        addKelasData();
        addMateriData();
    }
    function editData(id){
            $('#form-save .modal-title').text("Edit Data");
            $('#form-save').attr('tipe','edit');
            let urlEdit = "{{ route('jadwal.detail',':id')}}";
            $.ajax({
                type:'GET',
                url: urlEdit.replace(':id',id),
                success:function(response){
                    var resp = JSON.parse(response);
                    var data = resp.jadwal;
                    $('#form-save').find('#id_jadwal').val(data.id);
                    $('#form-save').find('input#nama_jadwal').val(data.nama_jadwal);
                    $('#form-save').find('input#kode_jadwal').val(data.kode_jadwal);
                    $('#form-save').find('input#link_jadwal').val(data.link_jadwal);
                    $('#form-save').find('textarea#deskripsi').val(data.deskripsi);

                    $('#modal-save').modal('show');
                }
            });
        }
    
    function hapusData(id){
        let urlDelete = "{{ route('jadwal.delete',':id')}}";
        $("#confirm-delete").modal('show');
        $('#confirm-delete').find('form').attr('action',urlDelete.replace(':id', id));
    }
</script>
@endsection
