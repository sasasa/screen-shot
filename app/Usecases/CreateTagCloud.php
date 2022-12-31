<?php

namespace App\Usecases;

use App\Models\Tag;
// use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection;

final class CreateTagCloud
{
    public function __construct()
    {
    }

    public function __invoke(): Collection
    {
        $tagswithCount = Tag::query()->withCount('sites')//->orderBy('sites_count', 'desc')
        ->inRandomOrder()->get();
        $tagCount = $tagswithCount->map(function($tag) {
            return $tag->sites_count;
        });
        $levels = $this->divideIntoTenLevels($tagCount->toArray());

        return $tagswithCount->map(function($tag) use($levels){
            $tag->level = $this->getLevel($tag->sites_count, $levels);
            return $tag;
        });
    }

    private function getLevel(int $count, array $levels): int {
        foreach ($levels as $key => $level) {
            if ($count <= $level) {
                return $key + 1;
            }
        }
        return 10;
    }

    /**
     * divide into ten levels
     */
    private function divideIntoTenLevels(array $sequence): array {
      $max = max($sequence);
      $min = min($sequence);
      $diff = $max - $min;
      $div = $diff / 10;
      $levels = [];
      for ($i = 0; $i < 10; $i++) {
          $levels[$i] = $min + $div * $i;
      }
      return $levels;
  }
}