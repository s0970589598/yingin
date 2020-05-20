<?php
//fetch.php
$connect = mysqli_connect("localhost", "root", "", "traveltw");
MySQLi_query($connect,"set names utf8");
$columns = array('spid', 'city','address','class1','class2','class3','googlerating','spotname','opentime','info','px','py','ticketinfo','toldescribe','travellinginfo','source','website','cid','spottag','description');
		
 $query = "select * from spot as s inner join spot_tag as st on s.spid=st.spid";

//if(@$_POST['area']=='undefined'){@$_POST['area']='';}
if(isset($_POST["city"]) and empty($_POST["area"]))
{
 	 $query .= " WHERE city ='$_POST[city]'";
}elseif (isset($_POST["city"]) and isset($_POST["area"])) {
 	 $query .= " WHERE city ='$_POST[city]' and area='$_POST[area]' ";
}else{
	if(isset($_POST["search"]["value"]))
	{
	 $query .= '
	 WHERE spotname LIKE "%'.$_POST["search"]["value"].'%" 
	 OR spottag LIKE "%'.$_POST["search"]["value"].'%" 
	 ';
	}
}
if(isset($_POST["choiceclass"]))
{
	 $query .= " and (class1='$_POST[choiceclass]' or class2='$_POST[choiceclass]' or class3='$_POST[choiceclass]')";
}

if(isset($_POST["class1"]))
{
	 $query .= " and (class1='$_POST[class1]' or class2='$_POST[class1]' or class3='$_POST[class1]')";
}





if(isset($_POST["order"]))
{
 $query .= ' ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
 $query .= ' ORDER BY s.spid DESC ';
}



$query1 = '';
if(! isset($_POST["length"])){
	$_POST["length"]=12;
	$_POST['start']=0;
	$_POST["draw"]=1;
}

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));
$result = mysqli_query($connect, $query . $query1);
$data = array();

while($row = mysqli_fetch_array($result))
{
		

 $sub_array = array();
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="spid">' . $row["spid"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="city">' . $row["city"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="area">' . $row["area"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="address">' . $row["address"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="class1">' . $row["class1"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="class2">' . $row["class2"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="class3">' . $row["class3"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="googlerating">' . $row["googlerating"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="spotname">' . $row["spotname"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="opentime">' . $row["opentime"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="info">' . $row["info"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="px">' . $row["px"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="py">' . $row["py"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="ticketinfo">' . $row["ticketinfo"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="toldescribe">' . $row["toldescribe"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="travellinginfo">' . $row["travellinginfo"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="source">' . $row["source"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="website">' . $row["website"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="cid">' . $row["cid"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="spottag">' . $row["spottag"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["spid"].'" data-column="description">' . $row["description"] . '</div>';


 $sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["spid"].'">Delete</button>';
 $data[] = $sub_array;
}
function get_all_data($connect)
{
 $query = "select * from spot as s inner join spot_tag as st on s.spid=st.spid";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),//get_all_data($connect)
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>
