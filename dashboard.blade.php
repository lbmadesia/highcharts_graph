@extends('app') @section('title', app_name() . ' | ' . __('strings.backend.dashboard.title')) @section('content') 
<style >
    .table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto !important;
    
    .highcharts-figure, .highcharts-data-table table {
  min-width: 360px; 
  max-width: 800px;
  margin: 1em auto;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
  padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
  padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
}
.highcharts-data-table tr:hover {
  background: #f1f7ff;
}
</style>
<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header">
        <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}!</strong>
      </div>
      <!--card-header-->
      <div class="card-body"> {!! __('strings.backend.welcome') !!} </div>
      <!--card-body-->
    </div>
    <!--card-->
  </div>
  <!--col-->
</div>
<!--row-->
<div class="row">
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
    <h6>Top TapiTag User All Time</h6>
   
    <?php foreach ($getData as $key => $value) {
            $totalnum=$getData[$key]->total;
            $get_name=$getData[$key]->first_name.''.$getData[$key]->last_name;
              ?>
    <p class="text-uppercase">{{ $get_name }}<span class="float-right">{{$totalnum}} -</span></p>
          <?php }  ?>
            
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <h6>Top TapiTag Users Today</h6>
     <?php
      foreach ($getDatatoday as $key => $value) {
              $totalnum=$getDatatoday[$key]->total;

      $getDatatoday_name=$getDatatoday[$key]->first_name.''.$getDatatoday[$key]->last_name; ?>
    <p class="text-uppercase">{{$getDatatoday_name}}<span class="float-right">{{$totalnum}} -</span></p>
          <?php } ?>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <h6>Top TapiTag Users Per Location</h6>
        <?php
      foreach ($getDatalocation as $key => $value) {
                $totalnum=$getDatalocation[$key]->total;
                $getDatalocation_name=$getDatalocation[$key]->first_name.''.$getDatalocation[$key]->last_name;
                ?>

    <p class="text-uppercase">{{$getDatalocation_name}}<span class="float-right">{{$totalnum}} -</span></p>
          <?php } ?>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <h6>Top TapiTag Users Per Company</h6>
         <?php
      foreach ($getDatacompany as $key => $value) {
                $totalnum=$getDatacompany[$key]->total;
                $getDatacompany_name=$getDatacompany[$key]->first_name.''.$getDatacompany[$key]->last_name; ?>
    <p class="text-uppercase">{{$getDatacompany_name}}<span class="float-right">{{$totalnum}} -</span></p>
          <?php } ?>
      </div>
    </div>
  </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<div class="row">
  <div class="col-md-3">
     <div class="card ">
       <figure class="highcharts-figure"><div id="container"></div></figure>
  </div>
   
     <div class="card ">
       <figure class="highcharts-figure"><div id="container1"></div></figure>
  </div></div>
 @php
 $todayData = [];
 $week = [];
   $today = date('Y/m/d');
 for($i=0;$i<7;++$i){
 $date=date_create($today);
   date_sub($date,date_interval_create_from_date_string($i." days"));
  $ctoday = date_format($date,'Y/m/d');
   $countData = DB::table('clientinformation')->where('todayDate',$ctoday)->count();
   array_push($todayData,$countData);
    $day = date_format($date,'D');
     array_push($week,$day);
     
   }
   $todayData = array_reverse($todayData);
      $week = array_reverse($week);
      
 @endphp
 
 @php
 $monthData = [];
 $month = [];
 $todaymonth = date('Y-m');
 for($i=0;$i<6;++$i){
 $date = date_create($todaymonth);
   date_sub($date,date_interval_create_from_date_string($i." months"));
  $cmonth = date_format($date,'Y/m');
   $countData = DB::table('clientinformation')->where('todayDate','like','%'.$cmonth.'%')->count();
   array_push($monthData,$countData);
    $months = date_format($date,'M');
     array_push($month,$months);
     
   }
     $monthData = array_reverse($monthData);
      $month = array_reverse($month);
 @endphp

