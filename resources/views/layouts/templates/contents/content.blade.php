@extends( 'layouts.admin.app' )

@section('sidebar')
    <?= $sidebar = ( isset( $sidebar ) ) ? $sidebar : ''  ?>
@endsection

@section('content')
<section class="content-header">
    <h1 class="m-0 text-dark"><?= $page_title = ( isset( $page_title ) ) ? strtoupper( $page_title ) : ''  ?></h1>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="box">
                    <div class="box-header">
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
                                <h5 class="box-title">
                                    <?= $header = ( isset( $header ) ) ? strtoupper( $header ) : ''  ?>
                                    <p class="text-secondary"><small><?= $sub_header = ( isset( $sub_header ) ) ? $sub_header : ''  ?></small></p>
                                </h5>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-10">
                                        <div class="pull-right" style="margin-right: 2rem;">
                                            <?php echo (isset( $header_button )) ? $header_button : '';  ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <?php echo (isset($contents)) ? $contents : '';  ?>
                    </div>
                    <div class="box-footer clearfix">
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
