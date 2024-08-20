<?php require APP_ROOT . 'views/include/header.php'; ?>
  <body>
  <?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
    <div class="container my-5">
      <div class="row">
        <div class="col-sm-4 mb-3 mb-sm-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">國內船舶資訊</h5>
              <p class="card-text text-secondary">顯示國內業者旗下各種類型船舶和可用船期。</p>
              <a href="./?url=domesticShip/domestic-ship" class="btn btn-sm btn-outline-success">點擊前往功能</a>
            </div>
          </div>
        </div>
        <div class="col-sm-4 mb-3 mb-sm-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">風場列表</h5>
              <p class="card-text text-secondary">簡述目前台灣個階段風場的位置、名稱、容量、公司所屬等資訊</p>
              <a href="./?url=page/wind-farm" class="btn btn-sm btn-outline-success">點擊前往功能</a>
            </div>
          </div>
        </div>
        <div class="col-sm-4 mb-3 mb-sm-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">公吿事項</h5>
              <p class="card-text text-secondary">用於公告會議時間、署內通知等，以利業者、公協會查詢</p>
              <a href="./?url=page/announcements" class="btn btn-sm btn-outline-success">點擊前往功能</a>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-2">
        <div class="col-sm-9 mb-4 mb-sm-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">船舶搜尋</h5>
              <p class="card-text text-secondary">透過船名、IMO、船種等訊息，顯示搜尋結果，並透過點擊船舶名稱，前往各船舶獨立頁面</p>
              <a href="./?url=page/search-vessel" class="btn btn-sm btn-outline-success">點擊前往功能</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    </body>
<?php require APP_ROOT . 'views/include/footer.php';?>