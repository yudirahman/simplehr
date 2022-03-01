<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Models\Candidate;

class ApiCandidateController extends Controller
{



    /**
     * @OA\Get(
     *      path="/api/v1/all-candidate",
     *      operationId="allCandidate",
     *      tags={"Candidate"},
     *      security={
     *          {"passport": {}},
     *      },
     *      summary="Get list of candidates",
     *      description="Returns list of candidates",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     */

    public function allCandidate()
    {
        $candidates = Candidate::all();
        return response()->json([
            'status' => 'success',
            'status_code' => Response::HTTP_OK,
            'data' => [
                'candidate' => $candidates
            ],

            'message' => 'All candidates pulled out successfully'

        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/detail-candidate/{id}",
     *      operationId="detailCandidate",
     *      tags={"Candidate"},
     *      security={
     *          {"passport": {}},
     *      },
     *      summary="Get detail of candidate by id",
     *      description="Returns detail of candidate by id",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     */
    public function detailCandidate($id)
    {

        $candidate = Candidate::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'status_code' => Response::HTTP_OK,
            'data' => [
                'candidate' => $candidate
            ],

            'message' => 'Candidate detail pulled out successfully'

        ]);
    }

    /**
    * @OA\Post(
    *     path="/api/v1/store-candidate",
    *     operationId="storeCandidate",
    *     tags={"Candidate"},
    *     security={
    *         {"passport": {}},
    *     },
    *     summary="Add new candidate",
    *     description="Add new candidate",
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 @OA\Property(
    *                       property="name",
    *                       type="string",
    *                 ),
    *                 @OA\Property(
    *                       property="education",
    *                       type="string",
    *                 ),
    *                 @OA\Property(
    *                       property="birthday",
    *                       type="string",
    *                       format="date",
    *                 ),
    *                 @OA\Property(
    *                       property="experience",
    *                       type="number",
    *                 ), 
    *                 @OA\Property(
    *                       property="last_position",
    *                       type="string",
    *                 ),
    *                 @OA\Property(
    *                       property="applied_position",
    *                       type="string",
    *                 ),
    *                 @OA\Property(
    *                       property="skils",
    *                       type="string",
    *                 ),
    *                 @OA\Property(
    *                       property="email",
    *                       type="string",
    *                 ),   
    *                 @OA\Property(
    *                       property="phone",
    *                       type="number",
    *                 ),   
    *                 @OA\Property(
    *                       property="resume",
    *                       type="string",
    *                       format="binary",
    *                 ),
    *             )
    *         )
    *     ),
    *       @OA\Response(
    *           response=201,
    *           description="Success",
    *           @OA\MediaType(
    *               mediaType="application/json",
    *           )
    *       ),
    *       @OA\Response(
    *           response=401,
    *           description="Unauthenticated"
    *       ),
    *       @OA\Response(
    *           response=400,
    *           description="Bad Request"
    *       ),
    *       @OA\Response(
    *           response=404,
    *           description="not found"
    *       ),
    *       @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *       )
    *)
    */

    public function storeCandidate(Request $request)
    {
        $edu = ['SMU', 'Associate Degree', 'Bachelor\'s Degree', 'Masters Degree', 'Doctorate'];

        $request->validate([
            'name' => ['required'], 
            'education' => ['required', Rule::in($edu)],
            'birthday'  => ['required'],
            'experience' => ['required', 'numeric','min:1','max:15'],
            'last_position' => ['required'],
            'applied_position' => ['required'],
            'skils' => ['required'],
            'email' => ['required', 'unique:candidate'],
            'phone' => ['required', 'numeric', 'digits_between:10,12', 'unique:candidate'],
            'resume' => ['required', 'mimes:pdf', 'max:2048'],
        ]);

        $input = $request->all();
        if ($resume = $request->file('resume')) {
            $destinationPath = 'resume/';
            $resumeFile = date('YmdHis') . "." .$resume->getClientOriginalExtension();
            $resume->move($destinationPath, $resumeFile);
            $input['resume'] ="$resumeFile";   
        }
        Candidate::create($input);

        return response()->json(['success' => 'New record successfully added.'])->setStatusCode(Response::HTTP_CREATED);

    }

    /**
    * @OA\Post(
    *     path="/api/v1/update-candidate/{id}",
    *     operationId="updateCandidate",
    *     tags={"Candidate"},
    *     security={
    *         {"passport": {}},
    *     },
    *     summary="Update candidate",
    *     description="Update candidate",
    *      @OA\Parameter(
    *          name="id",
    *          in="path",
    *          required=true,
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 @OA\Property(
    *                       property="name",
    *                       type="string",
    *                 ),
    *                 @OA\Property(
    *                       property="education",
    *                       type="string",
    *                 ),
    *                 @OA\Property(
    *                       property="birthday",
    *                       type="string",
    *                       format="date",
    *                 ),
    *                 @OA\Property(
    *                       property="experience",
    *                       type="number",
    *                 ), 
    *                 @OA\Property(
    *                       property="last_position",
    *                       type="string",
    *                 ),
    *                 @OA\Property(
    *                       property="applied_position",
    *                       type="string",
    *                 ),
    *                 @OA\Property(
    *                       property="skils",
    *                       type="string",
    *                 ),
    *                 @OA\Property(
    *                       property="email",
    *                       type="string",
    *                 ),   
    *                 @OA\Property(
    *                       property="phone",
    *                       type="number",
    *                 ),   
    *                 @OA\Property(
    *                       property="resume",
    *                       type="string",
    *                       format="binary",
    *                 ),
    *             )
    *         )
    *     ),
    *       @OA\Response(
    *           response=201,
    *           description="Success",
    *           @OA\MediaType(
    *               mediaType="application/json",
    *           )
    *       ),
    *       @OA\Response(
    *           response=401,
    *           description="Unauthenticated"
    *       ),
    *       @OA\Response(
    *           response=400,
    *           description="Bad Request"
    *       ),
    *       @OA\Response(
    *           response=404,
    *           description="not found"
    *       ),
    *       @OA\Response(
    *          response=403,
    *          description="Forbidden"
    *       )
    *)
    */
    public function updateCandidate($id,Request $request)
    {
        $edu = ['SMU', 'Associate Degree', 'Bachelor\'s Degree', 'Masters Degree', 'Doctorate'];
        $request->validate([
            'name' => ['required'], 
            'education' => ['required', Rule::in($edu)],
            'birthday'  => ['required'],
            'experience' => ['required', 'numeric','min:1','max:15'],
            'last_position' => ['required'],
            'applied_position' => ['required'],
            'skils' => ['required'],
            'email' => ['required', Rule::unique('candidate')->ignore($id)],
            'phone' => ['required', 'numeric', 'digits_between:10,12', Rule::unique('candidate')->ignore($id)],
            'resume' => ['mimes:pdf', 'max:2048'],
        ]);

        $input = $request->all();
        if ($resume = $request->file('resume')) {
            $destinationPath = 'resume/';
            $resumeFile = date('YmdHis') . "." .$resume->getClientOriginalExtension();
            $resume->move($destinationPath, $resumeFile);
            $input['resume'] ="$resumeFile";   
        }else{
            unset($input['resume']);
        }

        $candidate =Candidate::findOrFail($id);
        $candidate->update($input);

        return response()->json(['success' => 'Record successfully update.'])->setStatusCode(Response::HTTP_CREATED);

    }

    /**
     * @OA\Delete(
     *      path="/api/v1/delete-candidate/{id}",
     *      operationId="deleteCandidate",
     *      tags={"Candidate"},
     *      security={
     *          {"passport": {}},
     *      },
     *      summary="Delete candidate by id",
     *      description="Delete candidate by id",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     */
    public function deleteCandidate($id)
    {
        $candidate = Candidate::findOrFail($id);
        unlink('resume/'.$candidate->resume);
        $candidate->delete();
        
        return response()->json(['success' => 'Record has been deleted.'])->setStatusCode(Response::HTTP_CREATED);
    }

}
