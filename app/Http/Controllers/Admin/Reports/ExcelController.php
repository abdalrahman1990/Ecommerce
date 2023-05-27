<?php

namespace App\Http\Controllers\Admin\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Reports\Traits\Report;
use App\Http\Controllers\Admin\Reports\Traits\CustomersReport;
use App\Http\Controllers\Admin\Reports\Traits\OrdersReport;
use App\Http\Controllers\Admin\Reports\Traits\ProductsReport;
use App\Http\Controllers\Admin\Reports\Traits\AddressesReport;
use Carbon\Carbon;
use App\Order;
use App\Product;
use App\User;
use App\Address;
use ExcelReport;

class ExcelController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CSVController
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for generating reports in Excel format.
    | This controller makes use of traits so we can reuse all methods.
    | find the traits from above use statements.
    |
    */


    /**
     * This Controller uses OrderTrait
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
     * Download Excel report.
     * 
     * @return ExcelReport
     */
    public function makeExcelReport(Request $request){
        
        $this->validateDates($request);

        $dateFrom = $request->date_from;
        $dateTo   = $request->date_to;

        $dates = [
            new Carbon($dateFrom),
            new Carbon($dateTo)
        ];

        switch ($request->type) {
            case "products":
                $title = $this->productReportTitle();
        
                $queryBuilder = Product::whereBetween('created_at',$dates);
        
                $columns = $this->productColumns();
            break;
            
            case "customers":
                $title = $this->customerReportTitle();
        
                $queryBuilder = User::whereBetween('created_at',$dates);
        
                $columns = $this->customerColumns();
            break;
            
            case "addresses":
                $title = $this->addressReportTitle();
        
                $queryBuilder = Address::whereBetween('created_at',$dates);
        
                $columns = $this->addressColumns();
            break;
            
            case "orders":
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

        return $this->excelReport(
                $title,
                $meta,
                $queryBuilder,
                $columns,
                $reportName
            );
    }

    /**
     * Generate the Excel report
     * 
     * @param string $title
     * @param array $meta
     * @param \Illuminate\Datebase\Eloquent\Builder $queryBuilder
     * @param array $columns
     * @param string $reportName
     * @return ExcelReport
     */
    private function excelReport($title,$meta,$queryBuilder,$columns,$reportName){
        return ExcelReport::of(
                $title,
                $meta,
                $queryBuilder,
                $columns
            )
            ->download($reportName);
    }

}
