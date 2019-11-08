@extends('layouts.app')

@section('content')
    
    <style type="text/css">
        #tabel-list tr td {
            vertical-align: middle;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <section class="content-header">
        <h1>
            Pembelian Baru
            <small>{{ date('d-m-Y H:i') }} </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><span class="fa fa-info"></span> Info</h3>
                    </div>

                    <div class="box-body">
                        <form action="" method="post">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="">No. Transaksi</label>
                                <input type="text" name="kode" id="no_pembelian" value="{{ $no_pembelian }}" autocomplete="off" class="form-control" readonly="readonly">
                            </div>
                            <!-- <div class="form-group">
                                <label for="">Pelanggan</label>
                                <input type="text" name="pelanggan" autocomplete="off" class="form-control">
                            </div> -->
                            <div class="form-group">
                                <label>Distributor</label>
                                <select name="distributor" id="distributor_id" class="form-control">
                                    <option value="0">Pilih Distributor</option>
                                    @foreach ($distributors as $distributor)
                                    <option value="{{ $distributor->id }}">{{ $distributor->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input type="text" name="tanggal" id="tanggal" autocomplete="off" class="date form-control">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="box">
                    <form class="form-horizontal" id="form-add">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <input type="hidden" name="id" id="barang_id">

                                            <input type="text" class="form-control" id="nama_barang" placeholder="Pilih Barang" readonly="readonly">

                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalBarang"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Qty</label>
                                        <div class="col-md-7">
                                            <input type="text" name="qty" class="form-control" id="qty">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Harga</label>
                                        <div class="col-md-8">
                                            <input type="text" name="harga" class="form-control money" autocomplete="off" id="harga2">

                                            <input type="text" hidden="true" id="harga">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-md btn-flat bg-maroon" id="btnAddList"><i class="fa fa-cart-plus"></i> Tambah ke List</button>
                                </div>
                            </div>
                           <!--  <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-md btn-flat bg-maroon" id="btnAddList"><i class="fa fa-cart-plus"></i> Tambah ke List</button>
                                    <button class="btn btn-md btn-flat btn-danger" id="btnCancelList" style="margin-left: 10px;"><i class="fa fa-close"></i> Cancel</button>
                                </div>
                            </div> -->
                        </div>
                    </form>

                    <div class="box-body">
                        <div id="tabel-menu">
                            <table class="table table-bordered table-stripped" id="tabel-list">
                                <tbody>
                                    <tr>
                                        <th style="text-align: center;">Nama Barang</th>
                                        <th style="text-align: center;">Harga</th>
                                        <th style="text-align: center;">Qty</th>
                                        <th style="text-align: center;">Sub Total</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                    <?php
                                    
                                        $total = 0;
                                        if (isset($session_order)) :
                                            // print_r($session_order);
                                            foreach ($session_order as $key => $value) :
                                                $data = DB::table('ref_barang')->where('id', $value['id'])->first();
                                                $subtotal = $value['harga'] * $value['qty'];
                                                $total += $subtotal;
                                                // $ppn = ($total * 10) / 100;
                                                // $grandtotal = $total + $ppn;
                                            ?>
                                            <tr>
                                                <td>{{ $data->nama_barang }}</td>
                                                <td style="text-align: right;">{{ number_format($value['harga'],0,",",".") }}</td>
                                                <td style="text-align: center;">{{ $value['qty'] }}</td>
                                                <td style="text-align: right;">{{ number_format($subtotal,0,",",".") }}</td> 
                                                <td id="tbody" style="text-align: center;">
                                                    <button class="btn btn-sm btn-danger btnRemoveList" data-id="<?= $data->id ?>" title="Hapus"><i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php endforeach ;
                                        endif ;
                                    ?>
                                </tbody>
                            </table>

                            <h3 style=" margin-right: 20px;">
                                <input type="text" hidden="true" id="total" value="{{ $total }}">
                                <b class="pull-right"><?= number_format($total,0,",",".") ?></b>
                                <span><b>Total</b></span>
                            </h3>
                            
                        </div>
                    </div>

                    <div class="box-body">
                        <!-- <form class="form-horizontal">
                            <div class="col-md-7">
                                
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Bayar</label>
                                    <div class="col-md-9">
                                        <input type="text" name="harga" class="form-control money" id="uang-bayar" style="text-align: right; font-weight: 800;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-7"></div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Kembali</label>
                                    <div class="col-md-9">
                                        <input type="text" name="harga" class="form-control" id="uang-kembali" style="text-align: right; font-weight: 800;">
                                    </div>
                                </div>
                            </div>

                            <input type="text" hidden="true" id="uang_bayar">
                            <input type="text" hidden="true" id="uang_kembali">

                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button class="btn btn-flat btn-primary pull-right" id="btn-save" style="margin-right: 16px;"><i class="fa fa-save"></i> Selesai</button>
                                </div>
                            </div>
                        </form> -->
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button class="btn btn-flat btn-primary pull-right" id="save_beli" style="margin-right: 0px;"><i class="fa fa-save"></i> Selesai</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <div class="modal fade" id="modalBarang"  tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal-title">Daftar Menu</h4>
                </div>
                <div class="modal-body" id="modal-body">
                    <table class="table table-bordered table-stripped tabel-json">
                        <thead>
                            <tr>
                                <!-- <th style="text-align: center;">Kode Menu</th> -->
                                <th style="text-align: center;">Nama Barang</th>
                                <th style="text-align: center;">Stok</th>
                                <th style="text-align: center;">Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach(\App\RefBarang::all() as $data): ?>
                            <tr>
                                <td>
                                    {{ $data->nama_barang }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $data->stok }}
                                </td>
                                <td style="text-align: center;">
                                    <button class="btn btn-small btn-success btn-pilih" data-id="{{ $data->id }}" data-barang="{{ $data->nama_barang }}" data-stok="{{ $data->stok }}" title="Pilih">
                                        <i class="fa fa-hand-pointer-o"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer" id="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
 
@endsection


@push('scripts')
<script>
$(document).ready(function() {
    $('.tabel-json').DataTable();
});

$(document).on('click', '#save_beli', function(e) {
    e.preventDefault();

    var no_pembelian    = $('#no_pembelian').val();
    var distributor_id  = $('#distributor_id').val();
    var tanggal  = $('#tanggal').val();
    var total           = $('#total').val();

    if (distributor_id == 0) {
        alert ('Silahkan Pilih Distributor !');
    }
    else if (total == 0) {
        alert ('Data tidak tersedia !');
    }
    else if (tanggal == '') {
        alert ('Silahkan Pilih Tanggal !');
    }
    else {
        $.ajax({
            type: "GET",
            url: "save-transaction",
            data: {
                'no_pembelian' : no_pembelian,
                'distributor_id' : distributor_id,
                'tanggal' : tanggal,
                'total' : total,
            },
            success: function(data){
                // window.open('print-order/' + no_penjualan + '/' + uang_bayar + '/' + uang_kembali, '_blank');

                window.location = "{{ url('ta-pembelian/new-transaction') }}";
            },
        });
    }
});
</script>
@endpush