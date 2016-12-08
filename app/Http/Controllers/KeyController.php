<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateKeyRequest;
use App\Http\Requests\UpdateKeyRequest;
use App\Repositories\KeyRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class KeyController extends AppBaseController
{
    /** @var  KeyRepository */
    private $keyRepository;

    public function __construct(KeyRepository $keyRepo)
    {
        $this->keyRepository = $keyRepo;
    }

    /**
     * Display a listing of the Key.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->keyRepository->pushCriteria(new RequestCriteria($request));
        $keys = $this->keyRepository->all();

        return view('backend.keys.index')
            ->with('keys', $keys);
    }

    /**
     * Show the form for creating a new Key.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.keys.create');
    }

    /**
     * Store a newly created Key in storage.
     *
     * @param CreateKeyRequest $request
     *
     * @return Response
     */
    public function store(CreateKeyRequest $request)
    {
        $input = $request->all();

        $key = $this->keyRepository->create($input);

        Flash::success('Key saved successfully.');

        return redirect(route('admin.keys.index'));
    }

    /**
     * Display the specified Key.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $key = $this->keyRepository->findWithoutFail($id);

        if (empty($key)) {
            Flash::error('Key not found');

            return redirect(route('admin.keys.index'));
        }

        return view('backend.keys.show')->with('key', $key);
    }

    /**
     * Show the form for editing the specified Key.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $key = $this->keyRepository->findWithoutFail($id);

        if (empty($key)) {
            Flash::error('Key not found');

            return redirect(route('admin.keys.index'));
        }

        return view('backend.keys.edit')->with('key', $key);
    }

    /**
     * Update the specified Key in storage.
     *
     * @param  int              $id
     * @param UpdateKeyRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateKeyRequest $request)
    {
        $key = $this->keyRepository->findWithoutFail($id);

        if (empty($key)) {
            Flash::error('Key not found');

            return redirect(route('admin.keys.index'));
        }

        $key = $this->keyRepository->update($request->all(), $id);

        Flash::success('Key updated successfully.');

        return redirect(route('admin.keys.index'));
    }

    /**
     * Remove the specified Key from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $key = $this->keyRepository->findWithoutFail($id);

        if (empty($key)) {
            Flash::error('Key not found');

            return redirect(route('admin.keys.index'));
        }

        $this->keyRepository->delete($id);

        Flash::success('Key deleted successfully.');

        return redirect(route('admin.keys.index'));
    }
}
