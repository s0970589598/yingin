<?php
require '../class/class_crawler.php' ;
  $crawler=new crawler;
  $city='';
  $area='';
  $class='';
  $search=array();
  
    @$city=$_GET['city'];
    @$search['city']=$city;
    @$choicecity=$crawler->Rspotdata('choicecity',$search);
    @$choiceallclass=$crawler->Rspotdata('choiceclass1',$search);
  


    @$class1=$_GET['class1'];
    @$search['class1']=$class1;
    @$class2=$_GET['class2'];
    @$search['class2']=$class2;
    @$class3=$_GET['class3'];
    @$search['class3']=$class3;



  if(isset($_GET['area'])){
     $area=$_GET['area'];
     $search['area']=$area;
     $choicearea=$crawler->Rspotdata('choicearea',$search);
  }



  

  $showall=$crawler->Rspotdata('allspot',$search);

  
  if(isset($search['city'])){
    $showall=$crawler->Rspotdata('cityspot',$search);
  }
  if(isset($search['area'])){
    $showall=$crawler->Rspotdata('areaspot',$search);
  }

  if(isset($search['city'])){
    $choicearea=$crawler->Rspotdata('choicearea',$search);
  }
?>

<?php
    $str="學會,房地產,美容院,觀光景點,酒類專賣店,金融,髮廊,影片漫畫出租店,旅行社,會計,水電工,汽車修理,洗衣店,洗車,美妝,鎖匠";
    $exstr=explode(",", $str);

?>


縣市:<select  name="city" onchange="choiceca();" style="height: 50px;width: 100px;font-size:30px" id="city"  >
<?php
  for($j=0;$j<count($choicecity);$j++){
    echo '<option value="'.$choicecity[$j]['city'].'">'.$choicecity[$j]['city'].'</option>';
  } 
?>
</select>


鄉鎮區:<select name="area" onchange="choiceca();" style="height: 50px;width: 100px;font-size:30px" id="area">
  
</select>

class1:<select  name="class1" onchange="choiceclass(this.id);" style="height: 50px;width: 100px;font-size:30px" id="class1"  >
<option></option>

</select>
class2:<select  name="class2" onchange="choiceclass(this.id);" style="height: 50px;width: 100px;font-size:30px" id="class2"  >
<option></option>

</select>
class3:<select  name="class3" onchange="choiceclass(this.id);" style="height: 50px;width: 100px;font-size:30px" id="class3"  >
<option></option>

</select>

allclass:<select  name="allclass" onchange="choiceallclass(this.id);" style="height: 50px;width: 100px;font-size:30px" id="allclass"  >
<option></option>
<otpion value=""></otpion>
<?php
  for($k=0;$k<count($choiceallclass);$k++){
    echo '<option value="'.$choiceallclass[$k]['class1'].'">'.$choiceallclass[$k]['class1'].'</option>';
  } 
  for($m=0;$m<count($exstr);$m++){
    echo '<option value="'.$exstr[$m].'">'.$exstr[$m].'</option>';
  }
?>

</select>




<html>
 <head>
  <title>Live Add Edit Delete Datatables Records using PHP Ajax</title>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
  <style>
  body
  {
   margin:0;
   padding:0;
   background-color:#f1f1f1;
  }
  .box
  {
   width:1230px;
   padding:20px;
   background-color:#fff;
   border:1px solid #ccc;
   border-radius:5px;
   margin-top:25px;
   box-sizing:border-box;
  }
  </style>
 </head>
 <body>
  <div class="container box" >
   <h1 align="center">Live Add Edit Delete Datatables Records using PHP Ajax</h1>
   <br />
   <div class="table-responsive">
   <br />
    <div align="right">
     <button type="button" name="add" id="add" class="btn btn-info">Add</button>
    </div>
    <br />
    <div id="alert_message"></div>
    
    <table id="user_data" class="table  table-bordered table-striped">
     <thead>
      <tr>
       <th>spid</th>
       <th>city</th>
       <th>area</th> 
       <th>address</th>
       <th>class1</th>
       <th>class2</th>
       <th>class3</th>
       <th>googlerating</th>
       <th>spotname</th>
       <th>opentime</th>
       <th>info</th>
       <th>px</th>
       <th>py</th>
       <th>ticketinfo</th>
       <th>toldescribe</th>
       <th>travellinginfo</th>
       <th>source</th>
       <th>website</th>
       <th>cid</th>
       <th>spottag</th>
       <th>description</th>
       <th></th>
       </tr>
     </thead>
    </table>

   </div>
  </div>
 </body>