<script type="text/javascript">
    var todayData = @json($todayData);
    var week = @json($week);
    var monthData = @json($monthData);
    var month = @json($month);
     console.log(monthData);
    console.log(month);
    Highcharts.chart('container', {
  chart: { type: 'line' },
  credits: { enabled: false},
  title: {text: 'Total Taps - 46' },
  subtitle: {text: '' },
  //xAxis: {categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] },
  xAxis: {categories: month },
  yAxis: {title: { text: ''}
  },
  
  plotOptions: {line: { dataLabels: {enabled: true },
      enableMouseTracking: false
    }
  },
  //series: [{name: '',   data: [0, 15, 10, 20, 10, 5] }]
  series: [{name: '',   data: monthData }]
});
 Highcharts.chart('container1', {
  chart: { type: 'line' },
   credits: { enabled: false},
  title: {text: 'Today Taps - 4' },
  subtitle: {text: '' },
  xAxis: {categories: week },
  yAxis: {title: { text: ''}
  },
  plotOptions: {
    line: { dataLabels: {enabled: true },
      enableMouseTracking: false
    }
  },
  series: [{
    name: '',
    data: todayData
  }]
});
</script>

  <div class="col-md-9">
    <div class="card">
      <div class="card-body">
        <div class="container table-responsive">
          <h3>Live View</h3>
          <div class="table-responsive">

          <table id="table_1" class="table table-bordered table-hover">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Visitor IP</th>
                <th scope="col">Location</th>
                <th scope="col">Device</th>
                <th scope="col">Date</th>
                <th scope="col">Visit Urls</th>
                <th scope="col">Name</th>
                <th scope="col">Media</th>
              </tr>
            </thead>
            <tbody>

   
                <?php 
  $unique_visitor_array=array();
  $unique_visitor_count=array(); 

  ?>
   @foreach ($visitor_data as $visitor)
 
    <?php 
           
$userIP = $visitor->userIP ; 
$apiURL = 'https://freegeoip.app/json/'.$userIP;  
$ch = curl_init($apiURL); 
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
 $apiResponse = curl_exec($ch); 
 curl_close($ch); 
 $ipData = json_decode($apiResponse, true);
 
if(!empty($ipData)){ $country_name = $ipData['country_name']; }
 

    $extract_url=explode("/", $visitor->serverUri);
     $explode_count=count($extract_url);
     
     $unique_visitor= $visitor->user_id."_".$visitor->userBrowser."_".$visitor->userDevice."_".$extract_url[$explode_count-1];
     // dd($unique_visitor);
     if(!in_array($unique_visitor,$unique_visitor_array)){
         array_push($unique_visitor_array,$unique_visitor);

         $array_indexs = array_search($unique_visitor,$unique_visitor_array);
          array_push($unique_visitor_count,'1');
          $total_page_count='1';
           ?> 
 <tr>
                <th>{{ $visitor->userIP }}</th>
                <td><?php if(!empty($ipData)) { echo  $country_name ;} ?></td>
                <td>{{ $visitor->userDevice }}</td>
                <td>{{ $visitor->todayDate }} </td>
                <td>{{ $visitor->serverUri }}</td>
                <td>{{$visitor->first_name }}</td>
                <td>{{ $visitor->mediaName}} </td>

              </tr>

 <?php  } else{

          $array_index = array_search($unique_visitor,$unique_visitor_array);
          $unique_visitor_count[$array_index]= $unique_visitor_count[$array_index] + 1 ;
          $total_page_count=$unique_visitor_count[$array_index];
       ?>

<script>
    var unique_id = "{{ $unique_visitor}}";
    var total_page_count = "{{ $total_page_count}}";
    $('#'+unique_id).html(total_page_count);

    console.log(unique_id);
</script>

 <?php    }  ?>
 
 @endforeach
            
            </tbody>
          </table>
      </div>
        </div>
      </div>
    </div>
  </div>
</div> @endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script >$(function() {
 var table = $("#table_1").DataTable();

 // Date range vars
 minDateFilter = "";
 maxDateFilter = "";

 //$("#daterange").daterangepicker();
 $("#daterange").on("apply.daterangepicker", function(ev, picker) {
  minDateFilter = Date.parse(picker.startDate);
  maxDateFilter = Date.parse(picker.endDate);
  
  $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
  var date = Date.parse(data[1]);

  if (
   (isNaN(minDateFilter) && isNaN(maxDateFilter)) ||
   (isNaN(minDateFilter) && date <= maxDateFilter) ||
   (minDateFilter <= date && isNaN(maxDateFilter)) ||
   (minDateFilter <= date && date <= maxDateFilter)
  ) {
   return true;
  }
  return false;
 });
 table.draw();
}); 
  

});
 
 
</script>
