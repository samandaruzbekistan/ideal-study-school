<?php

namespace App\Http\Controllers;

use App\Repositories\StudentRepository;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function __construct(
        protected StudentRepository $studentRepository,
    )
    {
    }

    public function generatePDF($student_id)
    {
        $student = $this->studentRepository->getStudentById($student_id);
        $newDate = date("d.m.Y", strtotime($student->come_date));
        $data = [
            'id' => $student->id,
            'name' => $student->name,
            'contribution' => $student->contribution,
            'date' => $newDate,
        ];

        $pdf = PDF::loadView('exports.pdf_template', $data);

        return $pdf->download('shartnoma.pdf');
    }
}
