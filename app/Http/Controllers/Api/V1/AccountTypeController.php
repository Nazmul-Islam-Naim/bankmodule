<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Identifier;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\AccountTypes\CreateRequest;
use App\Http\Requests\AccountTypes\UpdateRequest;
use App\Http\Resources\AccountTypes\AccountTypeResource;
use App\Http\Resources\AccountTypes\AccountTypeResourcesCollection;
use App\Services\AccountTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AccountTypeController extends ApiController
{

    public function __init__(){
        $this->service = new AccountTypeService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $this->authorized('index')->setMessage();
            $accountTypes = $this->service->index(
                [
                    "filters"    =>  $request->query() ? Arr::only($request->query(), ['search','trashed']) : []
                ],
                true,
                50,
                $request->query("page")
            );
            return $this->respond(new AccountTypeResourcesCollection($accountTypes));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(CreateRequest $request)
    {
        try {
            return $this->authorized("store")->setMessage()
                ->respond($this->dispatchService->store($request->all()));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function show(Identifier $accountType, $filters = [])
    {
        try {
            $this->authorized('show')->setMessage();
            return $this->respond(new AccountTypeResource($this->service->show($accountType)));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Identifier $accountType)
    {
        try {
            return $this->authorized("update")->setMessage()
                ->respond(new AccountTypeResource($this->dispatchService->update($accountType, $request->all())));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

}
