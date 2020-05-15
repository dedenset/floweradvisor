<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Kode Diskon</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="kupon/{{ $trolis->id }}">
      <div class="modal-body">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" aria-describedby="basic-addon1" name="kodekupon" id="kodekupon" placeholder="Masukan Kode Kupon">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-warning">Terapkan</button>
      </div>
      </form>
    </div>
  </div>
</div>