<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use App\Traits\ApiResponser;
use Illuminate\Validation\ValidationException;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    
     use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
            $this->reportable(function (Throwable $e) {
                //
            });
            
          
          
    $this->renderable(function (Throwable $exception, $request) {
        if ($request->is('api/*')) {
            if($exception instanceof ValidationException){
                return $this->convertValidationExceptionToResponse($exception,$request);
            }
            // Not used in Laravel 8.x
         /*   if($exception instanceof ModelNotFoundException){
                $modelName = class_basename($exception->getModel());
                return $this->errorResponse("{$modelName} does not exist with specified id",404);
            }
        */
            if($exception instanceof AuthenticationException){
                return $this->unauthenticated($request,$exception);
            }
            if($exception instanceof AuthorizationException){
                return $this->errorResponse($exception->getMessage(),403);
            }
            if(!config('app.debug')){
            if($exception instanceof NotFoundHttpException){
                return $this->errorResponse('This URL cannot be found',404);
            }
            }
            if($exception instanceof MethodNotAllowedHttpException){
                return $this->errorResponse('The specified method for request is invalid',405);    
            }
            if($exception instanceof HttpException){
                return $this->errorResponse($exception->getMessage(),$exception->getStatusCode());    
            } 
        
         /*  if(config('app.debug')){
                return parent::render($request, $exception);
           } 
      */
         if(!config('app.debug')){
            return $this->errorResponse('Unexpected Exception. Please try again later',500);
         }
        } //#endif
     });
    }
    
      protected function convertValidationExceptionToResponse(ValidationException $e, $request){
        $errors = $e->validator->errors()->getMessages();
        return $this->errorResponse($errors,422);

    }

    protected function unauthenticated($request, AuthenticationException $exception){
        return $this->errorResponse('Unauthenticated for sure!',401);
    }
    
}
