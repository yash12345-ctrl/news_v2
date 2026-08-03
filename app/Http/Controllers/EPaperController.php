<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ENewsPaper;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EPaperController extends Controller
{
    //
    public function index(Request $request)
    {

        // @TODO To be implemented for date or edition wise filter result.

        $enews_paper = ENewsPaper::query();

        if (!request("date") && !request("edition")) {
            return redirect()->back()->with('error', 'Please select date and edition');
        }

        $enews_paper = $enews_paper->whereDate("created_at", "=", date("Y-m-d", strtotime(request("date"))))
                         ->where("edition", "=", (int) request("edition"))->first();
        if (!$enews_paper) {
            return redirect()->back()->with('error', 'No ENews Found');
        }

        return redirect('/epaper/'.$enews_paper->id);
       
    }

    public function show(Request $request, $id, $page = 1)
    {
        if (!is_numeric($id)) {
            return redirect()->back();
        }

        $id = (int) $id;
        $page = (int) $page;
        $categories = Category::paginate(8);
        $editions = ENewsPaper::edition();
        $enews = ENewsPaper::find($id);

        if (is_null($enews)) {
            throw new NotFoundHttpException();
        }
        if (! $enews->isPublished()) {
            return redirect()->back();
        }

        $pages = $enews->enewsPaperPage()->get();
        $pages = $pages->sortBy('page_number');
        $active_page = $pages->filter(fn ($p) => (int) $p->page_number === $page);

        $active_page = $active_page ? $active_page->first() : null;
        $share_url = env('APP_URL').'/epaper/'.$enews->id;

        return view('EPaper.show', [
            'categories'    => $categories,
            'enews'         => $enews,
            'editions'      => $editions,
            'pages'         => $pages,
            'active_page'   => $active_page,
            'share_url'     => $share_url
        ]);
    }
}
