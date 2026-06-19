<?php

namespace App\Services;

use App\Models\Translation;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;

class TranslationService
{
    public function create(array $data)
    {
        $translation = Translation::create([
            't_key' => $data['key'],
            'locale' => $data['locale'],
            'content' => $data['content'],
        ]);

        if (!empty($data['tags'])) {
            $tagIds = Tag::whereIn('name', $data['tags'])->pluck('id');
            $translation->tags()->sync($tagIds);
        }

        Cache::forget('translations_export');

        return $translation;
    }

    public function search(array $filters)
    {
        return Translation::query()
            ->select(['id', 't_key', 'locale', 'content'])
            ->when($filters['key'] ?? null, fn($q, $v) =>
            $q->where('t_key', 'like', "%$v%"))
            ->when($filters['locale'] ?? null, fn($q, $v) =>
            $q->where('locale', $v))
            ->when($filters['tag'] ?? null, fn($q, $tag) =>
            $q->whereHas('tags', fn($q) =>
            $q->where('name', $tag)))
            ->with('tags:id,name')
            ->paginate(50);
    }

    public function export()
    {
        return Cache::rememberForever('translations_export', function () {

            return Translation::query()
                ->select(['t_key', 'locale', 'content'])
                ->get()
                ->groupBy('locale')
                ->map(
                    fn($items) =>
                    $items->pluck('content', 't_key')
                );
        });
    }
}
