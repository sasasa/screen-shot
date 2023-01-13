<?php

namespace App\Enums;

enum SortOrder: string
{
    // 基本情報
    case NEW = '0';
    case OLD = '1';
    case RANDOM = '2';
    case POPULAR = '3';
    case COLOR = '4';

    // 日本語を追加
    public function label(): string
    {
        return match($this)
        {
            SortOrder::RANDOM => 'ランダム',
            SortOrder::POPULAR => '人気順',
            SortOrder::NEW => '新着順',
            SortOrder::OLD => '古い順',
            SortOrder::COLOR => '色割合順',
        };
    }
}