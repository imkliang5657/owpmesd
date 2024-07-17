<?php
echo <<<HTML
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <span class="navbar-brand mb-0 ps-4 fw-bold">
        <i class="bi bi-tsunami"></i> 離岸風電海事工程船舶資料庫
      </span>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="./?url=page/dashboard">首頁</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./?url=page/ship-database-dashboard">船舶資料庫</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./?url=page/ship-application-dashboard">船舶申請</a>
          </li>
        </ul>
      </div>
      <div class="d-flex align-items-center">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="./?url=page/login">帳號登入</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
HTML;