@extends('admin/layouts/app')
@section('title', 'List Data Transaksi')
@section('content')
 <!-- Page content -->
 <div class="container-fluid mt--6">
    <div class="row">
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
            <h3 class="mb-0">List Data Transaksi</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush" id="data">
              <thead class="thead-light">
                <tr>
                  <th scope="col" class="sort" data-sort="name">No.</th>
                  <th scope="col" class="sort" data-sort="budget">Nama User</th>
                  <th scope="col" class="sort" data-sort="status">Alamat</th>
                  <th scope="col">Total Bayar</th>
                  <th scope="col" class="sort" data-sort="completion">Bukti</th>
                  <th scope="col">Atas Nama</th>
                  <th scope="col">Status</th>
                  <th scope="col">Konfirmasi</th>
                </tr>
              </thead>
              <tbody class="list">
                  @php
                      $no = 1;
                  @endphp
                  @foreach ($transaksi as $t)
                  <tr>
                    <th scope="row"><?= $no++ ?></th>
                    <td class="budget"><?= $t->user->name ?></td>
                    <td><?= $t->alamat ?></td>
                    <td>Rp. <?= $t->total_bayar ?></td>
                    <td><a class="btn btn-primary" target="_blank" href="<?= url('buktiTF/', $t->bukti) ?>">Lihat</a></td>
                    <td class="text-right"><?= $t->atas_nama ?></td>
                    <td class="text-right">
                        @if ($t->status == 0)
                            <span class="badge badge-warning">Belum Dikonfirmasi</span>
                            @elseif ($t->status == 1)
                            <span class="badge badge-success">Dikonfirmasi</span>
                        @endif
                    </td>
                    <td>
                        @if ($t->status == 0)
                            <button class="btn btn-primary" data-toggle="modal" data-target="#konfirmasi<?= $t->id ?>">Konfirmasi</button>
                            @else
                            -                            
                        @endif
                    </td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
          <!-- Card footer -->
        </div>
      </div>
    </div>
@endsection

{{-- Modal Konfirmasi --}}
@foreach ($transaksi as $t)
<div class="modal fade" id="konfirmasi<?= $t->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= route('admin.transaksi.update', $t->id) ?>" method="post">
            @csrf
            @method('PUT')
            <div class="modal-body">
              Konfirmasi transaksi ini ?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Konfirmasi</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  @endforeach
