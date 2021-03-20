<?php

namespace App\Http\Controllers\V1;

use App\Complaint;
use App\Http\Controllers\Controller;
use App\Services\ComplaintService;
use Exception;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    protected $compliantService;

    public function __construct(ComplaintService $complaintService)
    {
        $this->compliantService = $complaintService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->only(['per_page']);

        $result = ['status' => 200];

        try {
            $this->authorize('viewAny', Complaint::class);
            $result['data'] = $this->compliantService->getPaginatedComplaints($data);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = ['status' => '201'];

        try {
            $this->authorize('create', Complaint::class);
            $result['data'] = $this->compliantService->saveComplaintData($request->all());
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $result = ['status' => '200'];

        try {
            $data = $this->compliantService->getComplaintById($id);
            $this->authorize('view', $data);

            if (is_null($data)) {
                $result['status'] = '404';
            }

            $result['data'] = $data;
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $result = ['status' => '200'];

        try {
            $this->authorize('create', Complaint::class);
            $data = $this->compliantService->saveComplaintData($request->all(), $id);

            if (is_null($data)) {
                $result['status'] = '404';
            }

            $result['data'] = $data;
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $result = ['status' => '204'];

        try {
            $this->authorize('delete', Complaint::find($id));
            if (!$this->compliantService->deleteComplaintById($id)) {
                $result = [
                    'status' => 404,
                    'error' => 'resource not found'
                ];
            }
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
