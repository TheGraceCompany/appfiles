<?php



namespace App\Http\Controllers;

use App\Services\Pagination;
use Illuminate\Http\Request;
use Search;
use View;

/**
 * Class SearchController.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class SearchController extends Controller
{
    /**
     * @var mixed
     */
    protected $perPage;

    public function __construct()
    {
        $this->perPage = config('grace.per_page');
    }

    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        $q = $request->get('search');

        View::composer('frontend/layout/menu', function ($view) use ($q) {
            $view->with('q', $q);
        });

        $result = Search::search($q);
        $paginator = Pagination::makeLengthAware($result, count($result), $this->perPage);

        return view('frontend.search.index', compact('paginator', 'q'));
    }
}
