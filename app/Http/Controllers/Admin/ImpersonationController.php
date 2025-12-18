<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Activity\ActivityLoggingServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    public function __construct(
        protected ActivityLoggingServiceInterface $activityLogger
    ) {}

    public function impersonate($id)
    {
        // Permission check should be handled by middleware or policy
        // authorize('impersonate', User::class); // Example

        $originalUserId = Auth::id();
        $userToImpersonate = User::findOrFail($id);

        if ($originalUserId == $userToImpersonate->id) {
            return redirect()->back()->with('error', 'You cannot impersonate yourself.');
        }

        session()->put('impersonator_id', $originalUserId);
        
        // Log the impersonation action
        $this->activityLogger->log(
            'impersonate_user',
            $userToImpersonate,
            null,
            [
                'impersonator_id' => $originalUserId,
                'impersonator_name' => Auth::user()->name,
                'target_user_id' => $userToImpersonate->id,
                'target_user_name' => $userToImpersonate->name,
            ]
        );

        Auth::login($userToImpersonate);

        return redirect()->route('dashboard')->with('success', "You are now impersonating {$userToImpersonate->name}");
    }

    public function leave()
    {
        if (! session()->has('impersonator_id')) {
            return redirect()->route('dashboard');
        }

        $originalUserId = session()->pull('impersonator_id');
        $originalUser = User::find($originalUserId);
        $impersonatedUser = Auth::user();

        // Log the action
        if ($originalUser) {
            $this->activityLogger->log(
                'stop_impersonation',
                $impersonatedUser,
                null,
                [
                    'impersonator_id' => $originalUserId,
                    'impersonator_name' => $originalUser->name,
                    'impersonated_user_id' => $impersonatedUser->id,
                    'impersonated_user_name' => $impersonatedUser->name,
                ]
            );

            Auth::login($originalUser);
        }

        return redirect()->route('dashboard')->with('success', 'You have returned to your original account.');
    }
}
