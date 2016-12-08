<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Criteria\LimitOffsetCriteria;
use App\Http\Requests\API\CreateBoxAPIRequest;
use App\Http\Requests\API\UpdateBoxAPIRequest;
use App\Models\Box;
use App\Repositories\BoxRepository;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class BoxController.
 */
class BoxAPIController extends AppBaseController
{
    /** @var BoxRepository */
    private $boxRepository;

    public function __construct(BoxRepository $boxRepo)
    {
        $this->boxRepository = $boxRepo;
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @SWG\Get(
     *      path="/boxes",
     *      summary="Get a listing of the Boxes.",
     *      tags={"Box"},
     *      description="Get all Boxes",
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
     *                  @SWG\Items(ref="#/definitions/Box")
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
        $this->boxRepository->pushCriteria(new RequestCriteria($request));
        $this->boxRepository->pushCriteria(new LimitOffsetCriteria($request));
        $boxes = $this->boxRepository->all();

        return $this->sendResponse($boxes->toArray(), 'Boxes retrieved successfully');
    }

    /**
     * @param CreateBoxAPIRequest $request
     *
     * @return Response
     *
     * @SWG\Post(
     *      path="/boxes",
     *      summary="Store a newly created Box in storage",
     *      tags={"Box"},
     *      description="Store Box",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Box that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Box")
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
     *                  ref="#/definitions/Box"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateBoxAPIRequest $request)
    {
        $input = $request->all();

        $boxes = $this->boxRepository->create($input);

        return $this->sendResponse($boxes->toArray(), 'Box saved successfully');
    }

    /**
     * @param int $id
     *
     * @return Response
     *
     * @SWG\Get(
     *      path="/boxes/{id}",
     *      summary="Display the specified Box",
     *      tags={"Box"},
     *      description="Get Box",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Box",
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
     *                  ref="#/definitions/Box"
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
        /** @var Box $box */
        $box = $this->boxRepository->findWithoutFail($id);

        if (empty($box)) {
            return $this->sendError('Box not found');
        }

        return $this->sendResponse($box->toArray(), 'Box retrieved successfully');
    }

    /**
     * @param int                 $id
     * @param UpdateBoxAPIRequest $request
     *
     * @return Response
     *
     * @SWG\Put(
     *      path="/boxes/{id}",
     *      summary="Update the specified Box in storage",
     *      tags={"Box"},
     *      description="Update Box",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Box",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Box that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Box")
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
     *                  ref="#/definitions/Box"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateBoxAPIRequest $request)
    {
        $input = $request->all();

        /** @var Box $box */
        $box = $this->boxRepository->findWithoutFail($id);

        if (empty($box)) {
            return $this->sendError('Box not found');
        }

        $box = $this->boxRepository->update($input, $id);

        return $this->sendResponse($box->toArray(), 'Box updated successfully');
    }

    /**
     * @param int $id
     *
     * @return Response
     *
     * @SWG\Delete(
     *      path="/boxes/{id}",
     *      summary="Remove the specified Box from storage",
     *      tags={"Box"},
     *      description="Delete Box",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Box",
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
        /** @var Box $box */
        $box = $this->boxRepository->findWithoutFail($id);

        if (empty($box)) {
            return $this->sendError('Box not found');
        }

        $box->delete();

        return $this->sendResponse($id, 'Box deleted successfully');
    }
}
