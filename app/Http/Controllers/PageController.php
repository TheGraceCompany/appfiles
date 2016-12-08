<?php
namespace App\Http\Controllers;

use App\Repositories\Page\PageInterface;
use App\Repositories\Page\PageRepository as Page;
use \Ecommerce\helperFunctions;

/**
 * Class PageController.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class PageController extends Controller
{
    /**
     * @var mixed
     */
    protected $page;

    /**
     * @param PageInterface $page
     */
    public function __construct(PageInterface $page)
    {
        $this->page = $page;
    }

    /**
     * Display page.
     *
     * @param  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $page = $this->page->getBySlug($slug, true);

        if ($page === null) {
            return Response::view('errors.missing', [], 404);
        }
        helperFunctions::getCartInfo($cart, $total);
        return view('frontend.page.show', compact('page', 'cart', 'total'));
    }
}
