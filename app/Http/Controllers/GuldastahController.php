<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Guldastah;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GuldastahController extends Controller
{
    //
    public function index()
    {
        // @TODO To be implemented for date or edition wise filter result.

        $guldastah = Guldastah::query();

        if (!request("date")) {
            return redirect()->back()->with('error', 'Please select date ');
        }

        $guldastah = $guldastah->whereDate("created_at", "=", date("Y-m-d", strtotime(request("date"))))->first();

        if (!$guldastah) {
            return redirect()->back()->with('error', 'No Guldastah Found');
        }

        return redirect('/guldastah/'.$guldastah->id);
    }

    public function show(Request $request, $id, $page = 1)
    {
        $categories = Category::paginate(8);
        $guldastah = Guldastah::find($id);

        if (is_null($guldastah)) {
            throw new NotFoundHttpException();
        }

        $pages = $guldastah->guldastahPage()->get();
        $pages = $pages->sortBy('page_number');
        $active_page = $pages->filter(fn ($p) => (int) $p->page_number === $page);

        $active_page = $active_page ? $active_page->first() : null;
        $share_url = env('APP_URL').'/guldastah/'.$guldastah->id;

        return view('Guldastah.show', [
            'categories'    => $categories,
            'guldastah'     => $guldastah,
            'pages'         => $pages,
            'active_page'   => $active_page,
            'share_url'     => $share_url,
        ]);
    }
}
