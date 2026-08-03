<?php

namespace App\Http\Controllers\Api;

use App\Models\ENewsPaper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ENewsPaperPage;
use App\Jobs\OptimizePaperImage;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ENewsPaperPageResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;


class ENewsPaperPageController extends Controller
{
    public function upload(Request $request, int $id): JsonResource
    {
        $auth_user = auth()->user();
        if (!$auth_user->isSuperAdmin() && !$auth_user->isEditor()) {
            throw new HttpException(403, 'You are not allowed to upload E-News images.');
        }

        $validated = $request->validate([
            'photo'          => 'required|file|mimes:jpg,jpeg|max:2048', // 2 MB File
            'page_number'    => 'required|integer',
        ]);

        $enews_paper = ENewsPaper::find($id);
        if (is_null($enews_paper)) {
            throw new NotFoundResourceException("The E-News Paper with ID '$id' does not exist.");
        }

        if ($auth_user->isEditor() && $auth_user->id !== $enews_paper->admin_id) {
            throw ValidationException::withMessages([
                'error' => ["E-News with ID '{$enews_paper->id}' does not belong to you"],
            ]);
        }

        $file = $request->file('photo');

        $name = time().Str::random(16).'.'.$file->extension();
        $file->move('uploads', $name);
        $validated['page_url'] = env('ASSETS_CDN') . $name;
        $validated['page_sm_url'] = env('ASSETS_CDN') . $name;
        $validated['enews_paper_id'] = $id;

        $enews_paper_page = ENewsPaperPage::getPagebyIdAndNumber($id, $validated['page_number']);

        if (is_null($enews_paper_page)) {
            $enews_paper_page = ENewsPaperPage::create($validated);
            $updated['pages'] = $enews_paper->pages + 1;
            OptimizePaperImage::dispatch($name, $enews_paper_page, $enews_paper, $validated['page_number']);
        } else {
            $old_image = $enews_paper_page->page_url;
            $old_image_sm = $enews_paper_page->page_sm_url;
            OptimizePaperImage::dispatch(
                $name,
                $enews_paper_page,
                $enews_paper,
                $validated['page_number'],
                $old_image,
                $old_image_sm
            );
            $enews_paper_page->update($validated);

        }

        return new ENewsPaperPageResource($enews_paper_page);
    }
}
