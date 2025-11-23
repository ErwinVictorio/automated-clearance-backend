<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 
        $search = $request->query('search');

        try {

            $teacher = User::where('role', '1')
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('full_name', 'like', "%{$search}%")
                            ->orWhere('section', 'like', "%{$search}%");
                    });
                })
                ->paginate(10);

            if ($teacher) {
                return response()->json([
                    'success' => true,
                    'teacher' => $teacher
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => $th->getMessage()
            ]);
        }
    }


    public function showTeacherName()
    {

        try {
            $teacher =  User::select('full_name', 'course', 'section', 'id')->where('role', '1')->get();

            if ($teacher) {
                return response()->json([
                    'success' => true,
                    'teacher' => $teacher
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'No Teacher Found'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => true,
                'message' => $th->getMessage()
            ]);
        }
    }




    public function TotalTeacher()
    {
        try {
            $counted = User::where('role', '1')->count();

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
        try {
            $validated =  $request->validate([
                'full_name' => 'required',
                'course' => 'required',
                'section' => 'required',
                'username' => "required|unique:users",
                'password' => 'required',
                'yearlavel' => 'required',
            ]);


            User::create([
                'full_name' => $validated['full_name'],
                'course' => $validated['course'],
                'section' =>  $validated['section'],
                'username' => $validated['username'],
                'password' =>  $validated['password'],
                'yearlavel' =>  $validated['yearlavel'],
                'role' => 1
            ]);

            return response([
                'success' => true,
                'message' => "$validated[yearlavel] is Successfully Created"
            ]);
        } catch (\Throwable $th) {

            return response([
                'success' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.  
     */
    public function show(string $id)
    {
        //
        try {
            $result = User::from('users as teacher')
                ->join('student_requirment_sub as submitedDoc', 'teacher.id', '=', 'submitedDoc.teacher_or_office')
                ->where('teacher.id', $id)
                ->select(
                    'submitedDoc.requestor_name as student_name',
                    'submitedDoc.status as status_of_request',
                    'submitedDoc.course as section',
                    'submitedDoc.drive_link as link',
                    'submitedDoc.image as image',
                )
                ->get();
            return response([
                'success' => true,
                'result' => $result
            ]);
        } catch (\Throwable $th) {
            return response([
                'success' => false,
                'error' => $th->getMessage()
            ], 500);
        }
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
