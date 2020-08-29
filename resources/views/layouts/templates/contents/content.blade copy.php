@extends( 'layouts.admin.app' )

@section('sidebar')
    <?= $sidebar = ( isset( $sidebar ) ) ? $sidebar : ''  ?>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= $page_title = ( isset( $page_title ) ) ? strtoupper( $page_title ) : ''  ?></h1>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="col-12">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                        <br>
                                    @endforeach
                            </div>
                        @else
                                <?= $message_alert = ( isset( $message_alert ) ) ? $message_alert : ''  ?>
                        @endif
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <h5>
                                    <?= $header = ( isset( $header ) ) ? strtoupper( $header ) : ''  ?>
                                    <p class="text-secondary"><small><?= $sub_header = ( isset( $sub_header ) ) ? $sub_header : ''  ?></small></p>
                                </h5>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-10">
                                        <div class="float-right">
                                            <?php echo (isset( $header_button )) ? $header_button : '';  ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                    <?php echo (isset($contents)) ? $contents : '';  ?>
                    <?php echo (isset($pagination_links)) ? $pagination_links : '';  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
@endsection
