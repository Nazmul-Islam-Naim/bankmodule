<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Identifier;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Logo\CreateRequest;
use App\Http\Requests\Logo\UpdateRequest;
use App\Http\Requests\Logo\UpdateStatusRequest;
use App\Http\Resources\Logo\LogoResource;
use App\Http\Resources\Logo\LogoResourcesCollection;
use App\Services\LogoService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class LogoController extends ApiController
{
    public function __init__(){
        $this->service = new LogoService();
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
        $logos = $this->service->index(
            [
                'filters' => $request->query() ? Arr::only($request->query(), ['search','trashed']) : []
            ],
            true,
            50,
            $request->query('page')
        );
        return $this->respond(new LogoResourcesCollection($logos));
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
            return $this->authorized('store')->setMessage()
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
    public function show(Identifier $logo, $filters = [])
    {
        try {
            $this->authorized('show')->setMessage();
            return $this->respond(new LogoResource($this->service->show($logo)));
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
    public function update(UpdateRequest $request, Identifier $logo)
    {   
        try {
            return $this->authorized('update')->setMessage()->respond(
                new LogoResource($this->dispatchService->update($logo, $request->all()))
            );
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
