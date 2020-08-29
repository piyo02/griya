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
        <div class="row col-12" style="margin: 0 .2rem 3rem 0;">
            <div class="pull-right">
                <?php echo (isset( $header_button )) ? $header_button : '';  ?>
            </div>
        </div>
        <div class="row col-12">
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
            @foreach($contents as $content)
            <div class="col-lg-6">
                <div class="box collapsed-box">
                    <div class="box-header">
                        <h5 class="box-title">
                            <?= $header = ( isset( $header ) ) ? strtoupper( $header ) : ''  ?> <?= $content['key']; ?>
                            <p class="text-secondary"><small><?= $sub_header = ( isset( $sub_header ) ) ? $sub_header : ''  ?></small></p>
                        </h5>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <?php echo (isset($content['content'])) ? $content['content'] : '';  ?>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
@section('js')
@endsection
