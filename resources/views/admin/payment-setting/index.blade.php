@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Payment Gateway</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Gateways</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-2">
                      <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="home-tab4" data-toggle="tab" href="#paypal-setting" role="tab" aria-controls="home" aria-selected="true">Paypal</a>
                        </li>
                      
                      </ul>
                    </div>
                    <div class="col-12 col-sm-12 col-md-10">
                     
                        @include('admin.payment-setting.sections.paypal')


                     
                    </div>
                  </div>
            </div>
        </div>
    </section>
@endsection

