<?header("content-type:text/html; charset=UTF-8");
session_start();

include ("./db_connect.php");
$connect = dbconn();
$member = member();
$dipconn = dipconn();

if(!$member[MemberID]) Error("로그인 후 이용해 주세요.");

$ProjectName = $_POST[ProjectNameInput];
$ProjectID = $_POST[ProjectIdInput];

if(!$ProjectName) $ProjectName = 'Untitled';

$query = "UPDATE DIP SET ProjectName = '$ProjectName' WHERE ProjectID = '$ProjectID'";
$query2 = "UPDATE PROJECT SET ProjectName = '$ProjectName' WHERE ProjectID = '$ProjectID'";
mysql_query("set names utf8", $connect);
mysql_query($query, $connect);
mysql_query($query2, $connect);

echo "success";
?>
