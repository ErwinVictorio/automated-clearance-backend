<?php

namespace App\Http\Controllers;

use App\Models\Annoucement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $annoucements = Annoucement::with('User')->get();
            if ($annoucements) {

                return response()->json([
                    'success' => true,
                    'announcement' => $annoucements
                ]);
            }
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

        $teacherId = Auth::user()->id;

        try {
            $validated = $request->validate([
                'title' => 'required|min:3',
                'message' => 'required|min:5',
            ]);

            Annoucement::create([
                'title' => $validated['title'],
                'message' => $validated['message'],
                'teacher_or_office_id' => $teacherId
            ]);

            return response()->json([
                'success' => true,
                'message' => "$validated[title] is successfully created"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => true,
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
    }
}
