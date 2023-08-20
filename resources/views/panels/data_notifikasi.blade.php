@extends('layouts.app')
@section('extrahead')
    <title>Simasndan Web Apps - Data notifikasi Page</title>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/css/select2bootstrap.min.css') }}">
    <meta name="description" content="Data Notifikasi Page Sistem Informasi Manajemen Santri Al-Windan" />
    <meta name="_token" content="{{csrf_token()}}" />
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">umum /</span> Data Notifikasi </h4>
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
                Tambah Kustom Notifikasi <i class="bx bx-sm bxs-plus-circle"></i>
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
        <table class="table table-striped table-responsive" id="datatable-notifikasi">
        <thead>
            <tr>
            <th>No.</th>
            <th>Judul</th>
            <th>Pesan</th>
            <th>Tipe Notif</th>
            <th>Dibuat</th>
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
        <input type="hidden" id="id_notifikasi" name="id_notifikasi"/>
            <div class="modal-header border-bottom">
                <h5 class="modal-title"></h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pb-0">
                <div class="row pb-3">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="switchbtn" id="btnradio1" autocomplete="off" onClick="switchValue()" checked>
                        <label class="btn btn-outline-secondary" for="btnradio1">Per-santri</label>
                        <input type="radio" class="btn-check" name="switchbtn" id="btnradio2" autocomplete="off" onClick="switchValue()">
                        <label class="btn btn-outline-secondary" for="btnradio2">Per-kelas</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                    <label for="judul" class="form-label">Judul Notifikasi</label>
                    <input type="text" class="form-control" name="judul" 
                        id="judul" placeholder="Masukkan judul notif"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                    <label for="pesan" class="form-label">Pesan Notifikasi</label>
                    <textarea class="form-control" rows="2" 
                        placeholder="Masukkan isi pesan notif" name="pesan" id="pesan"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                    <label for="tipe" class="form-label">Tipe Notifikasi</label>
                    <select class="form-control form-select" 
                        id="tipe" name="tipe" style="width: 100%;">
                        <option value="">-- pilih tipe notif --</option>
                        <option value="jadwal">Jadwal</option>
                        <option value="kelas">Kelas</option>
                        <option value="pengumuman">Pengumuman</option>
                    </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="" class="form-label">Audiens</label>
                        <div id="audiens"></div>
                    </div>
                </div>
                
            <div class="modal-footer py-4 px-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-success" id="btn-save">Simpan & Kirim Notifikasi 
                    <span class="tf-icons bx bxs-send"></span>
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
    var urlPhoto = "{{ asset('assets/img/uploads/notifikasi') }}";
    switchValue();
    $(function () {
        $('.js-select2-multiple').select2({
            placeholder: "Pilih",
            allowClear: true,
            theme: "bootstrap",
            dropdownParent: $('#modal-save'),
        });
        $('.js-select2').select2({
            placeholder: "Pilih",
            allowClear: true,
            theme: "bootstrap",
            dropdownParent: $('#modal-save'),
        })
    });
    $(document).ready(function(){
        var dtableNotifikasi = $('#datatable-notifikasi').DataTable({
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
                    'data': 'judul',
                    'className': "text-center",
                    'orderable': false,
                },
                {
                    'data': 'pesan',
                    'className': "text-center",
                    'orderable': false,
                },
                {
                    'data': 'tipe',
                    'className': "text-center",
                    'orderable': false,
                    render: function(data, type, row, meta) {
                        return data;
                    }
                },
                {
                    'data': 'created_at',
                    'className': "text-center",
                    'orderable': false,
                },
            ],
            "rowCallback": function( row, data, index ) {
            },
            columnDefs: [
            ],
            "ajax": {
                "url": "{{route('notifikasi.lists')}}",
                "type": "POST",
                'data': function(data) {
                    data.s_keyword = $('#s_keyword').val();

                    data._token =  "{{ csrf_token() }}";
                }
            }
        });

        dtableNotifikasi.on( 'draw', function () {
            var total_records = dtableNotifikasi.rows().count();
            var page_length = dtableNotifikasi.page.info().length;
            var total_pages = Math.ceil(total_records / page_length);
            var current_page = dtableNotifikasi.page.info().page+1;
        });

        $('#s_keyword').keyup(function() {
            dtableNotifikasi.draw();
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
                let siteUrl = "{{ route('notifikasi') }}";
                let formData = new FormData(this);
                let idnotifikasi = $('#form-save').find('#id_notifikasi').val();
                let urlPost = `${siteUrl}/insert`;
                let audienType = $('#btnradio1').is(":checked") ? 'santri': 'kelas';

                formData.append('id',idnotifikasi);
                formData.append('tipe_audiens',audienType);
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
                            dtableNotifikasi.draw();
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

    function addSantriData(itemSelected = []){
        let santri_data = [];
        let urlGetList = "{{ route('kelas.getsantri')}}";
        $('#santri_data').html('');
        $('#santri_data').append('');
        $.ajax({
            type: 'GET',
            url: urlGetList,
            success: function(response){ 
                var data = JSON.parse(response);
                for(var i=0;i<data.length; i++){
                    var santri = data[i].id;
                    if(isNotEmptyValue(data[i].fcm_token)){
                        santri_data.push(santri)
                        var opt = new Option(data[i].nama_santri,santri);
                        if(jQuery.inArray(santri, itemSelected) >= 0){
                            opt.selected=true;
                        }
                        $('#santri_data').append(opt);
                    }                    
                }
            },error: function(){
                showToast('danger','Peringatan','Gagal! Database server error','#toast-alert');
            }
        });
    }
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
    function switchValue(){
        var selectKelas = `<select class="form-control form-select js-select2" id="kode_kelas"
                            name="kode_kelas" style="width:100%" autofocus="true">
                        </select>`;
        var selectSantri = `<select class="form-control form-select js-select2-multiple" id="santri_data"
                            name="santri_data[]" multiple="multiple" style="width:100%" autofocus="true">
                        </select>`;
        var checkedValSantri = $('#btnradio1').is(":checked");
        var checkedValKelas = $('#btnradio2').is(":checked");
        if(checkedValSantri){
            addElementToAudiens(selectSantri);
            addSantriData();
            $('#santri_data').val(null).trigger('change');
        }else if(checkedValKelas){
            addElementToAudiens(selectKelas);
            addKelasData();
        }
    }
    function addElementToAudiens(elem){
        $('#audiens').empty();
        $('#audiens').html(elem);
    }
    function addData(){
        $('#form-save .modal-title').text("Tambah Data");
        $('#form-save').attr('tipe','add');
        addSantriData();
        addKelasData();
    }
</script>
@endsection
