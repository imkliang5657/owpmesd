<?php require APPROOT . 'views/include/header.php';?>
<body class="text-white" style="background-color: #1F2634">
<?php require APPROOT . 'views/components/userNavBar.php';?>
<div class="container my-5">
  <div class="row mt-2">
    <div class="col-sm-12 mb-4 mb-sm-4">
      <div class="card p-2" style="background-color: #2A3041">
        <div class="card-body">
          <div class="row">
            <div class="col-9">
              <h3 class="card-title text-light">篩選查詢</h3>
            </div>
            <div class="col-3" style="text-align: end">
              <button class="btn btn-warning" type="button" id="button-addon2">
                <i class="bi bi-search"></i> 查詢
              </button>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-7">
              <div class="input-group my-3">
                <span class="input-group-text" id="basic-addon1">關鍵字</span>
                <input type="text" class="form-control" value="">
              </div>
            </div>
            <div class="col-sm-5">
              <div class="input-group my-3">
                <span class="input-group-text" id="basic-addon1">發布單位</span>
                <select class="form-select" aria-label="Default select example">
                  <option selected>全部</option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
                </select>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">發布年月</span>
            <select class="form-select" aria-label="Default select example">
              <option selected>全部</option>
              <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option>
            </select>
            <span class="input-group-text" id="basic-addon1">～</span>
            <select class="form-select" aria-label="Default select example">
              <option selected>全部</option>
              <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12 mb-3 mb-sm-4">
      <div class="card p-2" style="background-color: #353A4A">
        <div class="card-body">
          <div class="row">
            <div class="col-9">
              <h3 class="card-title text-light mb-3">訊息公告</h3>
            </div>
            <div class="col-3" style="text-align: end">
              <div class="input-group">
                <span class="input-group-text" id="basic-addon1">每頁筆數</span>
                <select class="form-select" aria-label="Default select example">
                  <option selected>10</option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
                </select>
                <button class="btn btn-secondary" type="button" id="button-addon2">
                  <i class="bi bi-arrow-clockwise"></i>
                </button>
              </div>
            </div>
          </div>
          <table class="table table-bordered mt-3">
            <thead>
            <tr>
              <th class="table-primary" scope="col">發布日期</th>
              <th class="table-primary" scope="col">標題</th>
              <th class="table-primary" scope="col">組織</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>2023年10月30日</td>
              <td>
                <a href="https://www.moeaea.gov.tw/ECW/populace/news/Board.aspx?kind=3&sub_kind=6&menu_id=8682&news_id=32557" target="_blank" class="link-success link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                  離岸風力發電區塊開發第二期機制規劃草案說明會議
                  <i class="bi bi-arrow-up-right-square"></i>
                </a>
              <td></td>
            </tr>
            <tr>
              <td>2023年10月30日</td>
              <td>
                <a href="#" target="_blank" class="link-success link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                  外製船舶引入審查機制，船舶諮詢及審查會議行政流程
                  <i class="bi bi-arrow-up-right-square"></i>
                </a>
              <td></td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>
