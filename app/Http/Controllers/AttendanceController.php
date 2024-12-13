<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration; // Import the Registration model
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    // Show the attendance form
    public function showForm()
    {
        return view('form.attendeelist');
    }

    // Handle the form submission
    public function submitForm(Request $request)
    {
        // Log the incoming request data to debug
        Log::info('Form submitted:', $request->all());

        // Validate the mobile number
        $validated = $request->validate([
            'mobile_number' => 'required|numeric|digits:10',  // Adjust validation as needed
        ]);

        // Fetch all matching registration records for the provided mobile number
        $registrations = Registration::where('mobile', $validated['mobile_number'])
            ->orWhere('father_mobile', $validated['mobile_number'])
            ->orWhere('mother_mobile', $validated['mobile_number'])
            ->get();

        if ($registrations->isNotEmpty()) {
            $alreadyMarked = [];
            $updated = [];
            $userIds = [];  

            foreach ($registrations as $registration) {
                if ($registration->is_attendance == 1) {
                    $alreadyMarked[] = $registration->name;
                } else {
                    $registration->is_attendance = 1;
                    $registration->save();
                    $updated[] = $registration->name;
                    $userIds[] = $registration->id;
                }
            }

            if (!empty($alreadyMarked)) {
                $alreadyMarkedNames = implode(', ', $alreadyMarked);
                session()->flash('info', "Attendance already marked for: $alreadyMarkedNames.");
            }

            if (!empty($updated)) {
                $updatedNames = implode(', ', $updated);
                session()->flash('success', "Attendance recorded successfully for: $updatedNames.");

                // Redirect to kitRequestForm with user IDs
                return redirect()->route('form.kitrequestform', ['user_ids' => implode(',', $userIds)]);
            }

            if (empty($updated)) {
                // No new attendance was marked
                return redirect()->route('form.attendeelist')->with('info', "इस नंबर के सभी पंजीकरणों ने किट प्राप्त कर ली है।");
            }

            return redirect()->route('form.attendeelist');
        } else {
            // No records found
            return redirect()->route('form.attendeelist')->with('error', "प्रदान किए गए मोबाइल नंबर के लिए कोई पंजीकरण नहीं मिला है।");
        }
    }

    public function submitKit(Request $request)
    {
        // Get the array of user IDs from the request
        $userIds = $request->input('user_ids');

        // Check if user_ids are provided
        if ($userIds) {
            // Loop through each user ID and update the 'is_kit' field
            foreach ($userIds as $userId) {
                // Find the user by ID and mark 'is_kit' as 1
                $user = Registration::find($userId);
                if ($user) {
                    $user->is_kit = 1;  // Mark 'is_kit' as 1
                    $user->save();       // Save the updated record
                }
            }

            // Redirect to the "Thank You" page with a success message
            return redirect()->route('form.kitthankyou')->with('success', 'Kit marked as received for selected users.');
        } else {
            // If no user IDs were found, redirect with an error message
            return redirect()->route('form.attendeelist')->with('error', 'No users selected.');
        }
    }
}
