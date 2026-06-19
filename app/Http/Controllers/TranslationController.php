<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Translation;
use App\Services\TranslationService;

class TranslationController extends Controller
{
    public function __construct(private TranslationService $service) {}

    public function store(Request $request)
    {
        return response()->json(
            $this->service->create($request->all())
        );
    }

    public function update(Request $request, $id)
    {
        $translation = Translation::findOrFail($id);
        $translation->update($request->all());

        return response()->json($translation);
    }

    public function search(Request $request)
    {
        return response()->json(
            $this->service->search($request->all())
        );
    }

    public function export()
    {
        return response()->json(
            $this->service->export()
        );
    }
}
