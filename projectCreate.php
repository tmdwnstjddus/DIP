<?header("content-type:text/html; charset=UTF-8");
session_start();

include ("./db_connect.php");
$connect = dbconn();
$member = member();
$dipconn = dipconn();

if(!$member[MemberID]) Error("로그인 후 이용해 주세요.");

$DipID = $_POST[DipID];
$ProjectID = $_POST[ProjectID];
$ProjectName = $_POST[ProjectName];

if(!$ProjectID or $ProjectID == 0) $ProjectID = 1;
if(!$ProjectName) $ProjectName = 'Untitled';

$query = "INSERT INTO DIP(DipID, ProjectName)
VALUES('$DipID', '$ProjectName')";
$query2 = "INSERT INTO PROJECT(ProjectID, ProjectName)
VALUES('$ProjectID', '$ProjectName')";
mysql_query("set names utf8", $connect);
mysql_query($query, $connect);
mysql_query($query2, $connect);

echo "success";
?>
