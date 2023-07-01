@extends('layouts.app')
@section('extrahead')
    <title>Simasndan Web Apps - Data Admin Page</title>
    <meta name="description" content="Dashboard Page Sistem Informasi Manajemen Santri Al-Windan" />
    <meta name="_token" content="{{csrf_token()}}" />
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">umum /</span> Data admin </h4>
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
                Tambah Admin <i class="bx bx-sm bxs-plus-circle"></i>
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
                    <option value="all">-- semua status --</option>
                    <option value="1">pengasuh</option>
                    <option value="0">bukan pengaush</option>
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
        <table class="table table-striped table-responsive" id="datatable-admin">
        <thead>
            <tr>
            <th>No.</th>
            <th style="width: 15%;">Username</th>
            <th style="width: 20%;">Nama admin</th>
            <th style="width: 15%;">Status Pengasuh</th>
            <th>Foto</th>
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

@include('layouts.modal_delete')

<!-- modal save -->
<div class="modal fade" id="modal-save" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog sld-up" role="document">
    <form action="" method="POST" id="form-save" class="modal-content" 
        tipe="" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="id_admin" name="id_admin"/>
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
                    placeholder="Masukkan username admin"/>
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
                    <label for="nama_admin" class="form-label">Nama admin</label>
                    <input type="text" class="form-control" name="nama_admin" id="nama_admin" 
                    placeholder="Masukkan nama admin"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="is_pengasuh" class="form-label">Status Pengasuh</label>
                        <select class="form-control form-select" 
                            id="is_pengasuh" name="is_pengasuh" style="width: 100%;">
                            <option value="0">Bukan Pengasuh</option>
                            <option value="1">Pengasuh</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="foto" class="form-label">Foto</label>
                        <div class="custom-file border-bottom p-2" id="foto">
                            <input type="file" name="foto" hidden class="form-control" accept=".png,.jpg,.jpeg" id="foto-file">
                            <input type="text" name="foto_file_name" value="" class="form-control" hidden id="foto-file-name" >
                            <label class="btn-secondary btn" for="foto-file" style="padding: 4px 10px">
                            <span class="tf-icons bx bxs-image-add"></span>
                                Pilih </label>
                            <label id="foto-file-name-label" for="foto-file">Tidak ada gambar yang dipilih</label>
                        </div>
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
    var urlPhoto = "{{ asset('assets/img/uploads/admin') }}";
    $(document).ready(function(){
        var dtableAdmin = $('#datatable-admin').DataTable({
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
                    'data': 'username',
                    'className': "text-center",
                    'orderable': false,
                },
                {
                    'data': 'nama_admin',
                    'className': "text-center",
                    'orderable': false,
                },
                {
                    'data': 'is_pengasuh',
                    'className': "text-center",
                    'orderable': false,
                    render: function(data, type, row, meta) {
                        var sttsPengasuh = (data == 1) ? 'Pengasuh' : 'Bukan Pengasuh';
                        
                        return sttsPengasuh;
                    }
                },
                {
                    'data': 'foto',
                    'className': "text-center",
                    'orderable': false,
                    render: function (data, type, row, meta) {
                            let attrImg = (isNotEmptyValue(data)) ? 
                                `<img src="${urlPhoto+'/'+data}" class="img-fluid rounded img-thumb">` : '-';
                            return attrImg;
                        }
                },              
                {
                    'data': 'id', 
                    'className':"text-center",
                    'orderable': false,
                    render: function(data, type, row, meta) {
                    return `<button onclick="editData('${data}')" type="button" class="btn rounded-pill btn-icon 
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
                "url": "{{route('admin.lists')}}",
                "type": "POST",
                'data': function(data) {
                    data.s_keyword = $('#s_keyword').val();
                    data.s_status = $('#s_status option:selected').val()

                    data._token =  "{{ csrf_token() }}";
                }
            }
        });

        dtableAdmin.on( 'draw', function () {
            var total_records = dtableAdmin.rows().count();
            var page_length = dtableAdmin.page.info().length;
            var total_pages = Math.ceil(total_records / page_length);
            var current_page = dtableAdmin.page.info().page+1;
        });

        $('#s_keyword').keyup(function() {
            dtableAdmin.draw();
        });

        $('#s_status').on('change', function() {
            dtableAdmin.draw();
        });

        $("#modal-save").on('hidden.bs.modal', function (e) {
            $('#form-save').trigger('reset');
            resetValidationError();
        });

        $('#foto-file').on('change', function (e) {
          let file = $('#foto-file')[0].files[0]
          let ukuran = file.size;
          let name = file.name;
          let type = file.type;
          var allowtypes = ['image/jpeg', 'image/jpg', 'image/png'];

          if (e.target.files.length > 0) {
            if(jQuery.inArray(type, allowtypes) >= 0 && ukuran <= 2000000){
                let newName = (name.length > 40) ? name.substr(-30):name;
                $('#foto-file-name').val('adm-'+newName);	
                $('#foto-file-name-label').html('adm-'+newName);
                if($('#btn-remove-img').length <= 0){
                    let btnRemoveImg = `<a id="btn-remove-img" onclick="removeImg(this)" 
                        class="btn btn-sm btn-outline-secondary btn-icon"> <span class="tf-icons bx bx-trash"></span></a>`;
                    $('#foto-file').parent().append(btnRemoveImg);
                }
            }else{
                if(jQuery.inArray(type, allowtypes) < 0) {
                    showToast('warning','Peringatan','Tipe file tidak diijinkan!','#toast-alert');
                }else if(ukuran > 2000000){
                    showToast('warning','Peringatan','File tidak boleh lebih dari 2MB','#toast-alert');
                }
                $('#foto-file-name-label').html("Tidak ada gambar yang dipilih");
                $('#foto-file').val('');
                removeImg('#btn-remove-img');
            }
          }
        });

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $('#form-save').submit(function(e){
                e.preventDefault();
                let siteUrl = "{{ route('admin') }}";
                let formData = new FormData(this);
                let idadmin = $('#form-save').find('#id_admin').val();
                let urlPost =  ($(this).attr('tipe') == 'add') ? 
                    `${siteUrl}/insert`: `${siteUrl}/update`;

                formData.append('id',idadmin)
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
                            dtableAdmin.draw();
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
  
    function removeImg(img){
        $('#foto-file-name-label').html("Tidak ada gambar yang dipilih");
        $('#foto-file').val('');
        $('#foto-file-name').val('');
        $(img).remove();
    }

    function addData(){
        $('#form-save .modal-title').text("Tambah Data");
        $('#form-save').attr('tipe','add');
    }
    function editData(id){
            $('#form-save .modal-title').text("Edit Data");
            $('#form-save').attr('tipe','edit');
            let urlEdit = "{{ route('admin.detail',':id')}}";
            $.ajax({
                type:'GET',
                url: urlEdit.replace(':id',id),
                success:function(response){
                    var resp = JSON.parse(response);
                    var data = resp.admin;
                    $('#form-save').find('#id_admin').val(data.id);
                    $('#form-save').find('input#username').val(data.username);
                    $('#form-save').find('input#password').val('');
                    $('#form-save').find('input#nama_admin').val(data.nama_admin);
                    $('#form-save').find('select#is_pengasuh').val(data.is_pengasuh);

                    if(isNotEmptyValue(data.foto)){
                        $('#form-save').find('input[name="foto_file_name"]').val(data.foto);
                        $('#form-save').find('#foto-file-name-label').text(data.foto);
                    }

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
    
    function hapusData(id){
        let urlDelete = "{{ route('admin.delete',':id')}}";
        $("#confirm-delete").modal('show');
        $('#confirm-delete').find('form').attr('action',urlDelete.replace(':id', id));
    }
</script>
@endsection
