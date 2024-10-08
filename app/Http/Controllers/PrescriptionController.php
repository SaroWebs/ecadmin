<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\CustomerLogin;
use Illuminate\Support\Facades\Storage;

class PrescriptionController extends Controller
{

    public function get_customer(Request $request)
    {
        $token = $request->header('Authorization') ? explode(' ', $request->header('Authorization'))[1] : null;
        if (!$token) {
            return response()->json(['error' => 'Token is required'], 401);
        }

        $customerLogin = CustomerLogin::where('token', $token)->first();
        if (!$customerLogin) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        if ($customerLogin->token_expired_at && $customerLogin->token_expired_at < now()) {
            return response()->json(['error' => 'Token has expired'], 401);
        }

        $customer = $customerLogin->customer()->first();
        return $customer;
    }


    
    public function prescription_upload(Request $request)
    {
        $customer = $this->get_customer($request);
        if (!$customer instanceof Customer) {
            return $customer; // This will return the error response if authentication failed
        }

        $validatedData = $request->validate([
            'image' => 'required|file',
            'status' => 'required|in:pending,assigned,unassigned',
        ]);

        // Check for an existing pending prescription
        $existingPrescription = Prescription::where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->first();

        if ($existingPrescription) {
            // Remove the previous image
            Storage::disk('public')->delete($existingPrescription->file_path);
            
            // Update the existing prescription
            $existingPrescription->file_path = $validatedData['image']->store('prescriptions', 'public');
            $existingPrescription->status = $validatedData['status'];
            $existingPrescription->save();

            return response()->json(['message' => 'Prescription updated successfully'], 200);
        } else {
            // Create a new prescription if none exists
            $imagePath = $validatedData['image']->store('prescriptions', 'public');

            $prescription = Prescription::create([
                'customer_id' => $customer->id,
                'file_path' => $imagePath,
                'status' => $validatedData['status'],
            ]);

            if ($prescription) {
                return response()->json(['message' => 'Prescription uploaded successfully'], 201);
            } else {
                return response()->json(['message' => 'Failed to upload prescription'], 400);
            }
        }
    }
    
    public function get_pending_item(Request $request)
    {
        $customer = $this->get_customer($request);
        if (!$customer instanceof Customer) {
            return $customer;
        }

        $pendingItem = Prescription::where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->first();

        return response()->json($pendingItem, 200);
    }
}
