<?php
namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $request->validate([
            'role' => 'required|string',
        ]);

        return $this->generateUserReport($request);
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
        $pdf           = Pdf::loadView('admin.report.userReport', compact('formattedDate', 'role', 'users'));

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "attachment; filename=\"{$role}_report.pdf\"");
    }
}
