<?php
/**
 * Created by PhpStorm.
 * User: iisac
 * Date: 10/11/19
 * Time: 12:59 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cats\Model\Cat;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Class CatController
 * @package App\Http\Controllers
 */
class CatController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $response['request_id'] = Str::uuid();
        try {
            $cats = Cat::all();
            $response['status'] = 200;
            $response['error'] = false;
            $response['data']['cats'] = $cats;
        } catch (\Exception $exception) {
            Log::critical(__METHOD__, ['error' => $exception->getMessage(), 'request_id' => $response['request_id']]);
            $response['status'] = $exception->getCode();
            $response['error'] = $exception->getMessage();
            $response['data'] = [];
        }

        return response()->json($response);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $response['request_id'] = Str::uuid();

        $this->validate($request, [
            'name' => 'required',
            'status' => 'required|in:' . implode(',', array_keys(Cat::STATUS_TRANSLATIONS)),
            'food' => 'required|integer|min:0|max:10',
        ]);

        try {
            $cat = new Cat();
            $cat->name = $request->name;
            $cat->status = $request->status;
            $cat->food = $request->food;
            $cat->save();
            $response['status'] = 200;
            $response['error'] = false;
            $response['data']['cat'] = $cat;
        } catch (\Exception $exception) {
            $response['status'] = $exception->getCode();
            $response['error'] = $exception->getMessage();
            $response['data'] = [];
            Log::critical(__METHOD__, $response);

        }

        return response()->json($response);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $response['request_id'] = Str::uuid();
        try {
            $cat = Cat::find($id);
            $response['status'] = 200;
            $response['error'] = false;
            $response['data']['cat'] = $cat;
            $response['data']['cat']['readable_status'] = Cat::STATUS_TRANSLATIONS[$cat->status];
        } catch (\Exception $exception) {
            $response['status'] = $exception->getCode();
            $response['error'] = $exception->getMessage();
            $response['data'] = [];
            Log::critical(__METHOD__, $response);
        }

        return response()->json($response);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $response['request_id'] = Str::uuid();

        $this->validate($request, [
            'name' => 'sometimes',
            'status' => 'sometimes|in:' . implode(',', array_keys(Cat::STATUS_TRANSLATIONS)),
            'food' => 'sometimes|integer|min:0|max:10',
        ]);

        try {
            $cat = Cat::find($id);
            $cat->name = $request->input('name');
            $cat->status = $request->input('status');
            $cat->food = $request->input('food');
            $cat->save();

            $response['status'] = 200;
            $response['error'] = false;
            $response['data']['cat'] = $cat;
        } catch (\Exception $exception) {
            $response['status'] = $exception->getCode();
            $response['error'] = $exception->getMessage();
            $response['data'] = [];
            Log::critical(__METHOD__, $response);
        }


        return response()->json($response);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $response['request_id'] = Str::uuid();
        try {
            $cat = Cat::find($id);
            $cat->delete();
            $response['status'] = 200;
            $response['error'] = false;
            $response['data'] = 'cat has left the farm!';
        } catch (\Exception $exception) {
            $response['status'] = $exception->getCode();
            $response['error'] = $exception->getMessage();
            $response['data'] = [];
            Log::critical(__METHOD__, $response);
        }


        return response()->json($response);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function feed(Request $request, $id)
    {
        $response['request_id'] = Str::uuid();
        $this->validate($request, [
            'food' => 'required|integer|min:0|max:10',
        ]);
        try {
            $cat = Cat::find($id);
            $cat->food += $request->input('food');
            $cat->save();
            $response['status'] = 200;
            $response['error'] = false;
            $response['data']['cat'] = $cat;
            $response['data']['message'] = 'Cat '.$cat->name.' was fed. Thank you';
        } catch (\Exception $exception) {
            $response['status'] = $exception->getMessage();
            $response['error'] = $exception->getMessage();
            $response['data'] = [];
            Log::critical(__METHOD__, $response);
        }

        return response()->json($response);

    }
}
