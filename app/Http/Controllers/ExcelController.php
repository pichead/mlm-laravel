<?php




namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use DateTime;



class ExcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function download(Request $request){

        // return($_POST["file_content"]);
      if(isset($request["file_content"]))
          {
             $temporary_html_file = './tmp_html/' . time() . '.html';

             file_put_contents($temporary_html_file, $_POST["file_content"]);

             $reader = IOFactory::createReader('Html');

             $spreadsheet = $reader->load($temporary_html_file);
            //  $spreadsheet->getStyle('1:4')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);

            $spreadsheet->getActiveSheet()->getStyle('A:J')->getAlignment()->setHorizontal('center');
             
             $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

             date_default_timezone_set("Asia/Bangkok");
             $date_time = new DateTime();
             $filename = $request['file_name'].' '.$date_time->format('d-m-Y').'.xlsx';

             $writer->save($filename);

             header('Content-Type: application/x-www-form-urlencoded');

             header('Content-Transfer-Encoding: Binary');

             header("Content-disposition: attachment; filename=\"".$filename."\"");

             readfile($filename);

             unlink($temporary_html_file);

             unlink($filename);

             exit;
          }

    }
    // public function download(Request $request){
    //
    //     $file = new Spreadsheet();
    //     $active_sheet = $file->getActiveSheet();
    //     $active_sheet->setCellValue('A1', 'First Name');
    //     $active_sheet->setCellValue('B1', 'Last Name');
    //     $active_sheet->setCellValue('C1', 'Created At');
    //     $active_sheet->setCellValue('D1', 'Updated At');
    //
    //     $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, "Xlsx");
    //
    //     $file_name = time() . '.' . strtolower("Xlsx");
    //     $writer->save($file_name);
    //
    //
    //    header('Content-Type: application/x-www-form-urlencoded');
    //     header('Content-Transfer-Encoding: Binary');
    //
    //   header("Content-disposition: attachment; filename=\"".$file_name."\"");
    //    readfile($file_name);
    //    unlink($file_name);
    //
    //  exit;
    //
    // }
    // public function stockHistory(Request $request){
    //
    //   header('Content-Type: application/vnd.ms-excel');
    //   header('Content-disposition: attachment; filename='.rand().'.xls');
    //   echo $request["data"];
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
