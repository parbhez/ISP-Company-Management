<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MultiFormSubmitController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */

    public function showMultiStepForm()
    {
        return Inertia::render('MultiForm/MultiStepForm', []);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function submitMultiStepForm(Request $request)
    {
        try {
            // You can add validation logic here if needed
            // Example: $this->validate($request, ['field' => 'required']);
            $formData = $request->all();
            // Process the form data or store it in the database, if needed
            return response()->json(['message' => 'Form data submitted successfully', 'data' => $formData], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
