<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateShippingmethodRequest;
use App\Http\Requests\UpdateShippingmethodRequest;
use App\Repositories\ShippingmethodRepository;
use Flash;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ShippingmethodController extends AppBaseController
{
    /** @var ShippingmethodRepository */
    private $shippingmethodRepository;

    public function __construct(ShippingmethodRepository $shippingmethodRepo)
    {
        $this->shippingmethodRepository = $shippingmethodRepo;
    }

    /**
     * Display a listing of the Shippingmethod.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $this->shippingmethodRepository->pushCriteria(new RequestCriteria($request));
        $shippingmethods = $this->shippingmethodRepository->all();

        return view('backend.shippingmethods.index')
            ->with('shippingmethods', $shippingmethods);
    }

    /**
     * Show the form for creating a new Shippingmethod.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.shippingmethods.create');
    }

    /**
     * Store a newly created Shippingmethod in storage.
     *
     * @param CreateShippingmethodRequest $request
     *
     * @return Response
     */
    public function store(CreateShippingmethodRequest $request)
    {
        $input = $request->all();

        $shippingmethod = $this->shippingmethodRepository->create($input);

        Flash::success('Shippingmethod saved successfully.');

        return redirect(route('admin.shippingmethods.index'));
    }

    /**
     * Display the specified Shippingmethod.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $shippingmethod = $this->shippingmethodRepository->findWithoutFail($id);

        if (empty($shippingmethod)) {
            Flash::error('Shippingmethod not found');

            return redirect(route('admin.shippingmethods.index'));
        }

        return view('backend.shippingmethods.show')->with('shippingmethod', $shippingmethod);
    }

    /**
     * Show the form for editing the specified Shippingmethod.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $shippingmethod = $this->shippingmethodRepository->findWithoutFail($id);

        if (empty($shippingmethod)) {
            Flash::error('Shippingmethod not found');

            return redirect(route('admin.shippingmethods.index'));
        }

        return view('backend.shippingmethods.edit')->with('shippingmethod', $shippingmethod);
    }

    /**
     * Update the specified Shippingmethod in storage.
     *
     * @param int                         $id
     * @param UpdateShippingmethodRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShippingmethodRequest $request)
    {
        $shippingmethod = $this->shippingmethodRepository->findWithoutFail($id);

        if (empty($shippingmethod)) {
            Flash::error('Shippingmethod not found');

            return redirect(route('admin.shippingmethods.index'));
        }

        $shippingmethod = $this->shippingmethodRepository->update($request->all(), $id);

        Flash::success('Shippingmethod updated successfully.');

        return redirect(route('admin.shippingmethods.index'));
    }

    /**
     * Remove the specified Shippingmethod from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $shippingmethod = $this->shippingmethodRepository->findWithoutFail($id);

        if (empty($shippingmethod)) {
            Flash::error('Shippingmethod not found');

            return redirect(route('admin.shippingmethods.index'));
        }

        $this->shippingmethodRepository->delete($id);

        Flash::success('Shippingmethod deleted successfully.');

        return redirect(route('admin.shippingmethods.index'));
    }
}