</html>

<script type="text/javascript" language="javascript" >
function choiceallclass(){
  var allclass =$("#allclass").find(":selected").val();
  $('#user_data').DataTable().destroy();
       var dataTable = $('#user_data').DataTable({
          "processing" : false,
          "serverSide" : false,
          "order" : [],
          "ajax" : {
              url:"fetch.php",
              type:"POST",
              data: {
                    class1:allclass
                     }
             }
          });
}

function choiceca(){
    
      var city =$("#city").val();
      var area =$("#area").find(":selected").val();
      
      $("#area").empty();
      $("#class1").empty();

      $("#class2").empty();

      $("#class3").empty();

      $('#user_data').DataTable().destroy();
       var dataTable = $('#user_data').DataTable({
          "processing" : false,
          "serverSide" : false,
          "order" : [],
          "ajax" : {
              url:"fetch.php",
              type:"POST",
              data: {
                    city:city,
                    area:area
                    }
             }
          });

      $.ajax({
              type: 'POST',                     //GET or POST
              url: "/travel/showarea.php",      //請求的頁面
              cache: false,                     //防止抓到快取的回應
              data: {
                city:city
              },      //要傳送到頁面的參數
              success:function(data) {
                aa=JSON.stringify(data);
                bb=JSON.parse(data);
                var NumOfJData = bb.length; 
                $("#area").prepend("<option value='"+area+"'>"+area+"</option>"); //在前面插入一項option
                for (var i = 0; i < NumOfJData; i++) {
                  //$("#area").append( '<option value="+bb[i].area+">' + bb[i].area   + '</option>');
                  $('#area').append($('<option>', { value : bb[i].area }).text(bb[i].area)); 
                }
                  
              },         //當請求成功後此事件會被呼叫
              error: {},            //當請求失敗後此事件會被呼叫
              statusCode: {                     //狀態碼處理
                404: function() {
                  alert("page not found");
                }
              }
          });


       $.ajax({
              type: 'POST',                     //GET or POST
              url: "/travel/showclass.php",      //請求的頁面
              cache: false,                     //防止抓到快取的回應
              data: {
                city:city,
                area:area
              },      //要傳送到頁面的參數
              success:function(data) {
                aa=JSON.stringify(data);
                bb=JSON.parse(data);
                var NumOfJData = bb[0].length; 
                var NumOfJData2 = bb[1].length; 
                var NumOfJData3 = bb[2].length; 

                for (var i = 0; i < NumOfJData; i++) {
                  //$("#area").append( '<option value="+bb[i].area+">' + bb[i].area   + '</option>');
                  $('#class1').append($('<option>', { value : bb[0][i].class1 }).text(bb[0][i].class1)); 
                }
                for (var j = 0; j < NumOfJData2; j++){
                    $('#class2').append($('<option>', { value : bb[1][j].class2 }).text(bb[1][j].class2)); 

                }
                 for (var k = 0; k < NumOfJData3; k++){
                    $('#class3').append($('<option>', { value : bb[2][k].class3}).text(bb[2][k].class3)); 

                }



                  
              },         //當請求成功後此事件會被呼叫
              error: {},            //當請求失敗後此事件會被呼叫
              statusCode: {                     //狀態碼處理
                404: function() {
                  alert("page not found");
                }
              }
        });

     

  }



  function choiceclass(s){
      if(s=='class1'){
          var choiceclass =$("#class1").find(":selected").val();
      }else if(s=='class2'){
          var choiceclass =$("#class2").find(":selected").val();
      }else if(s=='class3'){
          var choiceclass =$("#class3").find(":selected").val();
      }
      var city =$("#city").val();
      var area =$("#area").val();
      
      $('#user_data').DataTable().destroy();
       var dataTable = $('#user_data').DataTable({
          "processing" : false,
          "serverSide" : false,
          "order" : [],
          "ajax" : {
              url:"fetch.php",
              type:"POST",
              data: {
                    city:city,
                    area:area,
                    choiceclass:choiceclass
                    }
             }
          });
  }


 $(document).ready(function(){
  
  fetch_data();
 

  function fetch_data()
  {
   var dataTable = $('#user_data').DataTable({
    "processing" : true,
    "serverSide" : true,
    "order" : [],
    "ajax" : {
     url:"fetch.php",
     type:"POST"
    }
   });
  }
  
  function update_data(id, column_name, value)
  {

      var city =$("#city").val();
      var area =$("#area").val();

   $.ajax({
    url:"update.php",
    method:"POST",
    data:{spid:id, column_name:column_name, value:value},
    success:function(data)
    {
     $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
     $('#user_data').DataTable().destroy();
     //fetch_data();
    }
   });
   var dataTable = $('#user_data').DataTable({
          "processing" : false,
          "serverSide" : false,
          "order" : [],
          "ajax" : {
              url:"fetch.php",
              type:"POST",
              data: {
                    city:city,
                    area:area,
                    choiceclass:choiceclass
                    }
             }
          });

   setInterval(function(){
    $('#alert_message').html('');
   }, 5000);
  }

  $(document).on('blur', '.update', function(){
   var id = $(this).data("id");
   var column_name = $(this).data("column");
   var value = $(this).text();
   update_data(id, column_name, value);
  });
  
  $('#add').click(function(){
   var html = '<tr>';
   html += '<td contenteditable id="data1"></td>';
   html += '<td contenteditable id="data2"></td>';
   html += '<td contenteditable id="data3"></td>';
   html += '<td contenteditable id="data4"></td>';
   html += '<td contenteditable id="data5"></td>';
   html += '<td contenteditable id="data6"></td>';
   html += '<td contenteditable id="data7"></td>';
   html += '<td contenteditable id="data8"></td>';
   html += '<td contenteditable id="data9"></td>';
   html += '<td contenteditable id="data10"></td>';
   html += '<td contenteditable id="data11"></td>';
   html += '<td contenteditable id="data12"></td>';
   html += '<td contenteditable id="data13"></td>';
   html += '<td contenteditable id="data14"></td>';
   html += '<td contenteditable id="data15"></td>';
   html += '<td contenteditable id="data16"></td>';
   html += '<td contenteditable id="data17"></td>';
   html += '<td contenteditable id="data18"></td>';
   html += '<td contenteditable id="data19"></td>';
   html += '<td contenteditable id="data20"></td>';
   html += '<td contenteditable id="data21"></td>';

   html += '<td><button type="button" name="insert" id="insert" class="btn btn-success btn-xs">Insert</button></td>';
   html += '</tr>';
   $('#user_data tbody').prepend(html);
  });
  
  $(document).on('click', '#insert', function(){
   var spid = $('#data1').text();
   var city = $('#data2').text();
   var area = $('#data3').text();
   var address = $('#data4').text();
   var class1 = $('#data5').text();
   var class2 = $('#data6').text();
   var class3 = $('#data7').text();
   var googlerating = $('#data8').text();
   var spotname = $('#data9').text();
   var opentime = $('#data10').text();
   var info = $('#data11').text();
   var px = $('#data12').text();
   var py = $('#data13').text();
   var ticketinfo = $('#data14').text();
   var toldescribe = $('#data15').text();
   var travellinginfo = $('#data16').text();
   var source = $('#data17').text();
   var website = $('#data18').text();
   var cid = $('#data19').text();
   var spottag = $('#data20').text();
   var description = $('#data21').text();



   if(spotname != '' )
   {
    $.ajax({
     url:"insert.php",
     method:"POST",
     data:{
      spid:spid,
      city:city,
      area:area,
      address:address,
      class1:class1,
      class2:class2,
      class3:class3,
      googlerating:googlerating,
      spotname:spotname,
      opentime:opentime,
      info:info,
      px:px,
      py:py,
      ticketinfo:ticketinfo,
      toldescribe:toldescribe,
      travellinginfo:travellinginfo,
      source:source,
      website:website,
      cid:cid,
      spottag:spottag,
      description:description
    },
     success:function(data)
     {
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#user_data').DataTable().destroy();
      fetch_data();
     }
    });
    setInterval(function(){
     $('#alert_message').html('');
    }, 5000);
   }
   else
   {
    alert("Both Fields is required");
   }
  });
  
  $(document).on('click', '.delete', function(){
   var id = $(this).attr("id");
   if(confirm("Are you sure you want to remove this?"))
   {
    $.ajax({
     url:"delete.php",
     method:"POST",
     data:{spid:id},
     success:function(data){
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#user_data').DataTable().destroy();
      fetch_data();
     }
    });
    setInterval(function(){
     $('#alert_message').html('');
    }, 5000);
   }
  });
 });
</script>

