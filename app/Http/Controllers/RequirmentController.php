<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RequirmentModel;

class RequirmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $requirements = RequirmentModel::all();

            return response()->json([
                'success' => true,
                'requirments' => $requirements
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function CounteTotalRequirmentByTeacherId()
    {

        //  ghet the current teacher Login
        $teacherId = Auth::user()->id;

        try {
            $counted = RequirmentModel::where('teacher_id', $teacherId)->count();

            return response()->json([
                'success' => true,
                'counted' => $counted
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()

            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $teacher = Auth::user()->id;

        try {
            $validated = $request->validate([
                'requirment' => 'required|min:5',
                'detail' => 'required|min:5',
                'subject' => 'required'
            ]);

            RequirmentModel::create([
                'title' => $validated['requirment'],
                'detail' => $validated['detail'],
                'subject' => $validated['subject'],
                'teacher_id' => $teacher
            ]);

            return response()->json([
                'success' => true,
                'message' => "{$validated['requirment']} is successfully created"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => $th->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function showByTeacherId($teacherId)
    {
        try {
            $list = RequirmentModel::select('title', 'detail', 'subject')
                ->where('teacher_id', $teacherId)
                ->get();

            return response()->json([
                'success' => true,
                'list' => $list
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
        try {
            $list = RequirmentModel::findOrFail($id);

            $list->delete();
            return response()->json([
                'success' => true,
                'message' => 'successfully deleted'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
