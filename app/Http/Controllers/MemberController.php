<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;


class MemberController extends Controller
{
    //
    public function index(Request $request)
    {
        $title = "Member";
        $q = trim((string) $request->query('q', ''));

        $Members = Member::with('group')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('names', 'like', '%' . $q . '%')
                        ->orWhere('national_ID', 'like', '%' . $q . '%');
                });
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10)
            ->withQueryString();
        $Groups = Group::orderBy('created_at', 'DESC')->get();
        return view('member.index', compact('title', 'Members', 'Groups'));
    }

    public function handleAction(Request $request)
    {
        // Validate input
        $request->validate([
            'action'        => 'required|in:INSERT,UPDATE,DELETE',
            'id'            => 'nullable|required_if:action,UPDATE,DELETE|integer',
            // 'member_code'   => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
            'names'         => 'nullable|required_if:action,INSERT,UPDATE|string|max:255',
            'phone'         => 'nullable|required_if:action,INSERT,UPDATE|string|max:20',
            'gender'        => 'nullable|required_if:action,INSERT,UPDATE|string|in:MALE,FEMALE',
            'group_id'      => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'national_ID'   => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
            'joinDate'      => 'nullable|required_if:action,INSERT,UPDATE|date',
            'Shares'        => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            'status'        => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
        ]);


        DB::statement(
            'CALL sp_members(?,?,?,?,?,?,?,?,?,?,?)',
            [
                $request->action,    // p_action
                $request->id,        // p_id
                NULL,                // p_member_code (ignored, SP will generate automatically)
                $request->names,     // p_names
                $request->phone,     // p_phone
                $request->gender,    // p_gender
                $request->group_id,  // p_group_id
                $request->national_ID, // p_national_ID
                $request->joinDate,  // p_joinDate
                $request->Shares,    // p_shares
                $request->status     // p_status
            ]
        );


        return back()->with('success', 'Action ' . $request->action . ' performed successfully!');
    }

    /**
     * Download the Excel import template.
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();

        // ── Members sheet ──────────────────────────────────────────────────────
        $ws = $spreadsheet->getActiveSheet();
        $ws->setTitle('Members');

        $headers = [
            'A1' => 'Names *',
            'B1' => 'Phone *',
            'C1' => 'Gender *',
            'D1' => 'National ID *',
            'E1' => 'Join Date (YYYY-MM-DD) *',
            'F1' => 'Shares *',
            'G1' => 'Status *',
        ];

        foreach ($headers as $cell => $label) {
            $ws->setCellValue($cell, $label);
        }

        // Header styling
        $ws->getStyle('A1:G1')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Arial', 'size' => 11],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F4E79']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]],
        ]);
        $ws->getRowDimension(1)->setRowHeight(22);

        // Sample row
        $sample = ['John Doe', '0781234567', 'MALE', '1199080012345678', '2024-01-15', 100, 'ACTIVE'];
        $cols   = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        foreach ($cols as $i => $col) {
            $ws->setCellValue($col . '2', $sample[$i]);
        }
        $ws->getStyle('A2:G2')->applyFromArray([
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EBF3FB']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]],
        ]);

        // Gender dropdown validation
        $dvGender = new DataValidation();
        $dvGender->setType(DataValidation::TYPE_LIST)
            ->setErrorStyle(DataValidation::STYLE_INFORMATION)
            ->setAllowBlank(false)
            ->setShowDropDown(false)
            ->setFormula1('"MALE,FEMALE"');
        for ($r = 2; $r <= 1000; $r++) {
            $ws->getCell('C' . $r)->setDataValidation(clone $dvGender);
        }

        // Status dropdown validation
        $dvStatus = new DataValidation();
        $dvStatus->setType(DataValidation::TYPE_LIST)
            ->setErrorStyle(DataValidation::STYLE_INFORMATION)
            ->setAllowBlank(false)
            ->setShowDropDown(false)
            ->setFormula1('"ACTIVE,INACTIVE"');
        for ($r = 2; $r <= 1000; $r++) {
            $ws->getCell('G' . $r)->setDataValidation(clone $dvStatus);
        }

        // Column widths
        $widths = ['A' => 25, 'B' => 18, 'C' => 12, 'D' => 22, 'E' => 28, 'F' => 12, 'G' => 12];
        foreach ($widths as $col => $w) {
            $ws->getColumnDimension($col)->setWidth($w);
        }

        // ── Instructions sheet ─────────────────────────────────────────────────
        $wi = $spreadsheet->createSheet();
        $wi->setTitle('Instructions');
        $wi->setCellValue('A1', 'MEMBER BULK UPLOAD TEMPLATE — INSTRUCTIONS');
        $wi->getStyle('A1')->getFont()->setBold(true)->setSize(14)->setName('Arial');
        $wi->getStyle('A1')->getFont()->getColor()->setRGB('1F4E79');

        $lines = [
            3  => '1. Fill all required fields in the "Members" sheet. Row 1 is the header — do NOT delete it.',
            4  => '2. The sample row (row 2) can be deleted or overwritten.',
            5  => '3. Gender: must be exactly MALE or FEMALE',
            6  => '4. Status: must be exactly ACTIVE or INACTIVE',
            7  => '5. Join Date: use format YYYY-MM-DD (e.g., 2024-01-15)',
            8  => '6. Shares: numeric value only',
            9  => '7. Group is assigned from your selection in the upload form — no column needed in the file.',
            10 => '8. Do not add extra columns or change the column order.',
        ];
        foreach ($lines as $row => $text) {
            $wi->setCellValue('A' . $row, $text);
            $wi->getStyle('A' . $row)->getFont()->setName('Arial')->setSize(11);
        }
        $wi->getColumnDimension('A')->setWidth(80);

        $spreadsheet->setActiveSheetIndex(0);

        // Stream the file
        $writer   = new Xlsx($spreadsheet);
        $filename = 'members_import_template.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'max-age=0',
        ]);
    }

    /**
     * Handle bulk import from Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'group_id'    => 'required|integer|exists:groups,id',
            'import_file' => 'required|file|mimes:xlsx,xls|max:5120',
        ]);

        if (!$request->hasFile('import_file')) {
            return back()->withErrors(['import_file' => 'No file was uploaded. Please choose an Excel file and try again.']);
        }

        $file = $request->file('import_file');
        if (!$file->isValid()) {
            return back()->withErrors(['import_file' => 'Upload failed. Please re-select the file and try again.']);
        }

        // Always persist the uploaded file first (useful for debugging and avoiding temp-file issues).
        $storedPath = $file->storeAs(
            'imports/members',
            now()->format('Ymd_His') . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $file->getClientOriginalName() ?: 'members.xlsx')
        );

        if (!class_exists('ZipArchive')) {
            $details = [
                'php_version'   => PHP_VERSION,
                'php_sapi'      => PHP_SAPI,
                'php_binary'    => PHP_BINARY,
                'php_ini'       => php_ini_loaded_file(),
                'extension_dir' => ini_get('extension_dir'),
            ];

            return back()->withErrors([
                'import_file' => 'Your PHP runtime (web request) is missing the ZipArchive extension, which is required to read .xlsx files. '
                    . 'The file was uploaded successfully, but cannot be processed until zip is enabled. '
                    . 'Uploaded to: ' . $storedPath . '. '
                    . 'Runtime: ' . json_encode($details),
            ]);
        }

        $spreadsheet = IOFactory::load(Storage::path($storedPath));
        $ws          = $spreadsheet->getSheet(0);
        $rows        = $ws->toArray(null, true, true, true);

        $importErrors = [];
        $successCount = 0;

        // Skip header row (row index 1)
        foreach ($rows as $rowIndex => $row) {
            if ($rowIndex === 1) {
                continue; // skip header
            }

            // Skip completely empty rows
            $values = array_filter(array_map('trim', array_values($row)));
            if (empty($values)) {
                continue;
            }

            $names      = trim($row['A'] ?? '');
            $phone      = trim($row['B'] ?? '');
            $gender     = strtoupper(trim($row['C'] ?? ''));
            $nationalId = trim($row['D'] ?? '');
            $joinDate   = trim($row['E'] ?? '');
            $shares     = $row['F'] ?? null;
            $status     = strtoupper(trim($row['G'] ?? ''));

            // Per-row validation
            $rowErrors = [];
            if (empty($names))                              $rowErrors[] = 'Names is required';
            if (empty($phone))                              $rowErrors[] = 'Phone is required';
            if (!in_array($gender, ['MALE', 'FEMALE']))     $rowErrors[] = 'Gender must be MALE or FEMALE';
            if (empty($nationalId))                         $rowErrors[] = 'National ID is required';
            if (empty($joinDate))                           $rowErrors[] = 'Join Date is required';
            if (!is_numeric($shares))                       $rowErrors[] = 'Shares must be numeric';
            if (!in_array($status, ['ACTIVE', 'INACTIVE'])) $rowErrors[] = 'Status must be ACTIVE or INACTIVE';

            if (!empty($rowErrors)) {
                $importErrors[] = "Row {$rowIndex}: " . implode(', ', $rowErrors);
                continue;
            }

            // Normalise date (Excel may return a float serial or string)
            if (is_numeric($joinDate)) {
                $joinDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($joinDate)->format('Y-m-d');
            } else {
                try {
                    $joinDate = \Carbon\Carbon::parse($joinDate)->format('Y-m-d');
                } catch (\Exception $e) {
                    $importErrors[] = "Row {$rowIndex}: Invalid Join Date format";
                    continue;
                }
            }

            try {
                DB::statement('CALL sp_members(?,?,?,?,?,?,?,?,?,?,?)', [
                    'INSERT',
                    null,
                    null,
                    $names,
                    $phone,
                    $gender,
                    $request->group_id,
                    $nationalId,
                    $joinDate,
                    (float) $shares,
                    $status,
                ]);
                $successCount++;
            } catch (\Exception $e) {
                $importErrors[] = "Row {$rowIndex} ({$names}): " . $e->getMessage();
            }
        }

        $message = "{$successCount} member(s) imported successfully.";
        if (!empty($importErrors)) {
            $message .= ' ' . count($importErrors) . ' row(s) had errors — see details below.';
            return back()
                ->with('success', $message)
                ->with('import_errors', $importErrors);
        }

        return back()->with('success', $message);
    }
}
