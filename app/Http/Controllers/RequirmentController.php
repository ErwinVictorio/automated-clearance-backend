<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RequirmentModel;
use App\Models\User;

class RequirmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // create Requitment by teacher
        //  get the current user or techer login

        $teacher = Auth::user()->id;

        try {
            //  now validate the requirment input
            $validated = $request->validate([
                'requirment' => 'required|min:5',
                'detail' => 'required|min:5',
                'subject' => 'required'
            ]);


            // now create the Requirment 
            RequirmentModel::create([
                'title' => $validated['requirment'],
                'detail' => $validated['detail'],
                'subject' => $validated['subject'],
                'teacher_id' => $teacher
            ]);

             return response()->json([
                 'success' => true,
                 'message' => "$validated[requirment] is successfully created"
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                 'success' => false,
                  'error' => $th->getMessage()
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

    public function ShowByTeacherId(string $id){


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
    }
}
