<div class="row my-4">
    <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-7">
              <h6>Data Donasi</h6>
            </div>
            <div class="col-lg-6 col-5 my-auto text-end">
              <a href="{{ env('APP_URL') }}/admin/data_donasi/create" type="button" class="btn btn-primary btn-data" id="btn-create">
                <i class="fa fa-plus-square"></i> <span>Tambah</span>
              </a>
                <button class="btn btn-secondary btn-data" id="filter_btn"><i class="fas fa-filter"></i> <span>Filter</span></button>
                <button class="btn btn-warning btn-data" id="download_btn"><i class="fas fa-download"></i> <span>Download</span></button>
            </div>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive px-3">
            <table id="table" class="table stripe" style="width: 100%;">
                <thead>
                    <tr class="tr-table">
                        <th class="th-table" style="max-width: 20px;">No</th>
                        <th class="th-table" style="max-width: 50px;">Aksi</th>
                        <th class="th-table" style="max-width: 200px;">Judul</th>
                        <th class="th-table" style="max-width: 200px;">Batas Donasi</th>
                        <th class="th-table" style="max-width: 100px;">Deskripsi</th>
                        <th class="th-table" style="max-width: 100px;">target</th>
                        <th class="th-table" style="max-width: 100px;">gambar</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr>
                        <td colspan="99" class="text-center">Data Tidak Ditemukan</td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
      </div>
    </div>
</div>