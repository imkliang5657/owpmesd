<?php

if ($data['status'] == '尚未審查') {
    $btnGroupContent = <<< HTML
        <a href="./?url=page/applications/manage&status=submitted" class="btn btn-outline-secondary active">尚未審查</a>
        <a href="./?url=page/applications/manage&status=prepare_conference" class="btn btn-outline-secondary">會議準備</a>
        <a href="./?url=page/applications/manage&status=rejected" class="btn btn-outline-secondary">被退件</a>
        <a href="./?url=page/applications/manage&status=in_conference" class="btn btn-outline-secondary">審查會議</a>
        <a href="./?url=page/applications/manage&status=closed" class="btn btn-outline-secondary">通過</a>
    HTML;
} else if ($data['status'] == '會議準備') {
    $btnGroupContent = <<< HTML
        <a href="./?url=page/applications/manage&status=submitted" class="btn btn-outline-secondary">尚未審查</a>
        <a href="./?url=page/applications/manage&status=prepare_conference" class="btn btn-outline-secondary active">會議準備</a>
        <a href="./?url=page/applications/manage&status=rejected" class="btn btn-outline-secondary">被退件</a>
        <a href="./?url=page/applications/manage&status=in_conference" class="btn btn-outline-secondary">審查會議</a>
        <a href="./?url=page/applications/manage&status=closed" class="btn btn-outline-secondary">通過</a>
    HTML;
} else if ($data['status'] == '被退件') {
    $btnGroupContent = <<< HTML
        <a href="./?url=page/applications/manage&status=submitted" class="btn btn-outline-secondary">尚未審查</a>
        <a href="./?url=page/applications/manage&status=prepare_conference" class="btn btn-outline-secondary">會議準備</a>
        <a href="./?url=page/applications/manage&status=rejected" class="btn btn-outline-secondary active">被退件</a>
        <a href="./?url=page/applications/manage&status=in_conference" class="btn btn-outline-secondary">審查會議</a>
        <a href="./?url=page/applications/manage&status=closed" class="btn btn-outline-secondary">通過</a>
    HTML;
} else if ($data['status'] == '審查會議') {
    $btnGroupContent = <<< HTML
        <a href="./?url=page/applications/manage&status=submitted" class="btn btn-outline-secondary">尚未審查</a>
        <a href="./?url=page/applications/manage&status=prepare_conference" class="btn btn-outline-secondary">會議準備</a>
        <a href="./?url=page/applications/manage&status=rejected" class="btn btn-outline-secondary">被退件</a>
        <a href="./?url=page/applications/manage&status=in_conference" class="btn btn-outline-secondary active">審查會議</a>
        <a href="./?url=page/applications/manage&status=closed" class="btn btn-outline-secondary">通過</a>
    HTML;
} else if ($data['status'] == '通過'){
    $btnGroupContent = <<< HTML
        <a href="./?url=page/applications/manage&status=submitted" class="btn btn-outline-secondary">尚未審查</a>
        <a href="./?url=page/applications/manage&status=prepare_conference" class="btn btn-outline-secondary">會議準備</a>
        <a href="./?url=page/applications/manage&status=rejected" class="btn btn-outline-secondary">被退件</a>
        <a href="./?url=page/applications/manage&status=in_conference" class="btn btn-outline-secondary">審查會議</a>
        <a href="./?url=page/applications/manage&status=closed" class="btn btn-outline-secondary active">通過</a>
    HTML;
}
