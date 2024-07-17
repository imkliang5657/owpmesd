<?php

class Utils
{
    public static function getSpecificationColumns(int $categoryId): array|null
    {
        $columns = [
          1 => ['crane_weight', 'crane_height', 'crane_radius', 'operating_draft', 'other_device'],
          2 => ['foot_length', 'crane_weight', 'crane_height', 'crane_radius', 'operating_draft', 'other_device'],
          3 => ['cable_capacity', 'operating_draft', 'other_device'],
          4 => ['cargo_max', 'transit_speed', 'operating_draft', 'other_device'],
          5 => ['cargo_max', 'transit_speed', 'operating_draft', 'other_device'],
          6 => ['bollard_pull_force', 'other_device'],
          7 => ['bollard_pull_force', 'other_device'],
          8 => ['other_device'],
          9 => ['dynamic_compensated', 'bed_number', 'other_device'],
          10 => [],
          11 => [],
          12 => [],
          13 => [],
          14 => ['bed_number', 'other_device'],
          15 => ['bed_number', 'other_device'],
        ];
        return $columns[$categoryId];
    }


    public static function convertEnglishToChineseForSpecificationColumns(int $categoryId): array|null
    {
        $columns = [
            1 => ['最大吊重(t)', '最大吊高(m)', '最大吊重半徑(m)', '作業水深(m)', '其它設備'],
            2 => ['支撐腳長(m)', '最大吊重(t)', '最大吊高(m)', '最大吊重半徑(m)', '作業水深', '其它設備'],
            3 => ['盤纜槽裝載量(t)', '作業水深(m)', '其它設備'],
            4 => ['裝載量能(t)', '工作速度(T/hr)', '作業水深(m)', '其它設備'],
            5 => ['裝載量能(t)', '工作速度(t/hr)', '作業水深(m)', '其它設備'],
            6 => ['繫纜拖力(t)', '其它設備'],
            7 => ['繫纜拖力(t)', '其它設備'],
            8 => ['其它設備'],
            9 => ['動態補償舷梯', '床位數', '其它設備'],
            10 => [],
            11 => [],
            12 => [],
            13 => [],
            14 => ['床位數', '其它設備'],
            15 => ['床位數', '其它設備'],
        ];
        return $columns[$categoryId];
    }
}