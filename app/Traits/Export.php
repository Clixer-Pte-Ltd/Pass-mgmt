<?php
namespace App\Traits;

use PDF;

trait Export
{
    public function exportExcel()
    {
        $dataExport = $this->filterExport($this->crud->getEntries());
        return $dataExport->downloadExcel(
            $this->crud->entity_name_plural . '.xlsx',
            $writerType = null,
            $headings = true
        );
    }

    public function exportPdf()
    {
        $dataExport = $this->filterExport($this->crud->getEntries());
        $headings = array_keys($dataExport->first());
        $pdf = PDF::loadView('vendor.backpack.crud.export.list_pdf', ['headings' => $headings, 'data' => $dataExport]);
        return $pdf->download($this->crud->entity_name_plural . '.pdf');
    }
}