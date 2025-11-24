<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $subjectList =  Subject::pluck('subject_name');

            return response([
                'success' => true,
                'data' => $subjectList
            ]);
        } catch (\Throwable $th) {
            return response([
                'success' => false,
                'data' => $th->getMessage()
            ]);
        }
    }


    public function ShowToAdmin()
    {
        //
        try {
            $subjectList =  Subject::all();

            return response([
                'success' => true,
                'data' => $subjectList
            ]);
        } catch (\Throwable $th) {
            return response([
                'success' => false,
                'data' => $th->getMessage()
            ]);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $validated =  $request->validate([
                'Subject_name' => 'required|unique:Subject'
            ]);

            Subject::create($validated);

            return response()->json([
                'success' => true,
                'message' => " New subject is Successfully Created"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => $th->getMessage()
            ]);
        }
    }



    public function TotalSibject()
    {
        try {
            $counted = Subject::count();

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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $subject = Subject::findOrFail($id);
            $subject->delete();

            return response()->json([
                'success' => true,
                'message' => "$subject->Subject_name is successfully deleted!"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()

            ]);
        }
    }
}
