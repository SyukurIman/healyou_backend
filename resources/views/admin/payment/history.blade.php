<div class="col mb-md-0 mb-4">
    <div class="card">
      <div class="card-header pb-0">
        <div class="row">
          <div class="col-lg-6 col-7">
            <h6>Histori Pembayaran</h6>
            <p class="text-sm mb-0">
              <i class="fa fa-check text-info" aria-hidden="true"></i>
              <span class="font-weight-bold ms-1">{{ $payment_history }} Transaksi</span> Secara
              Keseluruhan
            </p>
          </div>
          <div class="col-lg-6 col-5 my-auto text-end">
            <div class="dropdown float-lg-end pe-4">
              <a
                class="cursor-pointer"
                id="dropdownTable"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="fa fa-ellipsis-v text-secondary"></i>
              </a>
              <ul
                class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5"
                aria-labelledby="dropdownTable"
              >
                <li>
                  <a
                    class="dropdown-item border-radius-md"
                    href="javascript:;"
                    >Action</a
                  >
                </li>
                <li>
                  <a
                    class="dropdown-item border-radius-md"
                    href="javascript:;"
                    >Another action</a
                  >
                </li>
                <li>
                  <a
                    class="dropdown-item border-radius-md"
                    href="javascript:;"
                    >Something else here</a
                  >
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body m-3 px-2 p-2">
        <div class="table-responsive ">
          <table class="table align-items-center mb-0" id="table" style="width: 100%">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    No
                </th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Aksi
                </th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                  Nama User
                </th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Nama Donasi
                </th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                    Tanggal
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Nominal
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Status Pembayaran
                </th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>