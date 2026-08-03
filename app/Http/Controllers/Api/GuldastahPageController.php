<?php

namespace App\Http\Controllers\Api;

use App\Models\Guldastah;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\GuldastahPage;
use App\Jobs\OptimizePaperImage;
use App\Http\Controllers\Controller;
use App\Http\Resources\GuldastahPageResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class GuldastahPageController extends Controller
{
    public function upload(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to upload guldastah images.');
        }

        $validated = $request->validate([
            'photo'          => 'required|file|mimes:jpg,jpeg|max:2048', // 2 MB File
            'page_number'    => 'required|integer',
        ]);

        $guldastah = Guldastah::find($id);
        if (is_null($guldastah)) {
            throw new NotFoundResourceException("The Guldastah with ID '$id' does not exist.");
        }

        if ($auth_user->isEditor() && $auth_user->id !== $guldastah->admin_id) {
            throw ValidationException::withMessages([
                'error' => ["Guldastah with ID '{$guldastah->id}' does not belong to you"],
            ]);
        }

        $file = $request->file('photo');
        $name = time().Str::random(16).'.'.$file->extension();
        $file->move('uploads', $name);
        $validated['page_url'] = env('ASSETS_CDN') . $name;
        $validated['page_sm_url'] = env('ASSETS_CDN') . $name;
        $validated['guldastah_id'] = $id;

        $guldastah_page = GuldastahPage::getPagebyIdAndNumber($id, $validated['page_number'])->first();

        if (is_null($guldastah_page)) {
            $guldastah_page = GuldastahPage::create($validated);
            $updated['pages'] = $guldastah->pages + 1;
            OptimizePaperImage::dispatch($name, $guldastah_page, $guldastah, $validated['page_number']);
        } else {
            $old_image = $guldastah_page->page_url;
            $old_image_sm = $guldastah_page->page_sm_url;
            OptimizePaperImage::dispatch(
                $name,
                $guldastah_page,
                $guldastah,
                $validated['page_number'],
                $old_image,
                $old_image_sm
            );
            $guldastah_page->update($validated);

        }

        return new GuldastahPageResource($guldastah_page);
    }
}
