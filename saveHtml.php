<?header("content-type:text/html; charset=UTF-8");
session_start();

include ("./db_connect.php");
$connect = dbconn();
$member = member();
$dipconn = dipconn();

if(!$member[MemberID]) Error("로그인 후 이용해 주세요.");

$ProjectID = $_POST[ProjectID];
$TabID = $_POST[TabID];
$TabName = $_POST[TabName];
$HTML = $_POST[Html];
$DevHTML = $_POST[DevHtml];

$query = "INSERT INTO TAB(ProjectID, TabID, TabName, HTML, DevHTML)
VALUES('$ProjectID', '$TabID', '$TabName', '$HTML', '$DevHTML')";
mysql_query("set names utf8", $connect);
mysql_query($query, $connect);
echo "success";
?>
