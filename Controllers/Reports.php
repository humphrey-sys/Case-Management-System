<?php

namespace App\Controllers;

use App\Models\CaseModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use Dompdf\Dompdf;
use PhpOffice\PhpWord\PhpWord;

class Reports extends BaseController
{
    public function SuperadminReports()
{
    $caseModel = new \App\Models\CaseModel();

    // Get case counts
    $totalCases = $caseModel->countAll();
    $resolvedCases = $caseModel->whereIn('status', ['resolved', 'closed'])->countAllResults();
    $openCases = $caseModel->where('status', 'open')->countAllResults();

    // Get cases grouped by region
    $casesPerRegion = $caseModel->select('region, COUNT(*) as total')
                                ->groupBy('region')
                                ->findAll();

    // Get all cases
    $allCases = $caseModel->findAll();

    return $this->response->setJSON([
        'totalCases' => $totalCases,
        'resolvedCases' => $resolvedCases,
        'openCases' => $openCases,
        'casesPerRegion' => $casesPerRegion,
        'allCases' => $allCases
    ]);
}


    public function downloadTxt($id)
    {
        $model = new CaseModel();
        $case = $model->find($id);

        if (!$case) {
            return redirect()->back()->with('error', 'Case not found');
        }

        $content = "Case Report\n\n";
        $content .= "ID: {$case['id']}\n";
        $content .= "Title: {$case['title']}\n";
        $content .= "Region: {$case['region']}\n";
        $content .= "Status: {$case['status']}\n";
        $content .= "Officer: {$case['officer_id']}\n";
        $content .= "Created At: {$case['created_at']}\n";

        return $this->response
                    ->setHeader('Content-Type', 'text/plain')
                    ->setHeader('Content-Disposition', 'attachment; filename=case_' . $id . '.txt')
                    ->setBody($content);
    }

   

public function downloadPdf($id)
{
    $model = new CaseModel();
    $case = $model->find($id);

    if (!$case) {
        return redirect()->back()->with('error', 'Case not found');
    }

    $dompdf = new Dompdf();

    // 🔁 Wrap in an array so view can loop over it
    $html = view('exports/pdf_view', ['cases' => [$case]]);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // 📄 Download the PDF with the case ID in the filename
    $dompdf->stream("case_{$id}.pdf", ["Attachment" => true]);
}

    // Export to Word (DOCX)
    public function downloadDocx($id)
    {
        $model = new CaseModel();
        $case = $model->find($id);

        if (!$case) {
            return redirect()->back()->with('error', 'Case not found');
        }

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addTitle('Case Report', 1);
        $section->addText("ID: {$case['id']}");
        $section->addText("Title: {$case['title']}");
        $section->addText("Region: {$case['region']}");
        $section->addText("Status: {$case['status']}");
        $section->addText("Officer ID: {$case['officer_id']}");
        $section->addText("Created At: {$case['created_at']}");

        $file = WRITEPATH . "case_{$id}.docx";
        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($file);

        return $this->response
                    ->download($file, null)
                    ->setFileName("case_{$id}.docx");
    }
}
