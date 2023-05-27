<?php

namespace App\Http\Controllers\Admin\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Reports\Traits\Report;
use App\Http\Controllers\Admin\Reports\Traits\OrdersReport;
use App\Http\Controllers\Admin\Reports\Traits\ProductsReport;
use App\Http\Controllers\Admin\Reports\Traits\CustomersReport;
use App\Http\Controllers\Admin\Reports\Traits\AddressesReport;
use Carbon\Carbon;
use App\Order;
use App\User;
use App\Product;
use App\Address;
use PdfReport;

class PDFController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CSVController
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for generating reports in CSV format.
    | This controller makes use of traits so we can reuse all methods.
    | find the traits from above use statements.
    | PDF stands for Portable Document File.
    |
    */


    /**
     * This Controller uses Traits
     * to provide reusable methods.
     */
    use Report,
        OrdersReport,
        ProductsReport,
        CustomersReport,
        AddressesReport;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Download pdf report.
     * 
     * @return PdfReport
     */
    public function makePDFReport(Request $request){
        
        $this->validateDates($request);

        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        
        $dates =   [
                new Carbon($dateFrom),
                new Carbon($dateTo)
            ];
        
        switch ($request->type) {
            case 'products':
                $title = $this->productReportTitle();
        
                $queryBuilder = Product::whereBetween('created_at',$dates);
        
                $columns = $this->productColumns();
            break;
            
            case 'customers':
                $title = $this->customerReportTitle();
        
                $queryBuilder = User::whereBetween('created_at',$dates);
        
                $columns = $this->customerColumns();
            break;
            
            case "addresses":
                $title = $this->addressReportTitle();
        
                $queryBuilder = Address::whereBetween('created_at',$dates);
        
                $columns = $this->addressColumns();
            break;
        
            case 'orders':
            default:
                $title = $this->reportTitle();

                $queryBuilder = Order::whereBetween('created_at',$dates);
        
                $columns = $this->orderColumns();
            break;
        }

        $meta = $this->reportMeta(
            $dateFrom,
            $dateTo
        );

        $reportName = $title.' '.$this->fileName($dateFrom,$dateTo);

        return $this->PDFReport(
                $title,
                $meta,
                $queryBuilder,
                $columns,
                $reportName
            );
    }

    /**
     * Generate the actual PDF report
     * 
     * @param string $title
     * @param array $meta
     * @param \Illuminate\Datebase\Eloquent\Builder $queryBuilder
     * @param array $columns
     * @param string $reportName
     * @return PdfReport
     */
    private function PDFReport($title,$meta,$queryBuilder,$columns,$reportName){
        return PdfReport::of(
                $title,
                $meta,
                $queryBuilder,
                $columns
            )
            ->setCss([
                '.head-content' => 'border-width: 1px',
            ])
            ->download($reportName);
    }
}
