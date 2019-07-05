<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title></title>
    <style media="screen">
      html, body { padding: 0; margin: 0; width: 100%; height: 100%; }
      .window { width: 100%; height: 100%; }
    </style>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="./style/drag.css">
    <link rel="stylesheet" href="./style/library/dip-component.css">
    <link rel="stylesheet" href="./style/library/dip.css">
    <link rel="stylesheet" href="./style/template.css?ver=2">
    <link rel="stylesheet" href="./style/init.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="./script/library/dip.js"></script>
    <script src="./script/library/dip-component.js"></script>
    <script src="./script/library/dip-project.js"></script>
    <script src="./script/library/dip-layout.js"></script>
    <script src="./script/library/dip-hierarchy.js"></script>
    <script src="./script/library/dip-dips.js"></script>
    <script src="./script/resize.js"></script>
    <script src="./script/leftRightAnimation.js"></script>
    <script src="./script/attribute.js"></script>
    <script src="./script/clickComponent.js"></script>
    <script src="./script/editableTitle.js"></script>
    <script src="./script/dragAndDropComponent.js"></script>
    <script src="./script/tab.js"></script>
    <script src="./script/accordion.js"></script>
    <script src="./script/file.js"></script>
    <script src="./script/slider.js"></script>
    <script src="./script/paletteColor.js"></script>

    <script>
    var tabCount, tabId, contentId;
    </script>
  </head>
  <body>
    <?
    session_start();
    include ("./db_connect.php");
    $connect = dbconn();
    $member = member();
    $dipconn = dipconn();

    $project = $_GET[project];
    $query = "SELECT * FROM PROJECT WHERE ProjectID = '$project'";
    $result = mysql_query($query, $connect);
    $data = mysql_fetch_array($result);

    $query2 = "SELECT * FROM TAB";
    $result2 = mysql_query($query2, $connect);
    while($data2 = mysql_fetch_array($result2)) {
      $AllTabIdArray[] = (int)$data2[TabID];
    }

    $query3 = "SELECT * FROM TAB WHERE ProjectID = '$project'";
    $result3 = mysql_query($query3, $connect);
    while($data3 = mysql_fetch_array($result3)) {
      $TabIdArray[] = (int)$data3[TabID];
      $TabNameArray[] = $data3[TabName];
      $HTMLArray[] = $data3[HTML];
      $DevHTMLArray[] = $data3[DevHTML];
    }
    ?>
    <script>
    var dip = new Dip();
    var tabIndex = <?=json_encode($TabIdArray)?>;
    var tabName = <?=json_encode($TabNameArray)?>;
    var Html = <?=json_encode($HTMLArray)?>;
    var DevHtml = <?=json_encode($DevHTMLArray)?>;
    var allTabId = <?=json_encode($AllTabIdArray)?>;
    dip.setProjectIndex(<?=$data[ProjectID]?>);
    dip.setName('<?=$data[ProjectName]?>');

    function CurTabID() {
          if(allTabId == null) {
            allTabId = new Array;
            return 1;
          } else {
            for(var i=0; i<=allTabId.length; i++){
              if (i == allTabId.length) {
                return allTabId[i-1] + 1;
              }
            }
          }
        }

        function SaveHtml() {
      if(dip.getProject().length == 0) {
        window.alert("제출하려면 최소 한개 이상의 탭이 있어야 합니다.");
      } else {
        for(var i=0; i<dip.getProject().length; i++) {
          dip.getProject()[i].setTabId(CurTabID() + i);
          $.ajax({
                url: "saveHtml.php",
                type: "POST",
                data: {
                  ProjectID : dip.getProjectIndex(),
                  TabID : dip.getProject()[i].getTabId(),
                  TabName : dip.getProject()[i].getName(),
                  DevHtml : dip.getProject()[i].getDevHtml(),
                 },
                success: function(data) {
                  location.href = './project.php';
                },
                error:function(data){
                }
            });
        }
      }
    }

    </script>
    <!-- window -->
    <div class="window">

    <!-- navigation -->
    <div class="nav">
      <?if(!$member[MemberID]) {?>
      <a href="./login.php" style="float: right; padding-right: 5%;">로그인</a>
      <?} else {?>
      <a href="#" style="float: right; padding-right: 5%;"><?=$member[Name]?>님</a>
      <?}?>
        <!-- logo -->
        <div class="logo_layout">
          <a href="./index.html">
              <img class="logo" src="./img/DIP_LOGO_template.png" alt="">
          </a>
          <div class="logo_dip">Design In Programming</div>
        </div>

        <div class="search_layout">
            <input class="search" type="text" placeholder="  검색해보세요.">
        </div>

        <div class="saveBtn_layout">
        <!-- save file -->
          <div class="file">
            <button class="fileBtn" onclick="SaveHtml()">제출</button>
          </div>
        </div>
    </div>

    <!-- fixed_controller -->
    <div class="fixed_controller">

      <!-- tool_fixed -->
      <div class="left" id="left">
        <div class="controller">
          <div class="fix_pin_layout">
            <a onclick="leftFixFlag()"><img class="fixLeft" src="./img/pin.png" alt=""></a>
          </div>

          <div class="tools_layout">
            <div class="tools">
                <button class="component">모양</button>
                <div class="panel">
                  <div class="boxWrap" id="boxWrap">
                    <div class="draggable_tools" id="box">
                      <p></p>
                    </div>
                  </div>

                  <div class="circleWrap" id="circleWrap">
                    <div class="draggable_tools" id="circle">
                      <p></p>
                    </div>
                  </div>
                </div>

                <button class="component">텍스트</button>
                <div class="panel">
                  <div class="textWrap" id="textWrap">
                    <div class="draggable_tools" id="text">
                      <p>text</p>
                    </div>
                  </div>
                </div>

                <button class="component">이미지</button>
                <div class="panel">
                    <img src="./img/search.png" alt="">
                    <p>이미지 추가하기</p>
                </div>

                <button class="component">테이블</button>
                <div class="panel">
                  <div class="tableWrap" id="tableWrap">
                    <div class="draggable_tools" id="table">
                      <p>table</p>
                    </div>
                  </div>
                </div>

                <button class="component">버튼</button>
                <div class="panel">
                  <div class="buttonWrap" id="buttonWrap">
                    <div class="draggable_tools" id="button">
                      <p>버튼</p>
                    </div>
                  </div>
                </div>

            </div>
           </div>

        </div>
      </div>

      <!-- attribute_fixed -->
      <div class="right" id="right">

        <!-- attribute controller -->
        <div class="attribute_controller">

                  <!--pin-->
                  <div class="fixRightBtn_layout">
                    <a onclick="rightFixFlag()"><img class="fixRight" src="./img/pin.png" alt=""></a>
                  </div>

                  <div class="attribute_controller_layout">
                    <!--attribute_controller-->
                    <div class="attribute" id="attribute">
                    </div>
                    <!--directory-->
                    <div class="directory">
                      Directory
                    </div>
                  </div>

        </div>

      </div>

    </div>

      <div class="center">
        <div class="tabs" backgroundColor="#333333";>
          <div class="tabAdd" onclick="addTab()">+</div>
        </div>

        <div class="contentAdd">

        </div>
      </div>

    </div>
     <!-- window End -->
  </body>
