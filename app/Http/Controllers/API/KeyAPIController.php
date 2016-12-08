<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateKeyAPIRequest;
use App\Http\Requests\API\UpdateKeyAPIRequest;
use App\Models\Key;
use App\Repositories\KeyRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class KeyController
 * @package App\Http\Controllers\API
 */

class KeyAPIController extends AppBaseController
{
    /** @var  KeyRepository */
    private $keyRepository;

    public function __construct(KeyRepository $keyRepo)
    {
        $this->keyRepository = $keyRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/keys",
     *      summary="Get a listing of the Keys.",
     *      tags={"Key"},
     *      description="Get all Keys",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Key")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->keyRepository->pushCriteria(new RequestCriteria($request));
        $this->keyRepository->pushCriteria(new LimitOffsetCriteria($request));
        $keys = $this->keyRepository->all();

        return $this->sendResponse($keys->toArray(), 'Keys retrieved successfully');
    }

    /**
     * @param CreateKeyAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/keys",
     *      summary="Store a newly created Key in storage",
     *      tags={"Key"},
     *      description="Store Key",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Key that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Key")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Key"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateKeyAPIRequest $request)
    {
        $input = $request->all();

        $keys = $this->keyRepository->create($input);

        return $this->sendResponse($keys->toArray(), 'Key saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/keys/{id}",
     *      summary="Display the specified Key",
     *      tags={"Key"},
     *      description="Get Key",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Key",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Key"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Key $key */
        $key = $this->keyRepository->findWithoutFail($id);

        if (empty($key)) {
            return $this->sendError('Key not found');
        }

        return $this->sendResponse($key->toArray(), 'Key retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateKeyAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/keys/{id}",
     *      summary="Update the specified Key in storage",
     *      tags={"Key"},
     *      description="Update Key",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Key",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Key that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Key")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Key"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateKeyAPIRequest $request)
    {
        $input = $request->all();

        /** @var Key $key */
        $key = $this->keyRepository->findWithoutFail($id);

        if (empty($key)) {
            return $this->sendError('Key not found');
        }

        $key = $this->keyRepository->update($input, $id);

        return $this->sendResponse($key->toArray(), 'Key updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/keys/{id}",
     *      summary="Remove the specified Key from storage",
     *      tags={"Key"},
     *      description="Delete Key",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Key",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Key $key */
        $key = $this->keyRepository->findWithoutFail($id);

        if (empty($key)) {
            return $this->sendError('Key not found');
        }

        $key->delete();

        return $this->sendResponse($id, 'Key deleted successfully');
    }
}
