<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Identifier;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Banks\CreateRequest;
use App\Http\Requests\Banks\UpdateRequest;
use App\Http\Requests\Banks\UpdateStatusRequest;
use App\Http\Resources\Banks\BankResource;
use App\Http\Resources\Banks\BankResourcesCollection;
use App\Services\BankService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BankController extends ApiController
{

    public function __init__(){
        $this->service = new BankService();
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
            $banks = $this->service->index(
                [
                    "filters"    =>  $request->query() ? Arr::only($request->query(), ['search','trashed']) : []
                ],
                true,
                50,
                $request->query("page")
            );
            return $this->respond(new BankResourcesCollection($banks));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CreateRequest  $request
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
   public function show(Identifier $bank, $filters = [])
    {
        try {
            $this->authorized('show')->setMessage();
            return $this->respond(new BankResource($this->service->show($bank)));
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
    public function update(UpdateRequest $request, Identifier $bank)
    {
        try {
            return $this->authorized("update")->setMessage()
                ->respond(new BankResource($this->dispatchService->update($bank, $request->all())));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    
    /**
     * statusUpdate
     *
     * @param  mixed $request
     * @param  mixed $admin
     * @return void
     */
    public function statusUpdate(UpdateStatusRequest $request, Identifier $id)
    {

        try {
            return $this->authorized("update")->setMessage()
                ->respond($this->dispatchService->updateStatus($id, $request->all()));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }
}
