@extends( 'layouts.admin.app' )

@section('sidebar')
    <?= $sidebar = ( isset( $sidebar ) ) ? $sidebar : ''  ?>
@endsection

@section('content')
<div class="container-fluid" style="margin-bottom: 1rem">
    <div class="content-header">
        <h1 class="m-0 text-dark">Beranda</h1>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            @foreach($accounts as $account)
            <div class="col-md-4">
                <div class="card-account">
                    <div class="icon-account red"></div>
                    <div class="account-number white">
                        {{$account->number}}
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="account-name red">
                                {{$account->name}}
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="saldo-account pull-right white">
                                @convert($account->saldo)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Status Block Cluster</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="chart-responsive">
                                    <canvas id="pieCluster" height="150"></canvas>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <ul class="chart-legend clearfix">
                                    <li><i class="fa fa-circle-o text-red"></i> Belum Terisi</li>
                                    <li><i class="fa fa-circle-o text-green"></i> Terisi</li>
                                    <li style="margin-top: 5px">{{$cluster['empty'] + $cluster['full']}} Total Unit</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Metode Pembayaran</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="chart-responsive">
                                    <canvas id="piePayment" height="150"></canvas>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <ul class="chart-legend clearfix">
                                    <li><i class="fa fa-circle-o text-light-blue"></i> Kredit</li>
                                    <li><i class="fa fa-circle-o text-green"></i> Tunai</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Status Berkas</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="chart-responsive">
                                    <canvas id="pieStatus" height="150"></canvas>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <ul class="chart-legend clearfix">
                                    <li><i class="fa fa-circle-o text-green"></i> On Proses</li>
                                    <li><i class="fa fa-circle-o text-light-blue"></i> Approve</li>
                                    <li><i class="fa fa-circle-o text-red"></i> Reject</li>
                                    <li style="margin-top: 5px">{{$state['on_process'] + $state['approve'] + $state['cancel']}} Total Pelanggan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <script src="{{url('adminlte2/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{url('adminlte2/bower_components/chart.js/Chart.js')}}"></script>
    <script>
        var pieClusterCanvas = $('#pieCluster').get(0).getContext('2d');
        var pieCluster       = new Chart(pieClusterCanvas);
        var PieData        = [
            {
                value    : <?php echo $cluster['empty'] ?>,
                color    : '#f56954',
                highlight: '#f56954',
                label    : ' Belum Terisi'
            },
            {
                value    : <?php echo $cluster['full'] ?>,
                color    : '#00a65a',
                highlight: '#00a65a',
                label    : ' Terisi'
            },
        ];
        var pieOptions     = {
            segmentShowStroke    : true,
            segmentStrokeColor   : '#fff',
            segmentStrokeWidth   : 1,
            percentageInnerCutout: 50,
            animationSteps       : 100,
            animationEasing      : 'easeOutBounce',
            animateRotate        : true,
            animateScale         : false,
            responsive           : true,
            maintainAspectRatio  : false,
            legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
            tooltipTemplate      : '<%=value %> Unit<%=label%>'
        };
        pieCluster.Doughnut(PieData, pieOptions);

        var piePaymentCanvas = $('#piePayment').get(0).getContext('2d');
        var piePayment       = new Chart(piePaymentCanvas);
        var PieData        = [
            {
                value    : <?php echo $method['credit'] ?>,
                color    : '#3c8dbc',
                highlight: '#3c8dbc',
                label    : 'Kredit'
            },
            {
                value    : <?php echo $method['cash'] ?>,
                color    : '#00a65a',
                highlight: '#00a65a',
                label    : 'Tunai'
            },
        ];
        var pieOptions     = {
            segmentShowStroke    : true,
            segmentStrokeColor   : '#fff',
            segmentStrokeWidth   : 1,
            percentageInnerCutout: 50,
            animationSteps       : 100,
            animationEasing      : 'easeOutBounce',
            animateRotate        : true,
            animateScale         : false,
            responsive           : true,
            maintainAspectRatio  : false,
            legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
            tooltipTemplate      : '<%=value %> <%=label%>'
        };
        piePayment.Doughnut(PieData, pieOptions);

        var pieStatusCanvas = $('#pieStatus').get(0).getContext('2d');
        var pieStatus       = new Chart(pieStatusCanvas);
        var PieData        = [
            {
                value    : <?php echo $state['on_process'] ?>,
                color    : '#00a65a',
                highlight: '#00a65a',
                label    : 'On Process'
            },
            {
                value    : <?php echo $state['approve'] ?>,
                color    : '#3c8dbc',
                highlight: '#3c8dbc',
                label    : 'Approve'
            },
            {
                value    : <?php echo $state['cancel'] ?>,
                color    : '#f56954',
                highlight: '#f56954',
                label    : 'Reject'
            },
        ];
        var pieOptions     = {
            segmentShowStroke    : true,
            segmentStrokeColor   : '#fff',
            segmentStrokeWidth   : 1,
            percentageInnerCutout: 50,
            animationSteps       : 100,
            animationEasing      : 'easeOutBounce',
            animateRotate        : true,
            animateScale         : false,
            responsive           : true,
            maintainAspectRatio  : false,
            legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
            tooltipTemplate      : '<%=value %> <%=label%>'
        };
        pieStatus.Doughnut(PieData, pieOptions);
    </script>
@endsection
@section('js')
@endsection
