@extends('layouts.app')
@section('extrahead')
    <title>Simasndan Web Apps - Data Jadwal Page</title>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/css/select2bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/timepicker/jquery.timepicker.min.css') }}">
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
            <th>Waktu Mulai Jadwal</th>
            <th>Absensi Santri</th>
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

<!-- modal detail -->
<div class="modal fade" id="modal-detail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg sld-up" role="document">
        <div class="modal-content">
        <div class="modal-header border-bottom">
            <h5 class="modal-title">Detail Data</h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
        </div>
        <div class="modal-body p-4"> 
            <div id="form-detail">
                <div class="form-group row">
                    <label for="kegiatan" class="col-sm-4">Kegiatan</label>
                    <div class="col-sm-8">
                        <span id="kegiatan"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kelas" class="col-sm-4">Kelas</label>
                    <div class="col-sm-8">
                        <span id="kelas"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="waktu_mulai" class="col-sm-4">Waktu Mulai</label>
                    <div class="col-sm-8">
                        <span id="waktu_mulai"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sistem_penilaian" class="col-sm-4">Sistem Penilaian</label>
                    <div class="col-sm-8">
                        <span id="sistem_penilaian"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_materi" class="col-sm-4">Materi</label>
                    <div class="col-sm-8">
                        <span id="nama_materi"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="semester" class="col-sm-4">Semester</label>
                    <div class="col-sm-8">
                        <span id="semester"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="waktu_dibuat" class="col-sm-4">Dibuat</label>
                    <div class="col-sm-8">
                        <span id="waktu_dibuat"></span>
                    </div>
                </div>
                
            </div>
        </div>
        </div>
    </div>
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
                        name="kode_kelas" style="width:100%">
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
                    <label for="semester_id" class="form-label">Semester</label>
                    <select class="form-control form-select js-select2" id="semester_id"
                        name="semester_id" style="width:100%">
                    </select>
                </div>
                
                <div class="col-12 mb-3">
                    <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                        <input type="text" class="form-control timepicker" id="waktu_mulai" 
                        name="waktu_mulai" placeholder="07:00" readonly>
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
        $('.timepicker').timepicker({
                zindex:1090,
                timeFormat: 'HH:mm',
                minTime: new Date(0, 0, 0, 7, 0, 0),
                maxTime: new Date(0, 0, 0, 21, 0, 0),
                startTime: new Date(0, 0, 0, 7, 0, 0),
                interval: 10,
                dropdown:true,
                scrollbar:true
        });
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
                    render: function(data, type, row, meta) {
                        return data.substring(0,16);
                    }
                },
                {
                    'data': 'id', 
                    'className':"text-center",
                    'orderable': false,
                    render: function(data, type, row, meta) {
                        let urlAbsenkan = "{{route('absenkan',':id')}}";
                        let now = moment().format('YYYY-MM-DD HH:mm:ss');
                        if(moment(now).isAfter(moment(row.waktu_mulai))){
                            return `<a href="${urlAbsenkan.replace(':id',data)}" type="button" class="btn btn-outline-success rounded-3">
                                    Absenkan <i class="bx bx-sm bx-check-square"></i>
                                </a>`;
                        }else{
                            return `<button class="btn btn-outline-secondary rounded-3" disabled readonly>
                                    Absenkan <i class="bx bx-sm bx-check-square"></i>
                                </button>`;
                        }
                    },   
                },       
                {
                    'data': 'id', 
                    'className':"text-center",
                    'orderable': false,
                    render: function(data, type, row, meta) {
                        let now = moment().format('YYYY-MM-DD HH:mm:ss');
                        var btnEdit = '';            
                        if(moment(now).isBefore(moment(row.waktu_mulai))){
                            btnEdit = `<button onclick="editData('${data}')" type="button" class="btn rounded-pill btn-icon 
                                btn-warning" title="edit data">
                                    <span class="tf-icons bx bx-edit-alt"></span>
                                </button>`;
                        }else{
                            btnEdit = `<button type="button" class="btn rounded-pill btn-icon 
                                btn-secondary" title="edit data" disabled readonly>
                                    <span class="tf-icons bx bx-edit-alt"></span>
                                </button>`;
                        }

                    return `<button onclick="detailData('${data}')" type="button" class="btn rounded-pill 
                            btn-icon btn-primary" title="detail data">
                                <span class="tf-icons bx bxs-detail"></span>
                            </button>
                            ${btnEdit}
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
    });
  
    function addKelasData(itemSelected = ''){
        let kelas_data = [];
        let urlGetList = "{{ route('jadwal.getkelas')}}";
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
                    if(itemSelected == kode){
                        opt.selected=true;
                    }
                    $('#kode_kelas').append(opt);
                }
            },error: function(){
                showToast('danger','Peringatan','Gagal! Database server error','#toast-alert');
            }
        });
    }
    function addMateriData(itemSelected = ''){
        let materi_data = [];
        let urlGetList = "{{ route('jadwal.getmateri')}}";
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
                    if(itemSelected == materi){
                        opt.selected=true;
                    }
                    $('#materi_id').append(opt);
                }
            },error: function(){
                showToast('danger','Peringatan','Gagal! Database server error','#toast-alert');
            }
        });
    }

    function addSemesterData(itemSelected = ''){
        let semester_data = [];
        let urlGetList = "{{ route('jadwal.getsemester')}}";
        $('#semester_id').html('');
        $('#semester_id').append('');
        $.ajax({
            type: 'GET',
            url: urlGetList,
            success: function(response){ 
                var data = JSON.parse(response);
                for(var i=0;i<data.length; i++){
                    var semester = data[i].id;
                    semester_data.push(semester)
                    var opt = new Option(`Semester ke-${data[i].semester} (${data[i].tahun_pelajaran})`,semester);
                    if(itemSelected == semester){
                        opt.selected=true;
                    }
                    $('#semester_id').append(opt);
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
        addSemesterData();
    }
    function detailData(id){
        let urlDetail = "{{ route('jadwal.detail',':id')}}";
        $.ajax({
            type:'GET',
            url: urlDetail.replace(':id',id),
            success:function(response){
                var resp = JSON.parse(response);
                var data = resp.jadwal;
                    $('#form-detail').find('span#kegiatan').text(data.kegiatan);
                    $('#form-detail').find('span#kelas').text(`${data.kode_kelas} - ${data.nama_kelas}`);
                    $('#form-detail').find('span#waktu_mulai').html(data.waktu_mulai);
                    $('#form-detail').find('span#sistem_penilaian').text(data.sistem_penilaian);
                    $('#form-detail').find('span#nama_materi').text(data.nama_materi);
                    $('#form-detail').find('span#semester').text(`Semester ke-${data.semester} (${data.tahun_pelajaran})`);
                    $('#form-detail').find('span#waktu_dibuat').text(data.created_at);

                    $('#modal-detail').modal('show');
            }
        });
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
                var splittedTime = data.waktu_mulai.split(' ');
                var waktuMulai = splittedTime[1].substr(0,5);
                $('#form-save').find('#id_jadwal').val(data.id);
                $('#form-save').find('input#kegiatan').val(data.kegiatan);
                addKelasData(data.kode_kelas);
                addMateriData(data.materi_id);
                addSemesterData(data.semester_id);
                $('#form-save').find('select#sistem_penilaian').val(data.sistem_penilaian);
                $('#form-save').find('input#waktu_mulai').val(waktuMulai);

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
