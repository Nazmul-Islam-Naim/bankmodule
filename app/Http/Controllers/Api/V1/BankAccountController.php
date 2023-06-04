<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Identifier;
use App\Helpers\Helper;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\BankAccount\CreateRequest;
use App\Http\Requests\BankAccount\DepositRequest;
use App\Http\Requests\BankAccount\UpdateRequest;
use App\Http\Requests\BankAccount\UpdateStatusRequest;
use App\Http\Resources\BankAccount\BankAccountResource;
use App\Http\Resources\BankAccount\BankAccountResourcesCollection;
use App\Http\Resources\Banks\BankResource;
use App\Http\Resources\Banks\BankResourcesCollection;
use App\Services\BankAccountService;
use App\Services\BankService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BankAccountController extends ApiController
{

    public function __init__(){
        $this->service = new BankAccountService();
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
            $bankAccounts = $this->service->index(
                [
                    "filters"    =>  $request->query() ? Arr::only($request->query(), ['search','trashed']) : []
                ],
                true,
                50,
                $request->query("page")
            );
            return $this->respond(new BankAccountResourcesCollection($bankAccounts));
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
   public function show(Identifier $bankAccount, $filters = [])
    {
        try {
            $this->authorized('show')->setMessage();
            return $this->respond(new BankAccountResource($this->service->show($bankAccount)));
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
    public function update(UpdateRequest $request, Identifier $bankAccount)
    {
        try {
            return $this->authorized("update")->setMessage()
                ->respond(new BankAccountResource($this->dispatchService->update($bankAccount, $request->all())));
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


    /**
     * Deposit amount into bank account.
     *
     * @param  \Illuminate\Http\DepositRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deposit(DepositRequest $request, $id)
    {
        try {
            return $this->authorized("deposit")->setMessage()
                ->respond($this->service->deposit($id, $request->all()));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }


    /**
     * withdraw amount from bank account.
     *
     * @param  \Illuminate\Http\DepositRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function withdraw(DepositRequest $request, $id, $status = null)
    {
        try {
            return $this->authorized("deposit")->setMessage()
                ->respond($this->service->deposit($id, $request->all()));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }
}
