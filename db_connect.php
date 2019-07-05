<?
function dbconn() {
  $host_name = "localhost";
  $db_user_id = "DIP";
  $db_name = "DIP";
  $db_pw = "0567thirty";
  $connect = mysql_connect($host_name, $db_user_id, $db_pw);
  mysql_query("set names uft8", $connect);
  mysql_select_db($db_name, $connect);
  if(!$connect) die("연결에 실패하였습니다.".mysql_error());
  return $connect;
}

function Error($msg) {
  echo "
  <script>
  window.alert('$msg');
  history.back(1);
  </script>
  ";
  exit;
}

function member() {
  global $connect;
  $session = $_SESSION["MEMBER"];
  $query = "select * from MEMBER where MemberID = '$session'";
  mysql_query("set names utf8", $connect);
  $result = mysql_query($query, $connect);
  $member = mysql_fetch_array($result);
  return $member;
}

function dipconn() {
  global $connect;
  $session = $_SESSION["DIP"];
  $query = "select * from DIP where DipID = '$session'";
  mysql_query("set names utf8", $connect);
  $result = mysql_query($query, $connect);
  $dipconn = mysql_fetch_array($result);
  return $dipconn;
}
?>
