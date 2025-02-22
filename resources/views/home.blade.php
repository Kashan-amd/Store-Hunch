@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Welcome!') }}
                </div>
            </div>
            <div class="card mt-5">
            <div class="card-header">{{ __('Details') }}</div>
            <div class="card-body">
                <div id="columnchart_material" style="width: 700px; height: 500px;"></div>
            </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Year', 'Sales', 'Invetories', 'Expenses'],
            ['2023', {{ $data['countSales'] }}, {{ $data['countInventory'] }}, {{ $data['countExpenses'] }}]
        ]);

        var options = {
          chart: {
            title: 'Shop Stats',
            subtitle: 'Sales, Expenses and profit',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
@endsection