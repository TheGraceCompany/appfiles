<?php

/*
 * @author Phillip Madsen
 */

namespace App\Http\Controllers;

use App\Http\Requests\CreateDealerRequest;
use App\Http\Requests\UpdateDealerRequest;
use App\Repositories\DealerRepository;
use Flash;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class DealerController extends AppBaseController
{
    /** @var DealerRepository */
    private $dealerRepository;

    public function __construct(DealerRepository $dealerRepo)
    {
        $this->dealerRepository = $dealerRepo;
    }

    /**
     * Display a listing of the Dealer.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $this->dealerRepository->pushCriteria(new RequestCriteria($request));
        $dealers = $this->dealerRepository->all();

        return view('backend.dealers.index')
            ->with('dealers', $dealers);
    }

    /**
     * Show the form for creating a new Dealer.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.dealers.create');
    }

    /**
     * Store a newly created Dealer in storage.
     *
     * @param CreateDealerRequest $request
     *
     * @return Response
     */
    public function store(CreateDealerRequest $request)
    {
        $input = $request->all();

        $dealer = $this->dealerRepository->create($input);
     // $dealer->created_at = \Carbon::now();
           // $dealer->updated_at = \Carbon::now();

        Flash::success('Dealer saved successfully.');

        return redirect(route('admin.dealers.index'));
    }

    /**
     * Display the specified Dealer.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $dealer = $this->dealerRepository->findWithoutFail($id);

        if (empty($dealer)) {
            Flash::error('Dealer not found');

            return redirect(route('admin.dealers.index'));
        }

        return view('backend.dealers.show')->with('dealer', $dealer);
    }

    /**
     * Show the form for editing the specified Dealer.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $dealer = $this->dealerRepository->findWithoutFail($id);

        if (empty($dealer)) {
            Flash::error('Dealer not found');

            return redirect(route('admin.dealers.index'));
        }

        return view('backend.dealers.edit')->with('dealer', $dealer);
    }

    /**
     * Update the specified Dealer in storage.
     *
     * @param int                 $id
     * @param UpdateDealerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDealerRequest $request)
    {
        $dealer = $this->dealerRepository->findWithoutFail($id);

        if (empty($dealer)) {
            Flash::error('Dealer not found');

            return redirect(route('admin.dealers.index'));
        }

        $dealer = $this->dealerRepository->update($request->all(), $id);

        Flash::success('Dealer updated successfully.');

        return redirect(route('admin.dealers.index'));
    }

    /**
     * Remove the specified Dealer from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $dealer = $this->dealerRepository->findWithoutFail($id);

        if (empty($dealer)) {
            Flash::error('Dealer not found');

            return redirect(route('admin.dealers.index'));
        }

        $this->dealerRepository->delete($id);

        Flash::success('Dealer deleted successfully.');

        return redirect(route('admin.dealers.index'));
    }
}