</html>

<script>
if(tabIndex != null) {
  for(var i=0; i<tabIndex.length; i++) {
    loadTab(tabIndex[i], tabName[i], Html[i], DevHtml[i]);
  }
}
function loadTab(tabIndex, tabName, Html, DevHtml) {
  dip.getProject().push(new Project());

  dip.getProject()[i].setTabId(tabIndex);
  dip.getProject()[i].setName(tabName);
  dip.getProject()[i].setHtml(Html);
  dip.getProject()[i].setDevHtml(DevHtml);

  tabCount = dip.getProject().length - 1;
  var id = dip.getProject()[tabCount].getId();
  var tabName = dip.getProject()[tabCount].getName();


  var tabTemplate = "<div class='tabLink'  onclick='openTab(event, " + id + ")' id='" + "tab" + id + "' >" + tabName + " </div><div class='tabClose' onclick='closeTab(event, " + id + ")' id='" + "close" + id + "'>X</div>";
  var contentTemplate = "<div class='tabContent' id='" + "content" + id + "'>" + DevHtml + "</div>";

  $('.tabAdd').before(tabTemplate);
  $(".contentAdd").before(contentTemplate);

  STATUS = STATUS_ADD;
  console.log("dip.getProject() : " + dip.getProjectId())
  var curTab = "tab" + (dip.getProjectId());
  document.getElementById(curTab).click();
}
</script>
