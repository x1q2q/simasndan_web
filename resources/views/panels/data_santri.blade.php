@extends('layouts.app')
@section('extrahead')
<meta name="_token" content="{{csrf_token()}}" />
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">umum /</span> Data Santri </h4>
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
                Tambah Santri <i class="bx bx-sm bxs-plus-circle"></i>
            </button>
        </div>
    </div>
    <form class="nopadding" action="" method="post" enctype="multipart/form-data" onsubmit="return false;">
        @csrf
        <div class="row p-2 bg-light m-0">
            <div class="col-9">
                <div class="input-group input-group-merge">
                    <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                    <input type="text" class="form-control" id="s_keyword" 
                    name="s_keyword" placeholder="Cari di sini ..." aria-label="Search..." aria-describedby="basic-addon-search31">
                </div>
            </div>   
            <div class="col-3">
                <select class="form-control form-select" 
                id="s_status" name="s_status">
                    <option value="all">-- semua tingkatan --</option>
                    <option value="ula">Ula</option>
                    <option value="ulya">Ulya</option>
                    <option value="wustho">Wustho</option>
                </select>
            </div>
        </div>
      
        <div class="form-group row" style="display: none;">
            <div class="col">
                <button type="submit" class="btn btn-alt-primary">Cari</button>
            </div>
        </div>
    </form>
    <div class="table-responsive text-wrap">
        <table class="table table-striped table-responsive" id="datatable-santri">
        <thead>
            <tr>
            <th>No.</th>
            <th style="width: 20%;">Nama Santri</th>
            <th style="width: 20%;">Jenis Kelamin</th>
            <th style="width: 20%;">Tingkatan</th>
            <th>Alamat</th>
            <th style="width: 20%;">Aksi</th>
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
                    <label for="username" class="col-sm-4">Username</label>
                    <div class="col-sm-8">
                        <span id="username"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_santri" class="col-sm-4">Nama Santri</label>
                    <div class="col-sm-8">
                        <span id="nama_santri"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jenis_kelamin" class="col-sm-4">Jenis Kelamin</label>
                    <div class="col-sm-8">
                        <span id="jenis_kelamin"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-4">Email</label>
                    <div class="col-sm-8">
                        <span id="email"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nomor_hp" class="col-sm-4">Nomor HP</label>
                    <div class="col-sm-8">
                        <span id="nomor_hp"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="ttl" class="col-sm-4">TTL</label>
                    <div class="col-sm-8">
                        <span id="ttl"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tingkatan" class="col-sm-4">Tingkatan</label>
                    <div class="col-sm-8">
                        <span id="tingkatan"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="universitas" class="col-sm-4">Universitas</label>
                    <div class="col-sm-8">
                        <span id="universitas"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alamat" class="col-sm-4">Alamat</label>
                    <div class="col-sm-8">
                        <span id="alamat"></span>
                    </div>
                </div>
                <div class="form-group row">	
                    <label for="foto" class="col-sm-4">Foto</label>	
                    <div class="col-sm-8">	
                        <div id="foto">
                        </div>	
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
        <input type="hidden" id="id_santri" name="id_santri"/>
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
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" 
                    placeholder="Masukkan username santri"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3 form-password-toggle">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password" class="form-control" name="password" placeholder="" aria-describedby="password" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>                          
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="is_pengurus" class="form-label">Status Pengurus</label>
                        <select class="form-control form-select" 
                            id="is_pengurus" name="is_pengurus" style="width: 100%;">
                            <option value="0">Bukan pengurus</option>
                            <option value="1">Pengurus</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                    <label for="nama_santri" class="form-label">Nama Santri</label>
                    <input type="text" class="form-control" name="nama_santri" id="nama_santri" 
                    placeholder="Masukkan nama santri"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-control form-select" 
                            id="jenis_kelamin" name="jenis_kelamin" style="width: 100%;">
                            <option value="">-- pilih jenis kelamin --</option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="tingkatan" class="form-label">Tingkatan</label>
                        <select class="form-control form-select" 
                            id="tingkatan" name="tingkatan" style="width: 100%;">
                            <option value="">-- pilih tingkatan --</option>
                            <option value="ula">Ula</option>
                            <option value="ulya">Ulya</option>
                            <option value="wustho">Wustho</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12 mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" rows="3" 
                    placeholder="Masukkan alamat" name="alamat" id="alamat"></textarea>
                    </div>
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
        var dtableSantri = $('#datatable-santri').DataTable({
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
                    'data': 'nama_santri',
                    'className': "text-center",
                    'orderable': false,
                },
                {
                    'data': 'jenis_kelamin',
                    'className': "text-center",
                    'orderable': false,
                },
                {
                    'data': 'tingkatan',
                    'className': "text-center",
                    'orderable': false,
                },
                {
                    'data': 'alamat',
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
                "url": "{{route('santri.lists')}}",
                "type": "POST",
                'data': function(data) {
                    data.s_keyword = $('#s_keyword').val();
                    data.s_status = $('#s_status option:selected').val()

                    data._token =  "{{ csrf_token() }}";
                }
            }
        });

        dtableSantri.on( 'draw', function () {
            var total_records = dtableSantri.rows().count();
            var page_length = dtableSantri.page.info().length;
            var total_pages = Math.ceil(total_records / page_length);
            var current_page = dtableSantri.page.info().page+1;
        });

        $('#s_keyword').keyup(function() {
            dtableSantri.draw();
        });

        $('#s_status').on('change', function() {
            dtableSantri.draw();
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
                let siteUrl = "{{ route('santri') }}";
                let formData = new FormData(this);
                let idSantri = $('#form-save').find('#id_santri').val();
                let urlPost =  ($(this).attr('tipe') == 'add') ? 
                    `${siteUrl}/insert`: `${siteUrl}/update`;

                formData.append('id',idSantri)
                resetValidationError(); // agar bisa mengambil kondisi field terbaru
                console.log(urlPost);
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
                            dtableSantri.draw();
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
  
    
    function addData(){
        $('#form-save .modal-title').text("Tambah Data");
        $('#form-save').attr('tipe','add');
    }
    function editData(id){
            $('#form-save .modal-title').text("Edit Data");
            $('#form-save').attr('tipe','edit');
            let urlEdit = "{{ route('santri.detail',':id')}}";
            $.ajax({
                type:'GET',
                url: urlEdit.replace(':id',id),
                success:function(response){
                    var resp = JSON.parse(response);
                    var data = resp.santri;
                    $('#form-save').find('#id_santri').val(data.id);
                    $('#form-save').find('input#username').val(data.username);
                    $('#form-save').find('input#password').val('');
                    $('#form-save').find('select#is_pengurus').val(data.is_pengurus);
                    $('#form-save').find('input#nama_santri').val(data.nama_santri);
                    $('#form-save').find('select#jenis_kelamin').val(data.jenis_kelamin);
                    $('#form-save').find('select#tingkatan').val(data.tingkatan);
                    $('#form-save').find('textarea#alamat').val(data.alamat);

                    const inputTag = 'form#form-save #password';
                    $(inputTag).addClass('is-invalid');
                    if(!$(inputTag).parent().find('.invalid-feedback').length){
                        $(inputTag).parent().append(
                            `<div class="invalid-feedback text-secondary"> kosongkan jika tidak ingin mengupdate password!</div>`);
                        }

                    $('#modal-save').modal('show');
                }
            });
        }
    function detailData(id){
        let urlDetail = "{{ route('santri.detail',':id')}}";
        let urlPathThumb = "{{ asset('assets/img/upload/santri') }}";
        $.ajax({
            type:'GET',
            url: urlDetail.replace(':id',id),
            success:function(response){
                var resp = JSON.parse(response);
                var data = resp.santri;
                $('#form-detail').find('span#username').text('@'+data.username);
                $('#form-detail').find('span#nama_santri').text(data.nama_santri);
                $('#form-detail').find('span#email').text(data.email);
                $('#form-detail').find('span#nomor_hp').text(data.nomor_hp);
                $('#form-detail').find('span#ttl').text(data.tempat_lahir + ', ' + data.tgl_lahir);
                $('#form-detail').find('span#jenis_kelamin').text(data.jenis_kelamin);
                $('#form-detail').find('span#tingkatan').text(data.tingkatan);
                $('#form-detail').find('span#universitas').text(data.universitas);
                $('#form-detail').find('span#alamat').text(data.alamat);
                if(data.foto != '-'){
                    $('#form-detail').find('#foto').html(
                            `<img class="img-fluid rounded" src="${urlPathThumb}/${data.foto}" alt="">`);
                }else{
                    $('#form-detail').find('#foto').html('-');
                }
                $('#modal-detail').modal('show');
            }
        });
    }
    function hapusData(id){
        let urlDelete = "{{ route('santri.delete',':id')}}";
        $("#confirm-delete").modal('show');
        $('#confirm-delete').find('form').attr('action',urlDelete.replace(':id', id));
    }
</script>
@endsection