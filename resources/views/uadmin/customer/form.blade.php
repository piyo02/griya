@extends( 'layouts.admin.app' )

@section('sidebar')
    <?= $sidebar = ( isset( $sidebar ) ) ? $sidebar : ''  ?>
@endsection

@section('content')
<?php
    $customer = isset($customer) ? $customer : (object) array();
?>
<section class="content-header">
    <h1 class="m-0 text-dark"><?= $page_title = ( isset( $page_title ) ) ? strtoupper( $page_title ) : ''  ?></h1>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="box">
                    <form action="{{ $url }}" method="{{ $method }}">
                        <?php if($edit): ?>
                            @method('put')
                        <?php endif; ?>
                        @csrf
                        <div class="box-header">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <h5 class="box-title">
                                        <?= $header = ( isset( $header ) ) ? strtoupper( $header ) : ''  ?>
                                        <p class="text-secondary"><small><?= $sub_header = ( isset( $sub_header ) ) ? $sub_header : ''  ?></small></p>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                @if(!isset($customer->id))
                                <div class="form-group has-feedback @error('date') has-error @enderror">
                                    <label for="date">Tanggal</label>
                                    <input type="date" class="form-control datepicker" name="date" id="date" placeholder="Tanggal" value="<?= isset($customer->date) ? $customer->date : old('date') ?>">
                                    @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group has-feedback @error('time') has-error @enderror">
                                    <label for="time">Waktu</label>
                                    <input type="text" class="form-control timepicker" name="time" id="time" placeholder="Waktu" value="<?= isset($customer->time) ? $customer->time : old('time') ?>">
                                    @error('time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @endif
                                <div class="form-group has-feedback @error('name') has-error @enderror">
                                    <label for="name">Nama Pelanggan</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Nama Pelanggan" value="<?= isset($customer->name) ? $customer->name : old('name') ?>">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group has-feedback @error('phone') has-error @enderror">
                                    <label for="phone">Nomor Telepon</label>
                                    <input type="number" class="form-control" name="phone" id="phone" placeholder="Nomor Telepon" value="<?= isset($customer->phone) ? $customer->phone : old('phone') ?>">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group has-feedback @error('job') has-error @enderror">
                                    <label for="job">Pekerjaan</label>
                                    <input type="text" class="form-control" name="job" id="job" placeholder="Pekerjaan" value="<?= isset($customer->job) ? $customer->job : old('job') ?>">
                                    @error('job')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group has-feedback @error('cluster_id') has-error @enderror">
                                    <?php $cluster_id = isset($customer->cluster_id) ? $customer->cluster_id : old('cluster_id')  ?>
                                    <label for="cluster_id">Blok Kluster</label>
                                    <select class="form-control" name="cluster_id" id="cluster_id">
                                        @foreach($clusters as $key => $cluster)
                                            <option value="{{ $key }}" {{ $cluster_id == $key ? "selected" : "" }}>{{ $cluster }}</option>
                                        @endforeach
                                    </select>
                                    @error('cluster_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group has-feedback @error('method_payment') has-error @enderror">
                                    <?php $method_payment = isset($customer->method_payment) ? $customer->method_payment : old('method_payment')  ?>
                                    <label for="method_payment">Metode Pembayaran</label>
                                    <select class="form-control" name="method_payment" id="method_payment" onchange="changeMethodPayment()">
                                        <option value="Kredit" {{ $method_payment == "Kredit" ? "selected" : "" }}>Kredit</option>
                                        <option value="Tunai" {{ $method_payment == "Tunai" ? "selected" : "" }}>Tunai</option>
                                    </select>
                                    @error('method_payment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group has-feedback @error('type') has-error @enderror">
                                    <?php $type = isset($customer->type) ? $customer->type : old('type')  ?>
                                    <label for="type">Tipe Kredit</label>
                                    <select class="form-control" name="type" id="type">
                                        <option value="" {{ $type == "" ? "selected" : "" }}>-- Pilih Tipe --</option>
                                        <option value="Subsidi" {{ $type == "Subsidi" ? "selected" : "" }}>Subsidi</option>
                                        <option value="Komersil" {{ $type == "Komersil" ? "selected" : "" }}>Komersil</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <?php $sale_id = isset($customer->sale_id) ? $customer->sale_id : old('sale_id')  ?>
                                <div class="form-group has-feedback @error('sale_id') has-error @enderror">
                                    <label for="sale_id">Sales</label>
                                    <select class="form-control" name="sale_id" id="sale_id">
                                        @foreach($sales as $key => $sale)
                                            <option value="{{ $key }}" {{ $sale_id == $key ? "selected" : "" }}>{{ $sale }}</option>
                                        @endforeach
                                    </select>
                                    @error('sale_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group has-feedback @error('fee') has-error @enderror">
                                    <?php $fee = isset($customer->fee) ? $customer->fee : old('fee')  ?>
                                    <label for="fee">Fee Sales</label>
                                    <select class="form-control" name="fee" id="fee">
                                        <option value="half" {{ $fee == "half" ? "selected" : "" }}>Half</option>
                                        <option value="full" {{ $fee == "full" ? "selected" : "" }}>Full</option>
                                    </select>
                                    @error('fee')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group has-feedback @error('state_id') has-error @enderror">
                                    <?php $state_id = isset($customer->state_id) ? $customer->state_id : old('state_id')  ?>
                                    <label for="state_id">Status Berkas</label>
                                    <input type="hidden" class="form-control" name="state_id" id="state_id" value="<?= isset($customer->state_id) ? $customer->state_id : 1 ?>">
                                    <select class="form-control" name="state_name" id="state_name" disabled>
                                        <option value="1" {{ $state_id == "1" ? "selected" : "" }}>On Process</option>
                                        <option value="2" {{ $state_id == "2" ? "selected" : "" }}>Approve</option>
                                        <option value="3" {{ $state_id == "3" ? "selected" : "" }}>Reject</option>
                                    </select>
                                    @error('state_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group has-feedback @error('description') has-error @enderror">
                                    <label for="description">Keterangan</label>
                                    <textarea class="form-control" name="description" id="description"><?= isset($customer->description) ? $customer->description : old('description') ?></textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="col-12 pull-right">
                                <a href="<?= isset($customer->id) ? url('customer/' . $customer->id) : url('customer/') ?>" class="btn btn-sm btn-default">
                                    Batal
                                </a>
                                <button class="btn btn-sm btn-success" type="submit">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{url('adminlte2/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script>

    function checkMethodValue() {
        changeMethodPayment();
    }

    function changeMethodPayment(){
        methodValue = $('#method_payment')[0].value;
        parentOfType = $('select#type')[0].parentNode;

        if(methodValue == 'Tunai')
            parentOfType.style.display = 'none';
        
        else
            parentOfType.style.display = '';
    }

    checkMethodValue();

</script>
@endsection
@section('js')
@endsection
