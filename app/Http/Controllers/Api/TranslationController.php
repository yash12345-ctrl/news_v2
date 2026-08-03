<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TranslationService;
use Illuminate\Validation\ValidationException;

class TranslationController extends Controller
{
    protected TranslationService $translation_service;

    public function __construct(TranslationService $translation_service)
    {
        $this->translation_service = $translation_service;
    }

    public function urduToRomanHindustani(Request $request)
    {
        $validated = $request->validate([
            'input' => 'required|string|min:4',
        ]);

        $translation = "";
        try {
            $translation = $this->translation_service->urduToRomanHindustani($validated['input']);
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'input' => $e->getMessage()
            ]);
        }

        return response()->json([
            'output' => $translation
        ]);
    }
}