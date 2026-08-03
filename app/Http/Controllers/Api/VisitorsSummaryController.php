<?php

namespace App\Http\Controllers\Api;

use App\Support\CSVFile;
use Illuminate\Http\Request;
use App\Models\VisitorSummary;
use App\Models\VisitorAnalytic;
use App\Http\Controllers\Controller;
use App\Models\VisitorDeviceSummary;
use App\Models\VisitorBrowserSummary;
use App\Models\VisitorDemographicSummary;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VisitorsSummaryController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin()) {
            throw new HttpException(403, "You are not allowed to view visitor summary list.");
        }

        $from_date = request('from_date');
        $to_date   = request('to_date');
        $type = request('range', 'daily');
        $query = $this->getVisitorSummaryQuery($type, $from_date, $to_date);

        return $type === 'monthly'
            ? $query->paginate(12)
            : $query->paginate(30);

    }

    public function byType(Request $request, string $type)
    {
        $from_date = request('from_date');
        $to_date = request('to_date');
        switch ($type) {
            case 'device':
                return $this->device($from_date, $to_date);

            case 'browser':
                return $this->browser($from_date, $to_date);

            case 'country':
                return $this->country($from_date, $to_date);

            case 'state':
                return $this->state($from_date, $to_date);

            default:
                return throw new HttpException(403, "Invalid type. Use: device, browser, country or state.");
        }
    }

    public function downloadByType(Request $request, string $type)
    {
        $from_date = request('from_date');
        $to_date = request('to_date');
        switch ($type) {
            case 'device':
                return $this->downloadByDevice($from_date, $to_date);

            case 'browser':
                return $this->downloadByBrowser($from_date, $to_date);

            case 'country':
                return $this->downloadByCountry($from_date, $to_date);

            case 'state':
                return $this->downloadByState($from_date, $to_date);

            default:
                return throw new HttpException(403, "Invalid type. Use: device, browser, country or state.");
        }
    }

    private function device($from_date, $to_date)
    {
        $data = VisitorDeviceSummary::summaryByDevice($from_date, $to_date)->paginate(20);

        return $data;
    }

    private function browser($from_date, $to_date)
    {
        $data = VisitorBrowserSummary::summaryByBrowser($from_date, $to_date)->paginate(20);

        return $data;
    }

    private function country($from_date, $to_date)
    {
        $data = VisitorDemographicSummary::summaryByCountry($from_date, $to_date)->paginate(20);

        return $data;
    }

    private function state($from_date, $to_date)
    {
        $data = VisitorDemographicSummary::summaryByState($from_date, $to_date)->paginate(20);

        return $data;
    }

    public function downloadVisitorSummary(Request $request)
    {
        $user = auth()->user();
        if (!$user->isSuperAdmin()) {
            throw new HttpException(403, "You are not allowed to view visitor summary list.");
        }

        $from_date = request('from_date');
        $to_date   = request('to_date');
        $type = request('range', 'daily');
        $query = $this->getVisitorSummaryQuery($type, $from_date, $to_date);

        if ($type === 'monthly') {
            $this->downloadMonthlySummary($query->get()->toArray());
            return;
        }

        $this->downloadDailySummary($query->get()->toArray());
    }

    private function downloadMonthlySummary(array $data)
    {
        $csv = new CSVFile($data);
        $csv->fields([
            'Month',
            'Year',
            'Returning Visitor Count',
            'Visitor Count',
        ])->map(function($record) {
            return [
                $this->monthNumberToName($record['month']),
                $record['year'],
                $record['returning_visit_count'],
                $record['visitor_count'],
            ];
        })->download();
    }

    private function downloadDailySummary(array $data)
    {
        $csv = new CSVFile($data);
        $csv->fields([
            'Day',
            'Month',
            'Year',
            'Returning Visitor Count',
            'Visitor Count',
        ])->map(function($record) {
            return [
                $record['day'],
                $this->monthNumberToName($record['month']),
                $record['year'],
                $record['returning_visit_count'],
                $record['visitor_count'],
            ];
        })->download();
    }

    private function monthNumberToName(int $month): string
    {
        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];

        return $months[$month] ?? '';
    }

    private function getVisitorSummaryQuery($type, $from_date, $to_date)
    {
        if ($type === 'monthly') {
            return VisitorSummary::monthlySummary();
        }

        $query = VisitorSummary::query();

        if ($from_date && $to_date) {
            $query->whereBetween("created_at", [$from_date, $to_date]);
        }

        return $query->orderBy('id', 'desc');
    }

    private function downloadByDevice($from_date, $to_date)
    {
        $data = VisitorDeviceSummary::summaryByDevice($from_date, $to_date)->get()->toArray();
        $csv = new CSVFile($data);
        $csv->fields([
            'Device',
            'Total'
        ])->map(function($record) {
            return [
                $this->getDeviceName($record['device']),
                $record['total'],
            ];
        })->download();
    }

    private function downloadByBrowser($from_date, $to_date)
    {
        $data = VisitorBrowserSummary::summaryByBrowser($from_date, $to_date)->get()->toArray();
        $csv = new CSVFile($data);
        $csv->fields([
            'Browser',
            'Total'
        ])->map(function($record) {
            return [
                $this->getBrowserName($record['browser']),
                $record['total'],
            ];
        })->download();
    }

    private function downloadByCountry($from_date, $to_date)
    {
        $data = VisitorDemographicSummary::summaryByCountry($from_date, $to_date)->get()->toArray();
        $csv = new CSVFile($data);
        $csv->fields([
            'Country',
            'Total'
        ])->map(function($record) {
            return [
                $record['country'],
                $record['total'],
            ];
        })->download();
    }

    private function downloadByState($from_date, $to_date)
    {
        $data = VisitorDemographicSummary::summaryByState($from_date, $to_date)->get()->toArray();
        $csv = new CSVFile($data);
        $csv->fields([
            'State',
            'Total'
        ])->map(function($record) {
            return [
                $record['state'],
                $record['total'],
            ];
        })->download();
    }

    private function getDeviceName(int $device): string
    {
        return match ($device) {
            VisitorAnalytic::DEVICE_WINDOWS   => 'Windows',
            VisitorAnalytic::DEVICE_MACOS     => 'MacOS',
            VisitorAnalytic::DEVICE_LINUX     => 'Linux',
            VisitorAnalytic::DEVICE_ANDROID   => 'Android',
            VisitorAnalytic::DEVICE_IOS       => 'iOS',
            VisitorAnalytic::DEVICE_CHROMEOS  => 'ChromeOS',
            default     => 'Others',
        };
    }

    private function getBrowserName(int $browser): string
    {
        return match ($browser) {
            VisitorAnalytic::BROWSER_CHROME    => 'Chrome',
            VisitorAnalytic::BROWSER_FIREFOX   => 'Firefox',
            VisitorAnalytic::BROWSER_SAFARI    => 'Safari',
            VisitorAnalytic::BROWSER_EDGE      => 'Edge',
            VisitorAnalytic::BROWSER_OPERA     => 'Opera',
            VisitorAnalytic::BROWSER_UCBROWSER => 'UC Browser',
            default     => 'Others',
        };
    }
}
