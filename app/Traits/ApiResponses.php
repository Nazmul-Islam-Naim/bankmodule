<?php

namespace App\Traits;

use App\Exceptions\GeneralException;
use App\Exceptions\OtpException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

trait ApiResponses
{
    /**
     * @var int
     */
    public $responseCode = 200;

    /**
     * @var string
     */
    public $message = 'OK';

    /**
     * @var string
     */
    public $title = 'Success';

    /**
     * @param int $code
     * @return $this
     */
    public function setCode(int $code = 200): self
    {
        $this->responseCode = $code;
        return $this;
    }

    public function getExceptionCode($code = 500)
    {
        return is_int($code) && $code && $code!=0?$code:500;
    }


    /**
     * @param $title
     * @return $this
     */
    public function setTitle($title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function respond($data): JsonResponse
    {
        return response()
            ->json(
                [
                    "status"=>true,
                    'message' => $this->message,
                    'code' => $this->responseCode,
                    'data' => $data
                ],
                $this->responseCode
            );
    }


    /**
     * @param Exception $exception
     * @param array $data
     * @param string $title
     * @return JsonResponse
     */
    public function exceptionRespond($exception, array $data = [], string $title = 'Error')
    {

        if($exception instanceof GeneralException ){
            $message = $exception->message();
        }else if($exception instanceof AuthenticationException){
            $message = $exception->getMessage();
            $title = 'credentials';
        }
        else if($exception instanceof ValidationException){
            return response()->json(
                [
                    "status"=>false,
                    'title' => 'Validation Error',
                    'message' => $exception->getMessage(),
                    'errors'=>[$exception->errorBag=>$exception->errors()]
                ],422);
        }
        else{
            Log::error($exception);
            $message = "Something went wrong";
        }

        if($exception instanceof OtpException ){
            $message = $exception->message();
            $title = 'otp';
        }

        return response()->json(
            [
                "status"=>false,
                'title' => $title,
                'message' => $message,
                'code'=>$exception->getCode()?$exception->getCode():500
            ],$exception->getCode()?$exception->getCode():500);
    }

    /**
     * @param Exception $exception
     * @param string $title
     * @return JsonResponse
     */
    public function respondWithExceptionError(Exception $exception, string $title = 'Error'): JsonResponse
    {
        return response()
            ->json(
                [
                    'title' => $this->title,
                    'message' => $this->message,
                ],
                $exception->getCode()
            );
    }

    /**
     * @param $message
     * @param $code
     * @return JsonResponse
     */
    protected function errorResponse($message, $code): JsonResponse
    {
        return response()->json(
            [
                "status"    =>  false,
                'message'   =>  $message,
                'code'      =>  $code
            ],
            $code==0?403:$code);
    }

    /**
     * [Description for respondWithSuccess]
     *
     * @return [type]
     *
     */
    protected function respondWithSuccess(){
        return response()->json(
            [
                'message' => $this->message,
                'code' => $this->responseCode,
            ],
            $this->responseCode
        );
    }

    /**
     * @param $data
     * @param $code
     * @return JsonResponse
     */
    private function successResponse($data, $code=200): JsonResponse
    {
        return response()->json(
            [
                "status"    =>  true,
                "data"      =>  $data
            ],
            $code);
    }

}
