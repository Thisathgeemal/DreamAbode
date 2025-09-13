<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
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
        if ($request->filled('role')) {
            return $this->generateUserReport($request);
        }

        // CASE 2: Subscription type report
        if ($request->input('type') === 'subscriptionType') {
            return $this->generateSubscriptionReport($request);
        }

        // CASE 3: Subscription report for admin
        if ($request->input('type') === 'adminsubscription') {
            return $this->generateAdminSubscriptionReport($request);
        }

        // CASE 4: Subscription report for member
        if ($request->input('type') === 'membersubscription') {
            return $this->generateUserSubscriptionReport($request);
        }

        // CASE 5: Payment report for admin
        if ($request->input('type') === 'adminpayment') {
            return $this->generateAdminPaymentReport($request);
        }

        // CASE 6: Payment report for member
        if ($request->input('type') === 'memberpayment') {
            return $this->generateUserPaymentReport($request);
        }

        // If neither, return error
        return response()->json([
            'error' => 'Invalid request. Specify a valid role or type.',
        ], 400);
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

    /**
     * Format date for reports
     */
    protected function getFormattedDate($datetimeInput)
    {
        return Carbon::parse($datetimeInput)->format('Y-m-d');
    }

    /**
     * Abort if required parameters are missing
     */
    protected function abortIfMissing($params)
    {
        foreach ($params as $param) {
            if (! $param) {
                abort(400, 'Missing required parameters.');
            }
        }
    }

    /**
     * User detail report
     */
    public function generateUserReport(Request $request)
    {
        $datetimeInput = Carbon::now();
        $role          = $request->input('role');
        $this->abortIfMissing([$datetimeInput, $role]);

        $formattedDate = $this->getFormattedDate($datetimeInput);
        $users         = User::whereJsonContains('user_roles', [$role])->get();
        $pdf           = Pdf::loadView('report.userReport', compact('formattedDate', 'role', 'users'));

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "attachment; filename=\"{$role}_report.pdf\"");
    }

    /**
     * SubscriptionType detail report
     */
    public function generateSubscriptionReport(Request $request)
    {
        $datetimeInput = Carbon::now();
        $this->abortIfMissing([$datetimeInput]);

        $formattedDate     = $this->getFormattedDate($datetimeInput);
        $subscriptionTypes = SubscriptionType::all();
        $pdf               = Pdf::loadView('report.subscriptionTypeReport', compact('formattedDate', 'subscriptionTypes'));

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "attachment; filename=\"Subscription_type_report.pdf\"");
    }

    /**
     * Admin subscription report (all subscriptions)
     */
    public function generateAdminSubscriptionReport(Request $request)
    {
        $datetimeInput = Carbon::now();
        $this->abortIfMissing([$datetimeInput]);

        $formattedDate = $this->getFormattedDate($datetimeInput);
        $subscriptions = Subscription::with(['member', 'subscriptionType'])->get();
        $pdf           = Pdf::loadView('report.subscriptionDetailReport', compact('formattedDate', 'subscriptions'));

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Subscriptions_report.pdf"');
    }

    /**
     * User subscription report (subscriptions for logged-in user)
     */
    public function generateUserSubscriptionReport(Request $request)
    {
        $userId        = Auth::id();
        $datetimeInput = Carbon::now();
        $this->abortIfMissing([$datetimeInput]);

        $formattedDate = $this->getFormattedDate($datetimeInput);
        $subscriptions = Subscription::with(['member', 'subscriptionType'])
            ->where('member_id', $userId)
            ->get();

        $pdf = Pdf::loadView('report.subscriptionDetailReport', compact('formattedDate', 'subscriptions'));

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="My_Subscriptions_Report.pdf"');
    }

    /**
     * Admin payment report (all payments in the system)
     */
    public function generateAdminPaymentReport(Request $request)
    {
        $datetimeInput = Carbon::now();
        $this->abortIfMissing([$datetimeInput]);

        $formattedDate = $this->getFormattedDate($datetimeInput);
        $payments      = Payment::with(['member'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('report.paymentDetailReport', compact('formattedDate', 'payments'));

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Payments_Report.pdf"');
    }

    /**
     * User payment report (payments for logged-in user)
     */
    public function generateUserPaymentReport(Request $request)
    {
        $userId        = Auth::id();
        $datetimeInput = Carbon::now();
        $this->abortIfMissing([$datetimeInput]);

        $formattedDate = $this->getFormattedDate($datetimeInput);
        $payments      = Payment::where('member_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('report.paymentDetailReport', compact('formattedDate', 'payments'));

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Payments_Report.pdf"');
    }

}
