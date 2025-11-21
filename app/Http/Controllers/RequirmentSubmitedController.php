<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequirmentSubmited;
use Illuminate\Support\Facades\Auth;

class RequirmentSubmitedController extends Controller
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
        //
        //  get the current login user or student

        $student_id = Auth::user()->id;

        try {
            // handle Validation
            $validated = $request->validate([
                'requestor_name' => 'required',
                'section' => 'required',
                'course' => 'required',
                 'teacher_id' => 'required|integer',
                'drive_link' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048' // optional, max 2MB
            ]);


            //  handle na image upload
            if ($request->hasFile('image')) {
                $file = $request->file('image'); // get the uploaded file

                // Optional: generate a unique file name
                $filename = time() . '_' . $file->getClientOriginalName();

                // Store file in "storage/app/public/requirements"
                $path = $file->storeAs('requirements', $filename, 'public');

                // Save the path in the database if needed
                $validated['image'] = $path;
            }


              RequirmentSubmited::create([
                'requestor_name' => $validated['requestor_name'],
                'teacher_or_office' => $validated['teacher_id'],
                'section' => $validated['section'],
                'course' => $validated['course'],
                'drive_link' => $validated['drive_link'],
                'student_id' => $student_id,
                'image' => $validated['image'] ?? null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Your requirment is successfully submited',
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
    }
}
