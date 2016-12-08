<?php

namespace App\Http\Controllers;

use App\Repositories\Faq\FaqInterface;

/**
 * Class FaqController.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class FaqController extends Controller
{
    /**
     * @var FaqInterface
     */
    protected $faq;

    /**
     * @param FaqInterface $faq
     */
    public function __construct(FaqInterface $faq)
    {
        $this->faq = $faq;
    }

    /**
     * Display page.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $faqs = $this->faq->all();
        return view('frontend.faq.show', compact('faqs'));
    }
}
