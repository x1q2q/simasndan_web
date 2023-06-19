<div class="modal fade" id="confirm-delete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered sld-up" role="document">
        <form class="modal-content" method="POST" action="" id="form-delete">
        @csrf
        @method('DELETE')
        <div class="modal-header border-bottom">
            <h5 class="modal-title">Yakin untuk menghapus data?</h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
        </div>
        <div class="modal-body p-4 pb-0"> 
            <p>Data yang dihapus tidak akan bisa dikembalikan lagi</p> 
        </div>    
        <div class="modal-footer p-4 pt-0">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <input type="submit" id="delete-button" class="btn btn-danger" value="Ya, Hapus">
        </div>
        </form>
    </div>
</div>